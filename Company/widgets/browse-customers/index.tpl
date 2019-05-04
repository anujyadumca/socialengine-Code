
<div>
	<?php if( $this->form ): ?>
		<?php echo $this->form->render($this) ?>
	<?php endif ?>
</div>

 <div>
    
    <?php if($this->noproduct < 5):?>
     <?php echo $this->htmlLink(array(
        'route' => 'company_extended',
        'controller' => 'customers',
        'action' => 'create',
        'subject' => $this->subject()->getGuid(),
      ), $this->translate('Create New Company Customer'), array(
        'class' => 'buttonlink icon_group_photo_new'
      )) ?>
       <?php else:?>
      <?php echo "You can add only Five Products"; ?>
      <?php endif;?>
 </div>

 <div class='company_settings'>
    <form class="global_form">
      <div>
        <h3> <?php echo $this->translate("Company Customers") ?> </h3>
        <p class="description">
          <?php echo $this->translate("Listing all customers") ?>
        </p>
          <?php if(count($this->customers)>0):?>

         <table class='divTable'>
          <thead>
            <tr>
              <th class="divCell"><?php echo $this->translate("Product Name") ?></th>
              <th class="divCell"><?php echo $this->translate("Short Description") ?></th>
               <th class="divCell"><?php echo $this->translate("Phone") ?></th>
               <th class="divCell"><?php echo $this->translate("Customer Type") ?></th>
               <th class="divCell"><?php echo $this->translate("Link") ?></th>
              <th class="divCell"><?php echo $this->translate("Options") ?></th>
            </tr>

          </thead>
          <tbody>
            <?php foreach ($this->customers as $customer): ?>
                    <tr class = "divrow">
                      <td><?php echo $customer->name?></td>
                      <td><?php echo $customer->address?></td>
                      <td><?php echo $customer->phone?></td>
                      <?php if($customer->customertype == 1):?>
                          <td class ="divCell"><?php echo $this->translate("Promotions")?></td>
                           <?php endif;?>
                           <?php if($customer->customertype == 2):?>
                           <td class ="divCell"><?php echo $this->translate("Products")?></td>
                           <?php endif;?>
                            <?php if($customer->customertype == 3):?>
                            <td class ="divCell"><?php echo $this->translate("Store Locator")?></td>
                           <?php endif;?>
                           <?php if($customer->link):?>
                         <td class ="link"><a target="_blank" href="<?php echo $customer->link; ?>"><img src="application/modules/Company/externals/images/links-icon.png" width="17" height="20"></a></td>
                         <?php else:?>
                         <td class ="link"><?php echo $customer->link ?></td>
                         <?php endif;?>
                        <td class ="divCell">
                         <?php if($this->owner == 1 || $this->level_id == 1 || $this->level_id == 2):?>
                           <?php echo $this->htmlLink(array(
                                'route' => 'company_extended',
                                'controller' => 'customers',
                                'action' => 'edit',
                                'subject' => $this->subject()->getGuid(),
                                'customer-id' => $customer->customer_id,
                              ), $this->translate(''), array(
                                'class' => 'buttonlink icon_group_post_edit'
                              )) ?>
                              |
                              <?php echo $this->htmlLink(array(
                                'route' => 'company_extended',
                                'controller' => 'customers',
                                'action' => 'delete',
                                'subject' => $this->subject()->getGuid(),
                                'companyId' => $this->subject()->getIdentity(),
                                'customer-id' => $customer->customer_id,
                              ), $this->translate(''), array(
                                'class' => 'smoothbox buttonlink icon_group_post_delete'
                              )) ?>
                           <?php else:?>
                           <?php echo "Not to Edit"; ?>
                           <?php endif;?>
                          </td>
                     </tr>
              
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else:?>
      <br/>
      <div class="tip">
      <span><?php echo $this->translate("There are currently no customers list.") ?></span>
      </div>
      <?php endif;?>
        <br/>
    </div>
    </form>
    </div>

 



    
