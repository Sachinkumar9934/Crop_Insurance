<?php

include 'C:/xampp/htdocs/crop_insurance/config/db_connect.php';
include 'C:/xampp/htdocs/crop_insurance/config/config.php';

if (!isset($_SESSION['user_farmer_id'])) {
    header("Location: /crop_insurance/HomePage.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_farmer_id'];
    $name = $_POST['name'];
    $mobile_number = $_POST['mobile_number'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $caste = $_POST['caste'];
    $farm_type = $_POST['farm_type'];
    $farm_category = $_POST['farm_category'];
    $id_type = $_POST['id_type'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $subdistrict = $_POST['subdistrict'];
    $village = $_POST['village'];
    $address = $_POST['address'];

    // Validate inputs (add more validation as needed)
    if (empty($name) || empty($mobile_number) || empty($age)) {
        echo "<script>alert('Please fill in all required fields.'); window.history.back();</script>";
        exit();
    }

    // Update query
    $query = "UPDATE farmer_data SET 
        name = ?, 
        mobile_number = ?, 
        age = ?, 
        gender = ?, 
        caste = ?, 
        farm_type = ?, 
        farm_category = ?, 
        id_type = ?, 
        state = ?, 
        district = ?, 
        subdistrict = ?, 
        village = ?, 
        address = ? 
        WHERE farmer_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssissssssssssi", 
        $name, 
        $mobile_number, 
        $age, 
        $gender, 
        $caste, 
        $farm_type, 
        $farm_category, 
        $id_type, 
        $state, 
        $district, 
        $subdistrict, 
        $village, 
        $address, 
        $user_id
    );

    if ($stmt->execute()) {
        // Update session data
        $_SESSION['user_data'] = [
            'name' => $name,
            'mobile_number' => $mobile_number,
            'age' => $age,
            'gender' => $gender,
            'caste' => $caste,
            'farm_type' => $farm_type,
            'farm_category' => $farm_category,
            'id_type' => $id_type,
            'state' => $state,
            'district' => $district,
            'subdistrict' => $subdistrict,
            'village' => $village,
            'address' => $address
        ];
        echo "<script>alert('Profile updated successfully!'); window.location.href = '../views/profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile. Please try again.'); window.history.back();</script>";
    }
    $stmt->close();
    $conn->close();
}
?>