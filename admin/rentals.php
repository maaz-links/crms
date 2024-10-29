<?php  
session_start();
include '_checksession.php';

$delete = false;

// Connect to the Database 
include '_dbconnect.php';

$sqlrent = "SELECT * FROM `tblrental`
          LEFT JOIN `tblusers` ON `tblrental`.`user_id` = `tblusers`.`user_id`
          LEFT JOIN `tblcar` ON `tblrental`.`car_id` = `tblcar`.`car_id`";

$sqlrevenue = "SELECT SUM(`total_rental_price`) AS `count` FROM `tblrental`";
$sqlcountreserve = "SELECT COUNT(*) AS `count` FROM `tblrental`";
$sqlcountrented = "SELECT COUNT(*) AS `count` FROM `tblrental` where `rental_status`=2";
$sqlcountreturn = "SELECT COUNT(*) AS `count` FROM `tblrental` where `rental_status`=3";
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

  if (isset( $_POST['idstatus'])){

      $sno = $_POST["idstatus"];
      $status_value = $_POST["editstatus"];
    $sql = "UPDATE `tblrental` SET `rental_status` = '$status_value' WHERE `tblrental`.`rental_id` = '$sno' ";
    $result = mysqli_query($conn, $sql);
 
    $rented_car_id = $_POST["rentcarid"];
    $rented_car_status = $status_value+2;

    if($rented_car_status > 4)
    {
      $rented_car_status = 1;
    }
    $sql = "UPDATE `tblcar` SET `status` = '$rented_car_status' WHERE `tblcar`.`car_id` = '$rented_car_id' ";
      $result = mysqli_query($conn, $sql);
      if($result){
        $update = true;
    }
    else{ echo "We could not update the record successfully";}

}
if (isset( $_POST['dateInput1'])){
//echo "ok";

$date1 = $_POST['dateInput1'];
$date2 = $_POST['dateInput2'];
$sqlrent = "SELECT 
    rental_id, 
    user_contact,
    tblrental.car_id,
    model, 
    number, 
    total_rental_price, 
    reservation_date, 
    rental_date, 
    return_date, 
    payment_details, 
    rental_status
FROM 
    tblrental
LEFT JOIN 
    tblusers ON tblrental.user_id = tblusers.user_id
LEFT JOIN 
    tblcar ON tblrental.car_id = tblcar.car_id
WHERE 
    reservation_date BETWEEN '".$date1."' AND '".$date2."';";

$sqlrevenue = "SELECT SUM(`total_rental_price`) AS `count` FROM `tblrental` where `reservation_date` BETWEEN '".$date1."' AND '".$date2."' ";
$sqlcountreserve = "SELECT COUNT(*) AS `count` FROM `tblrental` where `reservation_date` BETWEEN '".$date1."' AND '".$date2."' ";
$sqlcountrented = "SELECT COUNT(*) AS `count` FROM `tblrental` where `rental_status`=2 and `reservation_date` BETWEEN '".$date1."' AND '".$date2."' ";
$sqlcountreturn = "SELECT COUNT(*) AS `count` FROM `tblrental` where `rental_status`=3 and `reservation_date` BETWEEN '".$date1."' AND '".$date2."' ";
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
  display:none;
  }
  .dates {
  font-size: 0.8em;
}
  </style>

  <title>Manage Rentals</title>

  <style>
    /* body * { display: none; } */
.print-content { display: block; }

/* Style the content you want to print */
.print-content {
    /* Your styles here */
}
  </style>
</head>

<body>

  <!-- Detail Modal -->
  <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="detailModalLabel">Payment Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="desc">Payment Details</label>
              <textarea class="form-control" id="descriptionView" name="descriptionView" rows="5" readonly></textarea>
            </div>
          </div>
          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
      </div>
    </div>
  </div>


  <!-- Change status Modal -->
  <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="statusModalLabel">Change Rental Status</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="/crms/admin/rentals.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="idstatus" id="idstatus">
            <input type="hidden" name="editstatus" id="editstatus">
            <input type="hidden" name="rentcarid" id="rentcarid">
            <div class="form-group">

              <input type="text" class="form-control" id="statusDescription" readonly>
              
            </div>
          </div>

          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Change Status</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <?php include '_nav.php' ?>

  <div class="print-content">
    <!-- Your content here -->

