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
class Company_CompanyInvestorsController extends Core_Controller_Action_Standard
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
    $this->view->form = $form = new Company_Form_Investors_Create();

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

    $CompanyInvestorsTable = Engine_Api::_ ()->getDbTable ( 'companyInvestors', 'company' );
   try
    {
      // Create Business contacts
        $investors = $CompanyInvestorsTable->createRow();
        $investors->setFromArray($values);
        $investors->save();

    }

    catch( Exception $e )
    {

      throw $e;
    }
    $form->addNotice ( 'The new company investors save succesfully' );
   /*  $this->_redirect('company/10/my-test-group1'); */
  }

  public function editAction()
  {

      $log = Engine_Api::_ ()->getApi ( 'core', 'socialapi' )->getLog ();

      $id = $this->_getParam('investor-id');


      $log->log("id_____".$id,Zend_Log::DEBUG);


      $this->view->company = $company = Engine_Api::_()->core()->getSubject('company_group');
      $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

      // Make form



      $log->log("busssssss__1",Zend_Log::DEBUG);
      // Process


      $CompanyInvestorsTable = Engine_Api::_ ()->getDbTable ( 'companyInvestors', 'company' );
      $investorsSelect = $CompanyInvestorsTable->select ()
      ->where ( 'company_id = ?', $company->getIdentity())
      ->where ( 'investor_id = ?', $id);
      $investors = $CompanyInvestorsTable->fetchRow ( $investorsSelect );


      $this->view->form = $form = new Company_Form_Investors_Edit();


      $form->populate($investors->toArray());


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
          $investors->setFromArray($values);
          $investors->save();

      }

      catch( Exception $e )
      {

          throw $e;
      }
      $form->addNotice ( 'Sucessfully Edited Your Investor' );
      /*  $this->_redirect('company/10/my-test-group1'); */
  }


  public function deleteAction()
  {
      $log = Engine_Api::_ ()->getApi ( 'core', 'socialapi' )->getLog ();
      $id = $this->_getParam('investor-id');
      $companyId = $this->_getParam('companyId');
      $this->view->company_id = $companyId;
//      $log->log("businesssid___".$id."companyid___".$companyId.json_encode($business),Zend_Log::DEBUG);
      $CompanyInvestorsTable = Engine_Api::_ ()->getDbTable ( 'companyInvestors', 'company' );
      $investorsSelect = $CompanyInvestorsTable->select ()
      ->where ( 'company_id = ?', $companyId)
      ->where ( 'investor_id = ?', $id);
      $investors = $CompanyInvestorsTable->fetchRow ( $investorsSelect );

      // Check post
      if( $this->getRequest()->isPost() ) {
          $db = $CompanyInvestorsTable->getAdapter();
          $db->beginTransaction();

          try {

              $investors->delete();

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
      $id = $this->_getParam('investor-id');
      $companyId = $this->_getParam('companyId');

      $CompanyInvestorsTable = Engine_Api::_ ()->getDbTable ( 'companyInvestors', 'company' );
      $investorsSelect = $CompanyInvestorsTable->select ()
      ->where ( 'company_id = ?', $companyId)
      ->where ( 'investor_id = ?', $id);
      $investors = $CompanyInvestorsTable->fetchAll ( $investorsSelect );
      $this->view->investors = $investors;


  }



}