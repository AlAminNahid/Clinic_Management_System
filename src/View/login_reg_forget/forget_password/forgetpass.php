<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reset Password | ClinicOS</title>
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
                <a class="nav-button" href="../login/login.php">Sign in</a>
            </nav>
        </header>

        <main class="auth-shell">
            <section class="auth-copy" aria-label="Password reset overview">
                <p class="eyebrow">Account recovery</p>
                <h1>Reset your password and return to your clinic workspace.</h1>
                <p>
                    Use the registered email for your ClinicOS account and choose a new password before signing in again.
                </p>
                <div class="value-list">
                    <div>
                        <strong>Keep access secure</strong>
                        <span>Use a password that is unique to your clinic account.</span>
                    </div>
                    <div>
                        <strong>Return quickly</strong>
                        <span>After resetting, sign in to continue managing appointments and records.</span>
                    </div>
                </div>
            </section>

            <section class="auth-card" aria-label="Reset password form">
                <span class="form-badge">Reset password</span>
                <h2>Forgot password?</h2>
                <p class="subtitle">Enter your registered email and a new password.</p>

                <form action="../../../Controller/log_reg_forget/forgetPasswordAction.php" method="POST">
                    <div class="form-message" data-form-message role="alert" aria-live="polite"></div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email">
                    </div>
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter new password">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password">
                    </div>
                    <button type="submit" class="submit-button">Reset password</button>
                </form>

                <p class="end-subtitle">Remember your password? <a href="../login/login.php">Go back to sign in</a></p>
            </section>
        </main>

        <footer class="site-footer">
            <span>ClinicOS</span>
            <p>&copy; 2026 Clinic Management SaaS. Built for modern healthcare teams.</p>
        </footer>
    </body>
</html>
