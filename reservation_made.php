<?php  
session_start();

if ($_SERVER['REQUEST_METHOD'] != 'POST'){
  header('location:index.php');
}

include '_dbconnect.php';

include_once 'config.php'; 

// $user_id = $_SESSION['userid'];

	//NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
    //Get transaction information from URL 
    $Transaction_id 	= $_POST['pp_TxnRefNo'];
	$Amount 			= $_POST['pp_Amount']; 
    $AuthCode 			= $_POST['pp_AuthCode']; 
	$ResponseCode 		= $_POST['pp_ResponseCode'];
	$ResponseMessage 	= $_POST['pp_ResponseMessage'];
    $MerchantID 		= $_POST['pp_MerchantID'];
	$SecureHash 		= $_POST['pp_SecureHash'];
	$RetreivalReferenceNo = $_POST['pp_RetreivalReferenceNo'];
  $TxnType = $_POST['pp_TxnType'];

	//add period(.) before the last two digits of $Amount
	$Amount = substr($Amount, 0, -2) . '.00';
	//NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
	if(!isset($_SESSION['userid'])){
  $ResponseCode = 66;
  }
	//NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
	//Insert tansaction data into the database
	if($ResponseCode == '000' || $ResponseCode == '199')
		{$payment_status = 1;
      $user_id = $_SESSION['userid'];
      $car_id = $_SESSION['car_id'];
      $model = $_SESSION["model"];
      $reservation_date = date("Y-m-d");
      $rental_date = $_SESSION["rental_date"];
      $return_date = $_SESSION["return_date"];
      $Location = $_SESSION['location_addr'];
 
      $payment_details = 
      "Transaction ID:".$Transaction_id."\n".
      "Reference No:".$RetreivalReferenceNo."\n".
      "Payment Method:".$TxnType."\n";

	$sql = "INSERT INTO `tblrental` (`user_id`, `car_id`, `total_rental_price`, `reservation_date`, `rental_date`, `return_date`, `payment_details`, `rental_status`)
  VALUES ('$user_id', '$car_id', '$Amount', '$reservation_date', '$rental_date', '$return_date', '$payment_details', '1')";

  $result = mysqli_query($conn, $sql);   

    $sql = "UPDATE `tblcar` SET `status` = 3 WHERE `tblcar`.`car_id` = '$car_id' ";
      $result = mysqli_query($conn, $sql);
      if(!$result)
 { echo "We could not update the record successfully";}
}
else
  {$payment_status = 0;}
	//NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN

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
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

  <title>Reservation Invoice</title>

</head>

<body class="bg-light">


  <?php include '_nav.php' ?>


  <div class="container card my-3" style="min-height:550px">
    <div class="card-body">
        <?php if($payment_status == 1){ ?>
		<!-- --------------------------------------------------------------------------- -->
		<!-- Payment successful -->
            <h1></h1>
            <h1 class="border-bottom py-2">Your Payment has been Successful</h1>
            <h4>Payment Information</h4>
            <p><b>Vehicle:</b> <?php echo $model; ?></p>
            <p><b>Reservation Date:</b> <?php echo $reservation_date; ?></p>
            <p><b>Rental Date:</b> <?php echo $rental_date; ?></p>
            <p><b>Return Date:</b> <?php echo $return_date; ?></p>
            <p><b>Rental Location:</b> <?php echo $Location; ?></p>
           
            <p><b>Reference Number:</b> <?php echo $RetreivalReferenceNo; ?></p>
            <p><b>Transaction ID:</b> <?php echo $Transaction_id; ?></p>
            <p><b>Paid Amount:</b> <?php echo $Amount; ?> PKR</p>
            <p><b>Payment Status:</b> Success</p>
		<!-- --------------------------------------------------------------------------- -->
			
			
		<!-- --------------------------------------------------------------------------- -->
        <!-- Payment not successful -->
		<?php }else{ ?>
            <h1 class="error">Your Payment has Failed</h1>
			<p><b>Message: </b><?php echo $ResponseMessage;?></p>
        <?php } ?>
		<!-- --------------------------------------------------------------------------- -->
		
		
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
  <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script>
    // Solves Resubmit form on Reload issue
    if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
    </script>

</body>

</html>
