<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: AdminSettingsController.php 9802 2012-10-20 16:56:13Z pamela $
 * @author     Jung
 */

/**
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Company_AdminSettingsController extends Core_Controller_Action_Admin
{
  public function indexAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('company_admin_main', array(), 'company_admin_main_settings');

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->form = $form = new Company_Form_Admin_Global();

    $form->bbcode->setValue($settings->getSetting('company_bbcode', 1));
    $form->html->setValue($settings->getSetting('company_html', 0));

    if( $this->getRequest()->isPost()&& $form->isValid($this->getRequest()->getPost()))
    {
      $values = $form->getValues();
      $settings->setSetting('company_bbcode', $values['bbcode']);
      $settings->setSetting('company_html', $values['html']);

      $form->addNotice('Your changes have been saved.');
    }
  }

  public function categoriesAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('company_admin_main', array(), 'company_admin_main_categories');

      $categoryTable = Engine_Api::_ ()->getDbTable ( 'categories', 'company' );
      $categorySelect = $categoryTable->select ()->where ( 'parent_id = ?', 0);
      $category = $categoryTable->fetchAll ( $categorySelect );
      $this->view->categories = $category;
  }

  public function associationAction()
  {
  	$this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
  	->getNavigation('company_admin_main', array(), 'company_admin_main_association');
  	$this->view->relationships = Engine_Api::_()->getDbtable('relationships', 'company')->fetchAll();
  }

  public function levelAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('company_admin_main', array(), 'company_admin_main_level');

    // Get level id
    if( null !== ($id = $this->_getParam('id')) ) {
      $level = Engine_Api::_()->getItem('authorization_level', $id);
    } else {
      $level = Engine_Api::_()->getItemTable('authorization_level')->getDefaultLevel();
    }

    if( !$level instanceof Authorization_Model_Level ) {
      throw new Engine_Exception('missing level');
    }

    $level_id = $id = $level->level_id;

    // Make form
    $this->view->form = $form = new Company_Form_Admin_Settings_Level(array(
      'public' => ( in_array($level->type, array('public')) ),
      'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
    ));
    $form->level_id->setValue($level_id);

    $permissionsTable = Engine_Api::_()->getDbtable('permissions', 'authorization');
    $form->populate($permissionsTable->getAllowed('group', $level_id, array_keys($form->getValues())));

    if( !$this->getRequest()->isPost() )
    {
      return;
    }

   // Check validitiy
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    // Process

    $values = $form->getValues();

    // Form elements with NonBoolean values
    $nonBooleanSettings = $form->nonBooleanFields();

    $db = $permissionsTable->getAdapter();
    $db->beginTransaction();

    try
    {
      // Set permissions
      if( isset($values['auth_comment']) ) {
        $values['auth_view'] = (array) @$values['auth_view'];
        $values['auth_comment'] = (array) @$values['auth_comment'];
        $values['auth_photo'] = (array) @$values['auth_photo'];
      }

      $permissionsTable->setAllowed('group', $level_id, $values, '', $nonBooleanSettings);

      // Commit
      $db->commit();
    }

    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }
    $form->addNotice('Your changes have been saved.');
  }

//   public function religionAction()
//   {
//       $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
//       ->getNavigation('company_admin_main', array(), 'company_admin_main_industries');

//       $this->view->industries = Engine_Api::_()->getDbtable('industries', 'company')->fetchAll();
//   }

//   public function worshipAction()
//   {
//       /* $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
//        ->getNavigation('faith_admin_main', array(), 'faith_admin_main_subcategorie'); */

