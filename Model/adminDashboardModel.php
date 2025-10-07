<?php
include("conn.php");

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
