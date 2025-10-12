<?php
require_once "conn.php"; // <-- because conn.php is in the same folder

class DoctorModel {
    private $conn;

    public function __construct() {
        $this->conn = getConnection(); // assuming conn.php defines getConnection()
    }

    // ===== Get Doctor Details =====
    public function getDoctorById($doctorId) {
        $stmt = $this->conn->prepare("SELECT * FROM Doctor WHERE DoctorID = ?");
        $stmt->bind_param("i", $doctorId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // ===== Update Doctor Profile =====
    public function updateProfile($doctorId, $fullname, $email, $phone, $specialization, $visit_fee, $password=null, $slots=null) {
        if ($password) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("UPDATE Doctor SET FullName=?, Email=?, PhoneNumber=?, Specialization=?, VisitFee=?, Password=?, Slots=? WHERE DoctorID=?");
            $stmt->bind_param("ssssdssi", $fullname, $email, $phone, $specialization, $visit_fee, $passwordHash, $slots, $doctorId);
        } else {
            $stmt = $this->conn->prepare("UPDATE Doctor SET FullName=?, Email=?, PhoneNumber=?, Specialization=?, VisitFee=?, Slots=? WHERE DoctorID=?");
            $stmt->bind_param("sssdssi", $fullname, $email, $phone, $specialization, $visit_fee, $slots, $doctorId);
        }

        return $stmt->execute();
    }

    // ===== Get Patients of this Doctor =====
    public function getPatients($doctorId) {
        $stmt = $this->conn->prepare("SELECT p.*, a.Date AS appointment_date, a.Status 
                                      FROM Patient p
                                      JOIN Appointment a ON p.PatientID = a.PatientID
                                      WHERE a.DoctorID = ?");
        $stmt->bind_param("i", $doctorId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // ===== Add Prescription =====
    public function addPrescription($doctorId, $patientId, $medicineId, $dosage, $duration, $notes) {
        $stmt = $this->conn->prepare("INSERT INTO Prescription (DoctorID, PatientID, MedicineID, Dosage, Duration, AdditionalNotes, Date) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("iiisss", $doctorId, $patientId, $medicineId, $dosage, $duration, $notes);
        return $stmt->execute();
    }

    // ===== Get Prescriptions of this Doctor =====
    public function getPrescriptions($doctorId) {
        $stmt = $this->conn->prepare("SELECT pr.*, p.FullName AS patient_name, m.Name AS medicine_name 
                                      FROM Prescription pr
                                      JOIN Patient p ON pr.PatientID = p.PatientID
                                      JOIN Medicine m ON pr.MedicineID = m.MedicineID
                                      WHERE pr.DoctorID = ?
                                      ORDER BY pr.Date DESC");
        $stmt->bind_param("i", $doctorId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // ===== Appointment Stats =====
    public function getAppointmentStats($doctorId) {
        $stats = ['Booked'=>0, 'Approved'=>0, 'Cancelled'=>0, 'Rescheduled'=>0];
        $stmt = $this->conn->prepare("SELECT Status, COUNT(*) AS count FROM Appointment WHERE DoctorID=? GROUP BY Status");
        $stmt->bind_param("i", $doctorId);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $status = $row['Status'];
            $stats[$status] = (int)$row['count'];
        }
        return $stats;
    }
}
?>
