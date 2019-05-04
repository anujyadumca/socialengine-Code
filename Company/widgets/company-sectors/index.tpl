<ul class='profile_friends' id="user_profile_friends">
  
   <?php foreach( $this->companies as $company ):
        
        ?>

    <li id="user_friend">
     <div class='profile_friends_body'>
        <div class='profile_friends_status'>
          <span>
            
             <div id = "companytitle">
             <?php echo $company->title ?>
             <?php echo "TotalViews" ?>
            <?php echo "".$company->view_count ?>
            </div>
          </span>
         
        </div>
        
        </li>
        
      <?php endforeach ?>
 </ul>