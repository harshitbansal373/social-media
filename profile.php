<?php  include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<?php 
    if(empty($_GET['username'])){
        redirect('index.php');
    }

    $isfollowing = False;
    if(isset($_GET['username'])){
        $the_username = $_GET['username'];
    
        $query = "SELECT * FROM users WHERE username = $the_username ";
        $select_user_query = mysqli_query($connection,$query);
        $count_user = mysqli_num_rows($select_user_query);
    
        if($count_user!=0){
            while($row = mysqli_fetch_assoc($select_user_query)){
                $user_id = $row['user_id'];
                $username = $row['username'];
                $user_firstname = $row['user_firstname'];
                $user_lastname = $row['user_lastname'];
            }
 
            if(isset($_POST['follow'])){
                $follower_id = $_SESSION['user_id'];
                
                if($user_id!=$follower_id){

                    if(empty($follower_id)){
                        redirect('login.php');
                    }

                    $query = "SELECT * FROM followers WHERE user_id = $user_id AND follower_id = $follower_id";
                    $select_follower_query = mysqli_query($connection,$query);
                    $count_follower_exist = mysqli_num_rows($select_follower_query);

                    if($count_follower_exist==0){
                        $query = "INSERT INTO followers(user_id,follower_id) VALUES ($user_id,$follower_id)";
                        $follow_query = mysqli_query($connection,$query);
                    }else{
                        echo "Already following!";
                    }
                    $isfollowing = True;
                }
            }

            if(isset($_POST['unfollow'])){
                $follower_id = $_SESSION['user_id'];

                $query = "DELETE FROM followers WHERE user_id = $user_id AND follower_id = $follower_id";
                $unfollow_query = mysqli_query($connection,$query);
                $isfollowing = False;
            }

            if(isset($_SESSION['user_id'])){
                $follower_id = $_SESSION['user_id'];
                $query = "SELECT * FROM followers WHERE user_id = $user_id AND follower_id = $follower_id ";
                $select_follower_query = mysqli_query($connection,$query);
                $count_follower_exist = mysqli_num_rows($select_follower_query);
                if($count_follower_exist!=0){
                    $isfollowing =True;
                }
            }

        }else{
            echo '<h2 class="text-center">User Not Found</h2>';
        }
        
    }
?>


<!-- Page Content -->
<?php if(isset($username)){ ?>

<h2><?php echo $username." 's Profile"; ?></h2>
<form action="profile.php?username='<?php echo $username; ?>' " method="POST">
    <?php
    if(isset($_SESSION['user_id'])){
        if($user_id!=$_SESSION['user_id']){
            if($isfollowing ==True){
                echo '<input type="submit" name="unfollow" value="Unfollow">';
            }else{
                echo '<input type="submit" name="follow" value="Follow">';
            }
        }
    }
    ?>
</form>

<?php } ?>

<br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php  include "includes/footer.php"; ?>