
<?php $categories = $this->categories; ?>


<?php if($this->noCategoryFound): ?>
	<div class="tip">
		<span><?php echo $this->translate("There is no Company Found, Please try to access another Company.") ?></span>
	</div>
<?php else: ?>
	<?php if($this->emptyCategories): ?>
		<div class="tip">
			<span><?php echo $this->translate("Empty Company Found, Please try to access another Company.") ?></span>
		</div>
	<?php endif; ?>
	
	<div class="generic_layout_container layout_core_content">  
	    <ul class="thumbs grid_wrapper">
	    	<?php foreach($categories as $key => $value): ?>
	    		<?php $photoUrl = Engine_Api::_ ()->getApi ( 'core', 'company' )->getCategoryPhotoUrl($key); ?>
	    		<?php 
		    		$slug = null;
		    		$title = null;
		    		if(isset($value['title'])){ 
		    			$slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $value['title']);
		    			$title = $value['title'];
		    		}
	    		 ?>
				<li>
					<div class="groups_photo">
					
		                <a href="<?php echo $this->url(array('category_id' => $key, 'slug' => $slug), 'company_browselevelone_categories') ?>">
		                	<img src="<?php echo $photoUrl; ?>" alt="Smiley face">
		                </a>
						<div class="info_stat_grid"></div>
					</div>
					<div class="groups_options"></div>
					<div class="groups_info">
					<div class="groups_title" style="margin-left:10px;padding-bottom: 10px;">
						<h3><a href="<?php echo $this->url(array('category_id' => $key, 'slug' => $slug), 'company_browselevelone_categories') ?>"><?php echo $title; ?></a></h3>
					</div>
					<p class="half_border_bottom"></p>
				</li>
			<?php endforeach?>
		</ul>
	</div>
<?php endif; ?>

<style>
.layout_company_browselevelone_categories > h3{
	display:none;
}
#global_page_company-category-browse #category_id_level_one-wrapper,
#global_page_company-category-browse #category_id_level_two-wrapper{
	display:none;
}
#global_page_company-category-browse ul.thumbs.grid_wrapper>li{
	height: auto;
    margin: 0 6px 20px 0;
    width: 24%
}
</style>
