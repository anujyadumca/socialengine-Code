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

<h2><?php echo $this->translate("Companys Subcategories") ?></h2>

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
        <h3> <?php echo $this->translate("Company Categories") ?> </h3>
        <p class="description">
          <?php echo $this->translate("") ?>
        </p>
          <?php if(count($this->categories)>0):?>

         <table class='admin_table'>
          <thead>
            <tr>
              <th><?php echo $this->translate("Category Name") ?></th>
<?php //              <th># of Times Used</th>?>
              <th><?php echo $this->translate("Options") ?></th>
            </tr>

          </thead>
          <tbody>
            <?php foreach ($this->categories as $category): ?>
                    <tr>
                      <td><?php echo $category->title?></td>
                      <td>
                      <?php if($category->status==1):?>
                        <?php echo $this->htmlLink(array('route' => 'company_extended', 'module' => 'company', 'controller' => 'admin-settings', 'action' => 'status-subcategory', 'id' => $category->category_id,'status'=>$category->status), $this->translate("Disable"), array(
                          'class' => 'smoothbox',
                        )) ?>
                         <?php else:?>
                         <?php echo $this->htmlLink(array('route' => 'company_extended', 'module' => 'company', 'controller' => 'admin-settings', 'action' => 'status-subcategory', 'id' => $category->category_id,'status'=>$category->status), $this->translate("Enable"), array(
                          'class' => 'smoothbox',
                        )) ?>
                        <?php endif;?>
                        <?php echo $this->htmlLink(array('route' => 'company_extended', 'module' => 'company', 'controller' => 'admin-settings', 'action' => 'edit-category', 'id' =>$category->category_id), $this->translate("edit"), array(
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
      <span><?php echo $this->translate("There are currently no categories.") ?></span>
      </div>
      <?php endif;?>
        <br/>


    
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'company', 'controller' => 'settings', 'action' => 'add-subcategory', 'parent_id' => $this->parent_id), $this->translate('Add New SubCategory'), array(
      'class' => 'smoothbox buttonlink',
      'style' => 'background-image: url(' . $this->layout()->staticBaseUrl . 'application/modules/Core/externals/images/admin/new_category.png);')) ?>
      
    </div>
    </form>
    </div>
  </div>
 
     