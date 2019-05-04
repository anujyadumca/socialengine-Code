<?php

/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: GroupController.php 9747 2012-07-26 02:08:08Z john $
 * @author     John
 */

/**
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Company_GroupController extends Core_Controller_Action_Standard
{
  public function init()
  {
  	$log = Engine_Api::_ ()->getApi ( 'core', 'socialapi' )->getLog ();
  	$log->log("init:::",Zend_Log::DEBUG);
    if( 0 !== ($group_id = (int) $this->_getParam('group_id')) &&
        null !== ($group = Engine_Api::_()->getItem('company', $group_id)) ) {
      Engine_Api::_()->core()->setSubject($group);
    }

    //$this->_helper->requireUser();
    //$this->_helper->requireSubject('company');
  }

  public function editAction()
  {
  	$log = Engine_Api::_ ()->getApi ( 'core', 'socialapi' )->getLog ();
  	$log->log("editAction:::",Zend_Log::DEBUG);

//     if( !$this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() ) {
//       return;
//     }

    $group = Engine_Api::_()->core()->getSubject();
    $officerList = $group->getOfficerList();
    $this->view->form = $form = new Company_Form_Edit();

    // Populate with categories
    $categories = Engine_Api::_()->getDbtable('categories', 'company')->getCategoriesAssoc();
    asort($categories, SORT_LOCALE_STRING);
//     $categoryOptions = array('0' => '');
//     foreach( $categories as $k => $v ) {
//       $categoryOptions[$k] = $v;
//     }
    //$form->category_id->setMultiOptions($categoryOptions);

    if( count($form->country_id->getMultiOptions()) <= 1 ) {
     // $form->removeElement('category_id');
    }

    if( !$this->getRequest()->isPost() ) {
      // Populate auth
      $auth = Engine_Api::_()->authorization()->context;
      $roles = array('officer', 'member', 'registered', 'everyone');
      $actions = array('view', 'comment', 'invite', 'photo', 'event');
      $perms = array();
      foreach( $roles as $roleString ) {
        $role = $roleString;
        if( $role === 'officer' ) {
          $role = $officerList;
        }
        foreach( $actions as $action ) {
          if( $auth->isAllowed($group, $role, $action) ) {
            $perms['auth_' . $action] = $roleString;
          }
        }
      }

      $form->populate($group->toArray());
      $form->populate($perms);
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    // Process
    $db = Engine_Api::_()->getItemTable('company')->getAdapter();
    $db->beginTransaction();

    try {
      $values = $form->getValues();

      if( empty($values['auth_view']) ) {
        $values['auth_view'] = 'everyone';
      }

      if( empty($values['auth_comment']) ) {
        $values['auth_comment'] = 'everyone';
      }

      $values['view_privacy'] =  $values['auth_view'];

      // Set group info
      $group->setFromArray($values);
      $group->save();

      if( !empty($values['photo']) ) {
        $group->setPhoto($form->photo);
      }

      // Process privacy
      $auth = Engine_Api::_()->authorization()->context;

      $roles = array('officer', 'member', 'registered', 'everyone');

      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);
      $photoMax = array_search($values['auth_photo'], $roles);
      $eventMax = array_search($values['auth_event'], $roles);
      $inviteMax = array_search($values['auth_invite'], $roles);

      foreach( $roles as $i => $role ) {
        if( $role === 'officer' ) {
          $role = $officerList;
        }
        $auth->setAllowed($group, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($group, $role, 'comment', ($i <= $commentMax));
        $auth->setAllowed($group, $role, 'photo', ($i <= $photoMax));
        $auth->setAllowed($group, $role, 'event', ($i <= $eventMax));
        $auth->setAllowed($group, $role, 'invite', ($i <= $inviteMax));
      }

      // Create some auth stuff for all officers
      $auth->setAllowed($group, $officerList, 'photo.edit', 1);
      $auth->setAllowed($group, $officerList, 'topic.edit', 1);

      // Add auth for invited users
      $auth->setAllowed($group, 'member_requested', 'view', 1);

      // Commit
      $db->commit();
    } catch( Engine_Image_Exception $e ) {
      $db->rollBack();
      $form->addError(Zend_Registry::get('Zend_Translate')->_('The image you selected was too large.'));
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }


    $db->beginTransaction();
    try {
      // Rebuild privacy
      $actionTable = Engine_Api::_()->getDbtable('actions', 'activity');
      foreach( $actionTable->getActionsByObject($group) as $action ) {
        $actionTable->resetActivityBindings($action);
      }

      $db->commit();
    }
    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }



    // Redirect
    if( $this->_getParam('ref') === 'profile' ) {
      $this->_redirectCustom($group);
    } else {
      $this->_redirectCustom(array('route' => 'company_general', 'action' => 'manage'));
    }
  }

  public function deleteAction()
  {
  	$log = Engine_Api::_ ()->getApi ( 'core', 'socialapi' )->getLog ();

    $viewer = Engine_Api::_()->user()->getViewer();
    $group = Engine_Api::_()->getItem('company', $this->getRequest()->getParam('group_id'));
    //if( !$this->_helper->requireAuth()->setAuthParams($group, null, 'delete')->isValid()) return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    // Make form
    $this->view->form = $form = new Company_Form_Delete();

    if( !$group )
    {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Group doesn't exists or not authorized to delete");
      return;
    }

    if( !$this->getRequest()->isPost() )
    {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $db = $group->getTable()->getAdapter();
    $db->beginTransaction();

    try {
      $group->delete();

      $log->log("delete Group:::",Zend_Log::DEBUG);
      $db->commit();
    } catch( Exception $e ) {
    	$log->log("Excep:::".$e,Zend_Log::DEBUG);
      $db->rollBack();
      throw $e;
    }

    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('The selected group has been deleted.');
    return $this->_forward('success' ,'utility', 'core', array(
      'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'company_general', true),
      'messages' => Array($this->view->message)
    ));
  }

  public function styleAction()
  {
    if( !$this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() )
        return;
    if( !$this->_helper->requireAuth()->setAuthParams(null, null, 'style')->isValid() )
        return;

    $user = Engine_Api::_()->user()->getViewer();
    $group = Engine_Api::_()->core()->getSubject('company_group');

    // Make form
    $this->view->form = $form = new Company_Form_Style();

    // Get current row
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $select = $table->select()
            ->where('type = ?', 'company')
            ->where('id = ?', $group->getIdentity())
            ->limit(1);

    $row = $table->fetchRow($select);

    // Check post
    if( !$this->getRequest()->isPost() ) {
      $form->populate(array(
        'style' => ( null === $row ? '' : $row->style )
      ));
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    // Cool! Process
    $style = $form->getValue('style');

    // Save
    if( null == $row ) {
      $row = $table->createRow();
      $row->type = 'company';
      $row->id = $group->getIdentity();
    }

    $row->style = $style;
    $row->save();

    $this->view->draft = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your changes have been saved.');
    $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => true,
      'parentRefresh' => false,
      'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your changes have been saved.'))
    ));
  }

}