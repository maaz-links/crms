<?php  

session_start();
include '_checksession.php';

$insert = false;
$update = false;
$delete = false;
$constraint = false;
// Connect to the Database 
include '_dbconnect.php';

//Delete record
if(isset($_GET['delete'])){
  $delete_id = $_GET['delete'];
  
  //Check foreign key constraint
  $sql = "SELECT * FROM `tblcar` WHERE `category_id`='$delete_id'";
  $result = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($result);
  if ($num > 0){$constraint = true;}
  else 
  {
    $sql = "DELETE FROM `tblcategory` WHERE `category_id` = '$delete_id' ";
    $result = mysqli_query($conn, $sql);
    $delete = true;
  }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
if (isset( $_POST['idEdit'])){
  // Update the record
    $update_id = $_POST["idEdit"];
    $update_value1 = $_POST["value1Edit"];

  // Sql query to be executed
  $sql = "UPDATE `tblcategory` SET `category_name` = '$update_value1' WHERE `tblcategory`.`category_id` = $update_id";
  $result = mysqli_query($conn, $sql);
  if($result){
    $update = true;
}
else{
    echo "We could not update the record successfully";
}
}
else{
  //Insert the record
    $insert_value1 = $_POST["insert_value1"];

  // Sql query to be executed
  $sql = "INSERT INTO `tblcategory` (`category_name`) VALUES ('$insert_value1')";

  $result = mysqli_query($conn, $sql);   
  if($result){ 
      $insert = true;
  }
  else{
      echo "The record was not inserted successfully because of this error ---> ". mysqli_error($conn);
  } 
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

  <title>Manage Car Category</title>
</head>

<body>

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit this record</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="/crms/admin/carcategory.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="idEdit" id="idEdit">
            <div class="form-group">
              <label for="value1Edit">Category Name</label>
              <input type="text" class="form-control" id="value1Edit" name="value1Edit" aria-describedby="emailHelp" required>
            </div>
          </div>
          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- NAVBAR -->
  <?php include '_nav.php' ?>


  <?php
  if($insert){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> The record has been inserted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
  <?php
  if($delete){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> The record has been deleted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
  <?php
  if($update){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> The record has been updated successfully
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
    <h2>Add a New Car Category</h2>
    <form action="/crms/admin/carcategory.php" method="POST" enctype="multipart/form-data" >
      <div class="form-group">
        <label for="insert_value1">Enter Category Name</label>
        <input type="text" class="form-control" id="insert_value1" name="insert_value1" aria-describedby="emailHelp" required>
      </div>

      <button type="submit" class="btn btn-primary">Add Category</button>
    </form>

  </div>

  <div class="container my-4">
    <table class="table table-striped table-sm" id="myTable">
      <thead>
        <!-- HEADINGS  -->
        <tr>
          <th scope="col">Category ID</th>
          <th scope="col">Category Name</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          $sql = "SELECT * FROM `tblcategory`";
          $result = mysqli_query($conn, $sql);
          $sno = 0;
          while($row = mysqli_fetch_assoc($result)){
            $sno = $sno + 1;
            $data_id = $row['category_id'];
            echo "<tr>
            <th scope='row'>". $sno . "</th>
            <td>". $row['category_name'] . "</td>
            <td> <button class='edit btn btn-sm btn-secondary' id=".$data_id.">Edit</button>
            <button class='delete btn btn-sm btn-danger' id=d".$data_id.">Delete</button>  </td>
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
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        tr = e.target.parentNode.parentNode;
        value1 = tr.getElementsByTagName("td")[0].innerText;
        console.log(value1);
        value1Edit.value = value1;
        idEdit.value = e.target.id;
        console.log(e.target.id)
        $('#editModal').modal('toggle');
      })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("delete");
        idDelete = e.target.id.substr(1);

        if (confirm("Are you sure you want to delete this record?")) {
          console.log("yes");
          window.location = `/crms/admin/carcategory.php?delete=${idDelete}`;
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
