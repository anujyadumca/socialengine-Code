<style>
.companyimport_admin_settings {
    background-color: #f5f5f5;
    padding: 10px;
    overflow: hidden;
}
</style>

<h2>
  <?php echo $this->translate("Company Importer Plugin") ?>
</h2>

<?php if( count($this->navigation) ): ?>
  <div class='tabs'>
    <?php
      // Render the menu
      //->setUlClass()
      echo $this->navigation()->menu()->setContainer($this->navigation)->render()
    ?>
  </div>
<?php endif; ?>

<div class='settings companyimport_admin_settings'>
	<div class="companyimport_admin_layout">
		<h4>This plugin created the companys in socialengine from the CSV file which is uploaded by admin.For CSV example you can see screen below or <a target="_blank" href="application/modules/Company/externals/company.csv">click here</a> </h4>
		<div class="companyimport_admin_form">
  			<?php echo $this->form->render($this); ?>
  		</div>
  	</div>
</div>

