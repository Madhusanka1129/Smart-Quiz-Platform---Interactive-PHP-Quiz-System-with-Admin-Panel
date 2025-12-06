<?php
session_start();
include 'db_connect.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['user_id'] = $user['id'];

        if ($user['role'] === 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Smart Quiz Platform</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --secondary: #7209b7;
            --accent: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --light-gray: #e9ecef;
            --success: #4cc9f0;
            --warning: #f8961e;
            --danger: #e63946;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
            --border-radius: 12px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Background Animation */
        .bg-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 15s infinite linear;
        }

        .circle:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .circle:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .circle:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        .circle:nth-child(4) {
            width: 100px;
            height: 100px;
            top: 20%;
            right: 25%;
            animation-delay: 6s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            33% {
                transform: translateY(-20px) rotate(120deg);
            }
            66% {
                transform: translateY(20px) rotate(240deg);
            }
        }

        /* Login Container */
        .login-container {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 450px;
            padding: 40px;
            position: relative;
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
        }

        /* Logo and Header */
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }

        .login-header h1 {
            font-size: 1.8rem;
            color: var(--dark);
            margin-bottom: 8px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .login-header p {
            color: var(--gray);
            font-size: 0.95rem;
        }

        /* Form Styles */
        .login-form {
            margin-top: 30px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark);
            font-size: 0.95rem;
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            font-size: 1.1rem;
            transition: var(--transition);
        }

        .input-with-icon input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 2px solid var(--light-gray);
            border-radius: 10px;
            font-size: 1rem;
            transition: var(--transition);
            background: var(--light);
        }

        .input-with-icon input:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }

        .input-with-icon input:focus + i {
            color: var(--primary);
        }

        /* Error Message */
        .error {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
            animation: shake 0.5s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .error i {
            font-size: 1.2rem;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
            background: linear-gradient(135deg, var(--primary-dark), var(--secondary));
        }

        .btn-submit:active {
            transform: translateY(-1px);
        }

        /* Additional Options */
        .login-options {
            margin-top: 25px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid var(--light-gray);
        }

        .login-options a {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.95rem;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .login-options a:hover {
            color: var(--secondary);
            text-decoration: underline;
        }

        .login-options a i {
            font-size: 0.9rem;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--gray);
        }

        .remember-me input {
            width: 16px;
            height: 16px;
            accent-color: var(--primary);
        }

        .forgot-password {
            color: var(--primary);
            text-decoration: none;
            transition: var(--transition);
        }

        .forgot-password:hover {
            color: var(--secondary);
            text-decoration: underline;
        }

        /* Footer */
        .login-footer {
            text-align: center;
            margin-top: 30px;
            color: var(--gray);
            font-size: 0.9rem;
        }

        .login-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 576px) {
            .login-container {
                padding: 30px 25px;
                margin: 20px;
            }

            .login-header h1 {
                font-size: 1.6rem;
            }

            .input-with-icon input {
                padding: 14px 14px 14px 40px;
                font-size: 0.95rem;
            }

            .btn-submit {
                padding: 15px;
                font-size: 1rem;
            }

            .remember-forgot {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }

        @media (max-width: 400px) {
            .login-container {
                padding: 25px 20px;
            }

            .login-header h1 {
                font-size: 1.4rem;
            }

            .logo {
                width: 50px;
                height: 50px;
                font-size: 1.3rem;
            }
        }

        /* Loading Animation */
        .loading {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Password Visibility Toggle */
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray);
            cursor: pointer;
            font-size: 1.1rem;
            transition: var(--transition);
            z-index: 2;
        }

        .password-toggle:hover {
            color: var(--primary);
        }
    </style>
</head>
<body>
    <!-- Background Animation -->
    <div class="bg-animation">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>

    <!-- Login Container -->
    <div class="login-container">
        <!-- Header -->
        <div class="login-header">
            <div class="logo">
                <i class="fas fa-user-shield"></i>
            </div>
            <h1>Admin Login</h1>
            <p>Access the Smart Quiz administration panel</p>
        </div>

        <!-- Error Message -->
        <?php if ($error): ?>
            <div class="error">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form class="login-form" method="POST">
            <!-- Email Field -->
            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-with-icon">
                    <i class="fas fa-envelope"></i>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required 
                        placeholder="Enter your admin email"
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                    >
                </div>
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required 
                        placeholder="Enter your password"
                    >
                    <button type="button" class="password-toggle" id="passwordToggle">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="remember-forgot">
                <label class="remember-me">
                    <input type="checkbox" name="remember" id="remember">
                    Remember me
                </label>
                <a href="#" class="forgot-password">
                    <i class="fas fa-key"></i> Forgot password?
                </a>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit" id="submitBtn">
                <span>Login to Dashboard</span>
                <i class="fas fa-sign-in-alt"></i>
                <div class="loading" id="loadingSpinner"></div>
            </button>
        </form>

        <!-- Additional Options -->
        <div class="login-options">
            <a href="index.php">
                <i class="fas fa-arrow-left"></i>
                Back to Homepage
            </a>
        </div>

        <!-- Footer -->
        <div class="login-footer">
            <p>© <?php echo date('Y'); ?> Smart Quiz Platform. All rights reserved.</p>
            <p>Need help? <a href="contact.php">Contact Support</a></p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password visibility toggle
            const passwordToggle = document.getElementById('passwordToggle');
            const passwordInput = document.getElementById('password');
            
            if (passwordToggle) {
                passwordToggle.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    this.querySelector('i').classList.toggle('fa-eye');
                    this.querySelector('i').classList.toggle('fa-eye-slash');
                });
            }

            // Form submission with loading state
            const loginForm = document.querySelector('.login-form');
            const submitBtn = document.getElementById('submitBtn');
            const loadingSpinner = document.getElementById('loadingSpinner');
            
            if (loginForm) {
                loginForm.addEventListener('submit', function() {
                    // Show loading state
                    submitBtn.querySelector('span').style.display = 'none';
                    submitBtn.querySelector('i').style.display = 'none';
                    loadingSpinner.style.display = 'block';
                    submitBtn.disabled = true;
                });
            }

            // Auto-focus on email field
            const emailInput = document.getElementById('email');
            if (emailInput && !emailInput.value) {
                emailInput.focus();
            }

            // Add floating label effect
            const inputs = document.querySelectorAll('.input-with-icon input');
            inputs.forEach(input => {
                // Check if input has value on page load
                if (input.value) {
                    input.parentElement.classList.add('has-value');
                }
                
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                    if (this.value) {
                        this.parentElement.classList.add('has-value');
                    } else {
                        this.parentElement.classList.remove('has-value');
                    }
                });
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl+Enter to submit form
                if (e.ctrlKey && e.key === 'Enter') {
                    loginForm.submit();
                }
                
                // Escape to clear form
                if (e.key === 'Escape') {
                    if (document.activeElement.tagName === 'INPUT') {
                        document.activeElement.value = '';
                    }
                }
            });

            // Remember me functionality
            const rememberCheckbox = document.getElementById('remember');
            
            // Check if there's a saved email in localStorage
            const savedEmail = localStorage.getItem('adminEmail');
            if (savedEmail && emailInput) {
                emailInput.value = savedEmail;
                rememberCheckbox.checked = true;
            }
            
            // Save email when checkbox is checked and form is submitted
            if (loginForm) {
                loginForm.addEventListener('submit', function() {
                    if (rememberCheckbox.checked && emailInput.value) {
                        localStorage.setItem('adminEmail', emailInput.value);
                    } else {
                        localStorage.removeItem('adminEmail');
                    }
                });
            }
        });
    </script>
</body>
</html>