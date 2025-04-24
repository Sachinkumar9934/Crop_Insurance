<?php
include 'C:/xampp/htdocs/crop_insurance/config/db_connect.php';
include 'C:/xampp/htdocs/crop_insurance/config/config.php';
if($_SERVER['REQUEST_METHOD']=="POST"){
    $email=($_POST['email']);
    $message=($_POST['message']);
}

$farmer_id=$_SESSION['user_farmer_id'];

$sql=$conn->prepare('INSERT into support_data(farmer_id,support_email,message) value(?,?,?)');
$sql->bind_param('iss', $farmer_id,$email,$message);
$sql->execute();
if($sql->execute()){
    echo "<script>alert('Support request submitted successfully!'); window.location.href='support_page.php';</script>";
} else {
    echo "<script>alert('Failed to submit support request. Please try again.'); window.history.back();</script>";
}
header("Location: " . BASE_URL . "views/HomePage.php");
?>