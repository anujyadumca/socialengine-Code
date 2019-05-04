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
class Company_Widget_BrowselevelthreeCategoriesController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
  	$log = Engine_Api::_ ()->getApi ( 'core', 'socialapi' )->getLog ();

  	// get all params
  	$request = Zend_Controller_Front::getInstance()->getRequest();
  	$params = $request->getParams();

  	// displaying categories/group based on the params
  	$data = array();
  	if (isset($params['category_id_level_one']) && $params['category_id_level_one'] > 0){
  		$data['parent_id'] = $params['category_id'];
  		$this->view->category_id = $data['category_id'] = $params['category_id_level_one'];
  		$this->view->categories = $categories = Engine_Api::_ ()->getApi ( 'categories', 'company' )->getCategoriesListBasedOnParentAndCategoryId($data);
  	}
  	else if (isset($params['category_id']) && $params['category_id'] > 0){
  		$this->view->category_id = $data['parent_id'] = $params['category_id'];
  		$this->view->categories = $categories = Engine_Api::_ ()->getApi ( 'categories', 'company' )->getCategoriesListBasedOnParentId($data);

  		if( count($this->view->categories) < 1 ){
  			$data['category_id_level_one'] = $params['category_id'];
  			$paginator = Engine_Api::_()->getItemTable('group')->getGroupPaginator($data);

  			// check paginer contains the value or not
  			if (count($paginator) > 0){
  				$this->view->paginator = $paginator;
  			}
  			else{

  				$this->view->emptyCategories = true;
  			}
  		}
  	}
  	else{
  		$this->view->noCategoryFound = true;
  	}
  }
}
