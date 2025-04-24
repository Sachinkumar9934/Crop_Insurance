<?php
include 'C:/xampp/htdocs/crop_insurance/config/db_connect.php';
include 'C:/xampp/htdocs/crop_insurance/config/config.php';
session_unset();
header("Location: ".BASE_URL."views/HomePage.php");
?>
