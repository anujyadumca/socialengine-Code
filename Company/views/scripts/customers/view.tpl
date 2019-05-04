<div class='clear'>
<div class='company_settings'>
    <form class="global_form">
      <div>
        <h3> <?php echo $this->translate("Company Customer") ?> </h3>
        <p class="description">
          <?php echo $this->translate("List for Company Customer") ?>
        </p>
          

         <table class='divTable'>
          <thead>
            <tr>
              <th class="divCell"><?php echo $this->translate("Name") ?></th>
              <th class="divCell"><?php echo $this->translate("Email") ?></th>
               <th class="divCell"><?php echo $this->translate("Address") ?></th>
               <th class="divCell"><?php echo $this->translate("Phone") ?></th>
               <th class="divCell"><?php echo $this->translate("Customer Type") ?></th>
               <th class="divCell"><?php echo $this->translate("Store Link") ?></th>
            </tr>
         </thead>
          <tbody>
            <?php foreach ($this->customers as $customer): ?>
                    <tr>
                      <td><?php echo $customer->name?></td>
                      <td><?php echo $customer->email?></td>
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
                           <td class ="divCell"><?php echo $customer->link ?></td>
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