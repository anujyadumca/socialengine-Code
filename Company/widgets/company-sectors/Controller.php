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
class Company_Widget_CompanySectorsController extends Engine_Content_Widget_Abstract
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
          $companyInfo = $company_table->info ( 'name' );
          $sector_table = Engine_Api::_ ()->getDbtable ( 'sectors', 'company' );
          $sectorInfo = $sector_table->info ( 'name' );
          $select = $company_table->select ()->setIntegrityCheck ( false )
          ->from ( array ('company' => $companyInfo), array ('company.group_id','company.view_count',) )
          ->joinLeft ( array ('sector' => $sectorInfo ), "sector.sector_id = company.sector_id", array ('sector.title'))
          ->order ( 'company.view_count DESC' )
           ->limit(3)
           ->group('sector.title')
          ;
          $result = $company_table->fetchAll ( $select );
          $this->view->companies = $result;


    }

}