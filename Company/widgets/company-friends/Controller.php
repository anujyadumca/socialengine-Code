<?php
/**
 * SocialEngine
 *
 * @category   Application_Core
 * @package    User
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Controller.php 9812 2012-11-01 02:14:01Z matthew $
 * @author     John
 */

/**
 * @category   Application_Core
 * @package    User
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Company_Widget_CompanyFriendsController extends Engine_Content_Widget_Abstract
{
  protected $_childCount;

  public function indexAction()
  {
      $log = Engine_Api::_ ()->getApi ( 'core', 'socialapi' )->getLog ();
      // Don't render this if not authorized
      $viewer = Engine_Api::_()->user()->getViewer();

      // Don't render this if friendships are disabled
      if( !Engine_Api::_()->getApi('settings', 'core')->user_friends_eligible ) {
          return $this->setNoRender();
      }

      $select = $viewer->membership()->getMembersOfSelect();
     $this->view->friends = $friends = $paginator = Zend_Paginator::factory($select);

      // Get stuff
      $ids = array();
      foreach( $friends as $friend ) {
          $ids[] = $friend->resource_id;

      }

      $log->log("friendss>>>>".json_encode($ids),Zend_Log::DEBUG);
      $this->view->friendIds = $ids;

      $membershiptable = Engine_Api::_ ()->getDbtable ( 'membership', 'company' );
      $membershipInfo = $membershiptable->info ( 'name' );
      $company_table = Engine_Api::_ ()->getDbtable ( 'groups', 'company' );
      $companyInfo = $company_table->info ( 'name' );
      $user_table = Engine_Api::_ ()->getDbtable ( 'users', 'user' );
      $userInfo = $user_table->info ( 'name' );
      $storage_table = Engine_Api::_ ()->getDbtable ( 'files', 'storage' );
      $storageInfo = $storage_table->info ( 'name' );
      $select = $membershiptable->select ()->setIntegrityCheck ( false )
      ->from ( array ('member' => $membershipInfo), array ('member.resource_id','member.user_id','member.resource_approved','member.user_approved', 'member.active') )
      ->joinLeft ( array ('friends' => $membershipInfo), 'member.resource_id=friends.resource_id', array ('friends.resource_id as friends_companyid', 'friends.user_id as friends_userid') )
      ->joinLeft ( array ('user' => $userInfo), 'friends.user_id=user.user_id', array ('user.displayname') )
      ->joinLeft ( array ('company' => $companyInfo ), "member.resource_id = company.group_id", array ('company.title'))
      ->where ( 'member.user_id =?', $viewer->getIdentity() )
      ->where('friends.user_id IN(?)', $ids)
      ->where ( 'member.active=?', 1 )
     // ->group('user.displayname')
      ;
      $result = $membershiptable->fetchAll ( $select );
      $count = count($result);
      $log->log("count___".json_encode($count),Zend_Log::DEBUG);
      $log->log("Queryttt_____".$select,Zend_Log::DEBUG);
      $this->view->totalcount = $count;

      $companyArray= array();
      foreach ($result as $item){

          if (array_key_exists($item->friends_userid, $companyArray))
          {
              $tempArray = array(
                  'company_id' => $item->resource_id,
                  'title' => $item->title
              );
              $companyArray[$item->friends_userid]['companies'][] =  $tempArray;

          }

          else{
              $tempArray = array(
                  'company_id' => $item->resource_id,
                  'title' => $item->title
              );

              $companyArray[$item->friends_userid]= array(
                  'displayname' => $item->displayname,
                  'user_id' => $item->friends_userid
              );
              $companyArray[$item->friends_userid]['companies'][] =  $tempArray;
              $log->log("companyarray____".json_encode($companyArray),Zend_Log::DEBUG);
          }
      }

      $this->view->companies = $companyArray;

     // $this->view->companies = $result;

      // Get stuff
      $friendids = array();
      foreach( $companyArray as $friend ) {
          $friendids[] = $friend['user_id'];

      }



      // Get the items
      $friendUsers = array();
      foreach( Engine_Api::_()->getItemTable('user')->find($friendids) as $friendUser ) {
          $friendUsers[$friendUser->getIdentity()] = $friendUser;
          $log->log("friendusers___".json_encode($friendUsers),Zend_Log::DEBUG);
      }
      $this->view->friendUsers = $friendUsers;
      $log->log("Step 3_____",Zend_Log::DEBUG);
      // Get lists if viewing own profile
     // if( $viewer->isSelf($viewer) ) {
          // Get lists
          $listTable = Engine_Api::_()->getItemTable('user_list');
          $this->view->lists = $lists = $listTable->fetchAll($listTable->select()->where('owner_id = ?', $viewer->getIdentity()));

          $listIds = array();
          foreach( $lists as $list ) {
              $listIds[] = $list->list_id;
          }
          $log->log("Step 4_____",Zend_Log::DEBUG);
          /* // Build lists by user
          $listItems = array();
          $listsByUser = array();
          if( !empty($listIds) ) {
              $listItemTable = Engine_Api::_()->getItemTable('user_list_item');
              $listItemSelect = $listItemTable->select()
              ->where('list_id IN(?)', $listIds)
              ->where('child_id IN(?)', $ids);
              $listItems = $listItemTable->fetchAll($listItemSelect);
              $log->log("Step 5_____",Zend_Log::DEBUG);
              foreach( $listItems as $listItem ) {
                  //$list = $lists->getRowMatching('list_id', $listItem->list_id);
                  //$listsByUser[$listItem->child_id][] = $list;
                  $listsByUser[$listItem->child_id][] = $listItem->list_id;
                  $log->log("Step 6_____",Zend_Log::DEBUG);
              }
          } */

     // }

      // Do not render if nothing to show
      if( $paginator->getTotalItemCount() <= 0 ) {
          return $this->setNoRender();
      }
      $log->log("Step 7_____",Zend_Log::DEBUG);
      // Add count to title if configured
      if( $this->_getParam('titleCount', false) && $paginator->getTotalItemCount() > 0 ) {
          $this->_childCount = $paginator->getTotalItemCount();
      }

      $this->view->test = "hello";

}

}