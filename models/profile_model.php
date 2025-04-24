<?php
include 'C:/xampp/htdocs/crop_insurance/config/db_connect.php';
include 'C:/xampp/htdocs/crop_insurance/config/config.php';

$farmer_id=$_SESSION['user_farmer_id'];
$sql=$conn->prepare("select * from farmer_data where farmer_id=?");
$sql->bind_param("i",$farmer_id);
$sql->execute();
$result=$sql->get_result();
$user=$result->fetch_assoc();


$_SESSION['user_data'] = [
    'name' => $user['name'],
    'mobile_number' => $user['mobile_number'],
    'age' => $user['age'],
    'gender' => $user['gender'],
    'caste' => $user['caste'],
    'farm_type' => $user['farm_type'],
    'farm_category' => $user['farm_category'],
    'state' => $user['state'],
    'subdistrict' => $user['subdistrict'],
    'address' => $user['address'],
    'id_type' => $user['id_type'],
    'district' => $user['district'],
    'village' => $user['village'],
];
print_r($_SESSION['user_data']);
header("Location: " . BASE_URL . "views/Profile.php");
?>