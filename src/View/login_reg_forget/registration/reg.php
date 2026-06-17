<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register | ClinicOS</title>
        <link rel="stylesheet" href="./style.css?v=20260620-saas">
        <script src="./verification.js?v=20260618-inline-errors"></script>
    </head>
    <body>
        <header class="site-header">
            <a class="brand" href="../../home_page/home_page.php" aria-label="ClinicOS home">
                <span class="brand-mark">C</span>
                <span>ClinicOS</span>
            </a>

            <nav class="site-nav" aria-label="Primary navigation">
                <a href="../../home_page/home_page.php">Home</a>
                <a href="../../infoSection/about.php">About</a>
                <a href="../../infoSection/contact.php">Contact</a>
                <a class="nav-button" href="../login/login.php">Sign in</a>
            </nav>
        </header>

        <main class="auth-shell">
            <section class="auth-copy" aria-label="ClinicOS registration overview">
                <p class="eyebrow">Start your workspace</p>
                <h1>Create a SaaS-ready account for your clinic role.</h1>
                <p>
                    Register as an admin, doctor, or patient and connect the core clinic workflow from booking to prescription.
                </p>
                <div class="value-list">
                    <div>
                        <strong>One account system</strong>
                        <span>Role-based access for admins, doctors, and patients.</span>
                    </div>
                    <div>
                        <strong>Operational visibility</strong>
                        <span>Keep appointment, medicine, and prescription activity organized.</span>
                    </div>
                </div>
            </section>

            <section class="auth-card" aria-label="Registration form">
                <span class="form-badge">Create account</span>
                <h2>Register</h2>
                <p class="subtitle">Join ClinicOS as a patient, doctor, or admin.</p>

                <form action="../../../Controller/log_reg_forget/registerAction.php" method="POST">
                    <div class="form-message" data-form-message role="alert" aria-live="polite"></div>
                    <div class="form-grid">
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
                                <option value="" disabled selected>Select user type</option>
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
                    </div>
                    <button type="submit" class="submit-button">Create account</button>
                </form>

                <p class="end-subtitle">Already have an account? <a href="../login/login.php">Sign in</a></p>
            </section>
        </main>

        <footer class="site-footer">
            <span>ClinicOS</span>
            <p>&copy; 2026 Clinic Management SaaS. Built for modern healthcare teams.</p>
        </footer>
    </body>
</html>
