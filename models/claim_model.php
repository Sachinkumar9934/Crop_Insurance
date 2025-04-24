<?php
/*include 'C:/xampp/htdocs/crop_insurance/config/db_connect.php';
include 'C:/xampp/htdocs/crop_insurance/config/config.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $insurance_id = ($_POST['insurance_id']);
}
echo $insurance_id;
$farmer_id=$_SESSION['user_farmer_id'];
$sql=$conn->prepare('select insurance_plan_id,farmer_id,status,area,sum_insured from insurance_data where farmer_id=?');
$sql->bind_param('i',$farmer_id);
$sql->execute();
$result = $sql->get_result();
$plans = $result->fetch_all(MYSQLI_ASSOC);
$sql->close();
print_r($plans);
foreach ($plans as $key => $value) {
    if($value['insurance_plan_id']== $insurance_id){
        $_SESSION['insurance_id']=$insurance_id;
    }
}
header("Location: " . BASE_URL . "views/ApplyClaim.php");*/
//gone no need currently 
?>
