<?php

$showlesspass = false;
$AlreadyExists = false;
$showError = false;
$notifySuccess= false;
$InvalidEmail = false;


if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';

    if(strlen($_POST["password"]) < 8)
    {
      $showError = true;
    }
    else
{

    $username = $_POST["username"];
    $email = $_POST["emailaddress"];
    $contactno = $_POST["contact"];
    $password = md5($_POST["password"]);
    $cpassword = md5($_POST["cpassword"]);
    $exists=false;
    $sql = "SELECT * FROM `tblusers` WHERE `user_email` = '$email'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1)
    {
      $AlreadyExists = true;
    }
    
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      $InvalidEmail = true;
    }
    else{
    if(($password == $cpassword)  ){
        $sql = "INSERT INTO `tblusers` (`username`, `user_email`, `user_contact`, `user_password`)
        VALUES ('$username', '$email', '$contactno', '$password')";
        $result = mysqli_query($conn, $sql);
        if ($result){
          //Auto Login
          $sql = "SELECT * FROM `tblusers` WHERE `user_email` = '$email'";
          $result = mysqli_query($conn, $sql);
          $row = mysqli_fetch_assoc($result);
          session_start();
          $notifySuccess= true;
          $_SESSION['loggedin'] = true;
          $_SESSION['userid'] = $row['user_id'];
          $_SESSION['username'] = $username;
          
        }
    }
    else{
        $showError = true;//"Passwords do not match";
    }
  }
}

}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create New Account</title>
    <link rel="icon" type="image/x-icon" href="img/OIG2.jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <style>
      body {
        height: 100%;
      }
      body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }
    
    </style>

  </head>
  <body class="text-center">

  <div class="px-4 py-5 px-md-5 text-center text-lg-start" style="background-color: hsl(0, 0%, 96%)">
    <div class="container">
      <div class="row gx-lg-5 align-items-center">
        <div class="col-lg-6 mb-5 mb-lg-0">
          <h1 class="my-5 display-3 fw-bold ls-tight">
            Easy and Fast way <br> to <span class="text-success">Rent</span> your Car <br />
          </h1>
          <p style="color: hsl(217, 10%, 50.8%)">
          First ever time in Gujranwala to effectively rent a car.
          Knowing the today's vital need to hire cabs and to travel all across the world
          we are very keen to introduce you the car renting system.
          </p>
        </div>

        <div class="col-lg-6 mb-5 mb-lg-0">
          <div class="card">
            <div class="card-body py-5 px-md-5">
            <h1 class="display-3 fw-bold ls-tight" style="padding-bottom: 0.8em;">
            <span>Create Account</span>
          </h1>
          
            <form action="/crms/signup.php" method="post">
                <!-- Username input -->
                <div data-mdb-input-init class="form-outline mb-3">
                <label class="form-label" for="username">Username</label>
                  <input type="text" id="username" name="username" class="form-control" required/>
                </div>

                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-3">
                <?php
                  if($AlreadyExists){
                    echo '<p class="text-danger">The Email you entered Already Exists</p>';
                  }
                ?>
                <?php
                  if($InvalidEmail){
                    echo '<p class="text-danger">The Email you entered is Invalid</p>';
                  }
                ?>
                <label class="form-label" for="emailaddress">Email address</label>
                  <input type="email" id="emailaddress" name="emailaddress" class="form-control"  maxlength="50" required/>
                  
                </div>
                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-3">
                  <label class="form-label" for="contact">Contact Number</label>
                  <input type="text" id="contact" name="contact" class="form-control" maxlength="11" pattern="[0-9]*" title="Please enter numeric characters only" required/>
                
                </div>

                <!-- Password input -->
                
                <div data-mdb-input-init class="form-outline mb-3">
                  <label class="form-label" for="password">Password</label>
                  <input type="password" id="password" name="password" class="form-control" maxlength="20" required/>
                
                </div>
                <div data-mdb-input-init class="form-outline mb-3">
                  <label class="form-label" for="cpassword">Confirm Password</label>
                  <input type="password" id="cpassword" name="cpassword" class="form-control" maxlength="20" required/>
                  <br>
                
                <?php
                  if($showError){
                    echo '<p class="text-danger">Password is invalid, It must contain at least 8 characters</p>';
                  }else{
                    echo '<small class="form-text text-muted">Make sure to type the same password</small>';
                  }
                ?>
                </div>
                <div class="form-check mb-4" style="text-align: right;">
                <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-block mb-4">
                  Create Account
                </button>
                <p class="small fw-bold mt-2 pt-1 mb-4">Already have an account? <a href="login.php"
                class="link-success">Login</a></p>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    // Solves Resubmit form on Reload issue
    if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
    </script>
<?php
if($notifySuccess){
          echo "<script type='text/javascript'>
            alert('New account successfully created. You are now logged in as ".$username."');
            window.location.href = 'index.php';
          </script>";
}
?>  

  </body>
</html>
