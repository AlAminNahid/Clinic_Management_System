<?php
session_start();
require_once '../Model/conn.php';
require_once '../Model/patientModel.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: ../home_page/login_reg_forget/index.php");
    exit();
}

$patient_id = $_SESSION['user_id'];
$patientModel = new PatientModel($conn);
$patient = $patientModel->getPatientById($patient_id);
$appointments = $patientModel->getPatientAppointments($patient_id);
$prescriptions = $patientModel->getPatientPrescriptions($patient_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard - Clinic Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Header -->
        <header class="dashboard-header">
            <div class="header-content">
                <h1>Patient Dashboard</h1>
                <div class="user-info">
                    <span>Welcome, <?php echo htmlspecialchars($patient['FullName']); ?></span>
                    <a href="../log_reg_forget/logout.php" class="logout-btn">Logout</a>
                </div>
            </div>
        </header>

        <!-- Navigation -->
        <nav class="dashboard-nav">
            <ul>
                <li><a href="#overview" class="nav-link active">Overview</a></li>
                <li><a href="#appointments" class="nav-link">My Appointments</a></li>
                <li><a href="#prescriptions" class="nav-link">Prescriptions</a></li>
                <li><a href="#profile" class="nav-link">Profile</a></li>
                <li><a href="#book-appointment" class="nav-link">Book Appointment</a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="dashboard-main">
            <!-- Overview Section -->
            <section id="overview" class="dashboard-section active">
                <h2>Dashboard Overview</h2>
                <div class="overview-cards">
                    <div class="card">
                        <h3>Upcoming Appointments</h3>
                        <p class="count"><?php echo count(array_filter($appointments, function($apt) {
                            return $apt['Status'] === 'Booked' || $apt['Status'] === 'Approved';
                        })); ?></p>
                    </div>
                    <div class="card">
                        <h3>Total Prescriptions</h3>
                        <p class="count"><?php echo count($prescriptions); ?></p>
                    </div>
                    <div class="card">
                        <h3>Recent Activity</h3>
                        <p>Last visit: <?php echo !empty($appointments) ? $appointments[0]['Date'] : 'No visits'; ?></p>
                    </div>
                </div>
            </section>

            <!-- Appointments Section -->
            <section id="appointments" class="dashboard-section">
                <h2>My Appointments</h2>
                <div class="appointments-list">
                    <?php if (empty($appointments)): ?>
                        <p class="no-data">No appointments found.</p>
                    <?php else: ?>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Doctor</th>
                                    <th>Status</th>
                                    <th>Reason</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($appointments as $appointment): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($appointment['Date']); ?></td>
                                        <td><?php echo htmlspecialchars($appointment['Time']); ?></td>
                                        <td><?php echo htmlspecialchars($appointment['DoctorName']); ?></td>
                                        <td>
                                            <span class="status-badge status-<?php echo strtolower($appointment['Status']); ?>">
                                                <?php echo htmlspecialchars($appointment['Status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($appointment['Reason']); ?></td>
                                        <td>
                                            <?php if ($appointment['Status'] === 'Booked'): ?>
                                                <button class="btn btn-cancel" onclick="cancelAppointment(<?php echo $appointment['AppointmentID']; ?>)">Cancel</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Prescriptions Section -->
            <section id="prescriptions" class="dashboard-section">
                <h2>My Prescriptions</h2>
                <div class="prescriptions-list">
                    <?php if (empty($prescriptions)): ?>
                        <p class="no-data">No prescriptions found.</p>
                    <?php else: ?>
                        <?php foreach ($prescriptions as $prescription): ?>
                            <div class="prescription-card">
                                <div class="prescription-header">
                                    <h3>Prescription #<?php echo $prescription['PrescriptionID']; ?></h3>
                                    <span class="date"><?php echo $prescription['Date']; ?></span>
                                </div>
                                <div class="prescription-details">
                                    <p><strong>Doctor:</strong> <?php echo htmlspecialchars($prescription['DoctorName']); ?></p>
                                    <p><strong>Medicine:</strong> <?php echo htmlspecialchars($prescription['MedicineName']); ?></p>
                                    <p><strong>Dosage:</strong> <?php echo htmlspecialchars($prescription['Dosage']); ?></p>
                                    <p><strong>Duration:</strong> <?php echo htmlspecialchars($prescription['Duration']); ?></p>
                                    <?php if (!empty($prescription['AdditionalNotes'])): ?>
                                        <p><strong>Notes:</strong> <?php echo htmlspecialchars($prescription['AdditionalNotes']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Profile Section -->
            <section id="profile" class="dashboard-section">
                <h2>My Profile</h2>
                <div class="profile-card">
                    <form id="profileForm" class="profile-form">
                        <div class="form-group">
                            <label for="fullName">Full Name</label>
                            <input type="text" id="fullName" name="fullName" value="<?php echo htmlspecialchars($patient['FullName']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="phoneNumber">Phone Number</label>
                            <input type="tel" id="phoneNumber" name="phoneNumber" value="<?php echo htmlspecialchars($patient['PhoneNumber']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($patient['Age']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender" required>
                                <option value="Male" <?php echo $patient['Gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo $patient['Gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                                <option value="Other" <?php echo $patient['Gender'] === 'Other' ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea id="address" name="address" rows="3" required><?php echo htmlspecialchars($patient['Address']); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </section>

            <!-- Book Appointment Section -->
            <section id="book-appointment" class="dashboard-section">
                <h2>Book New Appointment</h2>
                <div class="appointment-form-container">
                    <form id="appointmentForm" class="appointment-form">
                        <div class="form-group">
                            <label for="doctor">Select Doctor</label>
                            <select id="doctor" name="doctor" required>
                                <option value="">Choose a doctor...</option>
                                <?php
                                $doctors = $patientModel->getAllDoctors();
                                foreach ($doctors as $doctor): ?>
                                    <option value="<?php echo $doctor['DoctorID']; ?>">
                                        <?php echo htmlspecialchars($doctor['FullName'] . ' - ' . $doctor['Specialization'] . ' ($' . $doctor['VisitFee'] . ')'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="appointmentDate">Date</label>
                            <input type="date" id="appointmentDate" name="appointmentDate" required min="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="appointmentTime">Time</label>
                            <input type="time" id="appointmentTime" name="appointmentTime" required>
                        </div>
                        <div class="form-group">
                            <label for="reason">Reason for Visit</label>
                            <textarea id="reason" name="reason" rows="3" required placeholder="Describe your symptoms or reason for appointment..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Book Appointment</button>
                    </form>
                </div>
            </section>
        </main>
    </div>

    <script src="script.js"></script>
    <script src="validation.js"></script>
</body>
</html>
