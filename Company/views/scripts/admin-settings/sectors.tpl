<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Company
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: categories.tpl 9747 2012-07-26 02:08:08Z john $
 * @author     Jung
 */
?>

<h2><?php echo $this->translate("Companys Sectors") ?></h2>

<?php if( count($this->navigation) ): ?>
  <div class='tabs'>
    <?php
      // Render the menu
      //->setUlClass()
      echo $this->navigation()->menu()->setContainer($this->navigation)->render()
    ?>
  </div>
<?php endif; ?>

  <div class='clear'>
    <div class='settings'>
    <form class="global_form">
      <div>
        <h3> <?php echo $this->translate("Company Sectors") ?> </h3>
        <p class="description">
          <?php echo $this->translate("") ?>
        </p>
          <?php if(count($this->sectors)>0):?>

         <table class='admin_table'>
          <thead>
            <tr>
              <th><?php echo $this->translate("Sector Name") ?></th>
<?php //              <th># of Times Used</th>?>
              <th><?php echo $this->translate("Options") ?></th>
            </tr>

          </thead>
          <tbody>
            <?php foreach ($this->sectors as $sector): ?>
                    <tr>
                      <td><?php echo $sector->title?></td>
                      <td>
                      <?php if($sector->status==1):?>
                        <?php echo $this->htmlLink(array('route' => 'company_extended', 'module' => 'company', 'controller' => 'admin-settings', 'action' => 'status-sector', 'id' => $sector->sector_id,'status'=> $sector->status), $this->translate("Disable"), array(
                          'class' => 'smoothbox',
                        )) ?>
                         <?php else:?>
                         <?php echo $this->htmlLink(array('route' => 'company_extended', 'module' => 'company', 'controller' => 'admin-settings', 'action' => 'status-sector', 'id' => $sector->sector_id,'status'=> $sector->status), $this->translate("Enable"), array(
                          'class' => 'smoothbox',
                        )) ?>
                        <?php endif;?>
                        |
                        <?php echo $this->htmlLink(array('route' => 'company_extended', 'module' => 'company', 'controller' => 'admin-settings', 'action' => 'edit-sector', 'id' => $sector->sector_id), $this->translate("edit"), array(
                          'class' => 'smoothbox',
                        )) ?>
                        
                      </td>
                    </tr>

            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else:?>
      <br/>
      <div class="tip">
      <span><?php echo $this->translate("There are currently no Sectors.") ?></span>
      </div>
      <?php endif;?>
        <br/>


    
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'company', 'controller' => 'settings', 'action' => 'add-sector', 'industry_id' => $this->industry_id), $this->translate('Add New Sector'), array(
      'class' => 'smoothbox buttonlink',
      'style' => 'background-image: url(' . $this->layout()->staticBaseUrl . 'application/modules/Core/externals/images/admin/new_category.png);')) ?>
      
    </div>
    </form>
    </div>
  </div>
 
     