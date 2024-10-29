<?php
session_start();
session_destroy();
header("location:/crms/admin/loginadmin.php");
?>