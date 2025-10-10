<?php
session_start();
require_once '../../Model/conn.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$patient_id = $_SESSION['user_id'];
$doctor_id = intval($_POST['doctor']);
$date = $_POST['appointment-date'];
$time = $_POST['appointment-time'];
$reason = trim($_POST['reason']);

if (empty($doctor_id) || empty($date) || empty($time) || empty($reason)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit();
}

if (bookAppointment($conn, $doctor_id, $patient_id, $date, $time, $reason)) {
    echo json_encode(['success' => true, 'message' => 'Appointment booked successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to book appointment. Time slot may be unavailable.']);
}
?>