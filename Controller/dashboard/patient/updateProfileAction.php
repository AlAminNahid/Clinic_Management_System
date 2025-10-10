<?php
session_start();
require_once '../../Model/conn.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$patient_id = $_SESSION['user_id'];
$fullName = trim($_POST['fullname']);
$phoneNumber = trim($_POST['phone']);
$age = intval($_POST['age']);
$gender = trim($_POST['gender']);
$address = trim($_POST['address']);

// Basic validation
if (empty($fullName) || empty($phoneNumber) || empty($gender) || empty($address) || $age <= 0) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit();
}

if (updatePatientProfile($conn, $patient_id, $fullName, $phoneNumber, $age, $gender, $address)) {
    echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update profile']);
}
?>