<?php

//If admin not logged in then redirect to login page
if(!isset($_SESSION['aloggedin']) || $_SESSION['aloggedin']!=true){
    header("location: /crms/admin/loginadmin.php");
    exit;
  }

?>