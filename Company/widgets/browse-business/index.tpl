
<div>
	<?php if( $this->form ): ?>
		<?php echo $this->form->render($this) ?>
	<?php endif ?>
</div>

 <div>
    
    <?php //if($this->owner == 1 || $this->level_id == 1 || $this->level_id == 2):?>
     <?php echo $this->htmlLink(array(
        'route' => 'company_extended',
        'controller' => 'business-contacts',
        'action' => 'create',
        'subject' => $this->subject()->getGuid(),
      ), $this->translate('Create New Company Contact'), array(
        'class' => 'buttonlink icon_group_photo_new'
      )) ?>
       <?php //endif;?>
 </div>

 <div class='company_settings'>
    <form class="global_form">
      <div>
        <h3> <?php echo $this->translate("Company Contacts") ?> </h3>
        <p class="description">
          <?php echo $this->translate("Listing all contacts of companies") ?>
        </p>
          <?php if(count($this->business)>0):?>

         <table class='divTable'>
          <thead>
            <tr>
              <th class="divCell"><?php echo $this->translate("Name") ?></th>
               <th class="divCell"><?php echo $this->translate("Email") ?></th>
               <th class="divCell"><?php echo $this->translate("Address") ?></th>
               <th class="divCell"><?php echo $this->translate("Phone") ?></th>
               <th class="divCell"><?php echo $this->translate("Business Type") ?></th>
               <th class="link"><?php echo $this->translate("Link") ?></th>
               <th class="divCell"><?php echo $this->translate("Options") ?></th>
            </tr>

          </thead>
          <tbody>
            <?php foreach ($this->business as $business): ?>
                    <tr class = "divrow">
                          <td class ="divCell"><?php echo $business->name ?></td>
                            <td><?php echo $business->email?></td>
                          <td><?php echo $business->address?></td>
                          <td><?php echo $business->phone?></td>
                        <?php if($business->businesstype == 1):?>
                          <td class ="divCell"><?php echo $this->translate("Patnership")?></td>
                           <?php endif;?>
                           <?php if($business->businesstype == 2):?>
                           <td class ="divCell"><?php echo $this->translate("Supplier Proposal")?></td>
                           <?php endif;?>
                            <?php if($business->businesstype == 3):?>
                            <td class ="divCell"><?php echo $this->translate("Proposal")?></td>
                           <?php endif;?>
                          <?php if($business->link):?>
                         <td class ="link"><a target="_blank" href="<?php echo $business->link; ?>"><img src="application/modules/Company/externals/images/links-icon.png" width="17" height="20"></a></td>
                         <?php else:?>
                         <td class ="link"><?php echo $business->link ?></td>
                         <?php endif;?>
                         <td class ="divCell">
                         <?php if($this->owner == 1 || $this->level_id == 1 || $this->level_id == 2):?>
                           <?php echo $this->htmlLink(array(
                                'route' => 'company_extended',
                                'controller' => 'business-contacts',
                                'action' => 'edit',
                                'subject' => $this->subject()->getGuid(),
                                'contact-id' => $business->contact_id,
                              ), $this->translate(''), array(
                                'class' => 'buttonlink icon_group_post_edit'
                              )) ?>
                              |
                              <?php echo $this->htmlLink(array(
                                'route' => 'company_extended',
                                'controller' => 'business-contacts',
                                'action' => 'delete',
                                'subject' => $this->subject()->getGuid(),
                                'companyId' => $this->subject()->getIdentity(),
                                'contact-id' => $business->contact_id,
                              ), $this->translate(''), array(
                                'class' => 'smoothbox buttonlink icon_group_post_delete'
                              )) ?>
                           <?php else:?>
                           <?php echo "Not Authorize to Edit"; ?>
                           <?php endif;?>
                          </td>
                     </tr>
              
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else:?>
      <br/>
      <div class="tip">
      <span><?php echo $this->translate("There are currently no contact list.") ?></span>
      </div>
      <?php endif;?>
        <br/>
    </div>
    </form>
    </div>
<style>
table { 
  width: 100%; 
  border-collapse: collapse;
  background:white; 
}
/* Zebra striping */
tr:nth-of-type(odd) { 
  background: #eee; 
}
th { 
  background: #808080; 
  color: white; 
  font-weight: bold; 
}
td, th { 
  padding: 0px; 
  border: 2px solid #ccc; 
  text-align: center; 
}
td.link {
    text-align: center;
}
th.divCell {
    padding: 5px;
    text-align: center;
}
td.divCell {
    padding: 2px;
   
}
a.smoothbox.buttonlink.icon_group_post_delete {
    color: rgb(226, 10, 10);
}
a.buttonlink.icon_group_post_edit {
    color: rgba(23, 54, 64, 0.98);
}
</style>

    
