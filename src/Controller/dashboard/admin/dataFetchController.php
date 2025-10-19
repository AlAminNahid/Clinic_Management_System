<?php
    session_start();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include("../../../Model/adminDashboardModel.php");
    header('Content-Type: application/json');

    $adminID = $_SESSION['user_id'] ?? 0;
    $action = $_GET['action'] ?? '';
    $input = json_decode(file_get_contents("php://input"), true);

    switch ($action) {
        case 'getDoctors':
            echo json_encode(getDoctors($conn));
            break;

        case 'getPatients':
            echo json_encode(getPatients($conn));
            break;

        case 'getAppointments':
            echo json_encode(getAppointments($conn));
            break;

        case 'getMedicines':
            echo json_encode(getMedicines($conn));
            break;

        case 'getDashboardStats':
            $data = [
                "doctors" => getTotalDoctors($conn),
                "patients" => getTotalPatients($conn),
                "appointments" => getTotalAppointments($conn),
                "medicines" => getTotalMedicines($conn),
                "adminInfo" => getAdminInfo($conn, $adminID)
            ];
            echo json_encode($data);
            break;

        default:
            echo json_encode(["error" => "Invalid action"]);
            break;
    }
?>