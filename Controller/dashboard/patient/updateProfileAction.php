

<?php
session_start();
require_once '../Model/conn.php';
require_once '../Model/patientModel.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

$patient_id = $_SESSION['user_id'];
$fullName = trim($_POST['fullName']);
$phoneNumber = trim($_POST['phoneNumber']);
$age = intval($_POST['age']);
$gender = trim($_POST['gender']);
$address = trim($_POST['address']);

// Validation
if (empty($fullName) || empty($phoneNumber) || empty($gender) || empty($address) || $age <= 0) {
    echo json_encode(['success' => false, 'message' => 'All fields are required and must be valid']);
    exit();
}

$patientModel = new PatientModel($conn);

if ($patientModel->updatePatientProfile($patient_id, $fullName, $phoneNumber, $age, $gender, $address)) {
    echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update profile']);
}
?>