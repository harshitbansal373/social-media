<?php  include "includes/header.php"; ?>

<!-- Navigation -->
<?php  include "includes/navigation.php"; ?>

<?php
if(isset($_POST['submit'])){
$username = $_POST['username'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['password'];

    if(!empty($username) && !empty($email) && !empty($password)){
        $username = mysqli_real_escape_string($connection,$username);
        $firstname = mysqli_real_escape_string($connection,$firstname);
        $lastname = mysqli_real_escape_string($connection,$lastname);
        $email = mysqli_real_escape_string($connection,$email);
        $password = mysqli_real_escape_string($connection,$password);

        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

        $query = "SELECT username FROM users WHERE username = '{$username}' ";
        $user_exist_query = mysqli_query($connection,$query);
        $count_user_exist = mysqli_num_rows($user_exist_query);

        if($count_user_exist==0){
            $query = "INSERT INTO users (user_role,username,user_firstname,user_lastname,user_email,user_password) ";
            $query .= "VALUES( 'subscriber',?,?,?,?,?)";
            $stmt = mysqli_prepare($connection,$query);
            mysqli_stmt_bind_param($stmt,"sssss",$username,$firstname,$lastname,$email,$password);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            confirm_query($stmt);           

            $add_user_message = "Your Registration has been submitted";
        }else{
            $user_exist_message = 'Username Already exist!!!';
        }

    }else{
        $message = "fields cannot be empty";
    }

}else{
    $message = "";
}


?>
   
 
<!-- Page Content -->
<div class="container">
    <section id="login">
        <div class="row justify-content-center align-items-center">
            <div class="col-sm-5 col-sm-offset-5 boxview p-3 mt-4">
                <div class="form-wrap">
	    		    <h3 class="text-center mb-3"><i class="fas fa-portrait fa-3x"></i></h3>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                            <h6><?php if(isset($add_user_message)){echo $add_user_message;} ?></h6>
                            <h6><?php if(isset($message)){echo $message;} ?></h6>
                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                                <h6 class="text-danger ml-3"><?php if(isset($user_exist_message)){echo $user_exist_message;} ?></h6>
                            </div>
                            <div class="form-group">
                                <label for="firstname" class="sr-only">Firstname</label>
                                <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Enter Your Firstname">
                            </div>
                            <div class="form-group">
                                <label for="lastname" class="sr-only">Lastname</label>
                                <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Enter Your Lastname">
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            </div>
                            <input type="submit" name="submit" id="btn-login" class="btn btn-secondary btn-lg btn-block" value="Register">
                        </form>
                </div>
            </div> <!-- /.col-sm-5 -->
        </div> <!-- /.row -->
    </section>

<hr>

<?php include "includes/footer.php";?>

</div> <!-- /.container -->
