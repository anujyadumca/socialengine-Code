<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Company
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: edit.tpl 9987 2013-03-20 00:58:10Z john $
 * @author	   John
 */
?>

<?php echo $this->form/*->setAttrib('class', 'global_form_popup')*/->render($this) ?>


<script type="text/javascript">
  $$('.core_main_group').getParent().addClass('active');
</script>



<!-- add cutom js for adding subcategory features -->
<script src="application/modules/Company/externals/scripts/company.js"></script>





<style>
.form-wrapper{
    margin-bottom: 20px;
}
#category_id_level_one,
#category_id,
.global_form select{
	height: 45px;
}
</style>