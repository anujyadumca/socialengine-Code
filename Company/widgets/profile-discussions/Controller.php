<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Controller.php 9747 2012-07-26 02:08:08Z john $
 * @author     John
 */

/**
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Company_Widget_ProfileDiscussionsController extends Engine_Content_Widget_Abstract
{
  protected $_childCount;

  public function indexAction()
  {
  	$log = Engine_Api::_ ()->getApi ( 'core', 'socialapi' )->getLog ();

    // Don't render this if not authorized
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !Engine_Api::_()->core()->hasSubject() ) {
      return $this->setNoRender();
    }

    // Get subject and check auth
    $subject = Engine_Api::_()->core()->getSubject('company_group');
//     if( !$subject->authorization()->isAllowed($viewer, 'view') ) {
//       return $this->setNoRender();
//     }

    // Get paginator
    $table = Engine_Api::_()->getItemTable('company_topic');
    $select = $table->select()
      ->where('group_id = ?', Engine_Api::_()->core()->getSubject()->getIdentity())
      //->order('sticky DESC')
      ->order('modified_date DESC');
      ;

    $this->view->paginator = $paginator = Zend_Paginator::factory($select);

    // Set item count per page and current page number
    $paginator->setItemCountPerPage($this->_getParam('itemCountPerPage', 5));
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));

    // Do not render if nothing to show and not viewer
    if( $paginator->getTotalItemCount() <= 0 && !$viewer->getIdentity() ) {
      return $this->setNoRender();
    }

    $this->view->canPost = Engine_Api::_()->authorization()->isAllowed($subject, $viewer, 'comment');

    // Add count to title if configured
    if( $this->_getParam('titleCount', false) && $paginator->getTotalItemCount() > 0 ) {
      $this->_childCount = $paginator->getTotalItemCount();
    }
  }

  public function getChildCount()
  {
    return $this->_childCount;
  }
}