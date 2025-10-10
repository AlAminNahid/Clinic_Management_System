<?php
require_once 'conn.php';

class PatientModel {
    private $conn;
    
    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }
    
    public function getPatientProfile($patientID) {
        $stmt = $this->conn->prepare("SELECT p.PatientID, p.FullName, p.PhoneNumber, p.Age, p.Gender, p.Address, l.Email 
                                    FROM Patient p 
                                    LEFT JOIN Login l ON p.PatientID = l.PatientID 
                                    WHERE p.PatientID = ?");
        $stmt->bind_param("i", $patientID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    public function getPatientAppointments($patientID) {
        $stmt = $this->conn->prepare("SELECT a.AppointmentID, a.Date, a.Time, a.Reason, a.Status, d.FullName AS DoctorName 
                                    FROM Appointment a 
                                    LEFT JOIN Doctor d ON a.DoctorID = d.DoctorID 
                                    WHERE a.PatientID = ? 
                                    ORDER BY a.Date DESC, a.Time DESC");
        $stmt->bind_param("i", $patientID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getAllDoctors() {
        $result = $this->conn->query("SELECT DoctorID, FullName, Specialization FROM Doctor ORDER BY FullName");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getPatientPrescriptions($patientID) {
        $stmt = $this->conn->prepare("SELECT pr.PrescriptionID, pr.Date, pr.AdditionalNotes, d.FullName AS DoctorName, 
                                     m.Name as MedicineName, pr.Dosage, pr.Duration 
                                     FROM Prescription pr 
                                     LEFT JOIN Doctor d ON pr.DoctorID = d.DoctorID 
                                     LEFT JOIN Medicine m ON pr.MedicineID = m.MedicineID 
                                     WHERE pr.PatientID = ? 
                                     ORDER BY pr.Date DESC");
        $stmt->bind_param("i", $patientID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>