<div class='clear'>
<div class='company_settings'>
    <form class="global_form">
      <div>
        <h3> <?php echo $this->translate("Company Contact") ?> </h3>
        <p class="description">
          <?php echo $this->translate("List for Company Contact") ?>
        </p>
          

         <table class='divTable'>
          <thead>
            <tr>
              <th class="divCell"><?php echo $this->translate("Name") ?></th>
              <th class="divCell"><?php echo $this->translate("Email") ?></th>
               <th class="divCell"><?php echo $this->translate("Address") ?></th>
               <th class="divCell"><?php echo $this->translate("Phone") ?></th>
               <th class="divCell"><?php echo $this->translate("Key People") ?></th>
               <th class="divCell"><?php echo $this->translate("HR Recuriting Page Link") ?></th>
            </tr>
         </thead>
          <tbody>
            <?php foreach ($this->hr as $hr): ?>
                    <tr>
                      <td><?php echo $hr->name?></td>
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
                           <td class ="divCell"><?php echo $hr->link ?></td>
                      </tr>
        <?php endforeach; ?>
          </tbody>
        </table>
          </div>
    </form>
    </div>
     </div>
 
<style>
 th.divCell {
    padding: 5px;
    width: auto;
    border-bottom: 3px solid #fff;
    border-right: 3px solid #fff;
    background-color: rgba(178, 184, 195, 0.2);
}

#global_page_company-profile-index > #smoothbox_window {
    overflow: inherit;
    /* height: auto; */
    border: 5px solid #f1f1f1;
}

table.divTable tbody tr td {
    padding: 10px;
    border-bottom: 1px solid #eee;
    font-size: .9em;
    padding-top: 7px;
    padding-bottom: 7px;
    vertical-align: top;
    white-space: normal;
    
    
  }

.company_settings form {
    padding: 10px;
    overflow: hidden;
    width: auto;
    border: 5px solid;
}
</style>