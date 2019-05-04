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
class Company_Model_DbTable_Industries extends Engine_Db_Table
{
    public function getIndustriesAssoc()
    {
        $stmt = $this->select()
        ->from($this, array('industry_id', 'title'))
        ->where('status = ?',1)
        ->order('title ASC')
        ->query();

        $data = array();
        foreach( $stmt->fetchAll() as $industries ) {
            $data[$industries['industry_id']] = $industries['title'];
        }

        return $data;
    }

}