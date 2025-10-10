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
$doctor_id = intval($_POST['doctor']);
$date = $_POST['appointmentDate'];
$time = $_POST['appointmentTime'];
$reason = trim($_POST['reason']);

// Validation
if (empty($doctor_id) || empty($date) || empty($time) || empty($reason)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit();
}

// Check if date is not in the past
if (strtotime($date) < strtotime(date('Y-m-d'))) {
    echo json_encode(['success' => false, 'message' => 'Cannot book appointment in the past']);
    exit();
}

$patientModel = new PatientModel($conn);

if ($patientModel->bookAppointment($doctor_id, $patient_id, $date, $time, $reason)) {
    echo json_encode(['success' => true, 'message' => 'Appointment booked successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to book appointment']);
}
?>

