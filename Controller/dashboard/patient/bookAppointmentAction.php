<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once "../../../Model/patientModel.php";
session_start();

if (!isset($_SESSION['patient_id'])) {
    header("Location: ../../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $patientId = $_SESSION['patient_id'];
    $doctorId = $_POST['doctor_id'] ?? '';
    $appointmentDate = $_POST['appointment_date'] ?? '';
    $reason = $_POST['reason'] ?? '';

    // Validate input
    if (empty($doctorId) || empty($appointmentDate) || empty($reason)) {
        $error = "Please fill all fields.";
        header("Location: ../../../View/dashboard/patient.php?error=" . urlencode($error));
        exit();
    }

    
    exit();
}
?>
