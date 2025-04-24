<?php
include 'C:/xampp/htdocs/crop_insurance/config/db_connect.php';
include 'C:/xampp/htdocs/crop_insurance/config/config.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $insurance_id = ($_POST['insurance_id']);
}

$sql=$conn->prepare("SELECT count(*) from claims where insurance_id=?");
$sql->bind_param("i", $insurance_id);
$sql->execute();
$result=$sql->get_result();
$user=$result->fetch_assoc();


if($user["count(*)"]== 0){
    echo "<script>
        alert('Invalid Claim ID.');
        window.location.href = '" . BASE_URL . "views/HomePage.php';
        </script>";
}else{


    $sql=$conn->prepare("SELECT farmer_id from insurance_data where insurance_plan_id=?");
    $sql->bind_param("i", $insurance_id);
    $sql->execute();
    $result=$sql->get_result();
    $user=$result->fetch_assoc();
    $farmer_id=$user['farmer_id'];


    if($farmer_id!= $_SESSION['user_farmer_id']){
        echo "<script>
        alert('This claim ID is not registered in your number.');
        window.location.href = '" . BASE_URL . "views/HomePage.php';
    </script>";
    exit();
    }
}


$sql=$conn->prepare("SELECT * from claims where insurance_id=?");
$sql->bind_param("i",$insurance_id);
$sql->execute();
$result=$sql->get_result();
$user=$result->fetch_assoc();
$_SESSION['claim_data'] = [
        'insurance_id' => $user["insurance_id"],
        'area' => $user["area"],
        'claim_id' => $user["claim_id"],
        'claim_amount' => $user["claim_amount"],
        'reason' => $user["reason"],
        'status' => $user['status']
];
header("Location: ".BASE_URL."views/ClaimStatus.php");
?>