<?php  
session_start();

// Connect to the Database 
include '_dbconnect.php';


// if(!isset($_GET['selected'])){
//   header("location: /crms/carslist.php");
//   exit;
// }

$selected_id = $_GET['selected'];

$sql = "SELECT * FROM `tblcar`
where `car_id` = '$selected_id' AND `status` = 1";
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);
// if($num < 1){
//   header("location: /crms/carslist.php");
//   exit;
// }
$row = mysqli_fetch_assoc($result);
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/x-icon" href="img/OIG2.jpeg">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <!-- <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
  </style>

  <title><?php echo $row['model'] ?></title>

</head>

<body class="bg-light">
  
  <?php include '_nav.php' ?>


<div class="container my-4">
    <h2>Selected Car: <?php // echo $row['model'] ?></h2>
  </div>
  <hr>
  <div class="container my-4">

    <div class="row">

		<?php 

          $sql = "SELECT * FROM `tblcar`
          LEFT JOIN `tblcategory` ON `tblcar`.`category_id` = `tblcategory`.`category_id`
          LEFT JOIN `tbllocation` ON `tblcar`.`location_id` = `tbllocation`.`location_id` 
		  where `car_id` = $selected_id";
          $result = mysqli_query($conn, $sql);

          while($row = mysqli_fetch_assoc($result)){

		?>
      <div class="col-sm-3" ></div>

      <div class="col-sm-3" >
      <div class="card shadow-sm" style="width: 30rem;">
        <img src="<?php echo "/crms/admin/img/".$row['image'];?>" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title"><?php echo $row['model'];?> (<?php echo $row['number'];?>)</h5>
          <p class="card-text"><?php echo nl2br($row['details']);?></p>
          <h6>Rental Price per day: Rs. <?php echo number_format($row['rental_price']);?></h6>
					<h6>Rental Location: <?php echo $row['location_address'];?></h6>
          <hr>
          <?php
          $sqlll = "SELECT * FROM `tblrental` where `car_id` = $selected_id ORDER BY rental_id DESC";
          $resulttt = mysqli_query($conn, $sqlll);

          $rowww = mysqli_fetch_assoc($resulttt);
          
          $currentdate = $rowww['rental_date'];//date('Y-m-d');
          $date = new DateTime($currentdate);

// Add one day to the date
$date->modify('+1 day');

// Output the new date
$newdate=$date->format('Y-m-d');

if ($newdate < date('Y-m-d')) {
  // Set the date to the current date
  $newdate = date('Y-m-d');
}

          //echo $currentdate;
          $limiteddate = date('Y-m-d', mktime(0, 0, 0, date("m")  , date("d")+10, date("Y")) );
          ?>
        <form action="checkout.php" method="POST" id="myCCForm">
        <input type="hidden" id="CarID" name="CarID" value="<?php echo $row['car_id'];?>">
          <input type="hidden" id="Price" name="Price" value="<?php echo $row['rental_price'];?>">
          <input type="hidden" id="Location" name="Location" value="<?php echo $row['location_address'];?>">
          <div class="form-group">
            <label for="dateInput">Select Rental Date</label>
            <input type="date" id="dateInput" name="dateInput" value="<?php echo $newdate ?>" min="<?php echo $newdate ?>" max="<?php echo $limiteddate ?>">
          </div>

          <div class="form-group">
            <div class="row">
            <div class="col-sm-6" >
            <label for="NoOfDays">No Of Days for Rent</label>
            <input type="number" class="form-control" id="NoOfDays" name="NoOfDays" value="1" min="1" max="5">
            </div>
            <div class="col-sm-6" >
            </div>
            </div>
          </div>
          <?php
            if(isset($_SESSION['loggedin']))
            {
              echo '<button type="submit" class="CHECKOUT btn btn-primary">Reserve Now</a>';
            }
            else{
              echo '<p><a href="login.php">Sign in</a> or <a href="signup.php">Register</a> your account to proceed to checkout.</p>';
            }
          ?>
          

          </form>
        </div>
      </div>
      </div>
      <div class="col-sm-3" ></div>      <div class="col-sm-3" ></div>
		<?php } ?>

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
  <!-- <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script> -->

  <script>
    checkout = document.getElementsByClassName('CHECKOUT');
    Array.from(checkout).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("checkout ");
        value1Edit.value = dateInput.value;
        value2Edit.value = NoOfDays.value;
        value3Edit.value = NoOfDays.value*Price.value;
        //paynow.value = NoOfDays.value*Price.value;
        $('#editModal').modal('toggle');
      })
    })
  </script>


</body>

</html>
