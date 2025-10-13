<?php
session_start();
require_once "../../../Model/patientModel.php";

if (!isset($_SESSION['patient_id'])) {
    header("Location: ../../login.php");
    exit();
}

$patientId = $_SESSION['patient_id'];
$patientModel = new PatientModel();
$patient = $patientModel->getPatientById($patientId);
$doctors = $patientModel->getDoctors();

$success = $_GET['success'] ?? null;
$error = $_GET['error'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <script src="validation.js"></script>
</head>
<body>

<div class="dashboard">
   
    <div class="menu">
        <h2 class="menu-title">Patient Panel</h2>
        <button class="menu-btn active" data-target="dashboard">Dashboard</button>
        <button class="menu-btn" data-target="profile">My Profile</button>
        <button class="menu-btn" data-target="appointments">My Appointments</button>
        <button class="menu-btn" data-target="prescriptions">Prescriptions</button>
        <button class="menu-btn" id="logout-btn">Logout</button>
    </div>

    <div class="content">

        <div class="content-section active" id="dashboard">
            <div class="card">
                <h2>My Dashboard</h2>
                <div class="stats-grid">
                    <div class="stat-box pending">
                        <h3>Upcoming Appointments</h3>
                        <p id="upcoming-count">0</p>
                    </div>
                    <div class="stat-box completed">
                        <h3>Completed Appointments</h3>
                        <p id="completed-count">0</p>
                    </div>
                    <div class="stat-box prescriptions">
                        <h3>Prescriptions Received</h3>
                        <p id="prescriptions-count">0</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-section" id="profile">
            <div class="profile-form">
                <h3>My Profile</h3>
                
                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" value="<?php echo htmlspecialchars($patient['FullName'] ?? ''); ?>">

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($patient['Email'] ?? ''); ?>">

                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" placeholder="Enter your phone number" value="<?php echo htmlspecialchars($patient['PhoneNumber'] ?? ''); ?>">

                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" placeholder="Enter your age" value="<?php echo htmlspecialchars($patient['Age'] ?? ''); ?>">

                    <label for="gender">Gender</label>
                    <select id="gender" name="gender">
                        <option value="">-- Select Gender --</option>
                        <option value="Male" <?php if(($patient['Gender'] ?? '') == 'Male') echo 'selected'; ?>>Male</option>
                        <option value="Female" <?php if(($patient['Gender'] ?? '') == 'Female') echo 'selected'; ?>>Female</option>
                        <option value="Other" <?php if(($patient['Gender'] ?? '') == 'Other') echo 'selected'; ?>>Other</option>
                    </select>

                    <label for="address">Address</label>
                    <textarea id="address" name="address" placeholder="Enter your address"><?php echo htmlspecialchars($patient['Address'] ?? ''); ?></textarea>

                    <button type="submit" class="save-btn">Save Changes</button>

                    <?php if($success) echo "<p class='success'>$success</p>"; ?>
                    <?php if($error) echo "<p class='error'>$error</p>"; ?>
                
            </div>
        </div>

        <div class="content-section" id="appointments">
            <div class="appointment-form">
                <h3>Book Appointment</h3>
                    <label for="doctor">Select Doctor</label>
                    <select id="doctor" name="doctor_id">
                        <option value="">-- Select Doctor --</option>
                        <?php foreach ($doctors as $doc): ?>
                            <option value="<?php echo $doc['DoctorID']; ?>">
                                <?php echo htmlspecialchars($doc['FullName']) . " - " . htmlspecialchars($doc['Specialization']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label for="appointment-date">Appointment Date</label>
                    <input type="date" id="appointment-date" name="appointment_date">

                    <label for="reason">Reason for Appointment</label>
                    <textarea id="reason" name="reason" placeholder="Enter reason"></textarea>

                    <button type="submit" class="save-btn">Book Appointment</button>
            
            </div>

                <h2>My Appointments</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
               
              
                    </tbody>
                </table>
            </div>
       
        <div class="content-section" id="prescriptions">
          
                <h2>My Prescriptions</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Prescription ID</th>
                            <th>Doctor</th>
                            <th>Medicine</th>
                            <th>Dosage</th>
                            <th>Duration</th>
                            <th>Notes</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    </tbody>
                </table>
          
        </div>

    </div>
</div>

<script src="script.js"></script>
</body>
</html>
