<?php
session_start();

$showError = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $username = $_POST["ausername"];
    $password = md5($_POST["apassword"]); 
    
     
    $sql = "Select * from tbladmin where admin_name='$username' AND admin_password='$password'";
    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($result);
    $num = mysqli_num_rows($result);
    if ($num == 1){

        session_start();
        $_SESSION['aloggedin'] = true;
        $_SESSION['adminid'] = $row['id'];
        $_SESSION['adminname'] = $username;
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
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="img/OIG2.jpeg">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>

    </style>
    <title>Login Admin</title>
  </head>
  <body>



<section class="vh-100" style="background-image: url(/crms/admin/img/adminlogin.jpg);">

  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">
            <h3 class="mb-5">Log in as Administrator</h3>
            <form action="/crms/admin/loginadmin.php" method="post">
            <div data-mdb-input-init class="form-outline mb-4">
            <!-- <label class="form-label" for="username">Email</label> -->
              <input type="text" id="username" class="form-control form-control-lg" name="ausername" placeholder="Name" maxlength=20 required/>
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
            <!-- <label class="form-label" for="password" >Password</label> -->
              <input type="password" id="password" class="form-control form-control-lg" name="apassword" placeholder="Password" maxlength=20 required/>
            </div>
            <?php
            if($showError){
            echo '<p class="text-danger">'. $showError.'</p>';
            }
            ?>
            <hr>
            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
