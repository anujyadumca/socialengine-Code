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
class Company_Widget_HumanResourceController extends Engine_Content_Widget_Abstract
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

	        $humanResearchTable = Engine_Api::_ ()->getDbTable ( 'humanResource', 'company' );
	        $hrSelect = $humanResearchTable->select ()->where ( 'company_id = ?', $id);
	        $hrs = $humanResearchTable->fetchAll ( $hrSelect );
	       // $log->log("hr_____".json_encode($hrs->toArray()),Zend_Log::DEBUG);
	        $this->view->paginator = $paginator = Zend_Paginator::factory($hrSelect);
	        $this->view->hr = $paginator;
	        $this->view->owner = $owner;
	        $this->view->level_id = $viewer['level_id'];

	   // $form = $this->view->form = new Company_Form_Business();

	}
}
