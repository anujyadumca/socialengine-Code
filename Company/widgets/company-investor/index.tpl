
<div>
    <?php if( $this->form ): ?>
        <?php echo $this->form->render($this) ?>
    <?php endif ?>
</div>

 <div>
    
    <?php //if($this->owner == 1 || $this->level_id == 1 || $this->level_id == 2):?>
    <?php echo $this->htmlLink(array(
        'route' => 'company_extended',
        'controller' => 'company-investors',
        'action' => 'create',
        'subject' => $this->subject()->getGuid(),
      ), $this->translate('Create New Company Investor'), array(
        'class' => 'buttonlink icon_group_photo_new'
      )) ?>
       <?php //endif;?>
 </div>

 <div class='company_settings'>
    <form class="global_form">
      <div>
        <h3> <?php echo $this->translate("Company Investors") ?> </h3>
        <p class="description">
          <?php echo $this->translate("Listing all Investors of companies") ?>
        </p>
          <?php if(count($this->paginator)>0):?>

         <table class='divTable'>
          <thead>
            <tr>
            <th class="divCell"><?php echo $this->translate("Name") ?></th>
              <th class="divCell"><?php echo $this->translate("Email") ?></th>
               <th class="divCell"><?php echo $this->translate("Address") ?></th>
               <th class="divCell"><?php echo $this->translate("Phone") ?></th>
               <th class="divCell"><?php echo $this->translate("Investor Type") ?></th>
               <th class="divCell"><?php echo $this->translate("Link") ?></th>
              <th class="divCell"><?php echo $this->translate("Options") ?></th>
            </tr>

          </thead>
          <tbody>
           <?php foreach ($this->investors as $investor): ?>
                    <tr class = "divrow">
                  `  <td><?php echo $investor->name?></td>
                      <td><?php echo $investor->email?></td>
                      <td><?php echo $investor->address?></td>
                      <td><?php echo $investor->phone?></td>
                        <?php if($investor->investortype == 1):?>
                          <td class ="divCell"><?php echo $this->translate("Public")?></td>
                           <?php endif;?>
                           <?php if($investor->investortype == 2):?>
                           <td class ="divCell"><?php echo $this->translate("Private")?></td>
                           <?php endif;?>
                            <?php if($investor->investortype == 3):?>
                            <td class ="divCell"><?php echo $this->translate("If Public, Symbol")?></td>
                           <?php endif;?>
                           <?php if($investor->investortype == 4):?>
                            <td class ="divCell"><?php echo $this->translate("Primary Exchange")?></td>
                           <?php endif;?>
                           <?php if($investor->link):?>
                         <td class ="link"><a target="_blank" href="<?php echo $investor->link; ?>"><img src="application/modules/Company/externals/images/links-icon.png" width="17" height="20"></a></td>
                         <?php else:?>
                         <td class ="link"><?php echo $investor->link ?></td>
                         <?php endif;?>
                        <td class ="divCell">
                         <?php if($this->owner == 1 || $this->level_id == 1 || $this->level_id == 2):?>
                           <?php echo $this->htmlLink(array(
                                'route' => 'company_extended',
                                'controller' => 'company-investors',
                                'action' => 'edit',
                                'subject' => $this->subject()->getGuid(),
                                'investor-id' => $investor->investor_id,
                              ), $this->translate(''), array(
                                'class' => 'buttonlink icon_group_post_edit'
                              )) ?>
                              |
                              <?php echo $this->htmlLink(array(
                                'route' => 'company_extended',
                                'controller' => 'company-investors',
                                'action' => 'delete',
                                'subject' => $this->subject()->getGuid(),
                                'companyId' => $this->subject()->getIdentity(),
                                'investor-id' => $investor->investor_id,
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

 



    
