<?php
include 'C:/xampp/htdocs/crop_insurance/config/db_connect.php';
include 'C:/xampp/htdocs/crop_insurance/config/config.php';
if($_SERVER['REQUEST_METHOD']=="POST"){
    $mobile_number=($_POST['mobile_number']);
    $password=($_POST['password']);
}
$sql=$conn->prepare("select password from farmer_login where mobile_number=?");
$sql->bind_param("i",$mobile_number);
$sql->execute();
$result=$sql->get_result();
$user=$result->fetch_assoc();
if(is_null($user)){
    $_SESSION['login_error']="Invalid username";
    header("Location: ".BASE_URL."index.php");
    exit();
}
if($password===$user['password']){
    $sql=$conn->prepare("select * from farmer_data where mobile_number=?");
    $sql->bind_param("i",$mobile_number);
    $sql->execute();
    $result=$sql->get_result();
    $user=$result->fetch_assoc();
    $_SESSION['user_farmer_id']=$user['farmer_id'];
    $_SESSION['user_name']=$user['name'];
    $_SESSION['user_mobile_number']=$user['mobile_number'];
    $_SESSION['user_age']=$user['age'];
    $_SESSION['user_caste']=$user['caste'];
    $_SESSION['user_gender']=$user['gender'];
    $_SESSION['user_farm_type']=$user['farm_type'];
    $_SESSION['user_farm_category']=$user['farm_category'];
    $_SESSION['user_state']=$user['state'];
    $_SESSION['user_district']=$user['district'];
    $_SESSION['user_sub_district']=$user['subdistrict'];
    $_SESSION['user_village']=$user['village'];
    $_SESSION['user_address']=$user['address'];
    $_SESSION['user_id_type']=$user['id_type'];
    $sql->close();
    header("Location: ".BASE_URL."views/HomePage.php");
    unset($_SESSION['login_error']);
    exit();
}
else{
    $_SESSION['login_error']="Password couldnt be verified";
    header("Location: ".BASE_URL."index.php");
    exit();
}

?>