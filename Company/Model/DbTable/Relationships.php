<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Categories.php 9747 2012-07-26 02:08:08Z john $
 * @author     John
 */

/**
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Company_Model_DbTable_Relationships extends Engine_Db_Table
{
  protected $_rowClass = 'Company_Model_Relationship';
  //protected $_name = 'Family_categories';

  public function getRelationshipsAssoc()
  {
    $stmt = $this->select()
        ->from($this, array('relationship_id', 'title'))
        ->order('relationship_id ASC')
        ->query();

    $data = array();
    foreach( $stmt->fetchAll() as $relationship) {
    	$data[$relationship['relationship_id']] = $relationship['title'];
    }

    return $data;
  }
}