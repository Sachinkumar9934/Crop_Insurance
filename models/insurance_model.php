<?php
include 'C:/xampp/htdocs/crop_insurance/config/db_connect.php';
include 'C:/xampp/htdocs/crop_insurance/config/config.php';

$farmer_id=$_SESSION['user_farmer_id'];
$sql=$conn->prepare('select insurance_plan_id,farmer_id,status,area,sum_insured from insurance_data where farmer_id=?');
$sql->bind_param('i',$farmer_id);
$sql->execute();
$result = $sql->get_result();
$plans = $result->fetch_all(MYSQLI_ASSOC);
foreach ($plans as $key => $value) {
    $farmer_id=$_SESSION['user_farmer_id'];
    $sql=$conn->prepare('select crop_id from insurance_plan where insurance_plan_id=?');
    $sql->bind_param('i',$value['insurance_plan_id']);
    $sql->execute();
    $result = $sql->get_result();
    $user = $result->fetch_assoc();
    $crop_id=$user['crop_id'];
    $sql=$conn->prepare('select crop from crop_calender where crop_id=?');
    $sql->bind_param('i',$crop_id);
    $sql->execute();
    $result = $sql->get_result();
    $user = $result->fetch_assoc();
    $crop_name=$user['crop'];
    $plans[$key]['crop_name'] = $crop_name;  
}
$_SESSION['ins_plans']=$plans;
header("Location: ".BASE_URL."views/View_insurance_plan.php");
exit();
?>