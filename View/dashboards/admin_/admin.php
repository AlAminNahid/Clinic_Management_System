<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js?"></script>
    <script src="adminProfileFormValidation.js"></script>
    <script src="adminMedicineFormValidation.js"></script>
    <script src="edit_delete_update.js"></script>
</head>
<body>
    <div class="dashboard">
        <div class="menu">
            <h2 class="menu-title">Admin Panel</h2>
            <button class="menu-btn active" data-target="dashboard">Dashboard</button>
            <button class="menu-btn" data-target="profile">My Profile</button>
            <button class="menu-btn" data-target="doctors">Manage Doctors</button>
            <button class="menu-btn" data-target="patients">Manage Patients</button>
            <button class="menu-btn" data-target="appointments">Appointments</button>
            <button class="menu-btn" data-target="medicines">Medicines</button>
            <button class="menu-btn" data-target="backup">Data Backup</button>
            <button class="menu-btn" onclick="confirmLogout()">Logout</button>
        </div>
        <div class="content">
            <div class="content-section active" id="dashboard">
                <div class="card">
                    <h2>Welcome Admin</h2>
                    <div class="stats-grid">
                        <div class="stat-box">
                            <h3>Total Doctors</h3>
                            <p id="total-doctors"></p>
                        </div>
                        <div class="stat-box">
                            <h3>Total Patients</h3>
                            <p id="total-patients"></p>
                        </div>
                        <div class="stat-box">
                            <h3>Appointments</h3>
                            <p id="total-appointments"></p>
                        </div>
                        <div class="stat-box">
                            <h3>Medicines</h3>
                            <p id="total-medicines"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-section" id="profile">
                <div class="card">
                    <h2>Admin Profile</h2>
                    <div class="profile-form">
                        <h3>Update your profile</h3>
                        <form action="../../../Controller/dashboard/admin/adminProfileAction.php" method="POST">
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
                <div class="card">
                        <h2>Admin Information </h2>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                </tr>
                            </thead>
                            <tbody id="admin-info">
                            </tbody>
                        </table>
                    </div>
            </div>
            <div class="content-section" id="doctors">
                <div class="card">
                    <div class="card-header">
                        <h2>Manage Doctors</h2>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Specialization</th>
                                <th>Fee</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="doctor-list">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="content-section" id="patients">
                <div class="card">
                    <div class="card-header">
                        <h2>Manage Patients</h2>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="patient-list">
                        </tbody>
                    </table>
                </div>
            </div>
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
                        <tbody id="appointment-list">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="content-section" id="medicines">
                <div class="card">
                    <div class="card-header">
                        <h2>Manage Medicines</h2>
                    </div>
                    <div class="medicine-form">
                        <h3>Add New Medicine</h3>
                        <form action="../../../Controller/dashboard/admin/addMedicineAction.php" method="POST">
                            <label for="medicine-name">Name</label>
                            <input type="text" id="medicine-name" name="name" placeholder="Enter medicine name">

                            <label for="medicine-type">Type</label>
                            <select name="type" id="medicine-type">
                                <option value="">Select type</option>
                                <option value="tablet">Tablet</option>
                                <option value="syrup">Syrup</option>
                            </select>

                            <label for="medicine-strength">Strength</label>
                            <input type="text" id="medicine-strength" name="strength" placeholder="Enter strength">

                            <label for="medicine-manufacturer">Manufacturer</label>
                            <input type="text" id="medicine-manufacturer" name="manufacturer" placeholder="Enter manufacturer">

                            <label for="medicine-status">Status</label>
                            <select name="status" id="medicine-status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>

                            <button type="submit" class="save-btn">Add Medicine</button>
                        </form>
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
                        <tbody id="medicine-list">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="content-section" id="backup">
                <div class="card">
                    <div class="card-header">
                        <h2>Data Backup</h2>
                        <button class="add-btn" onclick="createBackup()">+ Create New Backup</button>
                    </div>
                    <div class="card-body">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Backup ID</th>
                                    <th>File Name</th>
                                    <th>Data Created</th>
                                    <th>Created By</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody id="backup-list">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
