<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Controller.php 9747 2012-07-26 02:08:08Z john $
 * @author     John Boehr <john@socialengine.com>
 */

/**
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Company_Widget_BrowseCustomersController extends Engine_Content_Widget_Abstract
{
	public function indexAction()
	{
	    $log = Engine_Api::_ ()->getApi ( 'core', 'socialapi' )->getLog ();

    	    // Don't render this if not authorized
    	    $viewer = Engine_Api::_()->user()->getViewer();
    	    $log->log("viewer".json_encode($viewer->toArray()),Zend_Log::DEBUG);

	        $subject = Engine_Api::_()->core()->getSubject('company_group');
	        $owner = $subject->isOwner($viewer);
	        $id = Engine_Api::_()->core()->getSubject()->getIdentity();
	        $CompanyCustomersTable = Engine_Api::_ ()->getDbTable ( 'customers', 'company' );
	        $customerSelect = $CompanyCustomersTable->select ()->where ( 'company_id = ?', $id);
	        $customers = $CompanyCustomersTable->fetchAll ( $customerSelect );

	        $CompanyCustomersSecondTable = Engine_Api::_ ()->getDbTable ( 'customers', 'company' );
	        $customerSecondSelect = $CompanyCustomersSecondTable->select ()
	        ->where ( 'company_id = ?', $id)
	        ->where ( 'user_id = ?', $viewer->getIdentity())
	        ;
	        $customerssecond = $CompanyCustomersSecondTable->fetchAll ( $customerSecondSelect );
	        $count = count($customerssecond);
	        $log->log("count__________".json_encode($count),Zend_Log::DEBUG);

	        $this->view->paginator = $paginator = Zend_Paginator::factory($customerSelect);
	        $this->view->customers = $paginator;
	        $this->view->owner = $owner;
	        $this->view->noproduct = $count;
            $this->view->level_id = $viewer['level_id'];


	}
}
