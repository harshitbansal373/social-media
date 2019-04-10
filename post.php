<?php  include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php 
                if(empty($_GET['p_id'])){
                    redirect('index.php');
                }

                if(isset($_GET['p_id'])){
                   $the_post_id = $_GET['p_id'];
                }

                include "like.php";        

                $query = "SELECT * FROM posts WHERE post_id = {$the_post_id} ";
                $select_all_posts_query = mysqli_query($connection,$query);
                while($row = mysqli_fetch_assoc($select_all_posts_query)){
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
                <h6> <i class="far fa-clock"></i> <?php echo $post_date; ?></h6>
                
                <div style="margin:-2.3%; margin-top:0;margin-bottom:0;">
                    <a href="post.php?p_id='<?php echo $post_id; ?>'">
                    <img class="img-fluid" src="images/<?php echo imagePlaceholder($post_image);?>" alt="img">
                    </a>
                </div>
                <h6 class="my-3"><?php echo $post_content; ?></h6>

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
                
            <?php } ?>


            <!-- Blog Comments -->
            <?php

            if(isset($_POST['create_comment'])){
                $the_post_id = $_GET['p_id'];
                $comment_author = $_POST['comment_author'];
                $comment_email = $_POST['comment_email'];
                $comment_content = $_POST['comment_content'];

                if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)){
                    $query = "INSERT INTO comments(comment_post_id,comment_author,comment_email,
                            comment_content,comment_status,comment_date) ";
                    $query .= "VALUES ( $the_post_id,'{$comment_author}','{$comment_email}',
                            '{$comment_content}','show', NOW() )";

                    $create_comment_query = mysqli_query($connection,$query);

                    confirm_query($create_comment_query);

                }else{
                    echo "<script>alert('fields cannot be empty')</script>";
                }          

            }
            ?>

            <!-- Comments Form -->
            <div class="mt-4 p-4 view">
                <div class="col-sm-7">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="POST" role="form">
                        <div class="form-group">
                            <label for="Author">Name</label>
                            <input type="text" class="form-control" name="comment_author">
                        </div>
                        <div class="form-group">
                        <label for="Email">Email</label>
                            <input type="email" class="form-control" name="comment_email">
                        </div>
                        <div class="form-group">
                        <label for="">Your Comment</label>
                            <textarea class="form-control" rows="3" name="comment_content"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
                    </form>
                </div>
            </div>

            <!-- Posted Comments -->
            <div class="mt-4 p-2 view">
                <?php

                $query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} ";
                $query .= "AND comment_status = 'show' ";
                $query .= "ORDER BY comment_id DESC ";
                $select_comments_query = mysqli_query($connection,$query);

                confirm_query($select_comments_query);

                while($row = mysqli_fetch_array($select_comments_query)) {
                   $comment_date = $row['comment_date'];
                   $comment_author = $row['comment_author'];
                   $comment_content = $row['comment_content'];
                ?>

                <!-- Comment -->
                <div class="media border-bottom mt-2">
                    <a class="pull-left" href="#">
                        <img class="media-object mr-2" src="http://placehold.it/50x50" alt="">
                    </a>
                    <div class="media-body">
                        <h5 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h5>
                        <h6><?php echo $comment_content; ?></h6>
                    </div>
                </div>

                <?php } ?>
            </div>
            <br>
            
        </div>

<!-- Sidebar Widgets Column -->
<?php  include "includes/sidebar.php"; ?>

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->

<?php  include "includes/footer.php"; ?>