<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login | Clinic Management System</title>
        <link rel="stylesheet" href="./style.css">
        <script src="./verification.js"></script>
    </head>
    <body>
        <header>
            <div class="logo">Clinic Management System</div>
            <nav>
                <ul class="nav-list">
                    <li><a href="" class="nav-anchor">Contact</a></li>
                </ul>
            </nav>
        </header>
        <section class="login-section">
            <div class="login-box">
                <h2>Login</h2>
                <p class="subtitle">Welcome! Please Log-in to continue</p>
                <form action="../../../Controller/log_reg_forget/loginAction.php" method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password">
                    </div>
                    <div class="form-option">
                        <label>
                            <input type="checkbox" name="remember-me">Remember me
                        </label>
                        <a href="../forget_password/forgetpass.php">Forget Password</a>
                    </div>
                    <button type="SUBMIT" class="submit-button">Login</button>
                </form>
                <p class="signup-link">Don't have an account? <a href="../registration/reg.php">Register here</a></p>
            </div>
        </section>
        <footer>
            <p>Clinic Management System, &copy; 2025</p>
        </footer>
    </body>
</html>