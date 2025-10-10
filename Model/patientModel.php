<?php
class PatientModel {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    // Get patient by ID
    public function getPatientById($patient_id) {
        $sql = "SELECT * FROM Patient WHERE PatientID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $patient_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Get patient appointments
    public function getPatientAppointments($patient_id) {
        $sql = "SELECT a.*, d.FullName as DoctorName 
                FROM Appointment a 
                JOIN Doctor d ON a.DoctorID = d.DoctorID 
                WHERE a.PatientID = ? 
                ORDER BY a.Date DESC, a.Time DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $patient_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $appointments = [];
        while ($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }
        return $appointments;
    }

    // Get patient prescriptions
    public function getPatientPrescriptions($patient_id) {
        $sql = "SELECT p.*, d.FullName as DoctorName, m.Name as MedicineName 
                FROM Prescription p 
                JOIN Doctor d ON p.DoctorID = d.DoctorID 
                JOIN Medicine m ON p.MedicineID = m.MedicineID 
                WHERE p.PatientID = ? 
                ORDER BY p.Date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $patient_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $prescriptions = [];
        while ($row = $result->fetch_assoc()) {
            $prescriptions[] = $row;
        }
        return $prescriptions;
    }

    // Get all doctors
    public function getAllDoctors() {
        $sql = "SELECT * FROM Doctor WHERE DoctorID IN (SELECT DISTINCT DoctorID FROM AppointmentSlots)";
        $result = $this->conn->query($sql);
        
        $doctors = [];
        while ($row = $result->fetch_assoc()) {
            $doctors[] = $row;
        }
        return $doctors;
    }

    // Update patient profile
    public function updatePatientProfile($patient_id, $fullName, $phoneNumber, $age, $gender, $address) {
        $sql = "UPDATE Patient SET FullName = ?, PhoneNumber = ?, Age = ?, Gender = ?, Address = ? WHERE PatientID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssissi", $fullName, $phoneNumber, $age, $gender, $address, $patient_id);
        return $stmt->execute();
    }

    // Book new appointment
    public function bookAppointment($doctor_id, $patient_id, $date, $time, $reason) {
        $sql = "INSERT INTO Appointment (DoctorID, PatientID, Date, Time, Status, Reason) VALUES (?, ?, ?, ?, 'Booked', ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iisss", $doctor_id, $patient_id, $date, $time, $reason);
        return $stmt->execute();
    }

    // Cancel appointment
    public function cancelAppointment($appointment_id, $patient_id) {
        $sql = "UPDATE Appointment SET Status = 'Cancelled' WHERE AppointmentID = ? AND PatientID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $appointment_id, $patient_id);
        return $stmt->execute();
    }
}
?>