<?php
require_once "../../model/doctorModel.php";
require_once '../../../Model/conn.php';

session_start();
if (!isset($_SESSION['doctor_id'])) {
    header("Location: ../../login.php");
    exit();
}

$doctorId = $_SESSION['doctor_id'];
$doctorModel = new DoctorModel($conn);

// Handle new prescription submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_prescription'])) {
    $patientId = $_POST['patient_id'];
    $medicine = trim($_POST['medicine']);
    $dosage = trim($_POST['dosage']);
    $duration = trim($_POST['duration']);
    $notes = trim($_POST['notes']);

    if ($doctorModel->addPrescription($doctorId, $patientId, $medicine, $dosage, $duration, $notes)) {
        $success = "Prescription added successfully!";
    } else {
        $error = "Failed to add prescription.";
    }
}

$prescriptions = $doctorModel->getPrescriptions($doctorId);
$patients = $doctorModel->getPatients($doctorId); // For dropdown
?>
