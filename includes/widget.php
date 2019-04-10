
<div class="card view">
  <h5 class="card-header">Recent Posts</h5>
  <div class="card-body">
      <?php 
      $query = "SELECT * FROM posts ORDER BY post_id DESC LIMIT 5";
      $select_all_posts_query = mysqli_query($connection,$query);
      while($row = mysqli_fetch_assoc($select_all_posts_query)){
          $post_id = $row['post_id'];
          $post_title = $row['post_title'];
          $post_user = $row['post_user'];
          $post_date = $row['post_date'];
          $post_image = $row['post_image'];
          $post_content = $row['post_content'];
      ?>
      <div class="media mb-2 border-bottom">
          <div class="media-body">
              <h6 class="mt-0 mb-0">
                  <?php
                  $query = "SELECT * FROM users WHERE username = '$post_user' ";
                  $select_user_query = mysqli_query($connection,$query);
                  while($row = mysqli_fetch_assoc($select_user_query)){
                    $user_firstname = $row['user_firstname'];
                    $user_lastname = $row['user_lastname'];
                  }
                  $name = $user_firstname.' '.$user_lastname;
                  ?>
                  <a style="color:#fcb941" href="profile.php?username='<?php echo $post_user; ?>'"><?php echo $name;?></a>
              </h6>
              <a href="post.php?p_id='<?php echo $post_id; ?>'">
              <h6 style="color:#336e7b"><?php echo $post_title; ?></h6>
              </a>  
          </div>
          <a href="post.php?p_id='<?php echo $post_id; ?>'">
          <img src="images/<?php echo imagePlaceholder($post_image);?>" class="ml-auto" style="width:60px; height:40px;" alt="post_image">
          </a>
      </div>
      <?php } ?>
      
  </div>
</div>
<br>