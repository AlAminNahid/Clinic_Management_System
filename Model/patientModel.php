<?php
require_once "conn.php";

class PatientModel {
    private $conn;

    public function __construct() {
        try {
            $this->conn = getConnection();
            if (!$this->conn) {
                throw new Exception("Database connection failed - getConnection() returned null");
            }
            
            // Test the connection
            if (!$this->conn->ping()) {
                throw new Exception("Database connection is not active");
            }
            
            error_log("PatientModel: Database connection established successfully");
            
        } catch (Exception $e) {
            error_log("PatientModel constructor error: " . $e->getMessage());
            throw new Exception("Failed to initialize PatientModel: " . $e->getMessage());
        }
    }

    public function getPatientById($patientId) {
        try {
            error_log("getPatientById: Fetching patient with ID: " . $patientId);
            
            if (empty($patientId)) {
                throw new Exception("Patient ID is empty");
            }
            
            $stmt = $this->conn->prepare("SELECT * FROM Patient WHERE PatientID = ?");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->conn->error);
            }
            
            $stmt->bind_param("i", $patientId);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            
            $result = $stmt->get_result();
            $patient = $result->fetch_assoc();
            
            error_log("getPatientById: Found " . ($patient ? 'patient data' : 'no patient'));
            return $patient;
            
        } catch (Exception $e) {
            error_log("Error in getPatientById: " . $e->getMessage());
            return false;
        }
    }

    public function updateProfile($patientId, $fullname, $phone, $age, $gender, $address) {
        try {
            error_log("updateProfile: Updating patient ID: " . $patientId);
            
            // Validate inputs
            if (empty($patientId) || empty($fullname) || empty($phone)) {
                throw new Exception("Required fields are missing");
            }
            
            $stmt = $this->conn->prepare("UPDATE Patient SET FullName=?, PhoneNumber=?, Age=?, Gender=?, Address=? WHERE PatientID=?");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->conn->error);
            }
            
            $stmt->bind_param("ssissi", $fullname, $phone, $age, $gender, $address, $patientId);
            $success = $stmt->execute();
            
            error_log("updateProfile: Update " . ($success ? "successful" : "failed"));
            return $success;
            
        } catch (Exception $e) {
            error_log("Error in updateProfile: " . $e->getMessage());
            return false;
        }
    }

    public function getUpcomingAppointmentsCount($patientId) {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM Appointment WHERE PatientID = ? AND Date >= CURDATE() AND Status IN ('Booked', 'Approved')");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->conn->error);
            }
            
            $stmt->bind_param("i", $patientId);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return $result['count'] ?? 0;
            
        } catch (Exception $e) {
            error_log("Error in getUpcomingAppointmentsCount: " . $e->getMessage());
            return 0;
        }
    }

    public function getTotalPrescriptionsCount($patientId) {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM Prescription WHERE PatientID = ?");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->conn->error);
            }
            
            $stmt->bind_param("i", $patientId);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return $result['count'] ?? 0;
            
        } catch (Exception $e) {
            error_log("Error in getTotalPrescriptionsCount: " . $e->getMessage());
            return 0;
        }
    }

    public function getTotalAppointmentsCount($patientId) {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM Appointment WHERE PatientID = ?");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->conn->error);
            }
            
            $stmt->bind_param("i", $patientId);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return $result['count'] ?? 0;
            
        } catch (Exception $e) {
            error_log("Error in getTotalAppointmentsCount: " . $e->getMessage());
            return 0;
        }
    }

    public function getLastVisit($patientId) {
        try {
            $stmt = $this->conn->prepare("SELECT Date FROM Appointment WHERE PatientID = ? AND Status = 'Completed' ORDER BY Date DESC LIMIT 1");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->conn->error);
            }
            
            $stmt->bind_param("i", $patientId);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return $result ? $result['Date'] : null;
            
        } catch (Exception $e) {
            error_log("Error in getLastVisit: " . $e->getMessage());
            return null;
        }
    }

    public function getPatientAppointments($patientId) {
        try {
            $stmt = $this->conn->prepare("SELECT a.*, d.FullName as DoctorName, d.Specialization 
                                         FROM Appointment a 
                                         JOIN Doctor d ON a.DoctorID = d.DoctorID 
                                         WHERE a.PatientID = ? 
                                         ORDER BY a.Date DESC, a.Time DESC");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->conn->error);
            }
            
            $stmt->bind_param("i", $patientId);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            
        } catch (Exception $e) {
            error_log("Error in getPatientAppointments: " . $e->getMessage());
            return [];
        }
    }

    public function getPatientPrescriptions($patientId) {
        try {
            $stmt = $this->conn->prepare("SELECT p.*, d.FullName as DoctorName, m.Name as MedicineName 
                                         FROM Prescription p 
                                         JOIN Doctor d ON p.DoctorID = d.DoctorID 
                                         JOIN Medicine m ON p.MedicineID = m.MedicineID 
                                         WHERE p.PatientID = ? 
                                         ORDER BY p.Date DESC");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->conn->error);
            }
            
            $stmt->bind_param("i", $patientId);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            
        } catch (Exception $e) {
            error_log("Error in getPatientPrescriptions: " . $e->getMessage());
            return [];
        }
    }

    public function getAvailableDoctors() {
        try {
            $result = $this->conn->query("SELECT * FROM Doctor WHERE Status = 'Active'");
            if (!$result) {
                throw new Exception("Query failed: " . $this->conn->error);
            }
            return $result->fetch_all(MYSQLI_ASSOC);
            
        } catch (Exception $e) {
            error_log("Error in getAvailableDoctors: " . $e->getMessage());
            return [];
        }
    }

    public function bookAppointment($patientId, $doctorId, $date, $time, $reason) {
        try {
            error_log("bookAppointment: Patient $patientId, Doctor $doctorId, Date $date, Time $time");
            
            // Validate inputs
            if (empty($patientId) || empty($doctorId) || empty($date) || empty($time) || empty($reason)) {
                throw new Exception("All appointment fields are required");
            }
            
            // Check if the time slot is available
            $checkStmt = $this->conn->prepare("SELECT AppointmentID FROM Appointment WHERE DoctorID = ? AND Date = ? AND Time = ? AND Status IN ('Booked', 'Approved')");
            if (!$checkStmt) {
                throw new Exception("Prepare failed for availability check: " . $this->conn->error);
            }
            
            $checkStmt->bind_param("iss", $doctorId, $date, $time);
            if (!$checkStmt->execute()) {
                throw new Exception("Execute failed for availability check: " . $checkStmt->error);
            }
            
            $checkResult = $checkStmt->get_result();
            if ($checkResult->num_rows > 0) {
                throw new Exception("This time slot is already booked. Please choose a different time.");
            }

            // Insert the appointment
            $stmt = $this->conn->prepare("INSERT INTO Appointment (PatientID, DoctorID, Date, Time, Reason, Status) VALUES (?, ?, ?, ?, ?, 'Booked')");
            if (!$stmt) {
                throw new Exception("Prepare failed for appointment insertion: " . $this->conn->error);
            }
            
            $stmt->bind_param("iisss", $patientId, $doctorId, $date, $time, $reason);
            $success = $stmt->execute();
            
            if ($success) {
                error_log("bookAppointment: Appointment booked successfully");
            } else {
                throw new Exception("Execute failed for appointment insertion: " . $stmt->error);
            }
            
            return $success;
            
        } catch (Exception $e) {
            error_log("Error in bookAppointment: " . $e->getMessage());
            throw $e;
        }
    }

    public function cancelAppointment($appointmentId, $patientId) {
        try {
            error_log("cancelAppointment: Cancelling appointment $appointmentId for patient $patientId");
            
            $stmt = $this->conn->prepare("UPDATE Appointment SET Status = 'Cancelled' WHERE AppointmentID = ? AND PatientID = ?");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->conn->error);
            }
            
            $stmt->bind_param("ii", $appointmentId, $patientId);
            $success = $stmt->execute();
            
            error_log("cancelAppointment: Cancellation " . ($success ? "successful" : "failed"));
            return $success;
            
        } catch (Exception $e) {
            error_log("Error in cancelAppointment: " . $e->getMessage());
            return false;
        }
    }

    // Add a method to check if tables exist (for debugging)
    public function checkTables() {
        try {
            $tables = ['Patient', 'Appointment', 'Doctor', 'Prescription', 'Medicine'];
            $existingTables = [];
            
            foreach ($tables as $table) {
                $result = $this->conn->query("SHOW TABLES LIKE '$table'");
                if ($result && $result->num_rows > 0) {
                    $existingTables[] = $table;
                }
            }
            
            error_log("Existing tables: " . implode(', ', $existingTables));
            return $existingTables;
            
        } catch (Exception $e) {
            error_log("Error checking tables: " . $e->getMessage());
            return [];
        }
    }

    // Close connection (optional, for cleanup)
    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>