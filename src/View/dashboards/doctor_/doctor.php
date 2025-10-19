<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="./style.css">
    <script src="./script.js"></script>
    </head>
<body>
    <div class="dashboard">
        <div class="menu" style="background-color: #4CAF50;"> <h2 class="menu-title">Doctor Panel</h2>
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
                            <p>12</p>
                        </div>
                        <div class="stat-box">
                            <h3>Approved Appointments</h3>
                            <p>8</p>
                        </div>
                        <div class="stat-box">
                            <h3>Completed Appointments</h3>
                            <p>5</p>
                        </div>
                    </div>
                    <h3 style="margin-top: 20px;">Upcoming Appointments</h3>
                    <table class="data-table">
                        <thead>
                            <tr style="background-color: #4CAF50; color: white;">
                                <th>Appointment ID</th>
                                <th>Patient</th>
                                <th>Date/Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#2001</td>
                                <td>Alex Johnson</td>
                                <td>2025-09-03 11:00 AM</td>
                                <td>Pending</td>
                                <td>
                                    <button class="action-btn approve-btn" style="background-color: #4CAF55;">Approve</button>
                                    <button class="action-btn cancel-btn" style="background-color: #F44336;">Cancel</button>
                                </td>
                            </tr>
                            <tr>
                                <td>#2002</td>
                                <td>Maria Gomez</td>
                                <td>2025-09-04 02:00 PM</td>
                                <td>Pending</td>
                                <td>
                                    <button class="action-btn approve-btn" style="background-color: #4CAF50;">Approve</button>
                                    <button class="action-btn cancel-btn" style="background-color: #F44336;">Cancel</button>
                                </td>
                            </tr>
                            </tbody>
                    </table>
                </div>
            </div>

            <div class="content-section" id="profile">
                <div class="card">
                    <!-- Doctor Profile Section -->
                    <h2>Doctor Profile</h2>
                    <div class="profile-form">
                        <h3>Update Your Profile</h3>
                        <form action="" method="POST">
                            <label for="fullname">Full Name</label>
                            <input type="text" id="fullname" name="fullname" value="Dr. John Smith" readonly>

                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" value="dr.john@example.com" readonly>

                            <label for="phone">Phone Number</label>
                            <input type="text" id="phone" name="phone" value="+880123456789">

                            <label for="specialization">Specialization</label>
                            <input type="text" id="specialization" name="specialization" value="Cardiologist">

                            <label for="visit-fee">Visit Fee ($)</label>
                            <input type="number" id="visit-fee" name="visit-fee" value="50">

                            <label for="password">Change Password</label>
                            <input type="password" id="password" name="password" placeholder="Enter new password">

                            <button type="submit" class="save-btn">Save Changes</button>
                        </form>
                    </div>

                    <!-- Manage Appointment Slots Section -->
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
                            <tbody>
                                <tr>
                                    <td>Monday</td>
                                    <td>10:00 AM</td>
                                    <td>12:00 PM</td>
                                    <td><button class="remove-slot-btn">Remove</button></td>
                                </tr>
                                <tr>
                                    <td>Tuesday</td>
                                    <td>01:00 PM</td>
                                    <td>03:00 PM</td>
                                    <td><button class="remove-slot-btn">Remove</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="content-section" id="patients">
                <div class="card">
                    <h2>My Patients</h2>
                    <table class="data-table">
                        <thead>
                            <tr style="background-color: #4CAF50; color: white;">
                                <th>Patient ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Medical History</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#P1001</td>
                                <td>Alex Johnson</td>
                                <td>alex@example.com</td>
                                <td>+880123456789</td>
                                <td>Diabetes</td>
                                <td>
                                    <button class="action-btn view-btn" style="background-color: #4CAF50;">View History</button>
                                    <button class="action-btn remove-btn" style="background-color: #F44336;">Remove</button>
                                </td>
                            </tr>
                            <tr>
                                <td>#P1002</td>
                                <td>Maria Gomez</td>
                                <td>maria@example.com</td>
                                <td>+880987654321</td>
                                <td>Hypertension</td>
                                <td>
                                    <button class="action-btn view-btn" style="background-color: #4CAF50;">View History</button>
                                    <button class="action-btn remove-btn" style="background-color: #F44336;">Remove</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="content-section" id="prescriptions">
                <div class="card">
                    <h2>Doctor Prescriptions</h2>
                    <div class="medicine-form">
                        <h3>Write Prescription</h3>
                        <form action="/Controller/doctor/savePrescriptionAction.php" method="POST">
                            <label for="select-patient">Select Patient</label>
                            <select id="select-patient" name="patient">
                                <option value="alex">Alex Johnson</option>
                                <option value="maria">Maria Gomez</option>
                            </select>

                            <label for="medicine-name">Medicine Name</label>
                            <input type="text" id="medicine-name" name="medicine-name" placeholder="Medicine Name">

                            <label for="dosage">Dosage</label>
                            <input type="text" id="dosage" name="dosage" placeholder="e.g. 1 tablet twice a day">

                            <label for="duration">Duration</label>
                            <input type="text" id="duration" name="duration" placeholder="e.g. 7 days">

                            <label for="notes">Additional Notes</label>
                            <input type="text" id="notes" name="notes" placeholder="Additional Notes">

                            <button type="submit" class="save-btn" style="background-color: #4CAF50;">Save Prescription</button>
                        </form>
                    </div>

                    <h3 style="margin-top: 30px;">Saved Prescriptions</h3>
                    <table class="data-table">
                        <thead>
                            <tr style="background-color: #4CAF50; color: white;">
                                <th>Patient</th>
                                <th>Medicine</th>
                                <th>Dosage</th>
                                <th>Duration</th>
                                <th>Notes</th>
                                </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Alex Johnson</td>
                                <td>Paracetamol</td>
                                <td>1 Tablet Twice Daily</td>
                                <td>5 days</td>
                                <td>After meals</td>
                            </tr>
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>