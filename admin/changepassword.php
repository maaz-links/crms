<?php  
session_start();
include '_checksession.php';
$insert = false;
//$passwordmatch = true
$validpassword = true;
$form_url = "/crms/admin/changepassword.php";

// Connect to the Database 
include '_dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

  //Insert the record
    $insert_value1 = md5($_POST["insert_value1"]);
    $insert_value2 = md5($_POST["insert_value2"]);
    $insert_value3 = md5($_POST["insert_value3"]);

  if($insert_value2 == $insert_value3){
  // Sql query to be executed
  $sql = "SELECT * FROM `tbladmin` WHERE `admin_password` = '$insert_value1' ";
  $result = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($result);
  if ($num == 1){
    $sql = "UPDATE `tbladmin` SET `admin_password` = '$insert_value2' WHERE `tbladmin`.`admin_id` = 1";
    $result = mysqli_query($conn, $sql);
    if($result){ 
        $insert = true;
    }
    else{
        echo "The record was not updated successfully because of this error ---> ". mysqli_error($conn);
    } 
  }
  else
  {
    $validpassword = false;
  }
}else{
  $validpassword = false;
}

}
?>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/x-icon" href="img/OIG2.jpeg">
  <!-- HEADER -->
  <?php include '_bootcss.php'?>

  <title>Change Password</title>
</head>
<body>

  <!-- NAVBAR -->
  <?php include '_nav.php' ?>

  <?php
  if($insert){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> The password has been changed successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
  <?php
  if(!$validpassword){
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    Either the current Password is incorrect or New Password and Confirm Password Fields do not match.
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>

  <div class="container my-4">
    <h2>Admin Change Password</h2>
    <form action="<?php echo $form_url ?>" method="POST" name="chngpwd" enctype="multipart/form-data" onSubmit="return valid();" >
    <div class="form-group">
        <label for="insert_value1">Current Password</label>
        <input type="text" class="form-control" id="insert_value1" name="insert_value1" required>
      </div>
      <div class="form-group">
        <label for="insert_value2">New Password</label>
        <input type="text" class="form-control" id="insert_value2" name="insert_value2" required>
      </div>
      <div class="form-group">
        <label for="insert_value3">Confirm New Password</label>
        <input type="text" class="form-control" id="insert_value3" name="insert_value3" required>
      </div>

      <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>

  </div>

  <?php include '_bootjs.php' ?>


  <script>
    if ( window.history.replaceState )
    {window.history.replaceState( null, null, window.location.href );}
  </script>
</body>
</html>