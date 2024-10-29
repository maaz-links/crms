<?php  
session_start();

$delete = false;

// Connect to the Database 
include '_dbconnect.php';

// Include configuration file 
include_once 'config.php'; 
 
if ( !isset($_POST['CarID'])){
  header("location: /crms/carslist.php");
}

?>




<?php 
date_default_timezone_set('Asia/Karachi');
ini_set('max_execution_time', 60);


$product_id = $_POST['CarID'];
$Price = $_POST['Price'];
$dateInput = $_POST['dateInput'];
$NoOfDays = $_POST['NoOfDays'];
$Location = $_POST['Location'];




$sql = "SELECT * FROM `tblcar`
LEFT JOIN `tblcategory` ON `tblcar`.`category_id` = `tblcategory`.`category_id`
LEFT JOIN `tbllocation` ON `tblcar`.`location_id` = `tbllocation`.`location_id` 
where `car_id` = '$product_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$product_name = $row['model'];
$product_price = $Price * $NoOfDays;
$date = new DateTime($dateInput);
$date->modify("+{$NoOfDays} days");
$return_date = $date->format('Y-m-d');
$_SESSION['car_id'] = $product_id;
$_SESSION['model'] = $product_name;
$_SESSION['rental_date'] = $dateInput;
$_SESSION['return_date'] = $return_date;
$_SESSION['location_addr'] = $Location;

//NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
//1.
//get formatted price. remove period(.) from the price
$temp_amount 	= $product_price*100;
$amount_array 	= explode('.', $temp_amount);
$pp_Amount 		= $amount_array[0];
//NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN


//NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
//2.
//get the current date and time
$DateTime 		= new DateTime();
$pp_TxnDateTime = $DateTime->format('YmdHis');
//NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN


//NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
//3.
//to make expiry date and time add one hour to current date and time
$ExpiryDateTime = $DateTime;
$ExpiryDateTime->modify('+' . 1 . ' hours');
$pp_TxnExpiryDateTime = $ExpiryDateTime->format('YmdHis');
//NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN


//NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
//4.
//make unique transaction id using current date
$pp_TxnRefNo = 'T'.$pp_TxnDateTime;
//NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN


//--------------------------------------------------------------------------------

$post_data =  array(
	"pp_Version" 			=> JAZZCASH_API_VERSION_1,
	"pp_TxnType" 			=> "MWALLET",
	"pp_Language" 			=> JAZZCASH_LANGUAGE,
	"pp_MerchantID" 		=> JAZZCASH_MERCHANT_ID,
	"pp_SubMerchantID" 		=> "",
	"pp_Password" 			=> JAZZCASH_PASSWORD,
	"pp_BankID" 			=> "TBANK",
	"pp_ProductID" 			=> $product_id,//"RETL",
	"pp_TxnRefNo" 			=> $pp_TxnRefNo,
	"pp_Amount" 			=> $pp_Amount,
	"pp_TxnCurrency" 		=> JAZZCASH_CURRENCY_CODE,
	"pp_TxnDateTime" 		=> $pp_TxnDateTime,
	"pp_BillReference" 		=> "billRef",
	"pp_Description" 		=> "Description of transaction",
	"pp_TxnExpiryDateTime" 	=> $pp_TxnExpiryDateTime,
	"pp_ReturnURL" 			=> JAZZCASH_RETURN_URL,
	"pp_SecureHash" 		=> "",
	"ppmpf_1" 				=> "1",
	"ppmpf_2" 				=> "2",
	"ppmpf_3" 				=> "3",
	"ppmpf_4" 				=> "4",
	"ppmpf_5" 				=> "5",
);
//--------------------------------------------------------------------------------


//NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
//5.
//$sorted_string
//make an alphabetically ordered string using $post_data array above
//and skip the blank fields in $post_data array
$sorted_string  = JAZZCASH_INTEGERITY_SALT . '&';
$sorted_string .= $post_data['pp_Amount'] . '&';
$sorted_string .= $post_data['pp_BankID'] . '&';
$sorted_string .= $post_data['pp_BillReference'] . '&';
$sorted_string .= $post_data['pp_Description'] . '&';
$sorted_string .= $post_data['pp_Language'] . '&';
$sorted_string .= $post_data['pp_MerchantID'] . '&';
$sorted_string .= $post_data['pp_Password'] . '&';
$sorted_string .= $post_data['pp_ProductID'] . '&';
$sorted_string .= $post_data['pp_ReturnURL'] . '&';
$sorted_string .= $post_data['pp_TxnCurrency'] . '&';
$sorted_string .= $post_data['pp_TxnDateTime'] . '&';
$sorted_string .= $post_data['pp_TxnExpiryDateTime'] . '&';
$sorted_string .= $post_data['pp_TxnRefNo'] . '&';
$sorted_string .= $post_data['pp_TxnType'] . '&';
$sorted_string .= $post_data['pp_Version'] . '&';
$sorted_string .= $post_data['ppmpf_1'] . '&';
$sorted_string .= $post_data['ppmpf_2'] . '&';
$sorted_string .= $post_data['ppmpf_3'] . '&';
$sorted_string .= $post_data['ppmpf_4'] . '&';
$sorted_string .= $post_data['ppmpf_5'];

