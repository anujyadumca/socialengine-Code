<?php

class Company_CategoryController extends Core_Controller_Action_Standard
{
  public function indexAction()
  {
    $this->view->someVar = 'someVal';
    $this->_redirectCustom(array('route' => 'company_categories_general', 'action' => 'browse'));
  }


  public function levelonecategoriesAction()
  {
  	$category_id = $this->_getParam('category_id');

  	// add category validation
  	if (!$category_id){
  		$response['posts'] = "<option value=0>--select--</option>";
  		$response['posts'] .= "<select name='selectform2' id='selectform2'>";
  		$response['posts'] .= "</select>";
  		return $this->_helper->json($response);
  	}

  	// get all sub categories based on the parent category
  	$categoriesTable = Engine_Api::_()->getDbtable('categories', 'company');
  	$select = $categoriesTable->select()->where('parent_id = ?',$category_id)->where('status = 1')->order('category_id ASC');
  	$results = $categoriesTable->fetchAll($select);

  	// iterating the results
  	$response['posts'] = "<option value=0>--select--</option>";
  	if (count($results) > 0){
  		$response['posts'] .= "<select name='selectform2' id='selectform2'>";
  		foreach ($results as $result){
  			$subcategory_id = $result['category_id'];
  			$subcategory_lebel =  $result['title'];
  			$response['posts'] .= '<option value="'.$subcategory_id.'">';
  			$response['posts'] .= $subcategory_lebel;
  			$response['posts'] .= '</option>';
  		}
  		$response['posts'] .= "</select>";
  	}
  	else{
  		$response['posts'] = "<option value=0>--select--</option>";
  		$response['posts'] .= "<select name='selectform2' id='selectform2'>";
  		$response['posts'] .= "</select>";
  	}

  	// returning response
  	return $this->_helper->json($response);
  }

  public function leveltwocategoriesAction()
  {
  	$category_id = $this->_getParam('category_id');

  	if (!$category_id){
  		$response['posts'] = "<option value=0>--select--</option>";
  		$response['posts'] .= "<select name='selectform2' id='selectform2'>";
  		$response['posts'] .= "</select>";
  		return $this->_helper->json($response);
  	}


  	// get all sub categories based on the parent category
  	$categoriesTable = Engine_Api::_()->getDbtable('categories', 'company');
  	$select = $categoriesTable->select()->where('parent_id = ?',$category_id)->order('category_id ASC');
  	$results = $categoriesTable->fetchAll($select);

  	$response['posts'] = "<option value=0>--select--</option>";
  	if (count($results) > 0){
  		$response['posts'] .= "<select name='selectform3' id='selectform3'>";
  		foreach ($results as $result){
  			$subcategory_id = $result['category_id'];
  			$subcategory_lebel =  $result['title'];
  			$response['posts'] .= '<option value="'.$subcategory_id.'">';
  			$response['posts'] .= $subcategory_lebel;
  			$response['posts'] .= '</option>';
  		}
  		$response['posts'] .= "</select>";
  	}
  	else{
  		$response['posts'] = "<option value=0>--select--</option>";
  		$response['posts'] .= "<select name='selectform2' id='selectform2'>";
  		$response['posts'] .= "</select>";
  	}

  	// returning response
  	return $this->_helper->json($response);
  }

  public function sectorsAction()
  {
      $industry_id = $this->_getParam('industry_id');

      if (!$industry_id){
          $response['posts'] = "<option value=0>--select--</option>";
          $response['posts'] .= "<select name='selectform2' id='selectform2'>";
          $response['posts'] .= "</select>";
          return $this->_helper->json($response);
      }


      // get all sub categories based on the parent category
      $sectorsTable = Engine_Api::_()->getDbtable('sectors', 'company');
      $select = $sectorsTable->select()->where('industry_id = ?',$industry_id)
      ->where('status = ?',1)
      ->order('sector_id ASC');
      $results = $sectorsTable->fetchAll($select);

      $response['posts'] = "<option value=0>--select--</option>";
      if (count($results) > 0){
          $response['posts'] .= "<select name='selectform3' id='selectform3'>";
          foreach ($results as $result){
              $subcategory_id = $result['sector_id'];
              $subcategory_lebel =  $result['title'];
              $response['posts'] .= '<option value="'.$subcategory_id.'">';
              $response['posts'] .= $subcategory_lebel;
              $response['posts'] .= '</option>';
          }
          $response['posts'] .= "</select>";
      }
      else{
          $response['posts'] = "<option value=0>--select--</option>";
          $response['posts'] .= "<select name='selectform2' id='selectform2'>";
          $response['posts'] .= "</select>";
      }

      // returning response
      return $this->_helper->json($response);
  }


