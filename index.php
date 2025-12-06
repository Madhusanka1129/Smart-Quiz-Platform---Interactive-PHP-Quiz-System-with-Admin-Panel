<?php
session_start();
include 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Quiz - Interactive Learning Platform</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Base Styles and Variables */
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
            --card-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
            --border-radius: 12px;
            --section-padding: 80px 20px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--dark);
            background-color: #f9fafc;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 24px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            gap: 8px;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(67, 97, 238, 0.4);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
            box-shadow: none;
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        .section-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-header h2 {
            font-size: 2.5rem;
            margin-bottom: 15px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: var(--gray);
            max-width: 600px;
            margin: 0 auto;
        }

        /* Header Styles */
        header {
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 15px 0;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .site-title {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--dark);
            cursor: pointer;
            padding: 5px;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .nav-menu a {
            font-weight: 500;
            position: relative;
            padding: 8px 0;
            transition: var(--transition);
        }

        .nav-menu a:hover {
            color: var(--primary);
        }

        .nav-menu a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: var(--transition);
        }

        .nav-menu a:hover::after {
            width: 100%;
        }

        .btn-login {
            padding: 10px 20px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border-radius: 10px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }

        /* Hero Section */
        .hero {
            padding: var(--section-padding);
            background: linear-gradient(135deg, #f5f7ff 0%, #eef1ff 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .hero-text h1 {
            font-size: 3rem;
            line-height: 1.2;
            margin-bottom: 20px;
            color: var(--dark);
        }

        .hero-icon {
            font-size: 3.5rem;
            margin-right: 10px;
            vertical-align: middle;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: var(--gray);
            margin-bottom: 30px;
            line-height: 1.7;
        }

        .hero-stats {
            display: flex;
            gap: 30px;
            margin: 30px 0;
        }

        .stat {
            text-align: center;
        }

        .stat-number {
            display: block;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
            line-height: 1;
        }

        .stat-label {
            font-size: 0.9rem;
            color: var(--gray);
            margin-top: 5px;
        }

        .hero-btn {
            padding: 15px 35px;
            font-size: 1.1rem;
        }

        .hero-image {
            position: relative;
            height: 400px;
        }

        .floating-element {
            position: absolute;
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            box-shadow: var(--card-shadow);
            animation: float 6s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            top: 10%;
            left: 10%;
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
            color: white;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            top: 50%;
            right: 15%;
            background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%);
            color: white;
            animation-delay: 2s;
        }

        .floating-element:nth-child(3) {
            bottom: 10%;
            left: 20%;
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            color: #e76f51;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        /* Quiz Section */
        .quiz-list {
            padding: var(--section-padding);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            text-align: left;
        }

        .add-quiz-btn {
            padding: 12px 25px;
            font-size: 1rem;
        }

        .quiz-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
        }

        .quiz-card {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            border-top: 5px solid var(--primary);
        }

        .quiz-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .quiz-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 20px 10px;
        }

        .quiz-category {
            padding: 6px 15px;
            border-radius: 50px;
            color: white;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .question-count {
            display: flex;
            align-items: center;
            gap: 5px;
            color: var(--gray);
            font-size: 0.9rem;
        }

        .quiz-card-body {
            padding: 15px 20px;
        }

        .quiz-card-body h3 {
            font-size: 1.4rem;
            margin-bottom: 10px;
            color: var(--dark);
        }

        .quiz-card-body p {
            color: var(--gray);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .quiz-card-footer {
            padding: 20px;
            border-top: 1px solid var(--light-gray);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .quiz-btn {
            padding: 10px 25px;
            font-size: 0.95rem;
        }

        .quiz-difficulty {
            font-size: 0.85rem;
            padding: 5px 12px;
            border-radius: 50px;
            background: var(--light-gray);
            font-weight: 600;
        }

        .no-quizzes {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
        }

        .no-quizzes i {
            font-size: 4rem;
            color: var(--light-gray);
            margin-bottom: 20px;
        }

        .no-quizzes h3 {
            font-size: 1.8rem;
            margin-bottom: 10px;
            color: var(--dark);
        }

        .no-quizzes p {
            color: var(--gray);
            font-size: 1.1rem;
        }

        /* Footer */
        footer {
            background: var(--dark);
            color: white;
            padding: 60px 0 0;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px 40px;
        }

        .footer-logo img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-bottom: 15px;
        }

        .footer-logo h2 {
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        .footer-logo p {
            color: #adb5bd;
        }

        .footer-links h3, .footer-social h3 {
            font-size: 1.3rem;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-links h3::after, .footer-social h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--primary);
        }

        .footer-links a {
            display: block;
            color: #adb5bd;
            margin-bottom: 12px;
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: white;
            padding-left: 5px;
        }

        .social-icons {
            display: flex;
            gap: 15px;
        }

        .social-icons a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            font-size: 1.2rem;
            transition: var(--transition);
        }

        .social-icons a:hover {
            background: var(--primary);
            transform: translateY(-5px);
        }

        .footer-bottom {
            text-align: center;
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #adb5bd;
            font-size: 0.9rem;
        }

        /* Scroll to Top Button */
        .scroll-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.4);
            z-index: 999;
        }

        .scroll-top.active {
            opacity: 1;
            visibility: visible;
        }

        .scroll-top:hover {
            background: var(--primary-dark);
            transform: translateY(-5px);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .hero-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            .hero-stats {
                justify-content: center;
            }
            
            .hero-image {
                height: 300px;
            }
            
            .section-header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
        }

        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }
            
            .nav-menu {
                position: fixed;
                top: 80px;
                left: 0;
                width: 100%;
                background: white;
                flex-direction: column;
                padding: 20px;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
                transform: translateY(-100%);
                opacity: 0;
                visibility: hidden;
                transition: var(--transition);
                z-index: 999;
            }
            
            .nav-menu.active {
                transform: translateY(0);
                opacity: 1;
                visibility: visible;
            }
            
            .hero-text h1 {
                font-size: 2.5rem;
            }
            
            .floating-element {
                width: 60px;
                height: 60px;
                font-size: 2rem;
            }
            
            .quiz-container {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }
        }

        @media (max-width: 576px) {
            .hero-stats {
                flex-direction: column;
                gap: 20px;
            }
            
            .stat-number {
                font-size: 2rem;
            }
            
            .quiz-container {
                grid-template-columns: 1fr;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            .footer-links h3::after, .footer-social h3::after {
                left: 50%;
                transform: translateX(-50%);
            }
            
            .social-icons {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <div class="logo-container">
                <h1 class="site-title">Smart Quiz</h1>
            </div>
            <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <nav class="nav-menu" id="navMenu">
                <a href="index.php"><i class="fas fa-home"></i> Home</a>
                <a href="about.php"><i class="fas fa-info-circle"></i> About</a>
                <a href="contact.php"><i class="fas fa-envelope"></i> Contact</a>
                <?php
                if (!isset($_SESSION['role'])) {
                    echo '<a href="admin_login.php" class="btn-login"><i class="fas fa-sign-in-alt"></i> Admin Login</a>';
                } else {
                    echo '<a href="logout.php" class="btn-login"><i class="fas fa-sign-out-alt"></i> Logout</a>';
                }
                ?>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1><span class="hero-icon"></span> Welcome to Smart Quiz</h1>
                <p class="hero-subtitle">Challenge yourself, expand your knowledge, and track your progress with our interactive quiz platform! Perfect for students, professionals, and lifelong learners.</p>
                <div class="hero-stats">
                    <div class="stat">
                        <span class="stat-number"><?php echo $conn->query("SELECT COUNT(*) as count FROM quizzes")->fetch_assoc()['count']; ?></span>
                        <span class="stat-label">Available Quizzes</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">10+</span>
                        <span class="stat-label">Categories</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">100+</span>
                        <span class="stat-label">Questions</span>
                    </div>
                </div>
                <a href="#quiz-section" class="btn hero-btn">
                    <span>Start Learning Now</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="hero-image">
                <div class="floating-element">
                    <i class="fas fa-brain"></i>
                </div>
                <div class="floating-element">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <div class="floating-element">
                    <i class="fas fa-trophy"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Quiz Section -->
    <section id="quiz-section" class="quiz-list">
        <div class="container">
            <div class="section-header">
                <div>
                    <h2>Available Quizzes</h2>
                    <p class="section-subtitle">Test your knowledge across various topics and track your progress</p>
                </div>
                <?php
                if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'){
                    echo '<a href="add_quiz.php" class="btn add-quiz-btn"><i class="fas fa-plus-circle"></i> Add New Quiz</a>';
                }
                ?>
            </div>
            
            <div class="quiz-container" id="quiz-container">
                <?php
                $result = $conn->query("SELECT * FROM quizzes");
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()) {
                        $quiz_id = $row['id'];
                        $question_count_result = $conn->query("SELECT COUNT(*) as count FROM questions WHERE quiz_id = $quiz_id");
                        $question_count = $question_count_result->fetch_assoc()['count'];
                        
                        $colors = ['#4361ee', '#3a0ca3', '#7209b7', '#f72585', '#4cc9f0'];
                        $color = $colors[$quiz_id % count($colors)];
                        
                        // Determine difficulty (this is a placeholder - you might want to add a difficulty field to your database)
                        $difficulty = ['Beginner', 'Intermediate', 'Advanced'][$quiz_id % 3];
                        $difficulty_class = ['Beginner' => 'success', 'Intermediate' => 'warning', 'Advanced' => 'danger'][$difficulty];
                        
                        echo "
                        <div class='quiz-card' style='border-top-color: $color;'>
                            <div class='quiz-card-header'>
                                <div class='quiz-category' style='background-color: $color;'>Quiz #{$row['id']}</div>
                                <div class='question-count'><i class='fas fa-question-circle'></i> {$question_count} Questions</div>
                            </div>
                            <div class='quiz-card-body'>
                                <h3>{$row['title']}</h3>
                                <p>{$row['description']}</p>
                            </div>
                            <div class='quiz-card-footer'>
                                <div class='quiz-difficulty' style='color: $color; border: 1px solid $color;'>
                                    {$difficulty}
                                </div>
                                <a href='quiz.php?id={$row['id']}' class='btn quiz-btn'>
                                    <span>Start Quiz</span>
                                    <i class='fas fa-play-circle'></i>
                                </a>
                            </div>
                        </div>";
                    }
                } else {
                    echo "
                    <div class='no-quizzes'>
                        <i class='fas fa-clipboard-list'></i>
                        <h3>No quizzes available yet.</h3>
                        <p>Check back soon or contact an admin to add quizzes.</p>
                        ".(!isset($_SESSION['role']) ? '<a href="admin_login.php" class="btn" style="margin-top: 20px;">Admin Login</a>' : '')."
                    </div>";
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-logo">
                <img src="images.jpeg" class="logo" alt="Smart Quiz Logo">
                <h2>Smart Quiz</h2>
                <p>Interactive Learning Platform</p>
            </div>
            <div class="footer-links">
                <h3>Quick Links</h3>
                <a href="index.php">Home</a>
                <a href="about.php">About</a>
                <a href="contact.php">Contact</a>
                <?php
                if (!isset($_SESSION['role'])) {
                    echo '<a href="admin_login.php">Admin Login</a>';
                } else {
                    echo '<a href="logout.php">Logout</a>';
                }
                ?>
            </div>
            <div class="footer-social">
                <h3>Follow Us</h3>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p> &copy; <?php echo date("Y"); ?> Smart Quiz | Designed by S. P Madhusanka</p>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <div class="scroll-top" id="scrollTop">
        <i class="fas fa-chevron-up"></i>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const navMenu = document.getElementById('navMenu');
            
            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function() {
                    navMenu.classList.toggle('active');
                    this.querySelector('i').classList.toggle('fa-bars');
                    this.querySelector('i').classList.toggle('fa-times');
                });
            }
            
            // Close mobile menu when clicking a link
            const navLinks = document.querySelectorAll('.nav-menu a');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    navMenu.classList.remove('active');
                    mobileMenuBtn.querySelector('i').classList.add('fa-bars');
                    mobileMenuBtn.querySelector('i').classList.remove('fa-times');
                });
            });
            
            // Scroll to top functionality
            const scrollTopBtn = document.getElementById('scrollTop');
            
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    scrollTopBtn.classList.add('active');
                } else {
                    scrollTopBtn.classList.remove('active');
                }
            });
            
            scrollTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
            
            // Quiz card hover effect enhancement
            const quizCards = document.querySelectorAll('.quiz-card');
            quizCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
            
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });
            
            // Dynamic year in footer
            document.querySelector('.footer-bottom p').innerHTML = `&copy; ${new Date().getFullYear()} Smart Quiz | Designed by S. P Madhusanka`;
        });
    </script>
</body>
</html>