<div class="container my-4">
    <h2>Manage Rentals and Reservations</h2>
  </div>

  <div class="container my-4">
    <table class="table table-striped table-sm" id="myTable">
      <thead>
        <tr>
          <th scope="col">Rental ID</th>
          <th scope="col">User Contact</th>
          <th scope="col">Car</th>
          <th scope="col">Number</th>
          <th scope="col">Rental Price</th>
          <th scope="col">Reservation Date</th>
          <th scope="col">Rental Date</th>
          <th scope="col">Return Date</th>
          <th scope="col">Payment Details</th>
          <th class="desc "scope="col">Details</th>
          <th scope="col">Status</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          function status_name($x, $idd){
            if($x == 1)
            return "Reserved</td> 
            <td><button class='statchange btn btn-sm btn-secondary' id=".$idd.">Change Status</button>  ";
            else if($x == 2)
            return "Rented</td> 
            <td><button class='statchange btn btn-sm btn-secondary' id=".$idd.">Change Status</button>  ";
            else if($x == 3)
            return "<p class='text-success'>Returned</p></td> 
            <td>";
          }

          // $sql = "SELECT * FROM `tblrental`
          // LEFT JOIN `tblusers` ON `tblrental`.`user_id` = `tblusers`.`user_id`
          // LEFT JOIN `tblcar` ON `tblrental`.`car_id` = `tblcar`.`car_id`";
          $result = mysqli_query($conn, $sqlrent);
          $sno = 0;
          while($row = mysqli_fetch_assoc($result)){
            $sno = $sno + 1;
            $data_id = $row['rental_id'];
            echo "<tr>
            <th scope='row'>". $data_id . "</th>
            <td>". $row['user_contact'] . "</td>

            <td id='".$row['car_id']."'>". $row['model'] . "</td>
            <td>". $row['number'] . "</td>
            <td>". $row['total_rental_price'] . "</td>

            <td class='dates'>". $row['reservation_date'] . "</td>
            <td class='dates'>". $row['rental_date'] . "</td>
            <td class='dates'>". $row['return_date'] . "</td>

            <td> <button class='detailview btn btn-sm btn-link' id=".$data_id.">Check Details</button> </td>
            <td class='desc'>". $row['payment_details'] . "</td>

            <td id='".$row['rental_status']."'>". status_name($row['rental_status'],$data_id) . "</td>
          </tr>";
        }
          ?>


      </tbody>
    </table>
  </div>
  <hr>
  <div class="container my-4">
<?php
$result = mysqli_query($conn, $sqlrevenue);
while($row = mysqli_fetch_assoc($result)){
  $myrevenue = number_format($row["count"]);
}
?>
  <div class="">
  <h4>Net Revenue Earned: <?php echo $myrevenue ?> PKR </h4>
  </div>

  <!-- <div class="">
  <h4>Admin Commission: </h4>
  </div> -->
  <?php
$result = mysqli_query($conn, $sqlrevenue);
while($row = mysqli_fetch_assoc($result)){
  $myrevenue = number_format(0.1*$row["count"]);
}
?>
  <div class="">
  <h4>10% Admin Commission: <?php echo $myrevenue ?> PKR </h4>
  </div>

  <?php
$result = mysqli_query($conn, $sqlrevenue);
while($row = mysqli_fetch_assoc($result)){
  $myrevenue = number_format(0.9*$row["count"]);
}
?>
  <div class="">
  <h4>Total Revenue Earned: <?php echo $myrevenue ?> PKR </h4>
  </div>
  
  <?php
$result = mysqli_query($conn, $sqlcountreserve);
while($row = mysqli_fetch_assoc($result)){
  $myrevenue = number_format($row["count"]);
}
?>
  <div class="">
  <h4>Total Cars Reserved: <?php echo $myrevenue ?> </h4>
  </div>

  <?php
$result = mysqli_query($conn, $sqlcountrented);
while($row = mysqli_fetch_assoc($result)){
  $myrevenue = number_format($row["count"]);
}
?>
  <div class="">
  <h4>Total Cars In Rent: <?php echo $myrevenue ?> </h4>
  </div>

  <?php
$result = mysqli_query($conn, $sqlcountreturn);
while($row = mysqli_fetch_assoc($result)){
  $myrevenue = number_format($row["count"]);
}
?>
  <div class="">
  <h4>Total Cars Returned: <?php echo $myrevenue ?> </h4>
  </div>





  </div> 



  <hr>
</div>
  <div class="container my-4">
    <h4>Filter Data</h4>
    <form action="rentals.php" method="POST" enctype="multipart/form-data" >
      <div class="form-group">
        <label>Enter Starting Date</label>
        <input type="date" name="dateInput1">
      </div>
      <div class="form-group">
        <label>Enter Ending Date</label>
        <input type="date" name="dateInput2">
      </div>
      <button type="submit" class="btn btn-primary my-3">Filter</button><button onclick="printData()" class="btn btn-primary mx-3">Print</button>
    </form>
    
  </div>

  <?php include '_bootjs.php' ?>
  <script>
    // $(document).ready(function () {
    //   $('#myTable').DataTable();

    // });
    new DataTable('#myTable', {
    order: [[0, 'desc']]
});
  </script>

 <script>
function printData() {
  var printContents = document.getElementsByClassName('print-content')[0].innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}


    detailview = document.getElementsByClassName('detailview');
    Array.from(detailview).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("detailview ");
        tr = e.target.parentNode.parentNode;
        value9 = tr.getElementsByTagName("td")[8].textContent;
        descriptionView.value = value9;
        console.log(value9);
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
        tr = e.target.parentNode.parentNode;
        carID = tr.getElementsByTagName("td")[1].id;
        rentalstatus = tr.getElementsByTagName("td")[9].id;
        idstatus.value = e.target.id;
        editstatus.value = parseInt(rentalstatus) + 1;
        rentcarid.value = carID;
        if(editstatus.value == 2) {statusDescription.value = "Reserved to Rented";}else{statusDescription.value = "Rented to Returned";}
        // if(editstatus.value == 2){

        // }

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
