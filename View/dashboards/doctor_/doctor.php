<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <script src="formValidation.js"></script>
</head>
<body>

<div class="dashboard">
    <!-- Sidebar Menu -->
    <div class="menu">
        <h2 class="menu-title">Doctor Panel</h2>
        <button class="menu-btn active" data-target="dashboard">Dashboard</button>
        <button class="menu-btn" data-target="profile">My Profile</button>
        <button class="menu-btn" data-target="patients">My Patients</button>
        <button class="menu-btn" data-target="prescription">Prescriptions</button>
        <button class="menu-btn" id="logout-btn">Logout</button>
    </div>

    <!-- Main Content -->
    <div class="content">

        <!-- Dashboard Section -->
        <div class="content-section active" id="dashboard">
            <div class="card">
                <h2>Appointments Overview</h2>
                <div class="stats-grid">
                    <div class="stat-box pending">
                        <h3>Pending Appointments</h3>
                        <p id="pending-appointments">0</p>
                    </div>
                    <div class="stat-box approved">
                        <h3>Approved Appointments</h3>
                        <p id="approved-appointments">0</p>
                    </div>
                    <div class="stat-box completed">
                        <h3>Completed Appointments</h3>
                        <p id="completed-appointments">0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Section -->
        <div class="content-section" id="profile">
            <div class="profile-form">
                <h3>My Profile</h3>
                <form action="../../../Controller/dashboard/doctor/doctorProfileAction.php" method="POST">
                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" placeholder="Enter your full name">

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email">

                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" placeholder="Enter phone number">

                    <label for="specialization">Specialization</label>
                    <input type="text" id="specialization" name="specialization" placeholder="Enter specialization">

                    <label for="visit-fee">Visit Fee</label>
                    <input type="text" id="visit-fee" name="visit_fee" placeholder="Enter visit fee">

                    <label for="password">Change Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter new password">

                    <h3>Manage Appointment Slots</h3>
                    <textarea id="slots" name="slots" placeholder="Enter available slots (e.g., Mon-Fri 10AM - 2PM)"></textarea>

                    <button type="submit" class="save-btn">Save Changes</button>
                </form>
            </div>
        </div>

        <!-- Patients Section -->
        <div class="content-section" id="patients">
            <div class="card">
                <h2>My Patients</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Contact</th>
                            <th>Appointment Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="patient-list">
                        <!-- Dynamic patient data -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Prescription Section -->
        <div class="content-section" id="prescription">
            <!-- Prescription Form -->
            <div class="medicine-form">
                <h3>Create Prescription</h3>
                <form action="../../../Controller/dashboard/doctor/addPrescriptionAction.php" method="POST">
                    <label for="patient-id">Select Patient</label>
                    <select id="patient-id" name="patient_id">
                        <option value="">-- Select Patient --</option>
                    </select>

                    <label for="medicine-name">Medicine Name</label>
                    <select id="medicine-name" name="medicine">
                        <option value="">-- Select Medicine --</option>
                    </select>

                    <label for="dosage">Dosage</label>
                    <input type="text" id="dosage" name="dosage" placeholder="e.g. 1 tablet twice a day">

                    <label for="duration">Duration</label>
                    <input type="text" id="duration" name="duration" placeholder="e.g. 5 days">

                    <label for="notes">Additional Notes</label>
                    <textarea id="notes" name="notes" placeholder="Enter any additional notes"></textarea>

                    <button type="submit" class="save-btn">Save Prescription</button>
                </form>
            </div>

            <!-- Saved Prescriptions Table -->
            <div class="card">
                <h2>Saved Prescriptions</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Prescription ID</th>
                            <th>Patient</th>
                            <th>Medicine</th>
                            <th>Dosage</th>
                            <th>Duration</th>
                            <th>Notes</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody id="prescription-list">
                        <!-- Dynamic prescriptions -->
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script src="script.js"></script>
</body>
</html>
