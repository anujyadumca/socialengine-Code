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
class Company_Widget_CompanyDetailsController extends Engine_Content_Widget_Abstract
{
  protected $_childCount;

      public function indexAction()
      {


          $log = Engine_Api::_ ()->getApi ( 'core', 'socialapi' )->getLog ();
          // Don't render this if not authorized
          $viewer = Engine_Api::_()->user()->getViewer();

          if(!$viewer){

              return $this->setNoRender();
          }

          $company_table = Engine_Api::_ ()->getDbtable ( 'groups', 'company' );
          $select = $company_table->select ();
          $result = $company_table->fetchAll ( $select );
          $user_table = Engine_Api::_ ()->getDbtable ( 'users', 'user' );
          $select = $user_table->select ();
          $users = $user_table->fetchAll ( $select );
          $this->view->users = $users;
          $this->view->companies = $result;


    }

}