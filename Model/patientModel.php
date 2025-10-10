<?php
    include("conn.php");

    function getPatientInfo($conn, $patientID){
        $sql = "SELECT * FROM Patient WHERE PatientID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $patientID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result);
    }

    function getPatientAppointments($conn, $patientID){
        $sql = "SELECT a.*, d.FullName as DoctorName, d.Specialization 
                FROM Appointment a 
                JOIN Doctor d ON a.DoctorID = d.DoctorID 
                WHERE a.PatientID = ? 
                ORDER BY a.Date DESC, a.Time DESC";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $patientID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $data = [];
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }

        return $data;
    }

    function getPatientPrescriptions($conn, $patientID){
        $sql = "SELECT p.*, d.FullName as DoctorName, m.Name as MedicineName 
                FROM Prescription p 
                JOIN Doctor d ON p.DoctorID = d.DoctorID 
                JOIN Medicine m ON p.MedicineID = m.MedicineID 
                WHERE p.PatientID = ? 
                ORDER BY p.Date DESC";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $patientID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $data = [];
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }

        return $data;
    }

    function getAllDoctors($conn){
        $sql = "SELECT * FROM Doctor ORDER BY FullName";
        $result = mysqli_query($conn, $sql);

        $data = [];
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }

        return $data;
    }

    function getAvailableDoctors($conn){
        $sql = "SELECT DISTINCT d.* FROM Doctor d 
                JOIN AppointmentSlots s ON d.DoctorID = s.DoctorID 
                WHERE d.DoctorID IN (SELECT DISTINCT DoctorID FROM AppointmentSlots)
                ORDER BY d.FullName";
        $result = mysqli_query($conn, $sql);

        $data = [];
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }

        return $data;
    }

    function updatePatientProfile($conn, $patientID, $fullName, $phoneNumber, $age, $gender, $address){
        $sql = "UPDATE Patient SET FullName=?, PhoneNumber=?, Age=?, Gender=?, Address=? 
                WHERE PatientID = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if(!$stmt){
            return false;
        }

        mysqli_stmt_bind_param($stmt, "ssissi", $fullName, $phoneNumber, $age, $gender, $address, $patientID);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $result;
    }

    function bookAppointment($conn, $doctorID, $patientID, $date, $time, $reason){
        // Check if time slot is available
        if(!isTimeSlotAvailable($conn, $doctorID, $date, $time)){
            return false;
        }

        $sql = "INSERT INTO Appointment (DoctorID, PatientID, Date, Time, Status, Reason) 
                VALUES (?, ?, ?, ?, 'Booked', ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if(!$stmt){
            return false;
        }

        mysqli_stmt_bind_param($stmt, "iisss", $doctorID, $patientID, $date, $time, $reason);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $result;
    }

    function isTimeSlotAvailable($conn, $doctorID, $date, $time){
        $sql = "SELECT AppointmentID FROM Appointment 
                WHERE DoctorID = ? AND Date = ? AND Time = ? 
                AND Status IN ('Booked', 'Approved')";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iss", $doctorID, $date, $time);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        return mysqli_num_rows($result) === 0;
    }

    function cancelAppointment($conn, $appointmentID, $patientID){
        // Verify appointment ownership
        if(!isAppointmentOwnedByPatient($conn, $appointmentID, $patientID)){
            return false;
        }

        $sql = "UPDATE Appointment SET Status = 'Cancelled' 
                WHERE AppointmentID = ? AND PatientID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $appointmentID, $patientID);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        return $result;
    }

    function isAppointmentOwnedByPatient($conn, $appointmentID, $patientID){
        $sql = "SELECT AppointmentID FROM Appointment 
                WHERE AppointmentID = ? AND PatientID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $appointmentID, $patientID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        return mysqli_num_rows($result) > 0;
    }

    function getAppointmentById($conn, $appointmentID, $patientID){
        $sql = "SELECT a.*, d.FullName as DoctorName, d.Specialization 
                FROM Appointment a 
                JOIN Doctor d ON a.DoctorID = d.DoctorID 
                WHERE a.AppointmentID = ? AND a.PatientID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $appointmentID, $patientID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result);
    }

    function getDoctorSlots($conn, $doctorID, $date){
        $dayOfWeek = date('D', strtotime($date));
        
        $sql = "SELECT * FROM AppointmentSlots 
                WHERE DoctorID = ? AND FIND_IN_SET(?, Days) > 0 
                ORDER BY StartTime";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "is", $doctorID, $dayOfWeek);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $data = [];
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }

        return $data;
    }

    function getUpcomingAppointments($conn, $patientID, $limit = 5){
        $sql = "SELECT a.*, d.FullName as DoctorName, d.Specialization 
                FROM Appointment a 
                JOIN Doctor d ON a.DoctorID = d.DoctorID 
                WHERE a.PatientID = ? AND a.Date >= CURDATE() 
                AND a.Status IN ('Booked', 'Approved')
                ORDER BY a.Date ASC, a.Time ASC 
                LIMIT ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $patientID, $limit);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $data = [];
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }

        return $data;
    }

    function getAppointmentStats($conn, $patientID){
        $sql = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN Status = 'Booked' THEN 1 ELSE 0 END) as booked,
                SUM(CASE WHEN Status = 'Approved' THEN 1 ELSE 0 END) as approved,
                SUM(CASE WHEN Status = 'Completed' THEN 1 ELSE 0 END) as completed,
                SUM(CASE WHEN Status = 'Cancelled' THEN 1 ELSE 0 END) as cancelled
                FROM Appointment 
                WHERE PatientID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $patientID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result);
    }

    function searchAppointments($conn, $patientID, $searchTerm){
        $sql = "SELECT a.*, d.FullName as DoctorName, d.Specialization 
                FROM Appointment a 
                JOIN Doctor d ON a.DoctorID = d.DoctorID 
                WHERE a.PatientID = ? AND 
                      (d.FullName LIKE ? OR a.Reason LIKE ? OR a.Status LIKE ?)
                ORDER BY a.Date DESC, a.Time DESC";
        $stmt = mysqli_prepare($conn, $sql);
        $searchPattern = "%" . $searchTerm . "%";
        mysqli_stmt_bind_param($stmt, "isss", $patientID, $searchPattern, $searchPattern, $searchPattern);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $data = [];
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }

        return $data;
    }

    function getRecentPrescriptions($conn, $patientID, $limit = 5){
        $sql = "SELECT p.*, d.FullName as DoctorName, m.Name as MedicineName 
                FROM Prescription p 
                JOIN Doctor d ON p.DoctorID = d.DoctorID 
                JOIN Medicine m ON p.MedicineID = m.MedicineID 
                WHERE p.PatientID = ? 
                ORDER BY p.Date DESC 
                LIMIT ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $patientID, $limit);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $data = [];
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }

        return $data;
    }

    function updatePatientCredentials($conn, $patientID, $email, $password = null){
        if($password){
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE Login SET Email = ?, Password = ? WHERE PatientID = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssi", $email, $hashedPassword, $patientID);
        } else {
            $sql = "UPDATE Login SET Email = ? WHERE PatientID = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "si", $email, $patientID);
        }
        
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $result;
    }

    function isEmailExists($conn, $email, $currentPatientID){
        $sql = "SELECT LoginID FROM Login 
                WHERE Email = ? AND PatientID != ? AND PatientID IS NOT NULL";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $email, $currentPatientID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        return mysqli_num_rows($result) > 0;
    }

    function getMedicalHistorySummary($conn, $patientID){
        $sql = "SELECT 
                COUNT(DISTINCT p.PrescriptionID) as total_prescriptions,
                COUNT(DISTINCT a.AppointmentID) as total_appointments,
                MIN(a.Date) as first_visit,
                MAX(a.Date) as last_visit
                FROM Patient pt
                LEFT JOIN Prescription p ON pt.PatientID = p.PatientID
                LEFT JOIN Appointment a ON pt.PatientID = a.PatientID
                WHERE pt.PatientID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $patientID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result);
    }

    function rescheduleAppointment($conn, $appointmentID, $patientID, $newDate, $newTime){
        // Verify ownership
        if(!isAppointmentOwnedByPatient($conn, $appointmentID, $patientID)){
            return false;
        }

        // Get appointment details
        $appointment = getAppointmentById($conn, $appointmentID, $patientID);
        if(!$appointment){
            return false;
        }

        // Check if new time slot is available
        if(!isTimeSlotAvailable($conn, $appointment['DoctorID'], $newDate, $newTime)){
            return false;
        }

        $sql = "UPDATE Appointment SET Date = ?, Time = ?, Status = 'Rescheduled' 
                WHERE AppointmentID = ? AND PatientID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssii", $newDate, $newTime, $appointmentID, $patientID);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $result;
    }

    function getPatientDashboardStats($conn, $patientID){
        $upcomingAppointments = getUpcomingAppointments($conn, $patientID);
        $totalPrescriptions = getRecentPrescriptions($conn, $patientID);
        $appointmentStats = getAppointmentStats($conn, $patientID);

        return [
            'upcoming_appointments' => count($upcomingAppointments),
            'total_prescriptions' => count($totalPrescriptions),
            'total_appointments' => $appointmentStats['total'],
            'last_visit' => !empty($upcomingAppointments) ? $upcomingAppointments[0]['Date'] : 'No visits'
        ];
    }
?>