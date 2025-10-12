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

// Get doctor details & appointment stats
$doctor = $doctorModel->getDoctorById($doctorId);
$stats = $doctorModel->getAppointmentStats($doctorId);
?>
