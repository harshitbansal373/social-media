<?php  include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php 
            if(isset($_GET['category'])){
                $post_category_id = $_GET['category'];
            }

            $query = "SELECT * FROM posts WHERE post_category_id = {$post_category_id} ORDER BY post_id DESC";
            $select_all_posts_count_query = mysqli_query($connection,$query);
            confirm_query($select_all_posts_count_query);
            $count = mysqli_num_rows($select_all_posts_count_query);

            if($count==0){
            ?>
            <hr>
            <img class="img-fluid" src='images/noimage.jpg' alt="img">
            <hr> 
            <?php }

            else{
            while($row = mysqli_fetch_assoc($select_all_posts_count_query)){
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_user = $row['post_user'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];
            ?>

                  
            <!--first Blog Post -->
            <div class="mt-4 p-4 view">
                <h4> 
                  <a href="post.php?p_id='<?php echo $post_id; ?>'"><?php echo $post_title; ?></a>
                </h4>
                <h5 class="lead">
                    <?php
                    $query = "SELECT * FROM users WHERE username = '$post_user' ";
                    $select_user_query = mysqli_query($connection,$query);
                    while($row = mysqli_fetch_assoc($select_user_query)){
                      $user_firstname = $row['user_firstname'];
                      $user_lastname = $row['user_lastname'];
                    }
                    $name = $user_firstname.' '.$user_lastname;
                    ?>
                    by <a href="post.php?p_id='<?php echo $post_id; ?>'"><?php echo $name; ?></a>
                </h5>
                <h6><i class="far fa-clock"></i> <?php echo $post_date; ?></h6>
                <hr>
                <a href="post.php?p_id='<?php echo $post_id; ?>'">
                <img class="img-fluid" src="images/<?php echo imagePlaceholder($post_image);?>" alt="img">
                </a>
                <h6 class="my-3"><?php echo $post_content; ?></h6>
                    <a href="post.php?p_id='<?php echo $post_id; ?>'" class="btn btn-primary">Read More &rarr;</a>
            </div>

            <?php } }?>
            
            <br>

        </div>

<!-- Sidebar Widgets Column -->
<?php  include "includes/sidebar.php"; ?>

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->

<?php  include "includes/footer.php"; ?>