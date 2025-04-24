<?php
include 'C:/xampp/htdocs/crop_insurance/config/db_connect.php';
include 'C:/xampp/htdocs/crop_insurance/config/config.php';

$farmer_id = $_SESSION['user_farmer_id'];

$sql_main = $conn->prepare("SELECT * FROM insurance_data WHERE farmer_id = ?");
$sql_main->bind_param("i", $farmer_id);
$sql_main->execute();
$result_main = $sql_main->get_result();

$plans = [];

while ($row = $result_main->fetch_assoc()) {
    $plan_id = $row["insurance_plan_id"];

    // Get crop_id from insurance_plan
    $sql_crop_id = $conn->prepare("SELECT crop_id FROM insurance_plan WHERE insurance_plan_id = ?");
    $sql_crop_id->bind_param("i", $plan_id);
    $sql_crop_id->execute();
    $result_crop_id = $sql_crop_id->get_result();
    $crop_data = $result_crop_id->fetch_assoc();
    $crop_id = $crop_data['crop_id'] ?? null;

    // Get crop name from crop_calender
    if ($crop_id !== null) {
        $sql_crop_name = $conn->prepare("SELECT crop FROM crop_calender WHERE crop_id = ?");
        $sql_crop_name->bind_param("i", $crop_id);
        $sql_crop_name->execute();
        $result_crop_name = $sql_crop_name->get_result();
        $crop_name_data = $result_crop_name->fetch_assoc();
        $row['crop_name'] = $crop_name_data['crop'] ?? 'Unknown';
    } else {
        $row['crop_name'] = 'Unknown';
    }

    $plans[] = $row;
}

// Store in session
$_SESSION['ins_plans'] = $plans;

print_r($plans);
// Redirect to the view page
 header("Location: " . BASE_URL . "views/ViewInsurancePlans.php");
exit;
?>
