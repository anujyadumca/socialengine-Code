<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Event
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Category.php 9747 2012-07-26 02:08:08Z john $
 * @author     Jung
 */

/**
 * @category   Application_Extensions
 * @package    Event
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Company_Model_Category extends Core_Model_Category
{
  protected $_searchTriggers = false;
  protected $_route = 'company_general';

  public function getTable()
  {
    if( null === $this->_table ) {
      $this->_table = Engine_Api::_()->getDbtable('categories', 'company');
    }

    return $this->_table;
  }

  public function getUsedCount()
  {
    $eventTable = Engine_Api::_()->getItemTable('group');
    return $eventTable->select()
        ->from($eventTable, new Zend_Db_Expr('COUNT(group_id)'))
        ->where('category_id = ?', $this->category_id)
        ->query()
        ->fetchColumn();
  }

  public function isOwner($owner)
  {
    return false;
  }

  public function getOwner($recurseType = null)
  {
    return $this;
  }

  public function setPhoto($photo)
  {
      if( $photo instanceof Zend_Form_Element_File ) {
          $file = $photo->getFileName();
          $fileName = $file;
      } else if( $photo instanceof Storage_Model_File ) {
          $file = $photo->temporary();
          $fileName = $photo->name;
      } else if( $photo instanceof Core_Model_Item_Abstract && !empty($photo->file_id) ) {
          $tmpRow = Engine_Api::_()->getItem('storage_file', $photo->file_id);
          $file = $tmpRow->temporary();
          $fileName = $tmpRow->name;
      } else if( is_array($photo) && !empty($photo['tmp_name']) ) {
          $file = $photo['tmp_name'];
          $fileName = $photo['name'];
      } else if( is_string($photo) && file_exists($photo) ) {
          $file = $photo;
          $fileName = $photo;
      } else {
          throw new User_Model_Exception('invalid argument passed to setPhoto');
      }

      if( !$fileName ) {
          $fileName = $file;
      }

      $viewer = Engine_Api::_ ()->user ()->getViewer ();
      $name = basename($file);
      $extension = ltrim(strrchr(basename($fileName), '.'), '.');
      $base = rtrim(substr(basename($fileName), 0, strrpos(basename($fileName), '.')), '.');
      $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
      $params = array(
          'parent_type' => $this->getType(),
          'parent_id' => $this->getIdentity(),
          'user_id' => $viewer->getIdentity(),
          'name' => basename($fileName),
      );

      // Save
      $filesTable = Engine_Api::_()->getDbtable('files', 'storage');

      // Resize image (main)
      $mainPath = $path . DIRECTORY_SEPARATOR . $base . '_m.' . $extension;
      $image = Engine_Image::factory();
      $image->open($file)
      ->autoRotate()
      ->resize(720, 720)
      ->write($mainPath)
      ->destroy();

      // Resize image (profile)
      $profilePath = $path . DIRECTORY_SEPARATOR . $base . '_p.' . $extension;
      $image = Engine_Image::factory();
      $image->open($file)
      ->autoRotate()
      ->resize(320, 640)
      ->write($profilePath)
      ->destroy();

      // Resize image (normal)
      $normalPath = $path . DIRECTORY_SEPARATOR . $base . '_in.' . $extension;
      $image = Engine_Image::factory();
      $image->open($file)
      ->autoRotate()
      ->resize(140, 160)
      ->write($normalPath)
      ->destroy();

      // Resize image (icon)
      $squarePath = $path . DIRECTORY_SEPARATOR . $base . '_is.' . $extension;
      $image = Engine_Image::factory();
      $image->open($file)
      ->autoRotate();

      $size = min($image->height, $image->width);
      $x = ($image->width - $size) / 2;
      $y = ($image->height - $size) / 2;

      $image->resample($x, $y, $size, $size, 48, 48)
      ->write($squarePath)
      ->destroy();

      // Store
      $iMain = $filesTable->createFile($mainPath, $params);
      $iProfile = $filesTable->createFile($profilePath, $params);
      $iIconNormal = $filesTable->createFile($normalPath, $params);
      $iSquare = $filesTable->createFile($squarePath, $params);

      $iMain->bridge($iProfile, 'thumb.profile');
      $iMain->bridge($iIconNormal, 'thumb.normal');
      $iMain->bridge($iSquare, 'thumb.icon');

      // Remove temp files
      @unlink($mainPath);
      @unlink($profilePath);
      @unlink($normalPath);
      @unlink($squarePath);

      // Update row
      $this->photo_id = $iMain->file_id;
      $this->save();

      return $this;
  }

}
