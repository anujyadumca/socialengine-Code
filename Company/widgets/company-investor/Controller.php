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
class Company_Widget_CompanyInvestorController extends Engine_Content_Widget_Abstract
{
	public function indexAction()
	{
	    $log = Engine_Api::_ ()->getApi ( 'core', 'socialapi' )->getLog ();

	    // Don't render this if not authorized
	        $viewer = Engine_Api::_()->user()->getViewer();
	   /*  if( !Engine_Api::_()->core()->hasSubject() ) {
	        return $this->setNoRender();
	        } */
	        $subject = Engine_Api::_()->core()->getSubject('company_group');
	        $owner = $subject->isOwner($viewer);
	        $id = Engine_Api::_()->core()->getSubject()->getIdentity();
	        $companyInvestorTable = Engine_Api::_ ()->getDbTable ( 'companyInvestors', 'company' );
	        $investorSelect = $companyInvestorTable->select ()->where ( 'company_id = ?', $id);
	        $investors = $companyInvestorTable->fetchAll ( $investorSelect );
	        $log->log("investorys___".json_encode($investors->toArray()),Zend_Log::DEBUG);
	        $this->view->paginator = $paginator = Zend_Paginator::factory($investorSelect);
	        $this->view->investors = $paginator;
	        $this->view->owner = $owner;
	        $this->view->level_id = $viewer['level_id'];

	}
}
