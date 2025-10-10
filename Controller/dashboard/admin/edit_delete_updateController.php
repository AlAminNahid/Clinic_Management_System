<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include("../../../Model/adminDashboardModel.php");
    header('Content-Type: application/json');

    $action = $_GET['action'] ?? '';
    $input = json_decode(file_get_contents("php://input"), true);

    switch($action){
        case 'deleteDoctor':
            $doctorID = $input['doctorID'] ?? '';

            if(!$doctorID){
                echo json_encode(['success' => false, 'message' => 'Doctor ID not specified']);
                exit;
            }
            $deleted = deleteDoctor($conn, $doctorID);

            if($deleted){
                echo json_encode(['success' => true]);
            }
            else{
                echo json_encode(['success' => false, 'message' => 'Database error']);
            }
            break;

        case 'deletePatient':
            $patientID = $input['patientID'] ?? '';

            if(!$patientID){
                echo json_encode(['success' => false, 'message' => 'Patient ID is not specified']);
                exit;
            }
            $deleted = deletePatient($conn, $patientID);

            if($deleted){
                echo json_encode(['success' => true]);
            }
            else{
                echo json_encode(['success' => false, 'message' => 'Database error']);
            }
            break;

        case 'deleteMedicine':
            $medicineName = $input['medicineName'] ?? '';

            if(!$medicineName){
                echo json_encode(['success' => false, 'message' => 'Medicine name not specified']);
                exit;
            }

            $deleted = deleteMedicine($conn, $medicineName);
            echo json_encode(['success' => $deleted, 'message' => $deleted ? 'Medicine deleted' : 'Database error']);
            break;
            
        
        case 'editDoctor':
            $doctorID = $input['doctorID'] ?? '';
            $newFullName = $input['newFullName'] ?? '';
            $newPhone = $input['newPhone'] ?? '';
            $newSpecialization = $input['newSpecialization'] ?? '';
            $newFee = $input['newFee'] ?? '';

            $result = editDoctor($conn, $doctorID, $newFullName, $newPhone, $newSpecialization, $newFee);

            if($result){
                echo json_encode(['success' => true]);
            }
            else{
                echo json_encode(['success' => false, 'message' => 'Could not update doctor information.']);
            }
            break;
        
        case 'editPatient':
            $patientID = $input['patientID'] ?? '';
            $newFullName = $input['newFullName'] ?? '';
            $newPhone = $input['newPhone'] ?? '';
            $newAge = $input['newAge'] ?? '';
            $newGender = $input['newGender'] ?? '';
            $newAddress = $input['newAddress'] ?? '';

            $result = editPatient($conn, $patientID, $newFullName, $newPhone, $newAge, $newGender, $newAddress);

            if($result){
                echo json_encode(['success' => true]);
            }
            else{
                echo json_encode(['success' => false, 'message' => 'Could not update patient information']);
            }
            break;

        case 'toggleMedicineStatus':
            $medicineName = $input['medicineName'] ?? '';
            $newStatus = $input['newStatus'] ?? '';

            if(!$medicineName || !$newStatus){
                echo json_encode(['success' => false, 'message' => 'Missing parameters']);
                exit;
            }

            $result = updateMedicineStatus($conn, $medicineName, $newStatus);
            echo json_encode(['success' => $result, 'message' => $result ? 'Status updated' : 'Failed to update status']);
            break;

        case 'updateAppointmentStatus':
            $appointmentID = $input['appointmentID'] ?? '';
            $newStatus = $input['newStatus'] ?? '';

            if(!$appointmentID || !$newStatus){
                echo json_encode(['success' => false, 'message' => 'Missing paremeters']);
                exit;
            }

            $result = updateAppointmentStatus($conn, $appointmentID, $newStatus);
            echo json_encode(['success' => $result, 'message' => $result ? 'Status updated' : 'Failed to update status']);
            break;

        case 'deleteAppointment':
            $appointmentID = $input['appointmentID'] ?? '';

            if(!$appointmentID){
                echo json_encode(['success' => false, 'message' => 'Appointment ID not specified']);
                exit;
            }

            $result = deleteAppointment($conn, $appointmentID);
            echo json_encode(['success' => $result, 'message' => $result ? 'Appointment deleted' : 'Failed to delete appointment']);
            break;
        
        default:
            echo json_encode(["error" => "Invalid action"]);
            break;
    }
?>