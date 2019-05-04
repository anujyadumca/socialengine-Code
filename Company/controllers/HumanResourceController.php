<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: TopicController.php 9921 2013-02-16 01:38:52Z jung $
 * @author     John
 */

/**
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Company_HumanResourceController extends Core_Controller_Action_Standard
{
  public function init()
  {

  }

  public function createAction()
  {
    if( !$this->_helper->requireUser()->isValid() ) return;
    if( !$this->_helper->requireSubject('company_group')->isValid() ) return;


    $this->view->company = $company = Engine_Api::_()->core()->getSubject('company_group');
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

    // Make form
    $this->view->form = $form = new Company_Form_HR_Create();

    // Check method/data
    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    // Process
    $values = $form->getValues();
    $parsed = parse_url($values['link'] );
    if (empty($parsed['scheme'])) {
        $urlStr = 'http://' . ltrim($values['link'], '/');
    }
    else{
        $urlStr = ltrim($values['link'], '/');
    }
    $values['link'] = $urlStr;
    $values['user_id'] = $viewer->getIdentity();
    $values['company_id'] = $company->getIdentity();

    $humanResourceTable = Engine_Api::_ ()->getDbTable ( 'humanResource', 'company' );
   try
    {
      // Create Business Hr
      $hr = $humanResourceTable->createRow();
      $hr->setFromArray($values);
      $hr->save();

    }

    catch( Exception $e )
    {

      throw $e;
    }
    $form->addNotice ( 'The new company human resource save succesfully' );
   /*  $this->_redirect('company/10/my-test-group1'); */
  }

  public function editAction()
  {

      $log = Engine_Api::_ ()->getApi ( 'core', 'socialapi' )->getLog ();
      $log->log("busssssss__",Zend_Log::DEBUG);
      $id = $this->_getParam('human-resourse-id');





      $this->view->company = $company = Engine_Api::_()->core()->getSubject('company_group');
      $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

      // Make form



      $log->log("busssssss__1",Zend_Log::DEBUG);
      // Process


      $humanResourceTable = Engine_Api::_ ()->getDbTable ( 'humanResource', 'company' );
      $hrSelect = $humanResourceTable->select ()
      ->where ( 'company_id = ?', $company->getIdentity())
      ->where ( 'human_resourse_id = ?', $id);
      $hr = $humanResourceTable->fetchRow ( $hrSelect );


      $this->view->form = $form = new Company_Form_HR_Edit();


      $form->populate($hr->toArray());


      $values['user_id'] = $viewer->getIdentity();
      $values['company_id'] = $company->getIdentity();



      // Check method/data
      if( !$this->getRequest()->isPost() ) {
          return;
      }

      if( !$form->isValid($this->getRequest()->getPost()) ) {
          return;
      }


      try
      {
          $values = $form->getValues();
          $parsed = parse_url($values['link'] );
          if (empty($parsed['scheme'])) {
              $urlStr = 'http://' . ltrim($values['link'], '/');
          }
          else{
              $urlStr = ltrim($values['link'], '/');
          }

          $values['link'] = $urlStr;
          $hr->setFromArray($values);
          $hr->save();

      }

      catch( Exception $e )
      {

          throw $e;
      }
      $form->addNotice ( 'The new company contacts save succesfully' );
      /*  $this->_redirect('company/10/my-test-group1'); */
  }

  public function deleteAction()
  {
      $log = Engine_Api::_ ()->getApi ( 'core', 'socialapi' )->getLog ();
      $id = $this->_getParam('human-resourse-id');
      $companyId = $this->_getParam('companyId');
      $this->view->company_id = $companyId;
      //$log->log("businesssid___".$id."companyid___".$companyId,Zend_Log::DEBUG);
      $humanResourceTable = Engine_Api::_ ()->getDbTable ( 'humanResource', 'company' );
      $HRSelect = $humanResourceTable->select ()
      ->where ( 'company_id = ?', $companyId)
      ->where ( 'human_resourse_id = ?', $id);
      $HR = $humanResourceTable->fetchRow ( $HRSelect );
     // $log->log("HRs___________".json_encode($HR),Zend_Log::DEBUG);

      // Check post
      if( $this->getRequest()->isPost() ) {
          $db = $humanResourceTable->getAdapter();
          $db->beginTransaction();

          try {

              $HR->delete();

              $db->commit();
          } catch( Exception $e ) {
              $db->rollBack();
              throw $e;
          }
          return $this->_forward('success', 'utility', 'core', array(
              'smoothboxClose' => 10,
              'parentRefresh'=> 10,
              'messages' => array('')
          ));
      }

  }

  public function viewAction()
  {
      $id = $this->_getParam('HR-id');
      $companyId = $this->_getParam('companyId');

      $humanResourceTable = Engine_Api::_ ()->getDbTable ( 'humanResource', 'company' );
      $HRSelect = $humanResourceTable->select ()
      ->where ( 'company_id = ?', $companyId)
      ->where ( 'human_resourse_id = ?', $id);
      $HR = $humanResourceTable->fetchAll ( $HRSelect );
      $this->view->hr = $HR;


  }



}