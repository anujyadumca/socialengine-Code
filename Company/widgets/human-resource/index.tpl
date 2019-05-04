
<div>
    <?php if( $this->form ): ?>
        <?php echo $this->form->render($this) ?>
    <?php endif ?>
</div>

 <div>
    <?php //if($this->owner == 1 || $this->level_id == 1 || $this->level_id == 2):?>
     <?php echo $this->htmlLink(array(
        'route' => 'company_extended',
        'controller' => 'human-resource',
        'action' => 'create',
        'subject' => $this->subject()->getGuid(),
      ), $this->translate('Create New Company HR'), array(
        'class' => 'buttonlink icon_group_photo_new'
      )) ?>
       <?php //endif;?>
 </div

 <div class='hr_settings'>
    <form class="global_form">
      <div>
        <h3> <?php echo $this->translate("Company Human Research") ?> </h3>
        <p class="description">
          <?php echo $this->translate("Listing all HR of companies") ?>
        </p>
          <?php if(count($this->hr)>0):?>

         <table class='divTable'>
          <thead>
            <tr>
              <th class="divCell"><?php echo $this->translate("Name") ?></th>
              <th class="divCell"><?php echo $this->translate("Email") ?></th>
               <th class="divCell"><?php echo $this->translate("Address") ?></th>
               <th class="divCell"><?php echo $this->translate("Phone") ?></th>
               <th class="divCell"><?php echo $this->translate("Key People") ?></th>
               <th class="divCell"><?php echo $this->translate("Link") ?></th>
              <th class="divCell"><?php echo $this->translate("Options") ?></th>
            </tr>

          </thead>
          <tbody>
            <?php foreach ($this->hr as $hr): ?>
                    <tr class = "divrow">
                         <td class ="divCell">
                          <?php echo $hr->name ?></td>
                          <td><?php echo $hr->email?></td>
                          <td><?php echo $hr->address?></td>
                          <td><?php echo $hr->phone?></td>
                        <?php if($hr->hrtype == 1):?>
                          <td class ="divCell"><?php echo $this->translate("Chairman")?></td>
                           <?php endif;?>
                           <?php if($hr->hrtype == 2):?>
                           <td class ="divCell"><?php echo $this->translate("President")?></td>
                           <?php endif;?>
                            <?php if($hr->hrtype == 3):?>
                            <td class ="divCell"><?php echo $this->translate("Cheif Finacial Officer")?></td>
                           <?php endif;?>
                           <?php if($hr->hrtype == 4):?>
                            <td class ="divCell"><?php echo $this->translate("Head of Human Resource")?></td>
                           <?php endif;?>
                          <?php if($hr->link):?>
                         <td class ="link"><a target="_blank" href="<?php echo $hr->link; ?>"><img src="application/modules/Company/externals/images/links-icon.png" width="17" height="20"></a></td>
                         <?php else:?>
                         <td class ="link"><?php echo $hr->link ?></td>
                         <?php endif;?>
                         <td class ="divCell">
                         <?php if($this->owner == 1 || $this->level_id == 1 || $this->level_id == 2):?>
                           <?php echo $this->htmlLink(array(
                                'route' => 'company_extended',
                                'controller' => 'human-resource',
                                'action' => 'edit',
                                'subject' => $this->subject()->getGuid(),
                                'human-resourse-id' => $hr->human_resourse_id,
                              ), $this->translate(''), array(
                                'class' => 'buttonlink icon_group_post_edit'
                              )) ?>
                              |
                              <?php echo $this->htmlLink(array(
                                'route' => 'company_extended',
                                'controller' => 'human-resource',
                                'action' => 'delete',
                                'subject' => $this->subject()->getGuid(),
                                'companyId' => $this->subject()->getIdentity(),
                                'human-resourse-id' => $hr->human_resourse_id,
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



    
