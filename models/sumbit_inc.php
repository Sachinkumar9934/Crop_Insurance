<?php
include 'C:/xampp/htdocs/crop_insurance/config/db_connect.php';
include 'C:/xampp/htdocs/crop_insurance/config/config.php';

$data=$_SESSION['insurance_data'];
$area=$data['area'];
$insurance_plan_id=$data['insurance_plan_id'];
$crop_id=$data['crop_id'];
$sum_insured=$data['sum_insured'];
$farmer_id=$_SESSION['user_farmer_id'];
//unset($_SESSION['application_details']);

$sql=$conn->prepare("insert into insurance_data (insurance_plan_id, farmer_id,status,area,sum_insured) VALUES (?,?,?,?,?)");
$status=1;
$sql->bind_param("iiiid",$insurance_plan_id,$farmer_id,$status,$area,$sum_insured);
$sql->execute();
$sql->close();
print_r($data);
print_r($farmer_id);
header("Location: " . BASE_URL . "views/InsuranceApplied.php");
?>