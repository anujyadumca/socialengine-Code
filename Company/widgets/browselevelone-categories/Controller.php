<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Controller.php 9791 2016-12-08 20:41:41Z pamela $
 * @author     Sami
 */

/**
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2016 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Company_Widget_BrowseleveloneCategoriesController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
  	$log = Engine_Api::_ ()->getApi ( 'core', 'socialapi' )->getLog ();

  	// get all params
  	$request = Zend_Controller_Front::getInstance()->getRequest();
  	$params = $request->getParams();

  	// displaying categories/group based on the params
  	$data = array();
  	if (isset($params['category_id']) && $params['category_id'] > 0){
  		$data['parent_id'] = 0;
  		$data['category_id'] = $params['category_id'];
  		//	$this->view->categories = Engine_Api::_()->getApi('categories', 'core')->getNavigation('group');
  		$this->view->categories = $categories = Engine_Api::_ ()->getApi ( 'categories', 'company' )->getCategoriesListBasedOnParentAndCategoryId($data);

  		if( count($this->view->categories) < 1 ){
  			$this->view->emptyCategories = true;
  		}
  	}
  	else{
  		$data['parent_id'] = 0;
  		$this->view->categories = $categories = Engine_Api::_ ()->getApi ( 'categories', 'company' )->getCategoriesListBasedOnParentId ($data);

  		if( count($this->view->categories) < 1 ){
  			$this->view->emptyCategories = true;
  		}
  	}

// 	// do not render if no results
//     if( count($this->view->categories) < 1 ) {
//       return $this->setNoRender();
//     }
  }
}
