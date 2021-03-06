<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: PhotoController.php 9913 2013-02-15 00:00:42Z john $
 * @author     John
 */

/**
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Company_PhotoController extends Core_Controller_Action_Standard
{
  public function init()
  {
    if( !Engine_Api::_()->core()->hasSubject() )
    {
      if( 0 !== ($photo_id = (int) $this->_getParam('photo_id')) &&
          null !== ($photo = Engine_Api::_()->getItem('company_photo', $photo_id)) )
      {
        Engine_Api::_()->core()->setSubject($photo);
      }

      else if( 0 !== ($group_id = (int) $this->_getParam('group_id')) &&
          null !== ($group = Engine_Api::_()->getItem('company', $group_id)) )
      {
        Engine_Api::_()->core()->setSubject($group);
      }
    }

    $this->_helper->requireUser->addActionRequires(array(
      'upload',
      'upload-photo', // Not sure if this is the right
      'edit',
    ));

    $this->_helper->requireSubject->setActionRequireTypes(array(
      'list' => 'company_group',
      'upload' => 'company_group',
      'view' => 'company_photo',
      'edit' => 'company_photo',
    ));
  }

  public function listAction()
  {
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $this->view->album = $album = $group->getSingletonAlbum();

    if( !$this->_helper->requireAuth()->setAuthParams($group, null, 'view')->isValid() ) {
      return;
    }

    $this->view->paginator = $paginator = $album->getCollectiblesPaginator();
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));

    $this->view->canUpload = $group->authorization()->isAllowed(null, 'photo');
  }

  public function viewAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->photo = $photo = Engine_Api::_()->core()->getSubject();
    $this->view->album = $album = $photo->getCollection();
    $this->view->group = $group = $photo->getGroup();
    $this->view->canEdit = $photo->canEdit(Engine_Api::_()->user()->getViewer());

    if( !$this->_helper->requireAuth()->setAuthParams($group, null, 'view')->isValid() ) {
      return;
    }

    if( !$viewer || !$viewer->getIdentity() || $photo->user_id != $viewer->getIdentity() ) {
      $photo->view_count = new Zend_Db_Expr('view_count + 1');
      $photo->save();
    }
  }

  public function uploadAction()
  {
  	$log = Engine_Api::_ ()->getApi ( 'core', 'socialapi' )->getLog ();
  	$log->log("uploadActionStep 1:::",Zend_Log::DEBUG);

    if( isset($_GET['ul']) ) {
      return $this->_forward('upload-photo', null, null, array('format' => 'json'));
    }

    $log->log("uploadActionStep 2:::".json_encode($_FILES['Filedata']),Zend_Log::DEBUG);
    if( isset($_FILES['Filedata']) ) {
      $_POST['file'] = $this->uploadPhotoAction();
    }

    $group = Engine_Api::_()->core()->getSubject();
    if( !$this->_helper->requireAuth()->setAuthParams($group, null, 'photo')->isValid() ) {
      return;
    }
    $log->log("uploadActionStep 3:::".$group->getHref(),Zend_Log::DEBUG);

    $viewer = Engine_Api::_()->user()->getViewer();
    $album = $group->getSingletonAlbum();

    $this->view->group = $group;
    $this->view->form = $form = new Company_Form_Photo_Upload();
    $form->file->setAttrib('data', array('group_id' => $group->getIdentity()));

    if( !$this->getRequest()->isPost() )
    {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) )
    {
      return;
    }

    $log->log("uploadActionStep 4 AfterPostAction:::",Zend_Log::DEBUG);
    // Process
    $table = Engine_Api::_()->getItemTable('company_photo');
    $db = $table->getAdapter();
    $db->beginTransaction();

    try
    {
      $values = $form->getValues();
      $params = array(
        'group_id' => $group->getIdentity(),
        'user_id' => $viewer->getIdentity(),
      );

      // Add action and attachments
      $api = Engine_Api::_()->getDbtable('actions', 'activity');
      $action = $api->addActivity(Engine_Api::_()->user()->getViewer(), $group, 'company_photo_upload', null, array(
        'count' => count($values['file'])
      ));

      // Do other stuff
      $count = 0;
      $log->log("uploadActionStep 5 BeforeForEach:::",Zend_Log::DEBUG);
      foreach( $values['file'] as $photo_id )
      {
      	$log->log("uploadActionStep 6:::".$photo_id,Zend_Log::DEBUG);
        $photo = Engine_Api::_()->getItem("company_photo", $photo_id);
        if( !($photo instanceof Core_Model_Item_Abstract) || !$photo->getIdentity() ) continue;

        /*
        if( $set_cover )
        {
          $album->photo_id = $photo_id;
          $album->save();
          $set_cover = false;
        }
        */

        $log->log("uploadActionStep 7 BeforeSavingPhoto:::",Zend_Log::DEBUG);
        $photo->collection_id = $album->album_id;
        $photo->album_id = $album->album_id;
        $photo->group_id = $group->group_id;
        $photo->save();

        $log->log("uploadActionStep 8 AfterSavingPhoto:::",Zend_Log::DEBUG);
        if( $action instanceof Activity_Model_Action && $count < 100 ) {
          $api->attachActivity($action, $photo, Activity_Model_Action::ATTACH_MULTI);
        }
        $count++;
      }

      $log->log("uploadActionStep 9 Commiting DB chnages:::",Zend_Log::DEBUG);
      $db->commit();
    }

    catch( Exception $e )
    {
    	$log->log("uploadActionException:::".$e->getMessage(),Zend_Log::DEBUG);
      $db->rollBack();
      throw $e;
    }


    $this->_redirectCustom($group);
  }

  public function uploadPhotoAction()
  {
    $groupId = $this->_getParam('group_id');
    if( empty($groupId) ) {
      $group = Engine_Api::_()->core()->getSubject();
    } else {
      $group = Engine_Api::_()->getItem('company', $groupId);
    }

    if( !$this->_helper->requireAuth()->setAuthParams($group, null, 'photo')->isValid() ) {
      return;
    }

    if( !$this->_helper->requireUser()->checkRequire() )
    {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Max file size limit exceeded (probably).');
      return;
    }

    if( !$this->getRequest()->isPost() )
    {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $values = $this->getRequest()->getPost();
    if( empty($values['Filename']) && !isset($_FILES['Filedata']) ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('No file');
      return;
    }

    if( !isset($_FILES['Filedata']) || !is_uploaded_file($_FILES['Filedata']['tmp_name']) ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid Upload');
      return;
    }

    $db = Engine_Api::_()->getDbtable('photos', 'company')->getAdapter();
    $db->beginTransaction();

    try {
      $viewer = Engine_Api::_()->user()->getViewer();
      $album = $group->getSingletonAlbum();

      $params = array(
        // We can set them now since only one album is allowed
        // ...or not?
        //'collection_id' => $album->getIdentity(),
        //'album_id' => $album->getIdentity(),

        //'group_id' => $group->getIdentity(),
        'user_id' => $viewer->getIdentity(),
      );

      $photoTable = Engine_Api::_()->getItemTable('company_photo');
      $photo = $photoTable->createRow();
      $photo->setFromArray($params);
      $photo->save();

      $photo->setPhoto($_FILES['Filedata']);

      $this->view->status = true;
      $this->view->name = $_FILES['Filedata']['name'];
      $this->view->photo_id = $photo->photo_id;

      $db->commit();
      return $photo->photo_id;
    }

    catch( Exception $e )
    {
      $db->rollBack();
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('An error occurred.');
      // throw $e;
      return;
    }
  }

  public function editAction()
  {
    $photo = Engine_Api::_()->core()->getSubject();
    $group = $photo->getParent('company');
    if( !$this->_helper->requireAuth()->setAuthParams($group, null, 'photo.edit')->isValid() ) {
      return;
    }
    $this->view->form = $form = new Company_Form_Photo_Edit();

    if( !$this->getRequest()->isPost() )
    {
      $form->populate($photo->toArray());
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) )
    {
      return;
    }

    // Process
    $db = Engine_Api::_()->getDbtable('photos', 'company')->getAdapter();
    $db->beginTransaction();

    try
    {
      $photo->setFromArray($form->getValues())->save();

      $db->commit();
    }

    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }

    return $this->_forward('success', 'utility', 'core', array(
      'messages' => array(Zend_Registry::get('Zend_Translate')->_('Changes saved')),
      'layout' => 'default-simple',
      'parentRefresh' => true,
      'closeSmoothbox' => true,
    ));
  }

  public function deleteAction()
  {
    $photo = Engine_Api::_()->core()->getSubject();
    $group = $photo->getParent('company');
    if( !$this->_helper->requireAuth()->setAuthParams($group, null, 'photo.edit')->isValid() ) {
      return;
    }

    $this->view->form = $form = new Company_Form_Photo_Delete();

    if( !$this->getRequest()->isPost() )
    {
      $form->populate($photo->toArray());
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) )
    {
      return;
    }

    // Process
    $photoTable = Engine_Api::_()->getDbtable('photos', 'company');
    $photoTable->deletePhoto($photo);

    return $this->_forward('success', 'utility', 'core', array(
      'messages' => array(Zend_Registry::get('Zend_Translate')->_('Photo deleted')),
      'layout' => 'default-simple',
      'parentRedirect' => $group->getHref(),
      'closeSmoothbox' => true,
    ));
  }
}
