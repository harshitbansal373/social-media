<?php
    if(isset($_POST['like'])){
      $user_id = $_SESSION['user_id'];
      $post_id = $_POST['post_id'];

      $query = "SELECT * FROM post_like WHERE user_id = $user_id AND post_id = $post_id";
      $select_user_like_query = mysqli_query($connection,$query);
      $count_user_like = mysqli_num_rows($select_user_like_query);

      if($count_user_like==0){
          $query = "INSERT INTO post_like(post_id,user_id) VALUES ($post_id,$user_id)";
          $like_query = mysqli_query($connection,$query);
      }else{
          echo "Already Liked!";
      }
    //   $isliked = True;
    }

    if(isset($_POST['unlike'])){
        $user_id = $_SESSION['user_id'];
        $post_id = $_POST['post_id'];

        $query = "DELETE FROM post_like WHERE user_id = $user_id AND post_id = $post_id";
        $unlike_query = mysqli_query($connection,$query);
        // $isliked = False;
    }

?>