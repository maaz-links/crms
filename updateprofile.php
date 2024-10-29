<?php

session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
  header("location: /crms/login.php");
  exit;
}

include '_dbconnect.php';

$notifySuccess = false;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["username"];
    //$email = $_POST["emailaddress"];
    $contactno = $_POST["phone"];
    $userID = $_SESSION["userid"];

        $sql = "UPDATE `tblusers` SET `username` = '$username', `user_contact` = '$contactno'
        WHERE `tblusers`.`user_id` = '$userID'";
        $result = mysqli_query($conn, $sql);
        if($result)
        {
          $notifySuccess = true;
        }
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Profile</title>
    <link rel="icon" type="image/x-icon" href="img/OIG2.jpeg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="assets/update.css">
    <style>
      .desc {
      display:none;
      }
      /* .dates {
      font-size: 0.8em;
    } */
  </style>
  </head>
  <body class="text-center">

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
        <!-- <form action="/crud/index.php" method="POST"> -->
          <div class="modal-body">
            <div class="form-group">
              <label for="desc">Payment Details</label>
              <textarea class="form-control" id="descriptionView" name="descriptionView" rows="5" readonly></textarea>
            </div>
          </div>
          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        <!-- </form> -->
      </div>
    </div>
  </div>


  <?php include '_nav.php' ?>
  <div style="text-align: left !important;" class="container my-4">
    <h2>My Profile</h2>
  </div>
  <hr>

  <?php 

$currentuser = $_SESSION["userid"];
$sql = "SELECT * FROM `tblusers`
where `user_id` = '$currentuser'";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($result)){

?>

<div class="container py-2">
        <div class="row gutters">
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
              <div class="card h-100">
                <div class="card-body">
                  <div class="account-settings">
                  <h5 class="text-primary">Current Information</h5>
                    <div class="user-profile my-4">
                      
                      <h5 class="user-name"><?php echo $row['username'];?></h5>
                      <h6 class="user-email"><?php echo $row['user_email'];?></h6>
                    </div>
                    <div class="about">
                  
                      <h6 class="user-name">Contact Number:</h6>
                      <h6 class="user-email"><?php echo $row['user_contact'];?></h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>

                  <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                    <div class="card h-100">
                      <div class="card-body">
                      <form action="updateprofile.php" method="POST">
                      <h5 class="mb-2 text-primary">Change Profile Information</h6>
                        <div class="row gutters my-4">
                          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            
                          </div>
                          
                          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                              <label for="fullName">Username</label>
                              <input type="text" class="form-control" id="username" name="username" value="<?php echo $row['username'];?>" required>
                            </div>
                          </div>
                          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                              <label for="eMail">Email Address</label>
                              <input type="email" class="form-control" id="email" value="<?php echo $row['user_email'];?>" readonly>
                            </div>
                          </div>
                          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                              <label for="phone">Contact Number</label>
                              <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $row['user_contact'];?>" maxlength="11" pattern="[0-9]*" title="Please enter numeric characters only" required>
                            </div>
                          </div>
                          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                              <label for="website">Password</label>
                              <a href="changepassword.php"><input type="text" class="form-control text-primary" id="pass" value="Click to change Password" readonly></a>
                            </div>
                          </div>
                        </div>
                        
                        <div class="row gutters">
                          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="text-right">
                              <button type="submit" id="submit" class="btn btn-primary">Update Info</button>
                            </div>
                          </div>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  
        </div>
</div>
<?php } ?>

<hr>
<div style="text-align: left !important;" class="container my-4">
    <h2>My Rentals and Reservations</h2>
  </div>
  <hr>

  <div class="container my-4">
    <table class="table table-striped table-sm" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No</th>
          <th scope="col">Car</th>
          <th scope="col">Number</th>
          <th scope="col">Rental Price</th>
          <th scope="col">Reservation Date</th>
          <th scope="col">Rental Date</th>
          <th scope="col">Return Date</th>
          <th scope="col">Payment Details</th>
          <th class="desc "scope="col">Details</th>
          <th scope="col">Status</th>
        </tr>
      </thead>
      <tbody>
        <?php 
         function status_name($x, $idd){
            if($x == 1)
            return "Reserved";
            else if($x == 2)
            return "Rented";
            else if($x == 3)
            return "<p class='text-success'>Returned</p>";
          }
          $currentuser = $_SESSION['userid'];
          $sql = "SELECT * FROM `tblrental`
          LEFT JOIN `tblusers` ON `tblrental`.`user_id` = `tblusers`.`user_id`
          LEFT JOIN `tblcar` ON `tblrental`.`car_id` = `tblcar`.`car_id`
          WHERE `tblrental`.`user_id` = '$currentuser' ";
          $result = mysqli_query($conn, $sql);
          $sno = 0;
          while($row = mysqli_fetch_assoc($result)){
            $sno = $sno + 1;
            $data_id = $row['rental_id'];
            echo "<tr>
            <th scope='row'>". $sno . "</th>
            

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
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

    <script>
    $(document).ready(function () {
      $('#myTable').DataTable();

    });

  </script>
  <script>
    detailview = document.getElementsByClassName('detailview');
    Array.from(detailview).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("detailview ");
        tr = e.target.parentNode.parentNode;
        value9 = tr.getElementsByTagName("td")[7].textContent;
        descriptionView.value = value9;
        console.log(value9);
        console.log(e.target.id);
        $('#detailModal').modal('toggle');
      })
    })
</script>
<script>
    // Solves Resubmit form on Reload issue
    if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
<?php
if($notifySuccess){
          echo "<script type='text/javascript'>
            alert('Profile information successfully created.');
          </script>";
}
?>  

  </body>
</html>
