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
    <!-- Sidebar Menu -->
    <div class="menu">
        <h2 class="menu-title">Patient Panel</h2>
        <button class="menu-btn active" data-target="dashboard">Dashboard</button>
        <button class="menu-btn" data-target="profile">My Profile</button>
        <button class="menu-btn" data-target="appointments">My Appointments</button>
        <button class="menu-btn" data-target="prescriptions">Prescriptions</button>
        <button class="menu-btn" id="logout-btn">Logout</button>
    </div>

    <!-- Main Content -->
    <div class="content">

        <!-- Dashboard Section -->
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

        <!-- Profile Section -->
        <div class="content-section" id="profile">
            <div class="profile-form">
                <h3>My Profile</h3>
                <form action="../../../Controller/dashboard/patient/patientProfileAction.php" method="POST">
                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" placeholder="Enter your full name">

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email">

                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" placeholder="Enter your phone number">

                    <label for="gender">Gender</label>
                    <select id="gender" name="gender">
                        <option value="">-- Select Gender --</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>

                    <label for="address">Address</label>
                    <textarea id="address" name="address" placeholder="Enter your address"></textarea>

                    <button type="submit" class="save-btn">Save Changes</button>
                </form>
            </div>
        </div>

        <!-- Appointments Section -->
        <div class="content-section" id="appointments">
            <div class="appointment-form">
                <h3>Book Appointment</h3>
                <form action="../../../Controller/dashboard/patient/bookAppointmentAction.php" method="POST">
                    <label for="doctor">Select Doctor</label>
                    <select id="doctor" name="doctor_id">
                        <option value="">-- Select Doctor --</option>
                        <!-- Dynamic doctors loaded from database -->
                    </select>

                    <label for="appointment-date">Appointment Date</label>
                    <input type="date" id="appointment-date" name="appointment_date">

                    <label for="reason">Reason for Appointment</label>
                    <textarea id="reason" name="reason" placeholder="Enter reason"></textarea>

                    <button type="submit" class="save-btn">Book Appointment</button>
                </form>
            </div>

            <!-- My Appointments Table -->
            <div class="card">
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
                    </thead>
                    <tbody id="appointment-list">
                        <!-- Dynamic appointment data -->
                        <!-- Example row:
                        <tr>
                            <td>Dr. Smith</td>
                            <td>2025-10-15</td>
                            <td>Fever</td>
                            <td>Upcoming</td>
                            <td><button class="cancel-btn">Cancel</button></td>
                        </tr>
                        -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Prescriptions Section -->
        <div class="content-section" id="prescriptions">
            <div class="card">
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
                    <tbody id="prescription-list">
                        <!-- Dynamic prescription data -->
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script src="script.js"></script>
</body>
</html>
