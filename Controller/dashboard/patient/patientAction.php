<?php
session_start();
require_once '../../Model/conn.php';
require_once '../../Model/patientModel.php';

if (!isset($_SESSION['PatientID']) || ($_SESSION['role'] ?? '') !== 'patient') {
    header("Location: ../../login_reg_forget/login/login.php");
    exit;
}

$patientID = (int)$_SESSION['PatientID'];

// Create model instance
$patientModel = new PatientModel();

// Get all data for the dashboard
$data = [
    'profile' => $patientModel->getPatientProfile($patientID),
    'appointments' => $patientModel->getPatientAppointments($patientID),
    'doctors' => $patientModel->getAllDoctors(),
    'prescriptions' => $patientModel->getPatientPrescriptions($patientID)
];

// Pass data to view via GLOBALS (as your view expects)
foreach ($data as $key => $value) {
    $GLOBALS[$key] = $value;
}

// Include the view
include '../../View/dashboards/patient/patient.php';
?>