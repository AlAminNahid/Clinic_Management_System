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

        $backupDir = $_SERVER['DOCUMENT_ROOT'] . '/web_tech_project/Clinic_Management_System/backups';
        if(!is_dir($backupDir)){
            die("Backup folder does not exist. Please create it at $backupDir");
        }

        if(!is_writable($backupDir)){
            die("Backup folder is not writable. Check folder permissions.");
        }

        $timestamp = date('Ymd_His');
        $fileName = "backup_{$timestamp}.sql";
        $filePath = $backupDir . '/' . $fileName;

        $dbHost = "localhost";
        $dbUser = "root";
        $dbPass = "";
        $dbName = "Clinic_Management_System";

        $mysqldump = '/Applications/XAMPP/xamppfiles/bin/mysqldump';
        $command = "$mysqldump --user={$dbUser} --password={$dbPass} --host={$dbHost} {$dbName} > {$filePath}";
        exec($command, $output, $returnVar);

        if($returnVar === 0){
            $createdBy = $_SESSION['email'];
            insertBackup($conn, $fileName, $createdBy);

            header('Content-Description: File Transfer');
            header('Content-Type: application/sql');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);

            exit;
        }
        else{
            echo "
                <script>
                    alert('Error creating backup.');
                </script>
            ";
        }
    }

    if($action === 'deleteBackup'){
        $backupID = $_GET['backupID'];
        $fileName = $_GET['fileName'];
        $filePath = "../../../backups/" . $fileName;

        if(file_exists($filePath)) {
            unlink($filePath);
        }

        if(deleteBackup($conn, $backupID)){
            echo json_encode(['success' => true]);
        }
        else{
            echo json_encode(['success' => false, "message" => "Failed to delete backup from database."]);
        }
        exit;
    }
?>