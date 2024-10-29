<?php  
session_start();
include '_checksession.php';

$insert = false;
$update = false;
$delete = false;
$constraint = false;
// Connect to the Database 
include '_dbconnect.php';

if(isset($_GET['delete'])){
  $delete_id = $_GET['delete'];
  
  //Check foreign key constraint
  $sql = "SELECT * FROM `tblrental` WHERE `car_id`='$delete_id'";
  $result = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($result);
  if ($num > 0){$constraint = true;}
  else 
  {
  $sql = "DELETE FROM `tblcar` WHERE `car_id` = $delete_id";
  $result = mysqli_query($conn, $sql);
  $delete = true;
  }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

  if (isset( $_POST['idstatus'])){
    // Update the record
      $sno = $_POST["idstatus"];
      $status_value = $_POST["editstatus"];
    // Sql query to be executed
    $sql = "UPDATE `tblcar` SET `status` = '$status_value' WHERE `tblcar`.`car_id` = '$sno' ";
    $result = mysqli_query($conn, $sql);
    if($result){
      $update = true;
  }
  else{
      echo "We could not update the record successfully";
  }

}else if (isset( $_POST['snoEdit'])){
  // Update the record
    $sno = $_POST["snoEdit"];
    $update_value1 = $_POST["value1Edit"];
    $update_value2 = $_POST["value2Edit"];
    $update_value3 = $_POST["value3Edit"];
    $update_value4 = $_POST["value4Edit"];
    $update_value5 = $_POST["value5Edit"];
    $update_value7 = $_POST["value7Edit"];
    $update_value8 = $_POST["value8Edit"];

  // Sql query to be executed
  $sql = "UPDATE `tblcar` 
  SET `model` = '$update_value1', `number` = '$update_value2', `category_id` = '$update_value3', `owner_id` = '$update_value4', `location_id` = '$update_value5', `details` = '$update_value7', `rental_price` = '$update_value8'
  WHERE `tblcar`.`car_id` = '$sno' ";
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
    $insert_value2 = $_POST["insert_value2"];
    $insert_value3 = $_POST["insert_value3"];
    $insert_value4 = $_POST["insert_value4"];
    $insert_value5 = $_POST["insert_value5"];
    $insert_value6 = $_POST["insert_value6"];
    $insert_value7 = $_POST["insert_value7"];

  // Sql query to be executed
  $sql = "INSERT INTO `tblcar` (`model`, `number`, `category_id`, `owner_id`, `location_id`, `details`, `rental_price`, `image`, `status`)
  VALUES ('$insert_value1', '$insert_value2', '$insert_value3', '$insert_value4', '$insert_value5', '$insert_value6', '$insert_value7', 'uploadimage.jpg', '1')";
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

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/x-icon" href="img/OIG2.jpeg">
  <!-- HEADER -->
  <?php include '_bootcss.php'?>
  <style>
  .desc {
    display: none;;
  }
  .newlinks{
    float:right;}
  </style>

  <title>Information about Cars for Rent</title>

</head>

<body>

  <!-- Detail Modal -->
  <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="detailModalLabel">Extra Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <!-- <form action="/crud/index.php" method="POST"> -->
          <div class="modal-body">
            <div class="form-group">
              <!-- <label for="desc">Note Description</label> -->
              <textarea class="form-control" id="descriptionView" name="descriptionView" rows="8" readonly></textarea>
            </div>
          </div>
          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        <!-- </form> -->
      </div>
    </div>
  </div>

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit this Record</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="/crms/admin/carslisting.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="form-group">
              <label for="value1Edit">Car Model</label>
              <input type="text" class="form-control" id="value1Edit" name="value1Edit">
            </div>
            <div class="form-group">
              <label for="value2Edit">Car Number</label>
              <input type="text" class="form-control" id="value2Edit" name="value2Edit">
            </div>
            <div class="form-group">
        <label for="value3Edit">Car Category</label><a class="newlinks" href="carcategory.php">Add New Category</a>
        <select class="form-control" aria-label="Default select example" id="value3Edit" name="value3Edit" >
        <?php 
            $sql = "SELECT * FROM `tblcategory`";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
              echo "<option value='".$row['category_id']."'>".$row['category_name']."</option>";
            } 
        ?>
        </select>
      </div>
      <div class="form-group">
        <label for="value4Edit">Car Owner</label><a class="newlinks" href="carowner.php">Add New Owner</a>
        <select class="form-control" aria-label="Default select example" id="value4Edit" name="value4Edit" >
        <?php 
            $sql = "SELECT * FROM `tblowner`";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
              echo "<option value='".$row['owner_id']."'>".$row['owner_name']."</option>";
            } 
        ?>
        </select>
      </div>
      <div class="form-group">
        <label for="value5Edit">Rental Location</label><a class="newlinks" href="carlocation.php">Add New Location</a>
        <select class="form-control" aria-label="Default select example" id="value5Edit" name="value5Edit" >
        <?php 
            $sql = "SELECT * FROM `tbllocation`";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
              echo "<option value='".$row['location_id']."'>".$row['location_address']."</option>";
            } 
        ?>
        </select>
      </div>
      <div class="form-group">
        <label for="value7Edit">Extra Details</label>
        <textarea class="form-control" id="value7Edit" name="value7Edit" rows="3"></textarea>
      </div>
      <div class="form-group">
        <label for="value8Edit">Rental Price per day</label>
        <input type="number" class="form-control" id="value8Edit" name="value8Edit" min="0" step="500">
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

  <!-- Change status Modal -->
  <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="statusModalLabel">Change Rental Status of Vehicle</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="/crms/admin/carslisting.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="idstatus" id="idstatus">
            <div class="form-group">
              <input type="radio" name="editstatus" value="1" checked>
              <label>Available</label><br>
              <input type="radio" name="editstatus" value="2">
              <label>Needs Maintenance</label><br>
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
    <h2>Add Information about Car for Rent</h2>
    <form action="/crms/admin/carslisting.php" method="POST" enctype="multipart/form-data" >
    <div class="row">
      <div class="form-group col-6">
        <label for="insert_value1">Car Model</label>
        <input type="text" class="form-control" id="insert_value1" name="insert_value1" aria-describedby="emailHelp">
      </div>
      <div class="form-group col-6">
        <label for="insert_value2">Car Number</label>
        <input type="text" class="form-control" id="insert_value2" name="insert_value2">
      </div>
    </div>
    <div class="row">
      <div class="form-group col-6">
        <label for="insert_value3">Car Category</label><a class="newlinks" href="carcategory.php">Add New Category</a>
        <select class="form-control" aria-label="Default select example" name="insert_value3" >
        <?php 
            $sql = "SELECT * FROM `tblcategory`";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
              echo "<option value='".$row['category_id']."'>".$row['category_name']."</option>";
            } 
        ?>
        </select>
      </div>
      <div class="form-group col-6">
        <label for="insert_value4">Car Owner</label><a class="newlinks" href="carowner.php">Add New Owner</a>
        <select class="form-control" aria-label="Default select example" name="insert_value4" >
        <?php 
            $sql = "SELECT * FROM `tblowner`";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
              echo "<option value='".$row['owner_id']."'>".$row['owner_name']."</option>";
            } 
        ?>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="form-group col-6">
        <label for="insert_value5">Rental Location</label> <a class="newlinks" href="carlocation.php">Add New Location</a>
        <select class="form-control" aria-label="Default select example" name="insert_value5" >
        <?php 
            $sql = "SELECT * FROM `tbllocation`";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
              echo "<option value='".$row['location_id']."'>".$row['location_address']."</option>";
            } 
        ?>
        </select>
      </div>
      <div class="form-group col-6">
        <label for="insert_value7">Rental Price per day</label>
        <input type="number" class="form-control" id="insert_value7" name="insert_value7" min="0" step="500">
      </div>
      </div>
      <div class="form-group">
        <label for="insert_value6">Extra Details</label>
        <textarea class="form-control" id="insert_value6" name="insert_value6" rows="3"></textarea>
      </div>
      
      <button type="submit" class="btn btn-primary">Submit Information</button>
    </form>
  </div>

  
  <div class="container my-4">
  <h2 id='listing'>Cars Listing</h2>
    <table class="table table-striped table-sm" id="myTable">
      <thead>
        <tr>
          <th scope="col">Car ID</th>
          <th scope="col">Model</th>
          <th scope="col">Number</th>
          <th scope="col">Category</th>
          <th scope="col">Owner Name</th>
          <th scope="col">Location Address</th>
          <th scope="col">Extra Details</th>
          <th class="desc "scope="col">Extra Details</th>
          <th scope="col">Rental Price/day</th>
          <th scope="col">Image</th>
          <th scope="col">Status</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
         // $sql = "SELECT * FROM `notes`";
          function status_name($x, $idd){
            if($x == 1)
            return "<p>Available</p><button class='statchange btn btn-sm btn-light' id=".$idd.">Change</button>";
            else if($x == 2)
            return "<p class='text-danger'>Needs Maintenance</p><button class='statchange btn btn-sm btn-light' id=".$idd.">Change</button>";
            else if($x == 3)
            return "<p class='text-info'>Reserved</p>";
            else if($x == 4)
            return "<p class='text-info'>Rented</p>";
            else
            return "<p>Available</p><button class='statchange btn btn-sm btn-light' id=".$idd.">Change</button>";
          }

          $sql = "SELECT * FROM `tblcar`
          LEFT JOIN `tblcategory` ON `tblcar`.`category_id` = `tblcategory`.`category_id`
          LEFT JOIN `tblowner` ON `tblcar`.`owner_id` = `tblowner`.`owner_id`
          LEFT JOIN `tbllocation` ON `tblcar`.`location_id` = `tbllocation`.`location_id` ";
          $result = mysqli_query($conn, $sql);
          $sno = 0;
          while($row = mysqli_fetch_assoc($result)){
            $sno = $sno + 1;
            $data_id = $row['car_id'];
            echo "<tr>
            <th scope='row'>". $sno . "</th>
            <td>". $row['model'] . "</td>
            <td>". $row['number'] . "</td>

            <td id=".$row['category_id'].">". $row['category_name'] . "</td>
            <td id=".$row['owner_id'].">". $row['owner_name'] . "</td>
            <td id=".$row['location_id'].">". $row['location_address'] . "</td>

            <td> <button class='detailview btn btn-sm btn-link' id=".$data_id.">Check Details</button> </td>
            <td class='desc'>". $row['details'] . "</td>

            <td>". $row['rental_price'] . "</td>
            <td> <a href='changeimage.php?change=".$data_id."'><img src='img/". $row['image'] ."'width='200'></a> </td>
            <td>". status_name($row['status'],$data_id) ."</td> 

            <td> <button class='edit btn btn-sm btn-secondary' id=".$data_id.">Edit</button><hr>
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
        value2 = tr.getElementsByTagName("td")[1].innerText;
        value3 = tr.getElementsByTagName("td")[2].id;
        value4 = tr.getElementsByTagName("td")[3].id;
        value5 = tr.getElementsByTagName("td")[4].id;
        value7 = tr.getElementsByTagName("td")[6].innerText;
        value8 = tr.getElementsByTagName("td")[7].innerText;

        console.log(value1);
        value1Edit.value = value1;
        value2Edit.value = value2;
        value3Edit.value = value3;
        value4Edit.value = value4;
        value5Edit.value = value5;
        value7Edit.value = value7;
        value8Edit.value = value8;
        snoEdit.value = e.target.id;
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
          window.location = `/crms/admin/carslisting.php?delete=${idDelete}`;
        }
        else {
          console.log("no");
        }
      })
    })
  </script>

 <script>
    detailview = document.getElementsByClassName('detailview');
    Array.from(detailview).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("detailview ");
        tr = e.target.parentNode.parentNode;
        value7 = tr.getElementsByTagName("td")[6].textContent;
        descriptionView.value = value7;
        console.log(value7);
        console.log(e.target.id);
        $('#detailModal').modal('toggle');
      })
    })
</script>

<script>
    statchange = document.getElementsByClassName('statchange');
    Array.from(statchange).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("statchange ");
        idstatus.value = e.target.id;
        $('#statusModal').modal('toggle');
      })
    })
</script>

  <script>
    // Solves Resubmit form on Reload issue
    if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
    </script>
</body>

</html>
