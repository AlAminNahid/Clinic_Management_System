<?php
session_start();
require_once '../../Model/conn.php';
require_once '../../Model/patientModel.php';

// Check if user is logged in as patient
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: ../../home_page/login_reg_forget/index.php");
    exit();
}

$patient_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard">
        <div class="menu">
            <h2 class="menu-title">Patient Panel</h2>
            <button class="menu-btn active" data-target="dashboard">Dashboard</button>
            <button class="menu-btn" data-target="profile">My Profile</button>
            <button class="menu-btn" data-target="appointments">My Appointments</button>
            <button class="menu-btn" data-target="prescriptions">My Prescriptions</button>
            <button class="menu-btn" data-target="book-appointment">Book Appointment</button>
            <button class="menu-btn" onclick="confirmLogout()">Logout</button>
        </div>
        <div class="content">
            <!-- Dashboard Section -->
            <div class="content-section active" id="dashboard">
                <div class="card">
                    <h2>Welcome Patient</h2>
                    <div class="stats-grid">
                        <div class="stat-box">
                            <h3>Upcoming Appointments</h3>
                            <p id="upcoming-appointments">0</p>
                        </div>
                        <div class="stat-box">
                            <h3>Total Prescriptions</h3>
                            <p id="total-prescriptions">0</p>
                        </div>
                        <div class="stat-box">
                            <h3>Total Appointments</h3>
                            <p id="total-appointments">0</p>
                        </div>
                        <div class="stat-box">
                            <h3>Last Visit</h3>
                            <p id="last-visit">No visits</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Section -->
            <div class="content-section" id="profile">
                <div class="card">
                    <h2>Patient Profile</h2>
                    <div class="profile-form">
                        <h3>Update your profile</h3>
                        <form id="profileForm" method="POST">
                            <label for="fullname">Full Name</label>
                            <input type="text" id="fullname" name="fullname" placeholder="Enter your full name">

                            <label for="phone">Phone Number</label>
                            <input type="text" id="phone" name="phone" placeholder="Enter your phone number">

                            <label for="age">Age</label>
                            <input type="number" id="age" name="age" placeholder="Enter your age">

                            <label for="gender">Gender</label>
                            <select id="gender" name="gender">
                                <option value="">Select gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>

                            <label for="address">Address</label>
                            <textarea id="address" name="address" placeholder="Enter your address" rows="3"></textarea>

                            <button type="submit" class="save-btn">Save Changes</button>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <h2>Profile Information</h2>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody id="patient-info">
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Appointments Section -->
            <div class="content-section" id="appointments">
                <div class="card">
                    <div class="card-header">
                        <h2>My Appointments</h2>
                        <div class="search-box">
                            <input type="text" id="search-appointments" placeholder="Search appointments...">
                            <button class="search-btn" onclick="searchAppointments()">Search</button>
                        </div>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Doctor</th>
                                <th>Specialization</th>
                                <th>Status</th>
                                <th>Reason</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="appointment-list">
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Prescriptions Section -->
            <div class="content-section" id="prescriptions">
                <div class="card">
                    <div class="card-header">
                        <h2>My Prescriptions</h2>
                    </div>
                    <div class="prescriptions-container" id="prescriptions-list">
                        <!-- Prescriptions will be loaded here -->
                    </div>
                </div>
            </div>

            <!-- Book Appointment Section -->
            <div class="content-section" id="book-appointment">
                <div class="card">
                    <div class="card-header">
                        <h2>Book New Appointment</h2>
                    </div>
                    <div class="appointment-form">
                        <form id="appointmentForm" method="POST">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="doctor">Select Doctor</label>
                                    <select id="doctor" name="doctor" required>
                                        <option value="">Choose a doctor...</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="appointment-date">Date</label>
                                    <input type="date" id="appointment-date" name="appointment-date" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="appointment-time">Time</label>
                                    <input type="time" id="appointment-time" name="appointment-time" required>
                                </div>
                                <div class="form-group">
                                    <label for="doctor-fee">Doctor's Fee</label>
                                    <input type="text" id="doctor-fee" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="reason">Reason for Visit</label>
                                <textarea id="reason" name="reason" placeholder="Describe your symptoms or reason for appointment..." rows="4" required></textarea>
                            </div>
                            <button type="submit" class="save-btn">Book Appointment</button>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <h2>Available Doctors</h2>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Specialization</th>
                                <th>Fee</th>
                                <th>Available Days</th>
                            </tr>
                        </thead>
                        <tbody id="doctors-list">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
    <script src="validation.js"></script>
</body>
</html>