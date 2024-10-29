<?php  

session_start();
include '_checksession.php';
if(!isset($_GET['change'])){
  header("location: /crms/admin/carslisting.php");
}

// Connect to the Database 
include '_dbconnect.php';

$insert = false;
$imgupload = true;


$change_id =$_GET['change'];
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  $new_img_name = "";
  //echo "set";
  if (isset($_FILES['image'])) {
   // echo "go";
    $img_name = $_FILES['image']['name'];
    $img_size = $_FILES['image']['size'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $error = $_FILES['image']['error'];
    
    if ($error === 0) {
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);
  
        $allowed_exs = array("jpg", "jpeg", "png"); 
        if (in_array($img_ex_lc, $allowed_exs)) {
          $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
          $img_upload_path = "img/".$new_img_name;
          move_uploaded_file($tmp_name, $img_upload_path);

          $sql = "UPDATE `tblcar` SET `image` = '$new_img_name' WHERE `tblcar`.`car_id` = '$change_id'";
          $result = mysqli_query($conn, $sql);
           
          if($result){ 
              $insert = true;
          }
          else{
              echo "The record was not inserted successfully because of this error ---> ". mysqli_error($conn);
          } 


        }else {
          $em = "You can't upload files of this type";
          $imgupload = false;
        }
      }else{$imgupload = false;}
    }else {
      $em = "unknown error occurred!";
      $imgupload = false;
    }
  
// Sql query to be executed

}

$sql = "SELECT `image`,`model` FROM `tblcar` WHERE `car_id`= '$change_id'";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($result)){
$imgname = $row['image'];
$carname = $row['model'];
}
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/x-icon" href="img/OIG2.jpeg">
  <!-- HEADER -->
  <?php include '_bootcss.php'?>

  <title>Change Image</title>
</head>

<body>
<?php include '_nav.php' ?>

  <?php
  if(!$imgupload){
    echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
    <strong>Warning!</strong>"." The image was not uploaded ".
    "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  elseif($insert){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> The image was uploaded successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>

    <div class="container my-4">
    <a class="btn btn-primary" href="/crms/admin/carslisting.php" ><- Back to Cars Listing</a>
    <h2>Add/Change Image <?php echo "of ".$carname;  ?></h2>
   <form action="/crms/admin/changeimage.php?change=<?php echo $change_id ?>" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="desc">Current Image</label><br>
        <label for="image">
        <?php echo "<img src='img/". $imgname."' height='300'> <input type='hidden' name='change' id='change' value='".$change_id."'>"; ?>
        </label>
      </div>
      <div class="form-group">
       <label for="image" class="form-label">Upload Image here</label>
      <input class="form-control" type="file" id="image" name="image" accept="image/*" >
      </div>

      
      <button type="submit" class="btn btn-primary">Submit Image</button> 
    </form>
  </div>
  <?php include '_bootjs.php' ?>
  <script>
    if ( window.history.replaceState )
    {window.history.replaceState( null, null, window.location.href );}
  </script>
</body>
</html>
