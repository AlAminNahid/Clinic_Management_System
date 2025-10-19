<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();
    include("../../../Model/adminDashboardModel.php");

    $action = $_GET['action'] ?? '';

    if($action === 'getBackupInfo'){
        $backups = getAllBackups($conn);
        echo json_encode($backups);
        exit;
    }

    if($action === 'createBackup'){
        if(!isset($_SESSION['email'])){
            echo json_encode(['Error' => 'Unauthorized']);
            exit;
        }

        $timestamp = date('Ymd_His');
        $fileName = "backup_{$timestamp}.sql";

        $dbHost = "localhost";
        $dbUser = "root";
        $dbPass = "";
        $dbName = "Clinic_Management_System";

        $mysqldump = '/Applications/XAMPP/xamppfiles/bin/mysqldump';
        $command = "$mysqldump --user={$dbUser} --password={$dbPass} --host={$dbHost} {$dbName}";

        exec($command, $output, $returnVar);

        if($returnVar === 0){
            $sqlContent = implode("\n", $output);
            $createdBy = $_SESSION['email'];

            insertBackup($conn, $fileName, $createdBy);

            header('Content-Description: File Transfer');
            header('Content-Type: application/sql');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . strlen($sqlContent));

            echo $sqlContent;
            exit;
        } 
        else {
            echo json_encode(['success' => false, 'message' => 'Backup creation failed.']);
            exit;
        }
    }

    if($action === 'deleteBackup'){
        $backupID = $_GET['backupID'];

        if(deleteBackup($conn, $backupID)){
            echo json_encode(['success' => true]);
        } 
        else {
            echo json_encode(['success' => false, "message" => "Failed to delete backup from database."]);
        }
        exit;
    }
?>
