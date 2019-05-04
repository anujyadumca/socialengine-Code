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
class Company_BusinessContactsController extends Core_Controller_Action_Standard
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
    $this->view->form = $form = new Company_Form_Business();

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

    $BusinessContactsTable = Engine_Api::_ ()->getDbTable ( 'businessContacts', 'company' );
   try
    {
      // Create Business contacts
     $contacts = $BusinessContactsTable->createRow();
      $contacts->setFromArray($values);
      $contacts->save();

    }

    catch( Exception $e )
    {

      throw $e;
    }
    $form->addNotice ( 'The new company contacts save succesfully' );
   /*  $this->_redirect('company/10/my-test-group1'); */
  }

  public function editAction()
  {

      $log = Engine_Api::_ ()->getApi ( 'core', 'socialapi' )->getLog ();
      $log->log("busssssss__",Zend_Log::DEBUG);
      $id = $this->_getParam('contact-id');





      $this->view->company = $company = Engine_Api::_()->core()->getSubject('company_group');
      $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

      // Make form



      $log->log("busssssss__1",Zend_Log::DEBUG);
      // Process


      $BusinessContactsTable = Engine_Api::_ ()->getDbTable ( 'businessContacts', 'company' );
      $businessSelect = $BusinessContactsTable->select ()
      ->where ( 'company_id = ?', $company->getIdentity())
      ->where ( 'contact_id = ?', $id);
      $business = $BusinessContactsTable->fetchRow ( $businessSelect );


      $this->view->form = $form = new Company_Form_Business_Edit();





      $values['user_id'] = $viewer->getIdentity();
      $values['company_id'] = $company->getIdentity();



      $form->populate($business->toArray());



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
          $business->setFromArray($values);
          $business->save();

      }

      catch( Exception $e )
      {

          throw $e;
      }
      $form->addNotice ( 'Sucessfully Edited Your Contact' );
      /*  $this->_redirect('company/10/my-test-group1'); */
  }


  public function deleteAction()
  {
      $log = Engine_Api::_ ()->getApi ( 'core', 'socialapi' )->getLog ();
      $id = $this->_getParam('contact-id');
      $companyId = $this->_getParam('companyId');
      $this->view->company_id = $companyId;
//      $log->log("businesssid___".$id."companyid___".$companyId.json_encode($business),Zend_Log::DEBUG);
      $BusinessContactsTable = Engine_Api::_ ()->getDbTable ( 'businessContacts', 'company' );
      $businessSelect = $BusinessContactsTable->select ()
      ->where ( 'company_id = ?', $companyId)
      ->where ( 'contact_id = ?', $id);
      $business = $BusinessContactsTable->fetchRow ( $businessSelect );

      // Check post
      if( $this->getRequest()->isPost() ) {
          $db = $BusinessContactsTable->getAdapter();
          $db->beginTransaction();

          try {

              $business->delete();

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
      $id = $this->_getParam('contact-id');
      $companyId = $this->_getParam('companyId');

      $BusinessContactsTable = Engine_Api::_ ()->getDbTable ( 'businessContacts', 'company' );
      $businessSelect = $BusinessContactsTable->select ()
      ->where ( 'company_id = ?', $companyId)
      ->where ( 'contact_id = ?', $id);
      $business = $BusinessContactsTable->fetchAll ( $businessSelect );
      $this->view->business = $business;


  }



}