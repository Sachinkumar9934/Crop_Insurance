<?php
include 'C:/xampp/htdocs/crop_insurance/config/db_connect.php';
include 'C:/xampp/htdocs/crop_insurance/config/config.php';


$state = $district = $crop = $season = $area = null;


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $state = strtolower($_POST['state'] ?? '');
    $district = strtolower($_POST['district'] ?? '');
    $crop = strtolower($_POST['crop'] ?? '');
    $season = strtolower($_POST['season'] ?? '');
    $area = $_POST['area']; 
}


$sql = $conn->prepare("SELECT farmer_share, crop_id FROM crop_calender WHERE state=? AND district=? AND crop=? AND season=?");
if (!$sql) {
    die("Error in SQL preparation: " . $conn->error);
}

$sql->bind_param('ssss', $state, $district, $crop, $season);
if (!$sql->execute()) {
    die("Error in SQL execution: " . $sql->error);
}

$result = $sql->get_result();
$user = $result->fetch_assoc();
if (!$user) {
    die("Error: No crop data found for the given details.");
}
$farmer_share = $user['farmer_share'];
$crop_id = $user['crop_id'];

$sql = $conn->prepare("SELECT company_id, acturial_rate, sum_insured FROM insurance_plan WHERE crop_id=?");
$sql->bind_param('i', $crop_id);
$sql->execute();
$result = $sql->get_result();
$user = $result->fetch_assoc();
if (!$user) {
    die("Error: No insurance plan found for this crop.");
}
$company_id = $user['company_id'];
$acturial_rate = $user['acturial_rate'];
$sum_insured = $user['sum_insured'];

$sql = $conn->prepare("SELECT company_name FROM insurance_login WHERE company_id=?");
$sql->bind_param('i', $company_id);
$sql->execute();
$result = $sql->get_result();
$user = $result->fetch_assoc();
if (!$user) {
    die("Error: No company found for this insurance plan.");
}
$company_name = $user['company_name'];

$sum_insured_total = $area * $sum_insured;
$total_premium = $sum_insured_total * $acturial_rate / 100;
$premium_farmer = $sum_insured_total * $farmer_share / 100;
$premium_gov = $total_premium - $premium_farmer;
if($premium_gov<0){
    $premium_gov=0;
}

$_SESSION['insurance_data'] = [
    'company_name' => $company_name,
    'company_id' => $company_id,
    'farmer_share' => $farmer_share,
    'acturial_rate' => $acturial_rate,
    'sum_insured' => $sum_insured,
    'crop' => $crop,
    'area' => $area,
    'premium_farmer' => $premium_farmer,
    'premium_gov' => $premium_gov,
    'sum_insured_total' => $sum_insured_total
];
$sql->close();
print_r($_SESSION['insurance_data']);
header("Location: ".BASE_URL."views/InsuranceCalculater.php");
exit();
?>