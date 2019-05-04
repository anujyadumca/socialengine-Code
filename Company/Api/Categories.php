<?php
class Company_Api_Categories extends Core_Api_Abstract {

	public function getParentCategoriesSelect($category_id = null){
		$selectform1options = array();

		// get all parent categories
		$categoriesTable = Engine_Api::_()->getDbtable('categories', 'company');
		$select = $categoriesTable->select()->where('parent_id = 0')->where('status = 1')->order('category_id ASC');

		// add check
		if ($category_id != null){
			$select = $select->where('category_id = ?',$category_id);
		}
		else{
			$selectform1options[''] = '';
		}

		$results = $categoriesTable->fetchAll($select);
		$selectform1options[0] = 'Select';
		array_shift($selectform1options);
		$selectform1options['231'] = 'United States';
		foreach ($results as $result){
			$selectform1options[$result['category_id']] = $result['title'];
		}
		// returning response
		return $selectform1options;
	}


	public function getParentIndustriesSelect(){
	    $selectform1options = array();

	    // get all parent categories
	    $industriesTable = Engine_Api::_()->getDbtable('industries', 'company');
	    $select = $industriesTable->select()
	    ->where('status = ?',1)
	    ->order('industry_id ASC');
	    $results = $industriesTable->fetchAll($select);

	    array_shift($selectform1options);
	    $selectform1options[0] = 'Select';
	    foreach ($results as $result){
	        $selectform1options[$result['industry_id']] = $result['title'];
	    }
	    // returning response
	    return $selectform1options;
	}



	public function getLevelOneCategoriesSelectElement($category_id_level_one)
	{
		if (!$category_id_level_one){
			return false;
		}

		// get all parent category
		$categoriesTable = Engine_Api::_()->getDbtable('categories', 'company');
		$select = $categoriesTable->select()->where('category_id =?',$category_id_level_one)->where('status = 1');
		$results = $categoriesTable->fetchRow($select);

		$selectform1options = array();

		if (count($results) > 0){
			$selectform1options[$results['category_id']] = $results['title'];
		}

		// returning response
		return $selectform1options;
	}



	public function getLevelTwoCategoriesSelectElement($category_id_level_two)
	{
		if (!$category_id_level_two){
			return false;
		}

		// get all parent category
		$categoriesTable = Engine_Api::_()->getDbtable('categories', 'company');
		$select = $categoriesTable->select()->where('category_id =?',$category_id_level_two)->where('status = 1');
		$results = $categoriesTable->fetchRow($select);

		$selectform1options = array();

		if (count($results) > 0){
			$selectform1options[$results['category_id']] = $results['title'];
		}

		// returning response
		return $selectform1options;
	}


	public function getCategoriesSelectElementBasedOnParentId($paren_category_id = null)
	{
		$selectform1options = array();

		// check validattion
		if (!$paren_category_id){
			return $selectform1options;
		}

		// get all parent category
		$categoriesTable = Engine_Api::_()->getDbtable('categories', 'company');
		$select = $categoriesTable->select()->where('parent_id =?',$paren_category_id);
		$results = $categoriesTable->fetchAll($select);

		// iterearte the array
		$selectform1options[0] = 'Select';
		if (count($results) > 0){
			foreach ($results as $result){
				$selectform1options[$result['category_id']] = $result['title'];
			}
		}

		// returning response
		return $selectform1options;
	}


	public function getParentSectorsSelect($parent_industry_id = null)
	{
	    $selectform1options = array();

	    // check validattion
	    if (!$parent_industry_id){
	        return $selectform1options;
	    }

	    // get all parent category
	    $sectorsTable = Engine_Api::_()->getDbtable('sectors', 'company');
	    $select = $sectorsTable->select()
	    ->where('status = ?',1)
	    ->where('industry_id =?',$parent_industry_id);
	    $results = $sectorsTable->fetchAll($select);

	    // iterearte the array
	    $selectform1options[0] = 'Select';
	    if (count($results) > 0){
	        foreach ($results as $result){
	            $selectform1options[$result['sector_id']] = $result['title'];
	        }
	    }

	    // returning response
	    return $selectform1options;
	}

	public function getCategoriesListBasedOnParentId($params = array()){


		// get all parent categories
		$categoriesArray = array();
		$categoriesTable = Engine_Api::_()->getDbtable('categories', 'company');
		$select = $categoriesTable->select();

		// add parentId filter
		if (isset($params['parent_id'])){
			$select->where('parent_id =?',$params['parent_id']);
		}

		// get the results
		$select->order('category_id ASC');
		$results = $categoriesTable->fetchAll($select);
		if (count($results) > 0){
			foreach ($results as $result){
				$categoriesArray[$result['category_id']] = array(
						"title" => $result['title'],
						"parent_id" => $result['parent_id'],

				);
			}
		}
		// returning response
		return $categoriesArray;
	}

	public function getCategoriesListBasedOnParentAndCategoryId($params = array()){

		// get all parent categories
		$categoriesArray = array();
		$categoriesTable = Engine_Api::_()->getDbtable('categories', 'company');
		$select = $categoriesTable->select();

		// add parentId filter
		if (isset($params['parent_id'])){
			$select->where('parent_id =?',$params['parent_id']);
		}
		if (isset($params['category_id'])){
			$select->where('category_id =?',$params['category_id']);
		}

		// get the results
		$select->order('category_id ASC');
		$results = $categoriesTable->fetchAll($select);
		if (count($results) > 0){
			foreach ($results as $result){
				$categoriesArray[$result['category_id']] = array(
						"title" => $result['title'],
						"parent_id" => $result['parent_id'],

				);
			}
		}
		// returning response
		return $categoriesArray;
	}


// 	public function getParentCategoryIdByChildCategoryId($category_id = null){

// 		if (!isset($category_id)){
// 			return 0;
// 		}

// 		// get all parent categories
// 		$categoriesTable = Engine_Api::_()->getDbtable('categories', 'company');
// 		$select = $categoriesTable->select()->where('caetgory_id =?', $category_id);
// 		$results = $categoriesTable->fetchRow($select);

// 		if ($results['category_id']){
// 			return $results['']
// 		}

// 	}


	public function getCategoryPhotoUrl($category_id) {
		if (! isset ( $category_id )) {
			return false;
		}

		return "/application/modules/Group/externals/images/nophoto_group_thumb_profile.png";

		// get photo url by category id
		$category = Engine_Api::_ ()->getItem ( 'groupimporter_category', $category_id );
		$photo_url = $category->getPhotoUrl ( 'thumb' );
		if ($photo_url) {
			return $photo_url;
		} else {
			$photo_url = "/application/modules/Group/externals/images/nophoto_group_thumb_profile.png";
		}
	}
}
