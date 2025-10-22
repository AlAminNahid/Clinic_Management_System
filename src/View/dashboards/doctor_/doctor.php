<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="./style.css">
    <script src="./script.js"></script>
    <script src="./validation.js"></script>
    </head>
<body>
    <div class="dashboard">
        <div class="menu"> <h2 class="menu-title">Doctor Panel</h2>
            <button class="menu-btn" data-target="dashboard">Dashboard</button>
            <button class="menu-btn" data-target="profile">My Profile</button>
            <button class="menu-btn" data-target="patients">My Patients</button>
            <button class="menu-btn" data-target="prescriptions">Prescriptions</button>
            <button class="menu-btn" onclick="confirmLogout()">Logout</button>
        </div>

        <div class="content">
            <div class="content-section active" id="dashboard">
                <div class="card">
                    <h2 id="welcome-message">Welcome, Dr. John Smith</h2>
                    <div class="stats-grid">
                        <div class="stat-box">
                            <h3>Pending Appointments</h3>
                            <p id="pending-appointments"></p>
                        </div>
                        <div class="stat-box">
                            <h3>Approved Appointments</h3>
                            <p id="approved-appointments"></p>
                        </div>
                        <div class="stat-box">
                            <h3>Completed Appointments</h3>
                            <p id="completed-appointments"></p>
                        </div>
                    </div>

                    <h3 class="dashboard-headings">Upcoming Appointments</h3>
                    
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Appointment ID</th>
                                <th>Patient</th>
                                <th>Date/Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="upcomming-appointment-info">    
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="content-section" id="profile">
                <div class="card">
                    <h2>Doctor Profile</h2>
                    <div class="profile-form">
                        <h3>Update Your Profile</h3>
                        <form id="profile-form" action="" method="POST">
                            <label for="fullname">Full Name</label>
                            <input type="text" id="fullname" name="fullname" placeholder="Enter your full name">

                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" placeholder="Enter your email address">

                            <label for="phone">Phone Number</label>
                            <input type="text" id="phone" name="phone" placeholder="Enter your phone number">

                            <label for="specialization">Specialization</label>
                            <input type="text" id="specialization" name="specialization" placeholder="Enter your specialization">

                            <label for="visit-fee">Visit Fee ($)</label>
                            <input type="number" id="visit-fee" name="visit-fee" placeholder="Enter your visit fee in taka, ex: 1000">

                            <label for="password">Change Password</label>
                            <input type="password" id="password" name="password" placeholder="Enter new password">

                            <button type="submit" class="save-btn">Save Changes</button>
                        </form>
                    </div>

                    <div class="slot-card">
                        <h3>Manage Appointment Slots</h3>
                        <div class="slot-input">
                            <label>Start Time</label>
                            <input type="time" id="start-time">
                            <label>End Time</label>
                            <input type="time" id="end-time">
                            <label>Day</label>
                            <select id="day">
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                                <option value="Sunday">Sunday</option>
                            </select>
                            <button class="add-slot-btn">Add Slot</button>
                        </div>

                        <table class="slot-table">
                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="slot-table-info">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="content-section" id="patients">
                <div class="card">
                    <h2 style="margin-bottom: 10px;">My Patients</h2>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Patient ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Medical History</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="my-patient-info">
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="content-section" id="prescriptions">
                <div class="card">
                    <h2>Doctor Prescriptions</h2>
                    <div class="medicine-form">
                        <h3>Write Prescription</h3>
                        <form id="medicine-form" action="" method="POST">
                            <label for="select-patient">Select Patient</label>
                            <select id="select-patient" name="patient">
                            </select>

                            <label for="medicine-name">Medicine Name</label>
                            <input type="text" id="medicine-name" name="medicine-name" placeholder="Medicine Name">

                            <label for="dosage">Dosage</label>
                            <input type="text" id="dosage" name="dosage" placeholder="e.g. 1 tablet twice a day">

                            <label for="duration">Duration</label>
                            <input type="text" id="duration" name="duration" placeholder="e.g. 7 days">

                            <label for="notes">Additional Notes</label>
                            <textarea id="notes" name="notes" rows="4" cols="50" placeholder="Type here - "></textarea>

                            <button type="submit" class="save-btn" style="background-color: #4CAF50;">Save Prescription</button>
                        </form>
                    </div>

                    <h3 class="dashboard-headings">Saved Prescriptions</h3>

                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Medicine</th>
                                <th>Dosage</th>
                                <th>Duration</th>
                                <th>Notes</th>
                                </tr>
                        </thead>
                        <tbody id="saved-prescriptions-info">
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>