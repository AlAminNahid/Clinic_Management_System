<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register | Clinic Managemenet System</title>
        <link rel="stylesheet" href="./style.css">
        <script src="./verification.js"></script>
    </head>
    <body>
        <header>
            <div class="logo">Clinic Managemenet System</div>
            <nav class="reg-nav">
                <ul class="reg-nav-ul">
                    <li><a href="">Contact</a></li>
                </ul>
            </nav>
        </header>

        <section class="reg-section">
            <div class=reg-box>
                <h2>Create Account</h2>
                <p class="subtitle">Join our system as a Patient, Doctor</p>

                <form action="" class="reg-box">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your full name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" placeholder="Enter your phone number">
                    </div>
                    <div class="form-group">
                        <label for="user-type">Register As</label>
                        <select class="user-type" name="user-type" id="user-type">
                            <option value="" disable selected>Select user type</option>
                            <option value="admin">Admin</option>
                            <option value="patient">Patient</option>
                            <option value="doctor">Doctor</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter password">
                    </div>
                    <div class="form-group">
                        <label for="confirm-pass">Confirm Password</label>
                        <input type="password" id="confirm-pass" name="confirm-pass" placeholder="Re-enter password">
                    </div>
                    <button type="submit" class="submit-button">Submit</button>
                </form>
                <p class="end-subtitle">Already have an account? <a href="../login/login.php">Login here</a></p>
            </div>
        </section>

        <footer>
            <p>Clinic Managemenet System &copy; 2025</p>
        </footer>
    </body>
</html>