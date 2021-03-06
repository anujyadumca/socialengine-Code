<?php if(false): ?>
	<?php $category = Engine_Api::_ ()->getApi ('categories', 'company' )->getCategoryByCategoryId($this->category_id); ?>
	<div class="groupBreadcrumbs">
		<ul>
			  <li class="group_stats_title">
			        <a href="/companies/browse/category_id/<?php echo $this->category_id; ?>"><?php echo $category['title']; ?></a>
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
	<?php elseif($this->paginator): ?>
		<ul class='groups_browse grid_wrapper'>
		  <?php foreach( $this->paginator as $group ): ?>
		    <li>
		      <div class="groups_photo">
		        <?php echo $this->htmlLink($group->getHref(), $this->itemBackgroundPhoto($group, 'thumb.profile')) ?>
		        <div class="info_stat_grid">
		          <?php if( $group->like_count > 0 ) :?>
		            <span>
		              <i class="fa fa-thumbs-up"></i>
		              <?php echo $this->locale()->toNumber($group->like_count) ?>
		            </span>
		          <?php endif; ?>
		          <?php if( $group->comment_count > 0 ) :?>
		            <span>
		              <i class="fa fa-comment"></i>
		              <?php echo $this->locale()->toNumber($group->comment_count) ?>
		            </span>
		          <?php endif; ?>
		          <?php if( $group->view_count > 0 ) :?>
		            <span class="views_group">
		              <i class="fa fa-eye"></i>
		              <?php echo $this->locale()->toNumber($group->view_count) ?>
		            </span>
		          <?php endif; ?>
		        </div>
		      </div>
		      <div class="groups_options">
		      </div>
		      <div class="groups_info">
		        <div class="groups_members">
		          <span><i class="fa fa-user"></i></span>
		          <span><?php echo $this->translate(array('%s', '%s', $group->membership()->getMemberCount()),$this->locale()->toNumber($group->membership()->getMemberCount())) ?></span>
		        </div>
		        <div class="groups_title">
		          <h3><?php echo $this->htmlLink($group->getHref(), $group->getTitle()) ?></h3>
		          <div class="groups_desc">
		            <?php echo $this->viewMore($group->getDescription()) ?>
		          </div>
		          <?php echo $this->translate('led by');?> <?php echo $this->htmlLink($group->getOwner()->getHref(), $group->getOwner()->getTitle()) ?>
		        </div>
		      </div>
		      <p class="half_border_bottom"></p>
		    </li>
		  <?php endforeach; ?>
		</ul>
	<?php else: ?>
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
							<a href="/companys?category_id_level_two=<?php echo $key; ?>"><img src="<?php echo $photoUrl; ?>" alt="Smiley face"></a>
							<div class="info_stat_grid"></div>
						</div>
						<div class="groups_options"></div>
						<div class="groups_info">
						<div class="groups_title" style="margin-left:10px;padding-bottom: 10px;">
							<h3><a href="/companys?category_id_level_two/<?php echo $key; ?>"><?php echo $title; ?></a></h3>
						</div>
						<p class="half_border_bottom"></p>
					</li>
				<?php endforeach?>
			</ul>
		</div>
	<?php endif; ?>
<?php endif; ?>


<style>
#global_page_company-category-browseleveltwo .tabs>ul>li:first-child>a{
    background-color: transparent;
    color: #1BC1D6;
    border-color: #1BC1D6;
}
#global_page_company-category-browseleveltwo ul.grid_wrapper{
	text-align: left;
}
#global_page_company-category-browseleveltwo #category_id-wrapper,
#global_page_company-category-browseleveltwo #category_id_level_two-wrapper{
	display:none;
}
#global_page_company-category-browseleveltwo .layout_company_browselevelthree_categories > h3{
	display:none;
}
#global_page_company-category-browseleveltwo ul.thumbs.grid_wrapper>li{
	height: auto;
    margin: 0 6px 20px 0;
    width: 24%
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