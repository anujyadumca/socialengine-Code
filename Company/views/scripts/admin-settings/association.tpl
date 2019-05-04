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

<h2><?php echo $this->translate("Association") ?></h2>

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
        <h3> <?php echo $this->translate("Company Association") ?> </h3>
        <p class="description">
          <?php echo $this->translate("") ?>
        </p>
          <?php if(count($this->relationships)>0):?>

         <table class='admin_table'>
          <thead>
            <tr>
              <th><?php echo $this->translate("Association Name") ?></th>
<?php //              <th># of Times Used</th>?>
              <th><?php echo $this->translate("Options") ?></th>
            </tr>

          </thead>
          <tbody>
            <?php foreach ($this->relationships as $relation): ?>
                    <tr>
                      <td><?php echo $relation->title?></td>
                      <td>
                        <?php echo $this->htmlLink(array('route' => 'company_extended', 'module' => 'company', 'controller' => 'admin-settings', 'action' => 'edit-relationship', 'id' =>$relation->relationship_id), $this->translate("edit"), array(
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
      <span><?php echo $this->translate("There are currently no association.") ?></span>
      </div>
      <?php endif;?>
        <br/>


     
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'company', 'controller' => 'settings', 'action' => 'add-relationship'), $this->translate('Add New Association'), array(
      'class' => 'smoothbox buttonlink',
      'style' => 'background-image: url(' . $this->layout()->staticBaseUrl . 'application/modules/Core/externals/images/admin/new_category.png);')) ?>
      
    </div>
    </form>
    </div>
  </div>
     