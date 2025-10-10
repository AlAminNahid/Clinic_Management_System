<?php
session_start();
require_once '../../Model/conn.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$patient_id = $_SESSION['user_id'];
$appointment_id = intval($_POST['appointment_id']);

if (cancelAppointment($conn, $appointment_id, $patient_id)) {
    echo json_encode(['success' => true, 'message' => 'Appointment cancelled successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to cancel appointment']);
}
?>