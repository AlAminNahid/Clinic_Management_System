<?php
require_once "../../Model/doctorModel.php";
require_once '../../Model/conn.php';

session_start();
if (!isset($_SESSION['doctor_id'])) {
    header("Location: ../../login.php");
    exit();
}

$doctorId = $_SESSION['doctor_id'];
$doctorModel = new DoctorModel($conn);
$doctor = $doctorModel->getDoctorById($doctorId);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_profile'])) {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $specialization = trim($_POST['specialization']);
    $visit_fee = trim($_POST['visit_fee']);
    $password = !empty($_POST['password']) ? $_POST['password'] : null;
    $slots = trim($_POST['slots']);

    if ($doctorModel->updateProfile($doctorId, $fullname, $email, $phone, $specialization, $visit_fee, $password, $slots)) {
        $success = "Profile updated successfully!";
        $doctor = $doctorModel->getDoctorById($doctorId);
    } else {
        $error = "Failed to update profile.";
    }
}
?>
