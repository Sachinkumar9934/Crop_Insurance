<?php
include 'C:/xampp/htdocs/crop_insurance/config/db_connect.php';
include 'C:/xampp/htdocs/crop_insurance/config/config.php';


// Check if the request is a POST
if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    die("Error: Invalid request method.");
}

// Retrieve and sanitize POST data
$state = strtolower($_POST['state'] ?? '');
$district = strtolower($_POST['district'] ?? '');
$crop = strtolower($_POST['crop'] ?? '');
$season = strtolower($_POST['season'] ?? '');
$area = floatval($_POST['area'] ?? 0);


// Query 1: Get crop_id from crop_calender
$sql = $conn->prepare("SELECT crop_id FROM crop_calender WHERE state = ? AND district = ? AND crop = ? AND season = ?");
$sql->bind_param('ssss', $state, $district, $crop, $season);
$sql->execute();
$result = $sql->get_result();

if ($row = $result->fetch_assoc()) {
    $crop_id = $row['crop_id'];
} else {
    die("Error: No matching crop found in the calendar.");
}
$sql->close();

$sql = $conn->prepare("SELECT company_id,insurance_plan_id,sum_insured FROM insurance_plan WHERE crop_id = ?");
$sql->bind_param('i', $crop_id);
$sql->execute();
$result = $sql->get_result();

if ($row = $result->fetch_assoc()) {
    $company_id = $row['company_id'];
    $insurance_plan_id = $row['insurance_plan_id'];
    $sum_insured= $row['sum_insured'];
} else {
    die("Error: No insurance plan found for this crop.");
}
$sql->close();

// Query 3: Get company details from insurance_login
$sql = $conn->prepare("SELECT email, company_name FROM insurance_login WHERE company_id = ?");
$sql->bind_param('s', $company_id); // Assuming company_id is a string; adjust to 'i' if integer
$sql->execute();
$result = $sql->get_result();

if ($row = $result->fetch_assoc()) {
    $email = $row['email'];
    $company_name = $row['company_name'];
} else {
    die("Error: No insurance company found.");
}
$sql->close();



$_SESSION['company_details'] = [
    'company_name' => $company_name,
    'email' => $email
];

$_SESSION['insurance_data'] = [
    'area' => $area,
    'insurance_plan_id'=> $insurance_plan_id,
    'crop_id' => $crop_id,
    'sum_insured'=> $sum_insured

];
if (!defined('BASE_URL')) {
    die("Error: BASE_URL is not defined.");
}
header("Location: " . BASE_URL . "views/ApplyInsurance.php");
exit();

?>