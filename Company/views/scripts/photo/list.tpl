<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Company
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: list.tpl 9987 2013-03-20 00:58:10Z john $
 * @author	   John
 */
?>

<h2>
  <?php echo $this->group->__toString() ?>
  <?php echo $this->translate('&#187; Photos');?>
</h2>

<?php if( $this->canUpload ): ?>
  <div class="group_photos_list_options">
    <?php echo $this->htmlLink(array(
        'route' => 'company_extended',
        'controller' => 'photo',
        'action' => 'upload',
        'subject' => $this->subject()->getGuid(),
      ), $this->translate('Upload Photos'), array(
        'class' => 'buttonlink icon_group_photo_new'
    )) ?>
  </div>
<?php endif; ?>

<div class='layout_middle'>
  <?php if( $this->paginator->count() > 0 ): ?>
    <?php echo $this->paginationControl($this->paginator); ?>
    <br />
  <?php endif; ?>
  <ul class="thumbs thumbs_nocaptions">
    <?php foreach( $this->paginator as $photo ): ?>
      <li>
        <a class="thumbs_photo" href="<?php echo $photo->getHref(); ?>">
          <?php echo $this->itemBackgroundPhoto($photo, 'thumb.normal')?>
        </a>
      </li>
    <?php endforeach;?>
  </ul>
  <?php if( $this->paginator->count() > 0 ): ?>
    <?php echo $this->paginationControl($this->paginator); ?>
    <br />
  <?php endif; ?>
</div>


<script type="text/javascript">
  $$('.core_main_group').getParent().addClass('active');
</script>