  public function browseAction()
  {
  	$viewer = Engine_Api::_()->user()->getViewer();

  	// Check create
  	$this->view->canCreate = Engine_Api::_()->authorization()->isAllowed('company', null, 'create');

  	// Form
  	$this->view->formFilter = $formFilter = new Company_Form_Filter_Browse();
  	$defaultValues = $formFilter->getValues();

  	if( !$viewer || !$viewer->getIdentity() ) {
  		$formFilter->removeElement('view');
  	}

  	/* // Populate options
  	$categories = Engine_Api::_()->getDbtable('categories', 'company')->getCategoriesAssoc();
  	$formFilter->category_id->addMultiOptions($categories); */

  	// Populate form data
  	if( $formFilter->isValid($this->_getAllParams()) ) {
  		$this->view->formValues = $values = $formFilter->getValues();
  	} else {
  		$formFilter->populate($defaultValues);
  		$this->view->formValues = $values = array();
  	}

  	// Prepare data
  	$this->view->formValues = $values = $formFilter->getValues();

  	if( $viewer->getIdentity() && @$values['view'] == 1 ) {
  		$values['users'] = array();
  		foreach( $viewer->membership()->getMembersInfo(true) as $memberinfo ) {
  			$values['users'][] = $memberinfo->user_id;
  		}
  	}

  	$values['search'] = 1;

  	// check to see if request is for specific user's listings
  	$user_id = $this->_getParam('user');
  	if( $user_id ) {
  		$values['user_id'] = $user_id;
  	}


  	// Make paginator
  	$this->view->paginator = $paginator = Engine_Api::_()->getItemTable('company_group')
  	->getGroupPaginator($values);

  	$paginator->setCurrentPageNumber($this->_getParam('page'));


//   	// Render
//   	$this->_helper->content
//   	//->setNoRender()
//   	->setEnabled()
//   	;

  	$this->_helper->content
  	->setContentName("company_category_browse_page") // page_id
  	->setNoRender()
  	->setEnabled();
  	return;
  }


  public function browseleveloneAction()
  {
  	$viewer = Engine_Api::_()->user()->getViewer();

  	// Check create
  	$this->view->canCreate = Engine_Api::_()->authorization()->isAllowed('company', null, 'create');

  	// Form
  	$this->view->formFilter = $formFilter = new Company_Form_Filter_Browse();
  	$defaultValues = $formFilter->getValues();

  	if( !$viewer || !$viewer->getIdentity() ) {
  		$formFilter->removeElement('view');
  	}

  	// Populate options
  	$categories = Engine_Api::_()->getDbtable('categories', 'company')->getCategoriesAssoc();
  	$formFilter->category_id->addMultiOptions($categories);

  	// Populate form data
  	if( $formFilter->isValid($this->_getAllParams()) ) {
  		$this->view->formValues = $values = $formFilter->getValues();
  	} else {
  		$formFilter->populate($defaultValues);
  		$this->view->formValues = $values = array();
  	}

  	// Prepare data
  	$this->view->formValues = $values = $formFilter->getValues();

  	if( $viewer->getIdentity() && @$values['view'] == 1 ) {
  		$values['users'] = array();
  		foreach( $viewer->membership()->getMembersInfo(true) as $memberinfo ) {
  			$values['users'][] = $memberinfo->user_id;
  		}
  	}

  	$values['search'] = 1;

  	// check to see if request is for specific user's listings
  	$user_id = $this->_getParam('user');
  	if( $user_id ) {
  		$values['user_id'] = $user_id;
  	}


  	// Make paginator
  	$this->view->paginator = $paginator = Engine_Api::_()->getItemTable('company_group')
  	->getGroupPaginator($values);

  	$paginator->setCurrentPageNumber($this->_getParam('page'));


  	//   	// Render
  	//   	$this->_helper->content
  	//   	//->setNoRender()
  	//   	->setEnabled()
  	//   	;

  	$this->_helper->content
  	->setContentName("company_category_browse_page_level_one") // page_id
  	->setNoRender()
  	->setEnabled();
  	return;
  }


  public function browseleveltwoAction()
  {
  	$viewer = Engine_Api::_()->user()->getViewer();

  	// Check create
  	$this->view->canCreate = Engine_Api::_()->authorization()->isAllowed('company', null, 'create');

  	// Form
  	$this->view->formFilter = $formFilter = new Company_Form_Filter_Browse();
  	$defaultValues = $formFilter->getValues();

  	if( !$viewer || !$viewer->getIdentity() ) {
  		$formFilter->removeElement('view');
  	}

  	// Populate options
  	$categories = Engine_Api::_()->getDbtable('categories', 'company')->getCategoriesAssoc();
  	$formFilter->category_id->addMultiOptions($categories);

  	// Populate form data
  	if( $formFilter->isValid($this->_getAllParams()) ) {
  		$this->view->formValues = $values = $formFilter->getValues();
  	} else {
  		$formFilter->populate($defaultValues);
  		$this->view->formValues = $values = array();
  	}

  	// Prepare data
  	$this->view->formValues = $values = $formFilter->getValues();

  	if( $viewer->getIdentity() && @$values['view'] == 1 ) {
  		$values['users'] = array();
  		foreach( $viewer->membership()->getMembersInfo(true) as $memberinfo ) {
  			$values['users'][] = $memberinfo->user_id;
  		}
  	}

  	$values['search'] = 1;

  	// check to see if request is for specific user's listings
  	$user_id = $this->_getParam('user');
  	if( $user_id ) {
  		$values['user_id'] = $user_id;
  	}


  	// Make paginator
  	$this->view->paginator = $paginator = Engine_Api::_()->getItemTable('company_group')
  	->getGroupPaginator($values);

  	$paginator->setCurrentPageNumber($this->_getParam('page'));


  	//   	// Render
  	//   	$this->_helper->content
  	//   	//->setNoRender()
  	//   	->setEnabled()
  	//   	;

  	$this->_helper->content
  	->setContentName("company_category_browse_page_level_two") // page_id
  	->setNoRender()
  	->setEnabled();
  	return;
  }

}
