<?php
include 'C:/xampp/htdocs/crop_insurance/config/db_connect.php';
include 'C:/xampp/htdocs/crop_insurance/config/config.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $name = ($_POST['name']);
    $mobile_number = ($_POST['mobile_number']);
    $age = ($_POST['age']);
    $caste = ($_POST['caste']);
    $gender = ($_POST['gender']);
    $farm_type = ($_POST['farm_type']);
    $farm_category = ($_POST['farm_category']);
    $state = ($_POST['state']);
    $district = ($_POST['district']);
    $subdistrict = ($_POST['subdistrict']);
    $village = ($_POST['village']);
    $address = ($_POST['address']);
    $id_type = $_POST['id_type'];
    $password = $_POST['password'];
}
$sql=$conn->prepare("select * from farmer_data where mobile_number=?");
$sql->bind_param("i",$mobile_number);
$sql->execute();
$result=$sql->get_result();
if($result->num_rows > 0){
    echo "Mobile number already registered.";
    exit();
}
$sql->close();

$sql = $conn->prepare("INSERT INTO farmer_data (name, mobile_number, age, caste, gender, farm_type, farm_category, state, district, subdistrict, village, address, id_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$sql->bind_param("ssissssssssss", $name, $mobile_number, $age, $caste, $gender, $farm_type, $farm_category, $state, $district, $subdistrict, $village, $address, $id_type);
$sql->execute();
$sql->close();

$sql=$conn->prepare("select farmer_id from farmer_data where mobile_number= ?");
$sql->bind_param("i",$mobile_number);
$sql->execute();
$result=$sql->get_result();
$row=$result->fetch_assoc();
$farmer_id=$row['farmer_id'];
$sql->close();

$sql=$conn->prepare("insert into farmer_login values(?,?,?,?)");
$status=1;
$sql->bind_param("iisi",$farmer_id,$mobile_number,$password,$status);
$sql->execute();
$sql->close();

$sql=$conn->prepare("select farmer_id,password from farmer_login where mobile_number=?");
$sql->bind_param("i",$mobile_number);
$sql->execute();
$result=$sql->get_result();
$user=$result->fetch_assoc();
$sql->close();

if($user){
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
        $_SESSION['user_sub_district']=$user['sub_district'];
        $_SESSION['user_village']=$user['village'];
        $_SESSION['user_address']=$user['address'];
        $_SESSION['user_id_type']=$user['id_type'];
        $sql->close();
        echo ("Hi");
        //header("Location: ".BASE_URL."views/HomePage.php");
        exit();
    }
    else{
        echo "Password couldnt be verified";
    }
}
else{
    echo "Registration failed";
    print_r($user);
    print_r($mobile_number);
}
?>
