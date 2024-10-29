<?php

session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
  header("location: /crms/login.php");
  exit;
}

include '_dbconnect.php';

$showError = " ";
$notifySuccess = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

  //Insert the record
    $insert_value1 = md5($_POST["currentpass"]);
    // echo $insert_value1;
    $insert_value2 = md5($_POST["newpass"]);
    $insert_value3 = md5($_POST["confirmpass"]);
    $userID = $_SESSION["userid"];
  if($insert_value2 == $insert_value3){
  // Sql query to be executed
  $sql = "SELECT * FROM `tblusers` WHERE `user_id` = '$userID' AND `user_password` = '$insert_value1' ";
  $result = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($result);
  if ($num == 1){
    $sql = "UPDATE `tblusers` SET `user_password` = '$insert_value2' WHERE `tblusers`.`user_id` = '$userID' ";
    $result = mysqli_query($conn, $sql);
    if($result){ 
        $notifySuccess = true;
    }
    else{
        echo "The record was not updated successfully because of this error ---> ". mysqli_error($conn);
    } 
  }
  else
  {
    $showError = "Current Password Entered is incorrect";
  }
}else{
  $showError = "New Password and Confirm Password do not match.";
}

}




?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Change Password</title>
    <link rel="icon" type="image/x-icon" href="img/OIG2.jpeg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/update.css">

  </head>
  <body class="text-center">
    
  <?php include '_nav.php' ?>
  <div style="text-align: left !important;" class="container my-4">
    <h2>Change Password</h2>
  </div>
  <hr>


<div class="container py-2">
        <div class="row gutters">
                  <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                    <div class="card h-100">
                      <div class="card-body">
                      <form action="changepassword.php" method="POST">
                      <h5 class="mb-2 text-primary">Change Password</h6>
                        <div class="row gutters my-4">
                          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            
                          </div>
                          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                              <label for="fullName">Current Password</label>
                              <input type="password" class="form-control" id="currentpass" name="currentpass" maxlength="20" required>
                            </div>
                          </div>

                          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                          </div>

                          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                              <label for="fullName">New Password</label>
                              <input type="password" class="form-control" id="newpass" name="newpass" maxlength="20" required>
                            </div>
                          </div>
                          
                          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                              <label for="fullName">Confirm Password</label>
                              <input type="password" class="form-control" id="confirmpass" name="confirmpass" maxlength="20" required>
                            </div>
                          </div>
                          
                        </div>
                        
                        <div class="row gutters">
                          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="text-left">
                              <p class="text-danger"><?php echo $showError ?></p>
                            </div>
                          </div>
                          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="text-right">
                              <button type="submit" id="submit" class="btn btn-primary">Update Password</button>
                            </div>
                          </div>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  
        </div>
</div>

<?php include '_footer.php'; ?>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
<script>
    // Solves Resubmit form on Reload issue
    if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
<?php
if($notifySuccess){
          echo "<script type='text/javascript'>
            alert('Password successfully changed.');
            window.location.href = 'updateprofile.php';
          </script>";
}
?>  

  </body>
</html>
