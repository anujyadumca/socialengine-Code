<?php if(false): ?>
	<?php $category = Engine_Api::_ ()->getApi ( 'categories', 'company' )->getCategoryByCategoryId($this->category_id); ?>
	<div class="groupBreadcrumbs">
		<ul>
			  <li class="group_stats_title">
			        <a href="/groups/browse/category_id/<?php echo $this->category_id; ?>"><?php echo $category['title']; ?></a>
			  </li>
		 </ul>
	</div>
<?php endif; ?>


<?php $categories = $this->categories; ?>
<?php if($this->noCategoryFound): ?>
	<div class="tip">
		<span><?php echo $this->translate("There is no company Found, Please try to access another company.") ?></span>
	</div>
<?php else: ?>
	<?php if($this->emptyCategories): ?>
		<div class="tip">
			<span><?php echo $this->translate("Empty company Found, Please try to access another company.") ?></span>
		</div>
	<?php endif; ?>
	<div class="generic_layout_container layout_core_content">  
	    <ul class="thumbs grid_wrapper">
	    	<?php foreach($categories as $key => $value): ?>
	    		<?php $photoUrl = Engine_Api::_ ()->getApi ( 'core', 'company' )->getCategoryPhotoUrl($key); ?>
	    		<?php
		    		$title = null;
		    		if(isset($value['title'])){
		    			$title = $value['title'];
		    		}
	    		 ?>
				<li>
					<div class="groups_photo">
						<a href="<?php echo $this->url(array('category_id' => $key, 'slug' => $slug), 'company_browseleveltwo_categories') ?>"><img src="<?php echo $photoUrl; ?>" alt="Smiley face"></a>
						<div class="info_stat_grid"></div>
					</div>
					<div class="groups_options"></div>
					<div class="groups_info">
					<div class="groups_title" style="margin-left:10px;padding-bottom: 10px;">
						<h3><a href="<?php echo $this->url(array('category_id' => $key, 'slug' => $slug), 'company_browseleveltwo_categories') ?>"><?php echo $title; ?></a></h3>
					</div>
					<p class="half_border_bottom"></p>
				</li>
			<?php endforeach?>
		</ul>
	</div>
<?php endif; ?>




<style>
#global_page_company-category-browselevelone .tabs>ul>li:first-child>a{
    background-color: transparent;
    color: #1BC1D6;
    border-color: #1BC1D6;
}
#global_page_company-category-browselevelone #category_id-wrapper,
#global_page_company-category-browselevelone #category_id_level_two-wrapper{
	display:none;
}
#global_page_company-category-browselevelone ul.thumbs.grid_wrapper>li{
	height: auto;
    margin: 0 6px 20px 0;
    width: 24%
}
#global_page_company-category-browselevelone .layout_company_browseleveltwo_categories > h3{
	display:none;
}
.groupBreadcrumbs{
	text-transform: none;
    font-weight: 100;
    font-size: 14px;
    color: #8a8a8a;
    border-bottom: 1px #ececec solid;
    padding-bottom: 15px;
}
</style>
