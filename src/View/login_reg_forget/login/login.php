<?php
    session_start();

    if(isset($_SESSION['admin_id'])){
        header("Location: ../../dashboards/admin_/admin.php");
        exit();
    }

    $sessionExpired = isset($_GET['expired']) && $_GET['expired'] == 1;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign in | ClinicOS</title>
        <link rel="icon" type="image/svg+xml" href="../../assets/favicon.svg?v=20260618">
        <link rel="stylesheet" href="./style.css?v=20260618-saas">
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
                <a class="nav-button" href="../registration/reg.php">Start free</a>
            </nav>
        </header>

        <main class="auth-shell">
            <section class="auth-copy" aria-label="ClinicOS sign in overview">
                <p class="eyebrow">Welcome back</p>
                <h1>Sign in to manage appointments, prescriptions, and clinic operations.</h1>
                <div class="value-list">
                    <div>
                        <strong>Admin-ready</strong>
                        <span>Control doctors, patients, medicines, and daily clinic work.</span>
                    </div>
                    <div>
                        <strong>Doctor workflow</strong>
                        <span>Review appointments, patient history, and prescriptions in one place.</span>
                    </div>
                    <div>
                        <strong>Patient portal</strong>
                        <span>Keep bookings and prescription access simple for every patient.</span>
                    </div>
                </div>
            </section>

            <section class="auth-card" aria-label="Sign in form">
                <span class="form-badge">ClinicOS account</span>
                <h2>Sign in</h2>
                <p class="subtitle">Continue to your secure clinic workspace.</p>

                <form action="../../../Controller/log_reg_forget/loginAction.php" method="POST">
                    <div class="form-message <?php echo $sessionExpired ? 'is-visible' : ''; ?>" data-form-message role="alert" aria-live="polite">
                        <?php echo $sessionExpired ? 'Your session has expired. Please sign in again.' : ''; ?>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password">
                    </div>
                    <div class="form-option">
                        <label class="check-label">
                            <input type="checkbox" name="remember-me">
                            <span>Remember me</span>
                        </label>
                        <a href="../forget_password/forgetpass.php">Forgot password?</a>
                    </div>
                    <button type="submit" class="submit-button">Sign in</button>
                </form>

                <p class="signup-link">New to ClinicOS? <a href="../registration/reg.php">Create an account</a></p>
            </section>
        </main>

        <footer class="site-footer">
            <span>ClinicOS</span>
            <p>&copy; 2026 Clinic Management SaaS. Built for modern healthcare teams.</p>
        </footer>
    </body>
</html>
