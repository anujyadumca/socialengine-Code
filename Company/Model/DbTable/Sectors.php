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
class Company_Model_DbTable_Sectors extends Engine_Db_Table
{
    public function getSectorsAssoc()
    {
        $stmt = $this->select()
        ->from($this, array('sector_id', 'title'))
        ->where('status = ?',1)
        ->order('title ASC')
        ->query();

        $data = array();
        foreach( $stmt->fetchAll() as $sector ) {
            $data[$sector['sector_id']] = $religion['title'];
        }

        return $data;
    }

}