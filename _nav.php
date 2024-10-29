

<nav style="padding-left: 90px; padding-right: 90px; background-color: #fff;" class="navbar navbar-expand-lg navbar-light rounded">
    <img style="width: 50px; border-radius: 50px;" src="/crms/img/OIG2.jpeg" alt="">
    <a class="navbar-brand" href="index.php"><h3>The-Byte-side<sup>TM</sup></h3></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample09" aria-controls="navbarsExample09" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample09">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="carslist.php">Cars List</a>
        </li>
        
      </ul>
      <?php
if(isset($_SESSION['loggedin'])){
          echo '      <div class="btn-group">
          <button style="margin-right: 25px;" type="button"
          class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Welcome, ' .$_SESSION['username']
          .'</button>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="updateprofile.php">Update Profile</a>
            <a class="dropdown-item" href="changepassword.php">Change Password</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item text-danger" href="_logout.php">Logout</a>
          </div>
        </div> ';
}
else{
         echo '      <a href="signup.php" style="width: 100px;margin-right: 25px;" class="btn btn-outline-primary my-2 my-sm-0" >Sign Up</a>
         <a href="login.php" style="width: 100px;margin-right: 25px;" class="btn btn-primary my-2 my-sm-0">Login</a>';
}


?>



    </div>
  </nav>