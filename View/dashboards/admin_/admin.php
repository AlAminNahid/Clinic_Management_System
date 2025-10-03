<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="style.css">
        <script src="script.js"></script>
    </head>

    <body>
        <div class="dashboard">
            <div class="menu">
                <h2 class="menu-title">Admin Panel</h2>
                    <button class="menu-button active" data-target="dashboard">Dashboard</button>
                    <button class="menu-button" data-target="profile">My Profile</button>
                    <button class="menu-button" data-target="doctors">Manage Doctors</button>
                    <button class="menu-button" data-target="patients">Manage Patients</button>
                    <button class="menu-button" data-target="appointments">appointments</button>
                    <button class="menu-button" data-target="medicines">Medicines</button>
                    <button class="menu-button" data-target="backup">Data Backup</button>
                    <button class="menu-button" data-target="logout">Logout</button>
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
                            <form action="" method="POST">
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
                 <div >

                 </div>
            </div>
        </div>
    </body>
</html>