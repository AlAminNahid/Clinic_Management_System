<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../../../Model/patientModel.php";
require_once "../../../Model/conn.php";

session_start();


$patientId = $_SESSION['user_id'];
$patientModel = new PatientModel();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $fullname = trim($_POST['fullname'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $age      = isset($_POST['age']) ? (int)$_POST['age'] : null;
    $gender   = trim($_POST['gender'] ?? '');
    $address  = trim($_POST['address'] ?? '');

    try {
        $updated = $patientModel->updateProfile($patientId, $fullname, $phone, $age, $gender, $address);


        if ($updated) {
            $_SESSION['success'] = "Profile updated successfully!";
        } else {
            $_SESSION['error'] = "Failed to update profile. Check logs for details.";
        }

    } catch (Exception $e) {
        error_log("patientAction.php Error: " . $e->getMessage());
        $_SESSION['error'] = "An error occurred while updating profile.";
    }

    header("Location: ../../View/dashboard/patient/patient.php");
    exit();
}
?>
