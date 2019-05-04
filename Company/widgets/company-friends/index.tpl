<ul class='profile_friends' id="user_profile_friends">
  
  <?php if($this->totalcount > 0):?>
  <?php foreach( $this->companies as $company ):
     $member = $this->friendUsers[$company['user_id']];
    
    ?>
     <li id="user_friend">
      <?php echo $this->htmlLink($member->getHref(), $this->itemPhoto($member, 'thumb.icon'), array('class' => 'profile_friends_icon')) ?>
      <div class='profile_friends_body'>
        <div class='profile_friends_status'>
          <span>
      <?php echo $company['displayname'] ?>
           <?php  $companiesDetails = $company['companies']; ?>
           <?php foreach( $companiesDetails as $data ):?> 
           <div id = "companytitle">
         <?php echo "".$data['title']; ?>
           </div>
           <?php endforeach ?> 
          </span>
        </div>
        </li>
      <?php endforeach ?>
 <li id="user_friend">
 <?php else:?>
 <?php echo "Your No Friend Match with Common Interest"; ?>
 <?php endif;?>
 </li>
 
 </ul>