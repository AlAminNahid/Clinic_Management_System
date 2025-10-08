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
        
        default:
            echo json_encode(["error" => "Invalid action"]);
            break;
    }
?>