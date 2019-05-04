<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: ProfileController.php 9747 2012-07-26 02:08:08Z john $
 * @author     John
 */

/**
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Company_ProfileController extends Core_Controller_Action_Standard
{
  public function init()
  {
  	$log = Engine_Api::_ ()->getApi ( 'core', 'socialapi' )->getLog ();

    // @todo this may not work with some of the content stuff in here, double-check
    $subject = null;
    if( !Engine_Api::_()->core()->hasSubject() )
    {
      $id = $this->_getParam('id');
      if( null !== $id )
      {
        $subject = Engine_Api::_()->getItem('company', $id);

        if( $subject && $subject->getIdentity() )
        {
          Engine_Api::_()->core()->setSubject($subject);
        }
      }
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    //$this->_helper->requireSubject('company');
//     $this->_helper->requireAuth()
// //      ->setNoForward()                          // for showing image and title irrespective of privacy
//       ->setAuthParams($subject, $viewer, 'view')
//       ->isValid();
  }

  public function indexAction()
  {
  	$log = Engine_Api::_ ()->getApi ( 'core', 'socialapi' )->getLog ();


    $subject = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();

//     $log->log("profileIndex:::".$subject->getHref(),Zend_Log::DEBUG);
//     $log->log("profileIndex:::".$viewer->getIdentity(),Zend_Log::DEBUG);

    // Increment view count
    if( !$subject->getOwner()->isSelf($viewer) )
    {
      $subject->view_count++;
      $subject->save();
    }

    // Get styles
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $select = $table->select()
      ->where('type = ?', $subject->getType())
      ->where('id = ?', $subject->getIdentity())
      ->limit();

    $row = $table->fetchRow($select);

    if( null !== $row && !empty($row->style) ) {
      $this->view->headStyle()->appendStyle($row->style);
    }

    // Render
    $this->_helper->content
        ->setNoRender()
        ->setEnabled()
        ;
  }
}