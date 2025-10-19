<!DOCTYPE html>
<html>
    <head lang="en">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Forget Password | Clinic Management System</title>
        <link rel="stylesheet" href="./style.css">
        <script src="./verification.js"></script>
    </head>
    <body>
        <header>
            <div class="logo">Clinic Management System</div>
            <nav>
                <ul class="nav-ul">
                    <li class="nav-li"><a href="">Contact</a></li>
                </ul>
            </nav>
        </header>

        <section class="forget-pass-section">
            <div class="forget-pass-box">
                <h2>Forget Password</h2>
                <p class="subtitle">Enter your register email and new password.</p>
                <form action="../../../Controller/log_reg_forget/forgetPasswordAction.php" method="POST">
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
                    <button type="submit" class="submit-button">Reset Password</button>
                </form>
                <p class="end-subtitle">Remember your password? <a href="../login/login.php">Go back to login</a></p>
            </div>
        </section>

        <footer>
            <p>Clinic Management System &copy; 2025</p>
        </footer>
    </body>
</html>