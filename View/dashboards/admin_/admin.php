<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="style.css">
        <script src="script.js"></script>
        <script src="validation.js"></script>
    </head>

    <body>
        <div class="dashboard">
            <div class="menu">
                <h2 class="menu-title">Admin Panel</h2>
                    <button class="menu-btn active" data-target="dashboard">Dashboard</button>
                    <button class="menu-btn" data-target="profile">My Profile</button>
                    <button class="menu-btn" data-target="doctors">Manage Doctors</button>
                    <button class="menu-btn" data-target="patients">Manage Patients</button>
                    <button class="menu-btn" data-target="appointments">appointments</button>
                    <button class="menu-btn" data-target="medicines">Medicines</button>
                    <button class="menu-btn" data-target="backup">Data Backup</button>
                    <button class="menu-btn" onclick="confirmLogout()">Logout</button>
            </div>

            <div class="content">
                <!-- dashboard -->
                <div class="content-section active" id="dashboard">
                    <div class="card">
                        <h2>Welcome Admin</h2>
                        <div class="stats-grid">
                            <div class="stat-box">
                                <h3>Total Doctors</h3>
                            </div>
                            <div class="stat-box">
                                <h3>Total Patients</h3>
                            </div>
                            <div class="stat-box">
                                <h3>Appointments</h3>
                            </div>
                            <div class="stat-box">
                                <h3>Medicines</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Profile -->
                <div class="content-section" id="profile">
                    <div class="card">
                        <h2>Admin Profile</h2>
                        <div class="profile-form">
                            <h3>Update your profile</h3>
                            <form action="../../../Controller/adminProfileAction.php" method="POST">
                                <label for="fullname">Full Name</label>
                                <input type="text" id="fullname" name="fullname" placeholder="Enter your full name">

                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" placeholder="Enter your email">

                                <label for="phone">Phone Number</label>
                                <input type="text" id="phone" name="phone" placeholder="Enter your phone number">

                                <label for="password">Change Password</label>
                                <input type="password" id="password" name="password" placeholder="Enter new password">

                                <button type="submit" class="save-btn">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Doctors -->
                <div class="content-section" id="doctors">
                    <div class="card">
                        <div class="card-header">
                            <h2>Manage Doctors</h2>
                            <button class="add-btn">+ Add Doctor</button>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Specialization</th>
                                    <th>Fee</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="doctor-list">
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <button class="edit-btn">Edit</button>
                                        <button class="delete-btn">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Patients -->
                <div class="content-section" id="patients">
                    <div class="card">
                        <div class="card-header">
                            <h2>Manage Patienst</h2>
                            <button class="add-btn">+ Add Patient</button>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Medical History</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="patient-list">
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <button class="edit-btn">Edit</button>
                                        <button class="delete-btn">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Appointments -->
                <div class="content-section" id="appointments">
                    <div class="card">
                        <div class="card-header">
                            <h2>Manage Appointments</h2>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Appointment ID</th>
                                    <th>Patient</th>
                                    <th>Doctor</th>
                                    <th>Date/Time</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <button class="approve-btn">Approve</button>
                                        <button class="reschedule-btn">Reschedule</button>
                                        <button class="delete-btn">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Medicines -->
                <div class="content-section" id="medicines">
                    <div class="card">
                        <div class="card-header">
                            <h2>Manage Medicines</h2>
                            <button class="add-btn">+ Add Medicines</button>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Strength</th>
                                    <th>Manufacturer</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <button class="toggle-btn deactivate-btn">Deactivate</button>
                                        <button class="delete-btn">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Data Backup -->
                <div class="content-section" id="backup">
                    <div class="card">
                        <div class="card-header">
                            <h2>Data Backup</h2>
                            <button class="add-btn">+ Create New Backup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>