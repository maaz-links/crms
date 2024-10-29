<?php

$showError = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $emailad = $_POST["emailaddress"];
    $password = md5($_POST["password"]); 
    
     
    $sql = "Select * from tblusers where user_email='$emailad' AND user_password='$password'";
    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($result);
    $num = mysqli_num_rows($result);
    if ($num == 1){
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['userid'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        header("location: index.php");
    } 
    else{
        $showError = "Invalid Credentials";
    }
}
    
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
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
      
      /* .btn-primary {
    color: #fff;
    background-color: #0043ff8c;
    border-color: #0043ff8c;} */

    </style>

  </head>
  <body class="text-center">

  <!-- Jumbotron -->
  <div class="px-4 py-5 px-md-5 text-center text-lg-start" style="background-color: hsl(0, 0%, 96%)">
    <div class="container">
      <div class="row gx-lg-5 align-items-center">
        <div class="col-lg-6 mb-5 mb-lg-0">
          <h1 class="my-5 display-3 fw-bold ls-tight">
            Easy and Fast way <br> to <span class="text-primary">Rent</span> your Car <br />
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
            <span>Log in</span>
          </h1>
          <?php
            if($showError){
              echo '<p class="text-danger">Invalid Email or Password</p>';
            }
          ?>
            <form action="/crms/login.php" method="post">

                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-3">
                <label class="form-label" for="emailaddress">Email address</label>
                  <input type="email" id="emailaddress" name="emailaddress" class="form-control" required/>
                  
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-3">
                <label class="form-label" for="password">Password</label>
                  <input type="password" id="password" name="password" class="form-control" required/>
                  
                </div>
                <br>

                <div class="form-check mb-4" style="text-align: right;">
                <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">
                  Log in
                </button>
                <a href="forgotpassword.php" class="btn btn-link btn-block mb-4">Forgot password?</a>
                <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="signup.php"
                class="link-success">Create Account</a></p>
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
  </body>
</html>
