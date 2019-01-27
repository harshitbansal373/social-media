<?php  include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>


<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
        
            <!--user profile search -->
            <div class="view mt-3 py-3">
                <h4 class="ml-3 mb-4">People</h4>

                <?php
                if(isset($_POST['submit'])){
                    $search = $_POST['search'];
               
                    $query = "SELECT * FROM users WHERE username LIKE '%$search%' OR user_firstname LIKE '%$search%' OR user_lastname LIKE '%$search%' ";
                    $search_query = mysqli_query($connection,$query);

                    while($row = mysqli_fetch_array($search_query)) {
                       $username = $row['username'];
                       $user_firstname = $row['user_firstname'];
                       $user_lastname = $row['user_lastname'];
                ?>

                <div class="media">
                    <a href="profile.php?username='<?php echo $username; ?>'">
                    <img src="images/nouser.png" class="mx-3" alt="...">
                    </a>
                    <div class="media-body">
                        <h6 class="mt-0">
                            <a href="profile.php?username='<?php echo $username; ?>'">
                                <?php echo $user_firstname.' '.$user_lastname; ?>
                            </a>
                        </h6>
                        Lorem ipsum dolor sit amet.
                    </div>
                </div>
                <hr>    
                <?php } }?>
            </div>


            <?php
            if(isset($_POST['submit'])){
                $search = $_POST['search'];
            
                $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%'";
                $search_query = mysqli_query($connection,$query);
            
                confirm_query($search_query);
            
                $count = mysqli_num_rows($search_query);

                if($count == 0){
                    echo '<div class="mt-4 p-4 view">
                            <h1 class="text-center">NOT FOUND POST</h1>
                          </div>';
                }
                else{
                    while($row = mysqli_fetch_assoc($search_query)){
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
                <h6> <i class="far fa-clock"></i> <?php echo $post_date; ?></h6>
                <hr>
                <a href="post.php?p_id='<?php echo $post_id; ?>'">
                <img class="img-fluid" src="images/<?php echo imagePlaceholder($post_image);?>" alt="img">
                </a>
                <h6 class="my-3"><?php echo $post_content; ?></h6>
                    <a href="post.php?p_id='<?php echo $post_id; ?>'" class="btn btn-primary">Read More &rarr;</a>       
            </div>
                
            <?php   } 
                }
            }
            ?>

            <br>

        </div>

<!-- Sidebar Widgets Column -->
<?php  include "includes/sidebar.php"; ?>

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->

<?php  include "includes/footer.php"; ?>