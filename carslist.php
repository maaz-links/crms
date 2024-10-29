<?php  

session_start();

$searchtext = false;
// Connect to the Database 
include '_dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

  if (isset( $_POST['category'])){
    $searchcriteria = $_POST['category'];
    $sqlcar = "SELECT * FROM `tblcar`
    LEFT JOIN `tblcategory` ON `tblcar`.`category_id` = `tblcategory`.`category_id`
    LEFT JOIN `tbllocation` ON `tblcar`.`location_id` = `tbllocation`.`location_id` 
    WHERE `tblcar`.`category_id` =  '$searchcriteria' ";

  }
  else{ if (isset( $_POST['location'])){
    $searchcriteria = $_POST['location'];
    $sqlcar = "SELECT * FROM `tblcar`
    LEFT JOIN `tblcategory` ON `tblcar`.`category_id` = `tblcategory`.`category_id`
    LEFT JOIN `tbllocation` ON `tblcar`.`location_id` = `tbllocation`.`location_id` 
    WHERE `tblcar`.`location_id` =  '$searchcriteria' ";

  }

  }

}else{
  $sqlcar = "SELECT * FROM `tblcar`
   LEFT JOIN `tblcategory` ON `tblcar`.`category_id` = `tblcategory`.`category_id`
   LEFT JOIN `tbllocation` ON `tblcar`.`location_id` = `tbllocation`.`location_id`";
       $result = mysqli_query($conn, $sqlcar);
    $row = mysqli_fetch_assoc($result);
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>List of Available Cars</title>
    <link rel="icon" type="image/x-icon" href="img/OIG2.jpeg">
    <link href="assets/carslist.css" rel="stylesheet">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/album/">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        
    <!-- Bootstrap core CSS -->
<link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    
  </head>
  <body>
  <?php include '_nav.php' ?>

<main role="main">

  <section class="py-3 text-center bg-light" >
    <div class="container" >
      <h1>List of Available Cars For Rent</h1>
      <p class="lead text-muted">
      <hr>
    </div>
    
  </section>

  <div style="min-height: 400px;" class="album py-1 bg-light">
    <div class="container">
    <div class="row" >
    <div class="col" >
      <form action="carslist.php" method="post" class="form-inline my-2 my-lg-3">
      <label class="mx-2">Search by Car Category</label><label style="visibility: hidden;width:244px;"></label>
      <p></p>
        <select class="form-control mr-sm-2" id="categorydom" name="category" placeholder="Search By Category" aria-label="Search">
        <?php 
              $sql = "SELECT * FROM `tblcategory`";
              $result = mysqli_query($conn, $sql);
              while($row = mysqli_fetch_assoc($result)){
                echo "<option value='".$row['category_id']."'>".$row['category_name']."</option>";
              } 
          ?>
          </select>
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
      </div>
      <div class="col" >
      <form action="carslist.php" method="post" class="form-inline my-2 my-lg-3">
      <label class="mx-2">Search by Car Location</label><label style="visibility: hidden;width:244px;"></label>
        <select class="form-control mr-sm-2" id="locationdom" name="location" placeholder="Search By Location" aria-label="Search">
        <?php 
              $sql = "SELECT * FROM `tbllocation`";
              $result = mysqli_query($conn, $sql);
              while($row = mysqli_fetch_assoc($result)){
                echo "<option value='".$row['location_id']."'>".$row['location_address']."</option>";
              } 
          ?>
          </select>
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
      </div>
    </div>
    </div>
        
    <div class="container">
    <div class="row">
		<?php 
          $result = mysqli_query($conn, $sqlcar);

          $num = mysqli_num_rows($result);
            if ($num < 1){
              echo "<h3>Sorry! We couldn't find any Vehicle Matching your criteria</h3>";
            }
          while($row = mysqli_fetch_assoc($result)){
            
		?>

        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <img src="<?php echo "/crms/admin/img/".$row['image'];?>" class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail">
            <div class="card-body">
            <h4 class="card-text"><?php echo $row['model'];?></h4>
            <p>Category: <?php echo $row['category_name'];?></p>
            <p>Rental Price per day: Rs. <?php echo number_format($row['rental_price']);?></p>
					<p>Rental Location: <?php echo $row['location_address'];?></p>
             <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="selectedcar.php?selected=<?php echo $row['car_id']; ?>"><button type="button" class="btn btn-sm btn-outline-primary">View</button></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
        
      </div>
    </div>
  </div>


</main>


<?php include '_footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="assets/dist/js/bootstrap.bundle.min.js"></script>
      <script>
        <?php
          if (isset( $_POST['category'])){
            echo "categorydom.value = ".$searchcriteria;
          }
          if (isset( $_POST['location'])){
            echo "locationdom.value = ".$searchcriteria;
          }
        ?>
      </script>
      </html>
