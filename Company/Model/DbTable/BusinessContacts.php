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
class Company_Model_DbTable_BusinessContacts extends Engine_Db_Table
{

    public function getHref($params = array())
    {
        $params = array_merge(array(
            'route' => 'company_extended',
            'controller' => 'business-contact',
            'action' => 'view',
            'company_id' => $this->group_id,
        ), $params);
        $route = @$params['route'];
        unset($params['route']);
        return Zend_Controller_Front::getInstance()->getRouter()->assemble($params, $route, true);
    }


}