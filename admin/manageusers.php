<?php  
session_start();
include '_checksession.php';
$insert = false;
$update = false;
$delete = false;
$constraint = false;
$form_url = "/crms/admin/manageusers.php";

// Connect to the Database 
include '_dbconnect.php';

//Delete record
if(isset($_GET['delete'])){
  $delete_id = $_GET['delete'];
  
  //Check foreign key constraint
  $sql = "SELECT * FROM `tblrental` WHERE `user_id`='$delete_id'";
  $result = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($result);
  if ($num > 0){$constraint = true;}
  else 
  {
    $sql = "DELETE FROM `tblusers` WHERE `user_id` = '$delete_id' ";
    $result = mysqli_query($conn, $sql);
    $delete = true;
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

  <title>Manage Users</title>
</head>

<body>

  <!-- NAVBAR -->
  <?php include '_nav.php' ?>

  <?php
  if($delete){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> The user profile has been deleted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
  <?php
  if($constraint){
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    This record has references in another table that prevents it from deleting.
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>

  <div class="container my-4">
    <h2>Manage Users</h2>
  </div>

  <div class="container my-4">
    <table class="table table-striped table-sm" id="myTable">
      <thead>
        <!-- HEADINGS  -->
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Username</th>
          <th scope="col">Email</th>
          <th scope="col">Phone Number</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          $sql = "SELECT * FROM `tblusers`";
          $result = mysqli_query($conn, $sql);
          $sno = 0;
          while($row = mysqli_fetch_assoc($result)){
            $sno = $sno + 1;
            $data_id = $row['user_id'];
            echo "<tr>
            <th scope='row'>". $sno . "</th>
            <td>". $row['username'] . "</td>
            <td>". $row['user_email'] . "</td>
            <td>". $row['user_contact'] . "</td>
            <td><button class='delete btn btn-sm btn-danger' id=d".$data_id.">Delete</button>  </td>
          </tr>";
          } 
        ?>

      </tbody>
    </table>
  </div>
  <hr>

  <?php include '_bootjs.php' ?>
  
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();
    });
  </script>
  <script>

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("delete");
        idDelete = e.target.id.substr(1);
        console.log(idDelete);
        if (confirm("Are you sure you want to delete this record?")) {
          console.log("yes");
          window.location = `/crms/admin/manageusers.php?delete=${idDelete}`;
        }
        else {
          console.log("no");
        }
      })
    })
  </script>
  <script>
    if ( window.history.replaceState )
    {window.history.replaceState( null, null, window.location.href );}
  </script>
</body>
</html>
