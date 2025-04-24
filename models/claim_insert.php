<?php
include 'C:/xampp/htdocs/crop_insurance/config/db_connect.php';
include 'C:/xampp/htdocs/crop_insurance/config/config.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $insurance_id = ($_POST['insurance_id']);
    $amount = ($_POST['amount']);
    $area = ($_POST['area']);
    $reason = ($_POST['reason']);
}

$sql=$conn->prepare("SELECT count(*) from claims where insurance_id=?");
$sql->bind_param("i", $insurance_id);
$sql->execute();
$result=$sql->get_result();
$user=$result->fetch_assoc();

if($user["count(*)"]!= 0){
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
    exit();
    
}
$status='pending';
$sql = $conn->prepare("INSERT INTO claims (insurance_id, reason, claim_amount, area,status) VALUES (?, ?, ?, ?,?)");
    $sql->bind_param("isiis", $insurance_id, $reason, $amount, $area,$status);

    if ($sql->execute()) {
        echo "<script>
                alert('Claim submitted successfully.');
                window.location.href = '/crop_insurance/views/HomePage.php';
              </script>";
    } else {
        echo "<script>
                alert('Error submitting claim.');
                window.location.href = '/crop_insurance/views/HomePage.php';
              </script>";
    }

    $sql->close();
?>