//sha256 hash encoding
$pp_SecureHash = hash_hmac('sha256', $sorted_string, JAZZCASH_INTEGERITY_SALT);
//NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN

$post_data['pp_SecureHash'] =  $pp_SecureHash;

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

  <style>
  </style>

  <title>Checkout</title>

</head>

<body>

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel"><img src="/crms/img/logo_JazzCash.png">Pay with Jazzcash</h5>
        </div>
        <form action="<?php echo JAZZCASH_HTTP_POST_URL;?>" method="POST" id="myCCForm">
          <div class="modal-body">
          <p>JazzCash Mobile Account can be registered on any Jazz or Warid number</p>
					<p>Biometric-verified Jazz and Warid customers can self-register their Mobile Account simply by dialing *786#.</p>

        <input type="hidden" name="amount" value="<?php echo $product_price;?>">
				<input type="hidden" name="product_name" value="<?php echo $product_name;?>">
				<input type="hidden" name="product_id" value="<?php echo $product_id;?>">

				<input type="hidden" name="pp_Version" value="<?php echo $post_data['pp_Version'];?>">
				<input type="hidden" name="pp_TxnType" value="<?php echo $post_data['pp_TxnType'];?>">
				<input type="hidden" name="pp_Language" value="<?php echo $post_data['pp_Language'];?>">
				<input type="hidden" name="pp_MerchantID" value="<?php echo $post_data['pp_MerchantID'];?>">
				<input type="hidden" name="pp_SubMerchantID" value="<?php echo $post_data['pp_SubMerchantID'];?>">
				<input type="hidden" name="pp_Password" value="<?php echo $post_data['pp_Password'];?>">
				<input type="hidden" name="pp_BankID" value="<?php echo $post_data['pp_BankID'];?>">
				<input type="hidden" name="pp_ProductID" value="<?php echo $post_data['pp_ProductID'];?>">
				
				<input type="hidden" name="pp_TxnRefNo" value="<?php echo $post_data['pp_TxnRefNo'];?>">
				<input type="hidden" name="pp_Amount" value="<?php echo $post_data['pp_Amount'];?>">
				<input type="hidden" name="pp_TxnCurrency" value="<?php echo $post_data['pp_TxnCurrency'];?>">
				<input type="hidden" name="pp_TxnDateTime" value="<?php echo $post_data['pp_TxnDateTime'];?>">
				<input type="hidden" name="pp_BillReference" value="<?php echo $post_data['pp_BillReference'];?>">
				<input type="hidden" name="pp_Description" value="<?php echo $post_data['pp_Description'];?>">
				<input type="hidden" name="pp_TxnExpiryDateTime" value="<?php echo $post_data['pp_TxnExpiryDateTime'];?>">
				<input type="hidden" name="pp_ReturnURL" value="<?php echo $post_data['pp_ReturnURL'];?>">
				<input type="hidden" name="pp_SecureHash" value="<?php echo $post_data['pp_SecureHash'];?>">
				<input type="hidden" name="ppmpf_1" value="<?php echo $post_data['ppmpf_1'];?>">
				<input type="hidden" name="ppmpf_2" value="<?php echo $post_data['ppmpf_2'];?>">
				<input type="hidden" name="ppmpf_3" value="<?php echo $post_data['ppmpf_3'];?>">
				<input type="hidden" name="ppmpf_4" value="<?php echo $post_data['ppmpf_4'];?>">
				<input type="hidden" name="ppmpf_5" value="<?php echo $post_data['ppmpf_5'];?>">


            <input type="hidden" name="user_id" value="1">
            <div class="form-group">
              <label for="value1Edit">Rental Date</label>
              <input type="text" class="form-control" id="value1Edit" value=<?php echo $dateInput ?> aria-describedby="emailHelp" readonly>
            </div>
            <div class="form-group">
              <label for="value1Edit">Number of Days for Rent</label>
              <input type="text" class="form-control" id="value2Edit" value=<?php echo $NoOfDays ?> aria-describedby="emailHelp" readonly>
            </div>
            <div class="form-group">
              <label for="value1Edit">Total Rental Price in PKR</label>
              <input type="text" class="form-control" id="value3Edit" value=<?php echo number_format($product_price) ?> aria-describedby="emailHelp" readonly>
            </div>
          </div>
          <div class="modal-footer d-block mr-auto">
            <a href="selectedcar.php?selected=<?php echo $product_id;?>" class="btn btn-outline-secondary">Go Back</a>
            <button type="submit" class="btn btn-success">Pay Now</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  

  <!-- Optional JavaScript -->
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

  <script>$('#editModal').modal({
      backdrop: 'static'
    }).modal('show');
     </script>


</body>

</html>
