

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
//$patientModel = new PatientModel($conn);

if (isset($_POST['action']) && $_POST['action'] === 'cancel' && isset($_POST['appointment_id'])) {
    $appointment_id = intval($_POST



