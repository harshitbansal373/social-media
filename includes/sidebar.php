<div class="col-md-4">

<!-- Search Widget -->

<div class="card my-4">
  <h5 class="card-header">Search</h5>
  <form action="search.php" method="POST">
  <div class="card-body">
    <div class="input-group">
      <input type="text" name="search" class="form-control" placeholder="Search for..." required>
      <span class="input-group-btn">
        <button name="submit" class="btn btn-secondary" type="submit"><i class="fas fa-search"></i></button>
      </span>
    </div>
  </div>
  </form>
</div>

<!-- Search Widget -->

<div class="card my-4">

  <?php if(isset($_SESSION['user_role'])): ?>

    <h5 class="card-header">Logged in as <?php echo $_SESSION['username']; ?></h5>
    <span class="input-group-btn text-center">
    <a href="includes/logout.php" class="btn btn-primary">Logout</a>
    </span>

  <?php else: ?>

  <h5 class="card-header">Login</h5>
    <form action="includes/login.php" method="POST">
    <div class="card-body">
      <div class="form-group">
        <input type="text" name="username" class="form-control" placeholder="Enter Username">
      </div>
      <div class="input-group">
        <input type="password" name="password" class="form-control" placeholder="Enter Password">
        <span class="input-group-btn">
          <button name="login" class="btn btn-secondary" type="submit">Submit</button>
        </span>
      </div>
      <div class="form-group">
      <a href="forgot.php?forgot=<?php echo uniqid(true); ?>"> Forgot Password?</a>
      </div>
    </div>
    </form>

  <?php endif; ?>


</div>

<!-- Categories Widget -->
<div class="card my-4">
  <h5 class="card-header text-center">Categories</h5>
  <div class="card-body">
      <?php 
      $query = "SELECT * FROM categories";
      $select_all_categories_query = mysqli_query($connection,$query);
      ?> 
                  
    <div class="row">
      <div class="col-lg-6">
        <ul class="list-unstyled mb-0">
            <?php
            while($row = mysqli_fetch_assoc($select_all_categories_query)){
             $cat_title = $row['cat_title'];
             $cat_id = $row['cat_id'];
             echo "<li class='nav-item text-center mb-2'>
             <a href='categorymenu.php?category=$cat_id'><span class='badge badge-pill badge-primary'><h6>{$cat_title}</h6></span></a></li>";
            }
            ?>
        </ul>
      </div>

      <div class="col-lg-6">
        <ul class="list-unstyled mb-0 text-center">
          <li>
            <a href="#"><span class="badge badge-pill badge-primary mb-2"><h6>JavaScript</h6></span></a>
          </li>
          <li>
            <a href="#"><span class="badge badge-pill badge-primary mb-2"><h6>CSS</h6></span></a>
          </li>
          <li>
            <a href="#"><span class="badge badge-pill badge-primary mb-2"><h6>PHP</h6></span></a>
          </li>
          <li>
            <a href="#"><span class="badge badge-pill badge-primary mb-2"><h6>SQL</h6></span></a>
          </li>
        </ul>
      </div>

    </div>
    
  </div>
</div>

<!-- Side Widget -->
<?php include "widget.php"; ?>

</div>