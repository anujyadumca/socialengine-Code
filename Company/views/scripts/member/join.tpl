<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Company
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: join.tpl 9747 2012-07-26 02:08:08Z john $
 * @author		 John
 */
?>

<?php echo $this->form->setAttrib('class', 'global_form_popup')->render($this) ?>
<script>
$('graduation-wrapper').style.display = "none";
 function showgraduation(value){ 
  if( value == 3 || value == 4 ){
   $('graduation-wrapper').style.display = "block"; 
  }else{
   $('graduation-wrapper').style.display = "none";
  }
}
</script>
<style>
#graduation-wrapper {
 margin-top:10px;
}
#graduation {
 padding : 8px 0 !important;
}
</style>