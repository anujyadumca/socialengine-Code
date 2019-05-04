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
               <th class="divCell"><?php echo $this->translate("Business Type") ?></th>
               <th class="divCell"><?php echo $this->translate("Patnership Page Link") ?></th>
            </tr>
         </thead>
          <tbody>
            <?php foreach ($this->business as $business): ?>
                    <tr>
                      <td><?php echo $business->name?></td>
                      <td><?php echo $business->email?></td>
                      <td><?php echo $business->address?></td>
                      <td><?php echo $business->phone?></td>
                      <?php if($business->businesstype == 1):?>
                          <td class ="divCell"><?php echo $this->translate("Contact for Patnership")?></td>
                           <?php endif;?>
                           <?php if($business->businesstype == 2):?>
                           <td class ="divCell"><?php echo $this->translate("Contact for Supplier Proposal")?></td>
                           <?php endif;?>
                            <?php if($business->businesstype == 3):?>
                            <td class ="divCell"><?php echo $this->translate("Request for Proposal")?></td>
                           <?php endif;?>
                           <td class ="divCell"><?php echo $business->link ?></td>
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
    padding: 18px;
    overflow: hidden;
    width: auto;
    border: 7px solid;
}
</style>