<?php
session_start();
if (!isset($_SESSION['PatientID']) || ($_SESSION['role'] ?? '') !== 'patient') {
    header("Location: ../../../login_reg_forget/login/login.php");
    exit;
}
$patientID = (int)$_SESSION['PatientID'];

// Get data from controller
$profile = $GLOBALS['profile'] ?? [];
$appointments = $GLOBALS['appointments'] ?? [];
$doctors = $GLOBALS['doctors'] ?? [];
$prescriptions = $GLOBALS['prescriptions'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Panel - Clinic Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrap">
        <!-- Sidebar Navigation -->
        <div class="sidebar">
            <div class="brand">Clinic — Patient Panel</div>
            <div class="nav">
                <a href="#" data-target="dashboard" onclick="showSection('dashboard')" class="active">Dashboard</a>
                <a href="#" data-target="profile" onclick="showSection('profile')">My Profile</a>
                <a href="#" data-target="appointments" onclick="showSection('appointments')">Appointments</a>
                <a href="#" data-target="prescriptions" onclick="showSection('prescriptions')">Prescriptions</a>
            </div>
            <div class="logout">
                <a class="btn" href="../../../Controller/log_reg_forget/logout.php">Logout</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main">
            <!-- Dashboard Section -->
            <div id="dashboard" class="section card active">
                <h2>Welcome, <?php echo htmlspecialchars($profile['FullName'] ?? 'Patient'); ?></h2>
                <p class="muted">This is your patient panel. Use the menu to manage your profile, appointments and prescriptions.</p>
                
                <div class="stats-container">
                    <div class="stat-card">
                        <strong>Upcoming Appointments</strong>
                        <div class="stat-number">
                            <?php
                                $countUpcoming = 0;
                                foreach ($appointments as $a) {
                                    if ($a['Date'] >= date('Y-m-d')) $countUpcoming++;
                                }
                                echo $countUpcoming;
                            ?>
                        </div>
                        <small class="muted">appointments scheduled</small>
                    </div>

                    <div class="stat-card">
                        <strong>Last Prescription</strong>
                        <div class="stat-info">
                            <?php if (count($prescriptions) > 0): ?>
                                <div class="doctor-name"><?php echo htmlspecialchars($prescriptions[0]['DoctorName']); ?></div>
                                <small class="muted"><?php echo htmlspecialchars($prescriptions[0]['Date']); ?></small>
                            <?php else: ?>
                                <div class="muted">No prescriptions yet</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Section -->
            <div id="profile" class="section card">
                <h2>My Profile</h2>
                <?php if (isset($_GET['profile_updated']) && $_GET['profile_updated']==1): ?>
                    <div class="success">Profile updated successfully.</div>
                <?php elseif (isset($_GET['profile_error'])): ?>
                    <div class="error"><?php echo htmlspecialchars($_GET['profile_error']); ?></div>
                <?php endif; ?>
                
                <form method="post" action="../../../Controller/patient/updateProfileAction.php">
                    <input type="hidden" name="PatientID" value="<?php echo $patientID; ?>">
                    <div class="row">
                        <div class="col">
                            <label>Full Name *</label>
                            <input type="text" name="FullName" value="<?php echo htmlspecialchars($profile['FullName'] ?? ''); ?>" required>
                            
                            <label>Email *</label>
                            <input type="email" name="Email" value="<?php echo htmlspecialchars($profile['Email'] ?? ''); ?>" required>
                            
                            <label>Phone Number</label>
                            <input type="text" name="PhoneNumber" value="<?php echo htmlspecialchars($profile['PhoneNumber'] ?? ''); ?>" placeholder="e.g., 01712345678">
                        </div>
                        <div class="col">
                            <label>Age</label>
                            <input type="number" name="Age" value="<?php echo htmlspecialchars($profile['Age'] ?? ''); ?>" min="1" max="120" placeholder="Your age">
                            
                            <label>Gender</label>
                            <select name="Gender">
                                <option value="">Select Gender</option>
                                <option value="Male" <?php echo (($profile['Gender'] ?? '') === 'Male') ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo (($profile['Gender'] ?? '') === 'Female') ? 'selected' : ''; ?>>Female</option>
                                <option value="Other" <?php echo (($profile['Gender'] ?? '') === 'Other') ? 'selected' : ''; ?>>Other</option>
                            </select>
                            
                            <label>Address</label>
                            <textarea name="Address" rows="3" placeholder="Your full address"><?php echo htmlspecialchars($profile['Address'] ?? ''); ?></textarea>
                            
                            <label>New Password <small class="muted">(leave blank to keep current)</small></label>
                            <input type="password" name="Password" autocomplete="new-password" placeholder="Minimum 6 characters">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="btn" type="submit">Update Profile</button>
                    </div>
                </form>
            </div>

            <!-- Appointments Section -->
            <div id="appointments" class="section card">
                <h2>Appointments</h2>
                <?php if (isset($_GET['appointment_success']) && $_GET['appointment_success']==1): ?>
                    <div class="success">Appointment booked successfully.</div>
                <?php elseif (isset($_GET['appointment_error'])): ?>
                    <div class="error"><?php echo htmlspecialchars($_GET['appointment_error']); ?></div>
                <?php endif; ?>

                <!-- Appointments List -->
                <div class="appointments-list">
                    <h3>Your Appointments</h3>
                    <?php if (count($appointments) === 0): ?>
                        <p class="muted">No appointments found.</p>
                    <?php else: ?>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Doctor</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($appointments as $appointment): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($appointment['DoctorName'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($appointment['Date']); ?></td>
                                        <td><?php echo htmlspecialchars($appointment['Time']); ?></td>
                                        <td><?php echo htmlspecialchars($appointment['Reason']); ?></td>
                                        <td>
                                            <span class="status-<?php echo strtolower($appointment['Status']); ?>">
                                                <?php echo htmlspecialchars($appointment['Status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>

                <!-- Book New Appointment -->
                <div class="book-appointment">
                    <h3>Book New Appointment</h3>
                    <form method="post" action="../../../Controller/patient/bookAppointmentAction.php" id="appointmentForm">
                        <input type="hidden" name="PatientID" value="<?php echo $patientID; ?>">
                        <div class="row">
                            <div class="col">
                                <label>Doctor *</label>
                                <select name="DoctorID" required>
                                    <option value="">Choose Doctor</option>
                                    <?php foreach($doctors as $doctor): ?>
                                        <option value="<?php echo $doctor['DoctorID']; ?>">
                                            <?php echo htmlspecialchars($doctor['FullName'] . ' - ' . $doctor['Specialization']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <label>Date *</label>
                                <input type="date" name="Date" required min="<?php echo date('Y-m-d'); ?>">

                                <label>Time *</label>
                                <input type="time" name="Time" required>
                            </div>
                            <div class="col">
                                <label>Reason for Appointment *</label>
                                <textarea name="Reason" placeholder="Please describe the reason for your appointment in detail..." required rows="5"></textarea>
                                <small class="muted">Minimum 10 characters required</small>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button class="btn" type="submit">Book Appointment</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Prescriptions Section -->
            <div id="prescriptions" class="section card">
                <h2>Prescriptions</h2>
                <?php if (count($prescriptions) === 0): ?>
                    <p class="muted">No prescriptions found.</p>
                <?php else: ?>
                    <div class="prescriptions-list">
                        <?php foreach($prescriptions as $prescription): ?>
                            <div class="prescription-card">
                                <div class="prescription-header">
                                    <div>
                                        <strong><?php echo htmlspecialchars($prescription['DoctorName']); ?></strong>
                                        <div class="muted">Date: <?php echo htmlspecialchars($prescription['Date']); ?></div>
                                    </div>
                                    <div class="prescription-id">
                                        <small class="muted">ID: <?php echo $prescription['PrescriptionID']; ?></small>
                                    </div>
                                </div>
                                
                                <div class="medicine-info">
                                    <table class="medicine-table">
                                        <thead>
                                            <tr>
                                                <th>Medicine</th>
                                                <th>Dosage</th>
                                                <th>Duration</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo htmlspecialchars($prescription['MedicineName'] ?? 'N/A'); ?></td>
                                                <td><?php echo htmlspecialchars($prescription['Dosage']); ?></td>
                                                <td><?php echo htmlspecialchars($prescription['Duration']); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <?php if (!empty($prescription['AdditionalNotes'])): ?>
                                    <div class="prescription-notes">
                                        <strong>Doctor's Notes:</strong>
                                        <p><?php echo nl2br(htmlspecialchars($prescription['AdditionalNotes'])); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- JavaScript Files -->
    <script src="script.js"></script>
    <script src="validation.js"></script>
</body>
</html>