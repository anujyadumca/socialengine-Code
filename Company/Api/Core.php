<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Core.php 9747 2012-07-26 02:08:08Z john $
 * @author     John
 */

/**
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Company_Api_Core extends Core_Api_Abstract
{

    public function uploadCsv(array $csv_data = array(), $creationDate, $userId, $approved) {
        $log = Zend_Registry::get ( 'Zend_Log' );
        $final_array = array ();

        /*
         * $log->log ("creation date____".$creationDate, Zend_Log::DEBUG );
         * $log->log ("userId____".$userId, Zend_Log::DEBUG );
         * $log->log ("approved___".$approved, Zend_Log::DEBUG );
         * $log->log ("csv data____".json_encode($csv_data), Zend_Log::DEBUG );
         */

        $this->insertGroup ( $csv_data, $creationDate, $userId, $approved );
    }

    public function insertGroup(array $groupdata = array(), $creationDate, $userId, $approved) {
        $log = Zend_Registry::get ( 'Zend_Log' );

        $enabled = 0;
        if ($approved == 1) {
            $enabled = 1;
        }
        date_default_timezone_set ( timezone_name_from_abbr ( "EST" ) );

        foreach ( $groupdata as $value ) {
            $user_id = $userId;
            $creation_date;
            $approved;
            $image = null;
            $groupName = null;
            try {

                if (isset ( $value )) {
                    $groupName = $value [0];
                    $description = $value [1];
                    $image = $value [2];
                    $imagecat = $value [3];
                    $category = $value [4];
                    $imagecatone = $value [5];
                    $categoryOne = $value [6];
                    $imagecattwo = $value [7];
                    $categoryTwo = $value [8];
                    $categoryName = trim ( $category );
                    $categoryNameOne = trim ( $categoryOne );
                    $categoryNameTwo = trim ( $categoryTwo );
                    $log->log("images____".($image),Zend_Log::DEBUG);
                    $tmpfile = $this->_fetchImage ( $image );
                }

                $data = array (

                    'category' => $category,
                    'categoryOne' => $categoryNameOne,
                    'categoryTwo' => $categoryNameTwo

                );

                //if category not exist
                $categoryStatus = $this->getCategoiresExist ( $data );
                $log->log ("catstatus_____company".json_encode($categoryStatus['category']['status']), Zend_Log::DEBUG );
                if($categoryStatus['category']['status'] == 'true'){

                    $category = $categoryStatus['category']['category_id'];

                    //$log->log ("image1___".json_encode($photoid), Zend_Log::DEBUG );
                }else{

                    $params = array(
                        'title'=> $category,
                        'parent_id' => 0

                    );
                    $category = $this->insertCategoriesByName($params);
                    if($imagecat){
                        $photoid = $this->getPhotoId($category,$imagecat);
                        $log->log ("image1___".json_encode($photoid), Zend_Log::DEBUG );
                    }
                }

                if($categoryStatus['categoryOne']['status'] == 'true'){

                    $categoryOne = $categoryStatus['categoryOne']['category_id'];

                }else{

                    $params = array(
                        'title'=> $categoryNameOne,
                        'parent_id' => $category

                    );
                    $categoryOne = $this->insertCategoriesByName($params);
                    if($imagecatone){
                        $photoid = $this->getPhotoId($categoryOne,$imagecatone);
                        $log->log ("image1_company__".json_encode($photoid), Zend_Log::DEBUG );
                    }
                }

                if($categoryStatus['categoryTwo']['status'] == 'true'){

                    $categoryTwo = $categoryStatus['categoryTwo']['category_id'];
                    $this->getPhotoId($categoryTwo,$imagecattwo);
                }else{

                    $params = array(
                        'title'=> $categoryNameTwo,
                        'parent_id' => $categoryOne

                    );
                    if($categoryNameTwo){
                        $categoryTwo = $this->insertCategoriesByName($params);
                    }
                    if($imagecattwo){
                        $this->getPhotoId($categoryTwo,$imagecattwo);
                    }
                }

                /* $ids = $this->getCategoiresIdByName($categoryName,$categoryNameOne,$categoryNameTwo,$imagecat,$imagecatone,$imagecattwo);
                 $log->log("step1___".json_encode($ids),Zend_Log::DEBUG);
                 $category = $ids['catid'];
                 $categoryOne = $ids['catone'];
                 $categoryTwo = $ids['catetwo']; */

                if (isset ( $creationDate)) {
                    $datestring = $creationDate;
                    $creationDate= date('Y-m-d H:i:s T',strtotime($datestring . ' UTC'));
                    //$log->log("creation date____".$creationDate,Zend_Log::DEBUG);
                    $modifiedDate = date('Y-m-d H:i:s T',strtotime($datestring . ' UTC'));
                }
                $imagedata = file_get_contents ( $tmpfile);
                // alternatively specify an URL, if PHP settings allow
                $base64 = base64_encode ( $imagedata );
                $log->log("base64____".$base64,Zend_Log::DEBUG);
                $groupData = array(

                    'apiKey' => 'meggalife',
                    'secretKey' => 'meggalife123',
                    'title' => $groupName,
                    'description' => $description,
                    'category_id' => $category,
                    'category_id_level_one' => $categoryOne,
                    'category_id_level_two' => $categoryTwo,
                    'search' => 1,
                    'data' => $base64,
                    'approval' => 1,
                    'auth_invite' => 1,
                    'view_privacy' => "everyone",
                    'auth_comment' => "registered",
                    'auth_photo' => "registered",
                    'auth_event' => "registered",
                );
              $createGroup = Engine_Api::_ ()->getApi ( 'company', 'socialapi' )->socialcreateGroup($groupData);

            } catch (Exception $e) {
                $log->log($e, Zend_Log::CRIT);
            }
        }
    }


    public function insertCategoriesByName($params){

        $categoryTable = Engine_Api::_ ()->getDbTable ( 'categories', 'company' );

        $params = array (
            'title' => $params['title'],
            'parent_id' => $params['parent_id']
        );


        $categoryId = $categoryTable->insert ($params);
        return $categoryId;

    }


    public function getCategoiresExist($data = array ()) {
        $log = Zend_Registry::get ( 'Zend_Log' );


        // call funcation
        $category = $this->GetCategoryStatus( $data ['category'],0);

        if($category == false){

            $data = array (
                'category' => false,
                'categoryOne' => false,
                'categoryTwo' => false
            );
            $log->log("Step_1false".json_encode($data), Zend_Log::DEBUG);
            return $data;
        }

        $log->log("Step_1".json_encode($category), Zend_Log::DEBUG);

        // call funcation
        $categoryOne = $this->GetCategoryStatus(  $data ['categoryOne'],$category['category_id']);
        if($categoryOne == false){

            $data = array (
                'category' => $category,
                'categoryOne' => false,
                'categoryTwo' => false
            );
            $log->log("Step_2false".json_encode($data), Zend_Log::DEBUG);
            return $data;
        }
        $log->log("Step_2".json_encode($categoryOne), Zend_Log::DEBUG);

        // call funcation
        $categoryTwo = $this->GetCategoryStatus( $data ['categoryTwo'],$categoryOne['category_id']);
        if($categoryTwo == false){
            $data = array (
                'category' => $category,
                'categoryOne' => $categoryOne,
                'categoryTwo' => false
            );
            $log->log("Step_2false".json_encode($data), Zend_Log::DEBUG);
            return $data;

        }

        // returnng responses
        $data = array (
            'category' => $category,
            'categoryOne' => $categoryOne,
            'categoryTwo' => $categoryTwo
        );
        $log->log("Step_4".json_encode($data), Zend_Log::DEBUG);
        return $data;

    }

    public function GetCategoryStatus($category = null,$parent_id) {
        $log = Zend_Registry::get ( 'Zend_Log' );
        if (!isset($category)){
            return false;
        }

        $categoryTable = Engine_Api::_ ()->getDbTable ( 'categories', 'company' );
        $categorySelect = $categoryTable->select ()->where ( 'title = ?', $category )
        ->where ( 'parent_id = ?', $parent_id);

        $log->log("Query__".$categorySelect, Zend_Log::DEBUG);
        $category = $categoryTable->fetchRow ( $categorySelect );
        $log = Zend_Registry::get ( 'Zend_Log' );

        if ($category ['category_id']) {
            return array (
                "status" => true,
                "category_id" => $category ['category_id'],
                "parent_id" => $category ['parent_id']
            );
        } else {
            return false;
        }
    }

    public function getCsv($usercsv) {
        if ($usercsv instanceof Zend_Form_Element_File) {
            $file = $usercsv->getFileName ();
            $fileName = $file;
        } else if ($usercsv instanceof Storage_Model_File) {
            $file = $usercsv->temporary ();
            $fileName = $usercsv->name;
        } else if ($usercsv instanceof Core_Model_Item_Abstract && ! empty ( $usercsv->file_id )) {
            $tmpRow = Engine_Api::_ ()->getItem ( 'storage_file', $usercsv->file_id );
            $file = $tmpRow->temporary ();
            $fileName = $tmpRow->name;
        } else if (is_array ( $usercsv ) && ! empty ( $usercsv ['tmp_name'] )) {
            $file = $usercsv ['tmp_name'];
            $fileName = $usercsv ['name'];
        } else if (is_string ( $usercsv ) && file_exists ( $usercsv )) {
            $file = $usercsv;
            $fileName = $usercsv;
        } else {
            throw new User_Model_Exception ( 'invalid argument passed to setfile' );
        }

        if (! $fileName) {
            $fileName = $file;
        }

        if (! file_exists ( 'public/csv' )) {
            mkdir ( 'public/csv' );
        }
        rename ( $fileName, 'public/csv/' . basename ( $file ) );
        return 'public/csv/' . basename ( $file );
    }
    public function readCsv($filepath) {
        ini_set ( 'auto_detect_line_endings', TRUE );
        $log = Zend_Registry::get ( 'Zend_Log' );
        $values = array ();
        $line_of_text = array ();
        $file_handle = fopen ( $filepath, "r" );
        /*
         * while ( ! feof ( $file_handle ) ) {
         *
         * $line_of_text [] = fgetcsv ( $file_handle, 1024 );
         * }
         */
        $row = 1;
        while ( ($line = fgetcsv ( $file_handle )) !== FALSE ) {
            if ($row == 1) {
                $row ++;
                continue;
            }
            $line_of_text [] = $line;
        }
        fclose ( $file_handle );
        ini_set ( 'auto_detect_line_endings', FALSE );
        // $log->log("read file array".json_encode($line_of_text),Zend_Log::DEBUG);
        return $line_of_text;
    }

    protected function getPhotoId($category_id, $photo_url) {
        $log = Zend_Registry::get ( 'Zend_Log' );
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $photo_url );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt ( $ch, CURLOPT_MAXREDIRS, 5 );
        $data = curl_exec ( $ch );
        curl_close ( $ch );

        $tmpfile = APPLICATION_PATH_TMP . DS . md5 ( $photo_url ) . '.jpg';
        @file_put_contents ( $tmpfile, $data );
        $log->log("tempfile".json_encode($tmpfile),Zend_Log::DEBUG);
        $categoryTable = Engine_Api::_ ()->getDbTable ( 'categories', 'company' );
        $categorySelect = $categoryTable->select ()->where ( 'category_id = ?', $category_id );
        $category = $categoryTable->fetchRow ( $categorySelect );
       // $category = Engine_Api::_ ()->getItem ( 'company_category', $category_id );

        $category->setPhoto ( $tmpfile );

        $photo_url = $category->getPhotoUrl ( 'thumb' );
        $log->log("photourl___".json_encode($photo_url),Zend_Log::DEBUG);
        return $photo_url;
    }
    public function getCategoryPhotoUrl($category_id) {

    	$log = Engine_Api::_ ()->getApi ( 'core', 'socialapi' )->getLog ();
    	$log->log("getCategoryPhotoUrl Step 1:::",Zend_Log::DEBUG);



        if (! isset ( $category_id )) {
            return false;
        }

        $log->log("getCategoryPhotoUrl Step 2:::".$category_id,Zend_Log::DEBUG);

        // get photo url by category id
        $categoryTable = Engine_Api::_ ()->getDbTable ( 'categories', 'company' );
        $categorySelect = $categoryTable->select ()->where ( 'category_id = ?', $category_id );
        $category = $categoryTable->fetchRow ( $categorySelect );

        //$category = Engine_Api::_ ()->getItem ( 'company_category', $category_id );
        $photo_url = $category->getPhotoUrl ( 'thumb' );

        $log->log("getCategoryPhotoUrl Step 3:::".$photo_url,Zend_Log::DEBUG);
        if ($photo_url) {
            return $photo_url;
        } else {
            return $photo_url = "/application/modules/Company/externals/images/nophoto_group_thumb_profile.png";
        }
    }
    protected function _fetchImage($photo_url) {
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $photo_url );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt ( $ch, CURLOPT_MAXREDIRS, 5 );
        $data = curl_exec ( $ch );
        curl_close ( $ch );

        $tmpfile = APPLICATION_PATH_TMP . DS . md5 ( $photo_url ) . '.jpg';
        @file_put_contents ( $tmpfile, $data );
        //$log->log("temp Path".json_encode($tmpfile),Zend_Log::DEBUG);
        return $tmpfile;
    }


    public function getItemTableClass($type)
	{
		$log = Engine_Api::_ ()->getApi ( 'core', 'socialapi' )->getLog ();

		// Generate item table class manually
		$module = Engine_Api::_()->getItemInfo($type, 'moduleInflected');
		$class = $module . '_Model_DbTable_' . self::typeToClassSuffix($type, $module);
		if (substr($class, -1, 1) === 'y' && substr($class, -3) !== 'way') {
			$class = substr($class, 0, -1) . 'ies';
		} elseif (substr($class, -1, 1) !== 's') {
			$class .= 's';
		}

// 		$log->log("getItemTableClass:::".$class,Zend_Log::DEBUG);
		return $class;
	}

	public static function typeToClassSuffix($type, $module)
	{
		$log = Engine_Api::_ ()->getApi ( 'core', 'socialapi' )->getLog ();
// 		$log->log($module. ":::typeToClassSuffix:::".$type,Zend_Log::DEBUG);

		if ($type == "company_list" ){
			return "List";
		}
		else if ($type == "company" ){
			return "Group";
		}
		else if ($type == "company_photo" ){
			return "Photo";
		}
		else if ($type == "company_album" ){
			return "Album";
		}
		else if ($type == "company_list_item" ){
			return "ListItem";
		}
		else if ($type == "company_topic" ){
			return "Topic";
		}
		else if ($type == "company_post" ){
			return "Post";
		}

		return "Group";
	}
	
	public function isUserAlreadyClaim ( $user_id, $company_id ) {
		// get claim company id
		$claimTable = Engine_Api::_ ()->getDbTable ( 'claims', 'company' );
		$claimSelect = $claimTable->select ()->where ( 'company_id = ?', $company_id )->where( 'user_id = ?', $user_id );
		$isclaim= $claimTable->fetchRow ( $claimSelect );
		if( count($isclaim) > 0  ) {
			return true;
		}else {
			return false;
		}
	}
}
