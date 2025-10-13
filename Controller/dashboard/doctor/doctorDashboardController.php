<?php


ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

require_once "../../Model/doctorModel.php";
require_once '../../../Model/conn.php';

session_start();
if (!isset($_SESSION['doctor_id'])) {
    header("Location: ../../login.php");
    exit();
}

$doctorId = $_SESSION['doctor_id'];
$doctorModel = new DoctorModel($conn);

$doctor = $doctorModel->getDoctorById($doctorId);
$stats = $doctorModel->getAppointmentStats($doctorId);
?>
