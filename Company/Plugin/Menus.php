<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Menus.php 9747 2012-07-26 02:08:08Z john $
 * @author     John
 */

/**
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Company_Plugin_Menus
{
	public function canCreateGroup()
  {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() ) {
      return false;
    }

    // Must be able to create events
    if( !Engine_Api::_()->authorization()->isAllowed('company', $viewer, 'create') ) {
      return false;
    }

    return true;
  }

  public function canViewGroups()
  {
    $viewer = Engine_Api::_()->user()->getViewer();

    // Must be able to view events
    if( !Engine_Api::_()->authorization()->isAllowed('company', $viewer, 'view') ) {
      return false;
    }

    return true;
  }

  public function onMenuInitialize_CompanyMainManage()
  {
    $viewer = Engine_Api::_()->user()->getViewer();

    if( !$viewer->getIdentity() )
    {
      return false;
    }
    return true;
  }

  public function onMenuInitialize_CompanyMainCreate()
  {
    $viewer = Engine_Api::_()->user()->getViewer();

    if( !$viewer->getIdentity() )
    {
      return false;
    }

    if( !Engine_Api::_()->authorization()->isAllowed('company', null, 'create') )
    {
      return false;
    }

    return true;
  }

  public function onMenuInitialize_CompanyProfileEdit()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if( $subject->getType() !== 'company_group' )
    {
      throw new Group_Model_Exception('Whoops, not a company!');
    }

    if( !$viewer->getIdentity() || !$subject->authorization()->isAllowed($viewer, 'edit') )
    {
      return false;
    }

    if( !$subject->authorization()->isAllowed($viewer, 'edit') )
    {
      return false;
    }

    return array(
      'label' => 'Edit Company Details',
      'class' => 'icon_group_edit',
      'route' => 'company_specific',
      'params' => array(
        'controller' => 'company',
        'action' => 'edit',
        'group_id' => $subject->getIdentity(),
        'ref' => 'profile'
      )
    );
  }

  public function onMenuInitialize_CompanyProfileStyle()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if( $subject->getType() !== 'company_group' )
    {
      throw new Group_Model_Exception('Whoops, not a company!');
    }

    if( !$viewer->getIdentity() || !$subject->authorization()->isAllowed($viewer, 'edit') )
    {
      return false;
    }

    if( !$subject->authorization()->isAllowed($viewer, 'style') )
    {
      return false;
    }

    return array(
      'label' => 'Edit Company Style',
      'class' => 'smoothbox icon_style',
      'route' => 'company_specific',
      'params' => array(
        'action' => 'style',
        'group_id' => $subject->getIdentity(),
        'format' => 'smoothbox',
      )
    );
  }

  public function onMenuInitialize_CompanyProfileMember()
  {
    $menu = array();
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if( $subject->getType() !== 'company_group' )
    {
      throw new Group_Model_Exception('Whoops, not a company!');
    }

    if( !$viewer->getIdentity() )
    {
      return false;
    }

    $row = $subject->membership()->getRow($viewer);

    // Not yet associated at all
    if( null === $row )
    {
      if( $subject->membership()->isResourceApprovalRequired() ) {
        $menu[] =  array(
          'label' => 'Request Membership',
          'class' => 'smoothbox icon_group_join',
          'route' => 'company_extended',
          'params' => array(
            'controller' => 'member',
            'action' => 'request',
            'group_id' => $subject->getIdentity(),
          ),
        );
      } else {
        $menu[] =  array(
          'label' => 'Join Company',
          'class' => 'smoothbox icon_group_join',
          'route' => 'company_extended',
          'params' => array(
            'controller' => 'member',
            'action' => 'join',
            'group_id' => $subject->getIdentity()
          ),
        );
      }
    }

    // Full member
    // @todo consider owner
    else if( $row->active )
    {
      if( !$subject->isOwner($viewer) ) {
        $menu[] =  array(
          'label' => 'Leave Company',
          'class' => 'smoothbox icon_group_leave',
          'route' => 'company_extended',
          'params' => array(
            'controller' => 'member',
            'action' => 'leave',
            'group_id' => $subject->getIdentity()
          ),
        );
      }
    }

    else if( !$row->resource_approved && $row->user_approved )
    {
      $menu[] =  array(
        'label' => 'Cancel Membership Request',
        'class' => 'smoothbox icon_group_cancel',
        'route' => 'company_extended',
        'params' => array(
          'controller' => 'member',
          'action' => 'cancel',
          'group_id' => $subject->getIdentity()
        ),
      );
    }

    else if( !$row->user_approved && $row->resource_approved )
    {
      $menu[] = array(
          'label' => 'Accept Membership Request',
          'class' => 'smoothbox icon_group_accept',
          'route' => 'company_extended',
          'params' => array(
            'controller' => 'member',
            'action' => 'accept',
            'group_id' => $subject->getIdentity()
          ),
      );

      $menu[] =  array(
          'label' => 'Ignore Membership Request',
          'class' => 'smoothbox icon_group_reject',
          'route' => 'company_extended',
          'params' => array(
            'controller' => 'member',
            'action' => 'reject',
            'group_id' => $subject->getIdentity()
          ),
      );
    }

    else
    {
      throw new Group_Model_Exception('Wow, something really strange happened.');
    }

    $canDelete = Engine_Api::_()->authorization()->isAllowed($subject, null, 'delete');
    if( $canDelete ) {
      $menu[] = array(
        'label' => 'Delete Company',
        'class' => 'smoothbox icon_group_delete',
        'route' => 'company_specific',
        'params' => array(
          'action' => 'delete',
          'group_id' => $subject->getIdentity()
        ),
      );
    }

    if( count($menu) == 1 ) {
      return $menu[0];
    }
    return $menu;
  }

  public function onMenuInitialize_CompanyProfileFollowship()
  {
  	$log= Zend_Registry::get('Zend_Log');
  	$menu = array();
  	$viewer = Engine_Api::_()->user()->getViewer();
  	$subject = Engine_Api::_()->core()->getSubject();
  	if( $subject->getType() !== 'company_group' )
  	{
  		throw new Company_Model_Exception('Whoops, not a company!');
  	}

  	if( !$viewer->getIdentity() )
  	{
  		return false;
  	}
  	//$log->log("comig menu before row>>>",Zend_Log::ERR);
  	try{
  		$row = $subject->followship()->getRow($viewer);
  		//$log->log("row coming>>".gettype($row),Zend_Log::ERR);
  	}catch(Exception $e){
  		//$log->log("comig followwsgipp menu row>>>".$e->getMessage(),Zend_Log::ERR);
  	}



  	// Not yet associated at all
  	if( null === $row && !$subject->isOwner($viewer) )
  	{
  		 $menu[] =  array(
  			'label' => 'Follow Company',
  			'class' => 'smoothbox icon_group_join',
  			'route' => 'company_extended',
  			'params' => array(
  					'controller' => 'member',
  					'action' => 'follow',
  					'group_id' => $subject->getIdentity()
  					),
  			);
  	}
  	// Full member
  	// @todo consider owner
  	else if( $row->active )
  	{
  		if( !$subject->isOwner($viewer) ) {
  			$menu[] =  array(
  					'label' => 'Unfollow Company',
  					'class' => 'smoothbox icon_group_leave',
  					'route' => 'company_extended',
  					'params' => array(
  							'controller' => 'member',
  							'action' => 'unfollow',
  							'group_id' => $subject->getIdentity()
  					),
  			);
  		}
  	}
  	else
  	{
  		throw new Company_Model_Exception('Wow, something really strange happened.');
  	}
  	if( count($menu) == 1 ) {
  		return $menu[0];
  	}
  	return $menu;
  }


  public function onMenuInitialize_CompanyProfileClaim()
  {
  	$log= Zend_Registry::get('Zend_Log');
  	$menu = array();
  	$viewer = Engine_Api::_()->user()->getViewer();
  	$subject = Engine_Api::_()->core()->getSubject();
  	if( $subject->getType() !== 'company_group' )
  	{
  	    throw new Company_Model_Exception('Whoops, not a company!');
  	}

  	$isUserAlreadyClaim = Engine_Api::_ ()->getApi ( 'core', 'company' )->isUserAlreadyClaim($viewer->getIdentity(), $subject->getIdentity() );
  	// Not yet associated at all
  	if( !$isuserAlreadyClaim  && !$subject->isOwner($viewer) )
  	{
  		$menu[] =  array(
  				'label' => 'Claim Company',
  				'class' => 'smoothbox icon_group_join',
  				'route' => 'company_extended',
  				'params' => array(
  						'controller' => 'member',
  						'action' => 'claim',
  						'group_id' => $subject->getIdentity()
  				),
  		);
  	}
  	else
  	{
  		throw new Company_Model_Exception('Wow, something really strange happened.');
  	}
  	if( count($menu) == 1 ) {
  		return $menu[0];
  	}
  	return $menu;
  }

  public function onMenuInitialize_CompanyProfileReport()
  {
    return false;
  }

  public function onMenuInitialize_CompanyProfileInvite()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();

    if( $subject->getType() !== 'company_group' ) {
        throw new Company_Model_Exception('Whoops, not a company!');
    }

    if( !$subject->authorization()->isAllowed($viewer, 'invite') ) {
      return false;
    }

    return array(
      'label' => 'Invite Members',
      'class' => 'smoothbox icon_invite',
      'route' => 'company_extended',
      'params' => array(
        //'module' => 'company',
        'controller' => 'member',
        'action' => 'invite',
        'group_id' => $subject->getIdentity(),
        'format' => 'smoothbox',
      ),
    );
  }

  public function onMenuInitialize_CompanyProfileShare()
  {
  	$log = Engine_Api::_ ()->getApi ( 'core', 'socialapi' )->getLog ();
  	//$log->log("onMenuInitialize_CompanyProfileShare_Step 1:::",Zend_Log::DEBUG);
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();

    //$log->log("onMenuInitialize_CompanyProfileShare_Step 1:::".$subject->getType(),Zend_Log::DEBUG);
    if( $subject->getType() !== 'company_group' )
    {
        throw new Company_Model_Exception('Whoops, not a company!');
    }

    if( !$viewer->getIdentity() )
    {
      return false;
    }

    return array(
      'label' => 'Share Company',
      'class' => 'smoothbox icon_share',
      'route' => 'default',
      'params' => array(
        'module' => 'activity',
        'controller' => 'index',
        'action' => 'share',
        'type' => $subject->getType(),
        'id' => $subject->getIdentity(),
        'format' => 'smoothbox',
      ),
    );
  }

  public function onMenuInitialize_CompanyProfileMessage()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if( $subject->getType() !== 'company_group' ) {
        throw new Company_Model_Exception('Whoops, not a company!');
    }

    if( !$viewer->getIdentity() || !$subject->isOwner($viewer) ) {
      return false;
    }

    return array(
      'label' => 'Message Members',
      'class' => 'icon_message',
      'route' => 'messages_general',
      'params' => array(
        'action' => 'compose',
        'to' => $subject->getIdentity(),
        'multi' => 'company'
      )
    );
  }
}