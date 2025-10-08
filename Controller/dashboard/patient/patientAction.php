<?php
session_start();
require_once '../../Model/conn.php';
require_once '../../Model/patientModel.php';
require_once '../../Validation/patientValidation.php';

class PatientController {
    private $model;
    
    public function __construct() {
        $this->model = new PatientModel();
    }
    
    public function showDashboard() {
        // Authentication
        if (!isset($_SESSION['PatientID']) || ($_SESSION['role'] ?? '') !== 'patient') {
            header("Location: ../../login_reg_forget/login/login.php");
            exit;
        }
        
        $patientID = (int)$_SESSION['PatientID'];
        
        // Get all data for dashboard
        $data = [
            'profile' => $this->model->getPatientProfile($patientID),
            'appointments' => $this->model->getPatientAppointments($patientID),
            'doctors' => $this->model->getAllDoctors(),
            'prescriptions' => $this->model->getPatientPrescriptions($patientID)
        ];
        
        // Pass to view
        foreach ($data as $key => $value) {
            $GLOBALS[$key] = $value;
        }
        
        // Include view
        include '../../View/dashboards/patient/patient.php';
    }
}

// Route the request
$controller = new PatientController();
$controller->showDashboard();
?>