//       $id = $this->_getParam('id');
//       $WorshipTable = Engine_Api::_ ()->getDbTable ( 'worships', 'faith' );
//       $worshipSelect = $WorshipTable->select ()->where ( 'religion_id = ?', $id);
//       $worship = $WorshipTable->fetchAll ( $worshipSelect );
//       $this->view->religion_id = $id;
//       $this->view->worships = $worship;
//   }


  public function addCategoryAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');

    // Generate and assign form
    $form = $this->view->form = new Company_Form_Admin_Category();
    $form->setAction($this->getFrontController()->getRouter()->assemble(array()));

    // Check post
    if( $this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost()) ) {
      // we will add the category
      $values = $form->getValues();

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try {
        // add category to the database
        // Transaction
        $table = Engine_Api::_()->getDbtable('categories', 'company');

        // insert the category into the database
       $row = $table->createRow();
        $row->title = $values["label"];
        $row->save();

        $db->commit();
      } catch( Exception $e ) {
        //$db->rollBack();
        throw $e;
      }

      return $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh'=> 10,
          'messages' => array('')
      ));
    }

    // Output
    $this->renderScript('admin-settings/form.tpl');
  }

  public function subCategoryAction()
  {
      /* $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
       ->getNavigation('faith_admin_main', array(), 'faith_admin_main_subcategorie'); */

      $id = $this->_getParam('id');
      $categoryTable = Engine_Api::_ ()->getDbTable ( 'categories', 'company' );
      $categorySelect = $categoryTable->select ()->where ( 'parent_id = ?', $id);
      $category = $categoryTable->fetchAll ( $categorySelect );
      $this->view->parent_id = $id;
      $this->view->categories = $category;
  }

  public function addRelationshipAction()
  {
  	// In smoothbox
  	$this->_helper->layout->setLayout('admin-simple');

  	// Generate and assign form
  	$form = $this->view->form = new Company_Form_Admin_Relationship();
  	$form->setAction($this->getFrontController()->getRouter()->assemble(array()));

  	// Check post
  	if( $this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost()) ) {
  		// we will add the category
  		$values = $form->getValues();

  		$db = Engine_Db_Table::getDefaultAdapter();
  		$db->beginTransaction();

  		try {
  			// add category to the database
  			// Transaction
  			$table = Engine_Api::_()->getDbtable('relationships', 'company');

  			// insert the category into the database
  			$row = $table->createRow();
  			$row->title = $values["label"];
  			$row->save();

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

  	// Output
  	$this->renderScript('admin-settings/form.tpl');
  }


  public function addIndustryAction()
  {

      $log = Zend_Registry::get('Zend_Log');

      // In smoothbox
      $this->_helper->layout->setLayout('admin-simple');

      // Generate and assign form
      $form = $this->view->form = new Company_Form_Admin_Industries();
      $form->setAction($this->getFrontController()->getRouter()->assemble(array()));

      // Check post
      if( $this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost()) ) {
          // we will add the category
          $values = $form->getValues();
          $log = Zend_Registry::get('Zend_Log');
          $db = Engine_Db_Table::getDefaultAdapter();
          $db->beginTransaction();

          try {
              // add category to the database
              // Transaction
              $table = Engine_Api::_()->getDbtable('industries', 'company');

              // insert the category into the database
              $row = $table->createRow();
              $row->title = $values["label"];
              $row->save();

              $db->commit();
          } catch( Exception $e ) {
              $db->rollBack();
              throw $e;
              $log->log("Error".($e->getMessage()),Zend_Log::CRIT);
          }

          return $this->_forward('success', 'utility', 'core', array(
              'smoothboxClose' => 10,
              'parentRefresh'=> 10,
              'messages' => array('')
          ));
      }

      // Output
      $this->renderScript('admin-settings/form.tpl');
  }


  public function addSectorAction()
  {

      $log = Zend_Registry::get('Zend_Log');
      $industry_id = $this->_getParam('industry_id');
      // In smoothbox
      $this->_helper->layout->setLayout('admin-simple');

      // Generate and assign form
      $form = $this->view->form = new Company_Form_Admin_Sector();
      $form->setAction($this->getFrontController()->getRouter()->assemble(array()));

      // Check post
      if( $this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost()) ) {
          // we will add the category
          $values = $form->getValues();
          $log = Zend_Registry::get('Zend_Log');
          $db = Engine_Db_Table::getDefaultAdapter();
          $db->beginTransaction();

          try {
              // add category to the database
              // Transaction
              $table = Engine_Api::_()->getDbtable('sectors', 'company');

              // insert the category into the database
              $row = $table->createRow();
              $row->title = $values["label"];
              $row->industry_id = $industry_id;
              $row->save();

              $db->commit();
          } catch( Exception $e ) {
              $db->rollBack();
              throw $e;
              $log->log("Error".($e->getMessage()),Zend_Log::CRIT);
          }

          return $this->_forward('success', 'utility', 'core', array(
              'smoothboxClose' => 10,
              'parentRefresh'=> 10,
              'messages' => array('')
          ));
      }

      // Output
      $this->renderScript('admin-settings/form.tpl');
  }

  public function industriesAction()
  {
      $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('company_admin_main', array(), 'company_admin_main_industries');

      $this->view->industries = Engine_Api::_()->getDbtable('industries', 'company')->fetchAll();
  }

  public function sectorsAction()
  {
      /* $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
       ->getNavigation('faith_admin_main', array(), 'faith_admin_main_subcategorie'); */

      $id = $this->_getParam('industry_id');
      $sectorTable = Engine_Api::_ ()->getDbTable ( 'sectors', 'company' );
      $sectorSelect = $sectorTable->select ()->where ( 'industry_id = ?', $id);
      $sector = $sectorTable->fetchAll ( $sectorSelect );
      $this->view->industry_id = $id;
      $this->view->sectors = $sector;
  }

  public function deleteCategoryAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $this->view->group_id=$id;

    $groupTable = Engine_Api::_()->getDbtable('groups', 'company');
    $categoryTable = Engine_Api::_()->getDbtable('categories', 'company');
    $category = $categoryTable->find($id)->current();

    // Check post
    if( $this->getRequest()->isPost() ) {
      $db = $categoryTable->getAdapter();
      $db->beginTransaction();

      try {
        // go through logs and see which groups used this category id and set it to ZERO
        $groupTable->update(array(
          'category_id' => 0,
        ), array(
          'category_id = ?' => $category->getIdentity(),
        ));

        $category->delete();

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

    // Output
    $this->renderScript('admin-settings/delete.tpl');
  }

  public function statusIndustriesAction()
  {
      // In smoothbox
      $this->_helper->layout->setLayout('admin-simple');
      $id = $this->_getParam('id');
      $status = $this->_getParam('status');
      $this->view->group_id=$id;

      $groupTable = Engine_Api::_()->getDbtable('groups', 'company');
      $industriesTable = Engine_Api::_()->getDbtable('industries', 'company');
      $industry = $industriesTable->find($id)->current();

      // Check post
      if( $this->getRequest()->isPost() ) {
          $db = $industriesTable->getAdapter();
          $db->beginTransaction();

          try {
              // go through logs and see which groups used this category id and set it to ZERO

              if($status==1){
                  $groupTable->update(array(
                      'industry_id' => 0,
                  ), array(
                      'industry_id = ?' => $industry->industry_id,
                  ));
                  $industriesTable->update(array(
                      'status' => 0,
                  ), array(
                      'industry_id = ?' => $industry->industry_id,
                  ));
              }else{
                  $groupTable->update(array(
                      'industry_id' => $industry->industry_id,
                  ), array(
                      'industry_id = ?' => 0,
                  ));
                  $industriesTable->update(array(
                      'status' => 1,
                  ), array(
                      'industry_id = ?' => $industry->industry_id,
                  ));
              }
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

      if($status==1){// Output
          $this->renderScript('admin-settings/disable-industry.tpl');
      }else{
          $this->renderScript('admin-settings/enable-industry.tpl');
      }
  }
  public function statusSectorAction()
  {
      // In smoothbox
      $this->_helper->layout->setLayout('admin-simple');
      $id = $this->_getParam('id');
      $status = $this->_getParam('status');
      $this->view->group_id=$id;

      $groupTable = Engine_Api::_()->getDbtable('groups', 'company');
      $sectorTable = Engine_Api::_()->getDbtable('sectors', 'company');
      $sector = $sectorTable->find($id)->current();

      // Check pot
      if( $this->getRequest()->isPost() ) {
          $db = $sectorTable->getAdapter();
          $db->beginTransaction();

          try {
              // go through logs and see which groups used this category id and set it to ZERO

              if($status==1){
                  $groupTable->update(array(
                      'sector_id' => 0,
                  ), array(
                      'sector_id = ?' => $sector->sector_id,
                  ));
                  $sectorTable->update(array(
                      'status' => 0,
                  ), array(
                      'sector_id = ?' => $sector->sector_id,
                  ));
              }else{
                  $groupTable->update(array(
                      'sector_id' => $sector->sector_id,
                  ), array(
                      'sector_id = ?' => 0,
                  ));
                  $sectorTable->update(array(
                      'status' => 1,
                  ), array(
                      'sector_id = ?' => $sector->sector_id,
                  ));
              }
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

      if($status==1){// Output
          $this->renderScript('admin-settings/disable-sector.tpl');
      }else{
          $this->renderScript('admin-settings/enable-sector.tpl');
      }
  }

  public function editSectorAction()
  {
      // In smoothbox
      $this->_helper->layout->setLayout('admin-simple');
      $form = $this->view->form = new Company_Form_Admin_Sector();
      $form->setAction($this->getFrontController()->getRouter()->assemble(array()));

      // Must have an id
      if( !($id = $this->_getParam('id')) ) {
          die('No identifier specified');
      }

      $SectorTable = Engine_Api::_()->getDbtable('sectors', 'company');
      $sector = $SectorTable->find($id)->current();
      $form->setField($sector);

      // Check post
      if( $this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost()) ) {
          // Ok, we're good to add field
          $values = $form->getValues();

          $db = Engine_Db_Table::getDefaultAdapter();
          $db->beginTransaction();

          try {
              $sector->title = $values["label"];
              $sector->save();

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

      // Output
      $this->renderScript('admin-settings/form.tpl');
  }
  public function editIndustriesAction()
  {
      // In smoothbox
      $this->_helper->layout->setLayout('admin-simple');
      $form = $this->view->form = new Company_Form_Admin_Industries();
      $form->setAction($this->getFrontController()->getRouter()->assemble(array()));

      // Must have an id
      if( !($id = $this->_getParam('id')) ) {
          die('No identifier specified');
      }

      $industriesTable = Engine_Api::_()->getDbtable('industries', 'company');
      $industry = $industriesTable->find($id)->current();
      $form->setField($industry);

      // Check post
      if( $this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost()) ) {
          // Ok, we're good to add field
          $values = $form->getValues();

          $db = Engine_Db_Table::getDefaultAdapter();
          $db->beginTransaction();

          try {
              $industry->title = $values["label"];
              $industry->save();

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

      // Output
      $this->renderScript('admin-settings/form.tpl');
  }


  public function editCategoryAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $form = $this->view->form = new Company_Form_Admin_Category();
    $form->setAction($this->getFrontController()->getRouter()->assemble(array()));

    // Must have an id
    if( !($id = $this->_getParam('id')) ) {
      die('No identifier specified');
    }

    $categoryTable = Engine_Api::_()->getDbtable('categories', 'company');
    $category = $categoryTable->find($id)->current();
    $form->setField($category);

    // Check post
    if( $this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost()) ) {
      // Ok, we're good to add field
      $values = $form->getValues();

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try {
        $category->title = $values["label"];
        $category->save();

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

    // Output
    $this->renderScript('admin-settings/form.tpl');
  }
  public function addSubcategoryAction()
  {

      $id = $this->_getParam('parent_id');
      $log = Engine_Api::_ ()->getApi ( 'core', 'socialapi' )->getLog ();
      $log->log("Id______".json_encode($id),Zend_Log::DEBUG);
      // In smoothbox
      $this->_helper->layout->setLayout('admin-simple');

      // Generate and assign form
      $form = $this->view->form = new Company_Form_Admin_Subcategory();
      /*  $categories = Engine_Api::_()->getDbtable('categories', 'faith')->getCategoriesAssocParent();
       $form->category_id->addMultiOptions($categories); */

      $form->setAction($this->getFrontController()->getRouter()->assemble(array()));

      // Check post
      if( $this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost()) ) {
          // we will add the categoryx
          $values = $form->getValues();

          $log->log("Create Form values:::".json_encode($values),Zend_Log::DEBUG);
          $db = Engine_Db_Table::getDefaultAdapter();
          $db->beginTransaction();

          try {
              // add category to the database
              // Transaction
              $table = Engine_Api::_()->getDbtable('categories', 'company');
              // insert the category into the database
              $row = $table->createRow();
              $row->title = $values["label"];
              $row->parent_id = $id;
              $row->save();

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

      // Output
      $this->renderScript('admin-settings/form.tpl');
  }
  public function editRelationshipAction()
  {
  	// In smoothbox
  	$this->_helper->layout->setLayout('admin-simple');
  	$form = $this->view->form = new Company_Form_Admin_Relationship();
  	$form->setAction($this->getFrontController()->getRouter()->assemble(array()));

  	// Must have an id
  	if( !($id = $this->_getParam('id')) ) {
  		die('No identifier specified');
  	}

  	$relationshipTable = Engine_Api::_()->getDbtable('relationships', 'company');
  	$relationship= $relationshipTable->find($id)->current();
  	$form->setField($relationship);

  	// Check post
  	if( $this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost()) ) {
  		// Ok, we're good to add field
  		$values = $form->getValues();

  		$db = Engine_Db_Table::getDefaultAdapter();
  		$db->beginTransaction();

  		try {
  			$relationship->title = $values["label"];
  			$relationship->save();

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

  	// Output
  	$this->renderScript('admin-settings/form.tpl');
  }
  public function statusCategoryAction()
  {
      // In smoothbox
      $this->_helper->layout->setLayout('admin-simple');
      $id = $this->_getParam('id');
      $status = $this->_getParam('status');
      $this->view->group_id=$id;

      $groupTable = Engine_Api::_()->getDbtable('groups', 'company');
      $categoryTable = Engine_Api::_()->getDbtable('categories', 'company');
      $category = $categoryTable->find($id)->current();

      // Check post
      if( $this->getRequest()->isPost() ) {
          $db = $categoryTable->getAdapter();
          $db->beginTransaction();

          try {
              // go through logs and see which groups used this category id and set it to ZERO

              if($status==1){
                  $groupTable->update(array(
                      'category_id' => 0,
                  ), array(
                      'category_id = ?' => $category->getIdentity(),
                  ));
                  $categoryTable->update(array(
                      'status' => 0,
                  ), array(
                      'category_id = ?' => $category->getIdentity(),
                  ));
              }else{
                  $groupTable->update(array(
                      'category_id' => $category->getIdentity(),
                  ), array(
                      'category_id = ?' => 0,
                  ));
                  $categoryTable->update(array(
                      'status' => 1,
                  ), array(
                      'category_id = ?' => $category->getIdentity(),
                  ));
              }
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

      if($status==1){// Output
          $this->renderScript('admin-settings/disable-category.tpl');
      }else{
          $this->renderScript('admin-settings/enable-category.tpl');
      }
  }

  public function statusSubcategoryAction()
  {
      // In smoothbox
      $this->_helper->layout->setLayout('admin-simple');
      $id = $this->_getParam('id');
      $status = $this->_getParam('status');
      $this->view->group_id=$id;

      $groupTable = Engine_Api::_()->getDbtable('groups', 'company');
      $categoryTable = Engine_Api::_()->getDbtable('categories', 'company');
      $category = $categoryTable->find($id)->current();

      // Check post
      if( $this->getRequest()->isPost() ) {
          $db = $categoryTable->getAdapter();
          $db->beginTransaction();

          try {
              // go through logs and see which groups used this category id and set it to ZERO

              if($status==1){
                  $groupTable->update(array(
                      'category_id_level_one' => 0,
                  ), array(
                      'category_id_level_one = ?' => $category->getIdentity(),
                  ));
                  $categoryTable->update(array(
                      'status' => 0,
                  ), array(
                      'category_id = ?' => $category->getIdentity(),
                  ));
              }else{
                  $groupTable->update(array(
                      'category_id_level_one' => $category->getIdentity(),
                  ), array(
                      'category_id_level_one = ?' => 0,
                  ));
                  $categoryTable->update(array(
                      'status' => 1,
                  ), array(
                      'category_id = ?' => $category->getIdentity(),
                  ));
              }
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

      if($status==1){// Output
          $this->renderScript('admin-settings/disable-category.tpl');
      }else{
          $this->renderScript('admin-settings/enable-category.tpl');
      }
  }

  public function importAction()
  {
     //$this->_helper->layout->setLayout('admin-simple');
      $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('company_admin_main', array(), 'company_admin_main_import');
      $log = Zend_Registry::get('Zend_Log');


      $form = $this->view->form = new Company_Form_Admin_Import();


      if( !$this->getRequest()->isPost() ) {
          return;
      }

      if( !$form->isValid($this->getRequest()->getPost()) ) {
          return;
      }

      // Process
      $values = $form->getValues();
      $form->csv_file->getValue();

      // Uploading a new csv file''
      if ($form->csv_file->getValue() !== null)
      {
          $approved = 1;

          $usercsv = $form->csv_file;
          $creation_date = new Zend_Db_Expr ( 'NOW()' );
          $viewer = Engine_Api::_()->user()->getViewer();
          $userId = $viewer->getIdentity();

          try{
              $groupImporterApi = Engine_Api::_()->company();
              $csvPath = $groupImporterApi->getCsv($usercsv);
              $csv_data = array();
              $filepath = APPLICATION_PATH . '/' . $csvPath;
              $csv_data = $groupImporterApi->readCsv($filepath);

              $status = $groupImporterApi->uploadCsv($csv_data,$creation_date,$userId,$approved);
              $form->addNotice('Successfully imported the  companys from your file');

          }catch(Exception $e){

          }
      }



  }


}
