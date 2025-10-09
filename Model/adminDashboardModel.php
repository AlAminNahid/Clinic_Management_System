<?php
    include("conn.php");

    function insertBackup($conn, $fileName, $createdBy){
        $sql = "INSERT INTO Backup (FileName, CreatedBy) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if(!$stmt){
            return false;
        }

        mysqli_stmt_bind_param($stmt, "ss", $fileName, $createdBy);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $result;
    }

    function getAllBackups($conn){
        $sql = "SELECT * FROM Backup ORDER BY BackupID DESC";
        $result = mysqli_query($conn, $sql);

        $data = [];
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }

        return $data;
    }

    function deleteBackup($conn, $backupID){
        $sql = "DELETE FROM Backup WHERE BackupID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $backupID);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        return $result;
    }

    function deleteDoctor($conn, $doctorID){
        $sql = "DELETE FROM Doctor WHERE DoctorID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $doctorID);

        return mysqli_stmt_execute($stmt);
    }

    function deletePatient($conn, $patientID){
        $sql = "DELETE FROM Patient WHERE PatientID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $patientID);

        return mysqli_stmt_execute($stmt);
    }

    function editDoctor($conn, $doctorID, $newFullName, $newPhone, $newSpecialization, $newFee){
        $sql = "UPDATE Doctor SET FullName=?, PhoneNumber=?, Specialization=?, VisitFee=? 
                WHERE DoctorID = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if(!$stmt){
            return false;
        }

        mysqli_stmt_bind_param($stmt, "sssdi", $newFullName, $newPhone, $newSpecialization, $newFee, $doctorID);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $result;
    }

    function editPatient($conn, $patientID, $newFullName, $newPhone, $newAge, $newGender, $newAddress){
        $sql = "UPDATE Patient SET FullName=?, PhoneNumber=?, Age=?, Gender=?, Address=?
                WHERE PatientID = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if(!$stmt){
            return false;
        }

        mysqli_stmt_bind_param($stmt, "ssissi", $newFullName, $newPhone, $newAge, $newGender, $newAddress, $patientID);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $result;
    }

    function getTotalDoctors($conn){
        $sql = "SELECT COUNT(*) as total FROM Doctor";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        return $row['total'];
    }

    function getTotalPatients($conn){
        $sql = "SELECT COUNT(*) as total FROM Patient";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        return $row['total'];
    }

    function getTotalAppointments($conn){
        $sql = "SELECT COUNT(*) as total FROM Appointment";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        return $row['total'];
    }

    function getTotalMedicines($conn) {
        $sql = "SELECT COUNT(*) as total FROM Medicine";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        return $row['total'];
    }

    function getAdminInfo($conn, $adminID){
        $sql = "SELECT FullName, Email, PhoneNumber FROM Admin WHERE AdminID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $adminID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result);
    }

    function getDoctors($conn) {
        $sql = "SELECT * FROM Doctor";
        $result = mysqli_query($conn, $sql);
        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    function getPatients($conn) {
        $sql = "SELECT * FROM Patient";
        $result = mysqli_query($conn, $sql);
        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    function getAppointments($conn) {
        $sql = "SELECT a.AppointmentID, p.FullName as PatientName, d.FullName as DoctorName, a.Date, a.Time, a.Status
                FROM Appointment a
                JOIN Patient p ON a.PatientID = p.PatientID
                JOIN Doctor d ON a.DoctorID = d.DoctorID";
        $result = mysqli_query($conn, $sql);
        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    function getMedicines($conn) {
        $sql = "SELECT * FROM Medicine";
        $result = mysqli_query($conn, $sql);
        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }
?>
