<?php  
session_start();
include '_checksession.php';

$delete = false;

// Connect to the Database 
include '_dbconnect.php';


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

  <title>Dashboard - Car Rental Management System</title>

</head>

<body>

  
  <?php include '_nav.php' ?>

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

<div class="container my-4">
    <h2>Dashboard</h2>
  </div>
  <hr>
  <div class="container my-4">

  

  <div class="row">


  <div class="col-sm-3">
  <div class="card text-center text-white bg-primary mb-3" style="max-width: 18rem;">
    <div class="card-body">
      <h5 style="font-size: 5em;" class="card-title">
      <?php
      $sql = "SELECT COUNT(*) AS `count` FROM `tblcar`";
      $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
              echo $row["count"];
        }
      ?>
      </h5>
      <p class="card-text">Cars Listed for Rent</p>
    </div>
    </div>
  </div>

  <div class="col-sm-3">
  <div class="card text-center text-white bg-danger mb-3" style="max-width: 18rem;">
    <div class="card-body">
      <h5 style="font-size: 5em;" class="card-title">
      <?php
      $sql = "SELECT COUNT(*) AS `count` FROM `tblcar` where `status` = 2";
      $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
              echo $row["count"];
        }
      ?>
      </h5>
      <p class="card-text">Cars Need Maintenance</p>
    </div>
    </div>
  </div>

  <div class="col-sm-3">
  <div class="card text-center text-white bg-info mb-3" style="max-width: 18rem;">
    <div class="card-body">
      <h5 style="font-size: 5em;" class="card-title">
      <?php
      $sql = "SELECT COUNT(*) AS `count` FROM `tblrental` where `rental_status` = 1 OR `rental_status` = 2";
      $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
              echo $row["count"];
        }
      ?>
      </h5>
      <p class="card-text">Cars Reserved or Rented</p>
    </div>
    </div>
  </div>


  <div class="col-sm-3">
  <div class="card text-center text-white bg-success mb-3" style="max-width: 18rem;">
    <div class="card-body">
      <h5 style="font-size: 3em;" class="card-title">
      <?php

      $from_date = date('Y-m-d', mktime(0, 0, 0, date("m")  , date("d")-14, date("Y")) );
      $sql = "SELECT SUM(`total_rental_price`) AS `count` FROM `tblrental` WHERE `reservation_date` >= '" . $from_date ."'";
      $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
              echo number_format($row["count"]);
        }
      ?>
      <p style="font-size: 0.6em;">PKR</p></h5>
      <p class="card-text">Revenue in Last 2 Weeks</p>
    </div>
    </div>
  </div>

  <div class="col-sm-3">
  <div class="card text-center text-dark bg-light mb-3" style="max-width: 18rem;">
    <div class="card-body">
      <h5 style="font-size: 5em;" class="card-title">
      <?php
      $sql = "SELECT COUNT(*) AS `count` FROM `tblusers`";
      $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
              echo $row["count"];
        }
      ?>
      </h5>
      <p class="card-text">Registered Users</p>
    </div>
    </div>
  </div>

  <div class="col-sm-3">
  <div class="card text-center text-white bg-dark mb-3" style="max-width: 18rem;">
    <div class="card-body">
      <h5 style="font-size: 5em;" class="card-title">
      <?php
      $sql = "SELECT COUNT(*) AS `count` FROM `tbllocation`";
      $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
              echo $row["count"];
        }
      ?>
      </h5>
      <p class="card-text">Locations in Use</p>
    </div>
    </div>
  </div>

  <div class="col-sm-3">
  <div class="card text-center text-white bg-secondary mb-3" style="max-width: 18rem;">
    <div class="card-body">
      <h5 style="font-size: 5em;" class="card-title">
      <?php
      $sql = "SELECT COUNT(*) AS `count` FROM `tblcategory`";
      $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
              echo $row["count"];
        }
      ?>
      </h5>
      <p class="card-text">Listed Categories</p>
    </div>
    </div>
  </div>

  <div class="col-sm-3">
  <div class="card text-center text-dark bg-warning mb-3" style="max-width: 18rem;">
    <div class="card-body">
      <h5 style="font-size: 3em;" class="card-title">
      <?php
      $sql = "SELECT SUM(`commission`) AS `count` FROM `tblowner`";
      $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
              echo number_format($row["count"]);
        }
      ?>
      <p style="font-size: 0.6em;">PKR</p></h5>
      <p class="card-text">Commission owed per month</p>
    </div>
    </div>
  </div>

  

</div>


</div>

  <!-- <hr> -->
  <?php include '_bootjs.php' ?>

</body>

</html>
