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

            include "like.php";        

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
            <div class="mt-3 p-3 view">
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
                    by <a href="profile.php?username='<?php echo $post_user; ?>'"><?php echo $name; ?></a>
                </h5>
                <h6><i class="far fa-clock"></i> <?php echo $post_date; ?></h6>

                <div style="margin:-2.3%; margin-top:0;margin-bottom:0;">
                    <a href="post.php?p_id='<?php echo $post_id; ?>'">
                    <img class="img-fluid" src="images/<?php echo imagePlaceholder($post_image);?>" alt="img">
                    </a>
                </div>

                <h6 class="my-3"><?php echo $post_content; ?></h6>
                <a href="post.php?p_id='<?php echo $post_id; ?>'" class="btn btn-primary">Read More &rarr;</a>

                <?php if(isset($_SESSION['username'])){ ?>
                <div class="row border-top py-1 mt-2 text-center">
                    <form class="col-6" action="" method="POST">
                        <input style="display:none" type="text" class="form-control" name="post_id" value="<?php echo $post_id; ?>" >
                        <?php
                        if(isset($_SESSION['user_id'])){
                            $user_id = $_SESSION['user_id'];
                            $query = "SELECT * FROM post_like WHERE user_id = $user_id AND post_id = $post_id";
                            $select_user_like_query = mysqli_query($connection,$query);
                            $count_user_like = mysqli_num_rows($select_user_like_query);
                            if($count_user_like!=0){
                                echo '<input type="submit" class="text-dark btn-block" name="unlike" value="Unlike">';
                            }else{
                                echo '<input type="submit" class="text-dark btn-block" name="like" value="Like">';
                            }
                        }?>
                    </form>
                    <div class="col-6"><input type="submit" class="text-dark btn-block" name="comments" value="Comments"></div>
                </div>

                <?php } ?>

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