<?php
    session_start();

    $timeoutDuration = 60;

    if(!isset($_SESSION['admin_id'])){
        header("Location: ../../login_reg_forget/login/login.php");
        exit();
    }

    if(isset($_SESSION['lastActivity']) && (time() - $_SESSION['lastActivity']) > $timeoutDuration){
        session_unset();
        session_destroy();
        header("Location: ../../login_reg_forget/login/login.php?expired=1");
        exit();
    }

    $_SESSION['lastActivity'] = time();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Workspace | ClinicOS</title>
    <link rel="icon" type="image/svg+xml" href="../../assets/favicon.svg?v=20260618">
    <link rel="stylesheet" href="style.css?v=20260618-saas-admin">
    <script src="script.js?v=20260618-saas-admin"></script>
    <script src="validation.js?v=20260618-inline-errors"></script>
    <script src="edit_delete_update.js?v=20260618-saas-admin"></script>
</head>
<body>
    <div class="dashboard">
        <aside class="menu" aria-label="Admin navigation">
            <a class="brand" href="../../home_page/home_page.php" aria-label="ClinicOS home">
                <span class="brand-mark">C</span>
                <span>
                    <strong>ClinicOS</strong>
                    <small>Admin workspace</small>
                </span>
            </a>
            <div class="menu-group">
                <button class="menu-btn active" data-target="dashboard">Dashboard</button>
                <button class="menu-btn" data-target="profile">My Profile</button>
                <button class="menu-btn" data-target="doctors">Doctors</button>
                <button class="menu-btn" data-target="patients">Patients</button>
                <button class="menu-btn" data-target="appointments">Appointments</button>
                <button class="menu-btn" data-target="medicines">Medicines</button>
                <button class="menu-btn" data-target="backup">Data Backup</button>
            </div>
            <button class="menu-btn logout-btn" type="button" onclick="confirmLogout()">Logout</button>
        </aside>
        <div class="content">
            <header class="content-topbar">
                <div>
                    <p class="eyebrow">Clinic operations</p>
                    <h1>Admin workspace</h1>
                </div>
                <span class="status-pill">Live dashboard</span>
            </header>
            <div class="content-section active" id="dashboard">
                <div class="card hero-card">
                    <div>
                        <p class="eyebrow">Overview</p>
                        <h2 id="welcome-message">Welcome Admin</h2>
                        <p class="section-copy">Monitor users, appointments, medicines, and backups from one operational control center.</p>
                    </div>
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
                    <div class="card-header">
                        <div>
                            <p class="eyebrow">Account</p>
                            <h2>Admin Profile</h2>
                        </div>
                    </div>
                    <div class="profile-form">
                        <h3>Update your profile</h3>
                        <form action="../../../Controller/dashboard/admin/adminProfileAction.php" method="POST">
                            <div class="form-message" data-form-message role="alert" aria-live="polite"></div>
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
                        <div class="card-header">
                            <div>
                                <p class="eyebrow">Current record</p>
                                <h2>Admin Information</h2>
                            </div>
                        </div>
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
                        <div>
                            <p class="eyebrow">Care team</p>
                            <h2>Manage Doctors</h2>
                        </div>
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
                        <div>
                            <p class="eyebrow">Patient records</p>
                            <h2>Manage Patients</h2>
                        </div>
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
                        <div>
                            <p class="eyebrow">Schedule</p>
                            <h2>Manage Appointments</h2>
                        </div>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Appointment ID</th>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Date/Time</th>
                                <th>Reason</th>
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
                        <div>
                            <p class="eyebrow">Inventory</p>
                            <h2>Manage Medicines</h2>
                        </div>
                    </div>
                    <div class="medicine-form">
                        <h3>Add New Medicine</h3>
                        <form action="../../../Controller/dashboard/admin/addMedicineAction.php" method="POST">
                            <div class="form-message" data-form-message role="alert" aria-live="polite"></div>
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
                        <div>
                            <p class="eyebrow">System maintenance</p>
                            <h2>Data Backup</h2>
                        </div>
                        <button class="add-btn" onclick="createBackup()">Create New Backup</button>
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
