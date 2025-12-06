<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us | Smart Quiz Platform</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    /* Variables & Base Styles */
    :root {
      --primary: #4361ee;
      --primary-dark: #3a0ca3;
      --secondary: #7209b7;
      --accent: #f72585;
      --success: #4cc9f0;
      --warning: #f8961e;
      --danger: #e63946;
      --light: #f8f9fa;
      --dark: #212529;
      --gray: #6c757d;
      --light-gray: #e9ecef;
      --transition: all 0.3s ease;
      --border-radius: 16px;
      --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      --card-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f9fafc;
      color: var(--dark);
      line-height: 1.6;
      overflow-x: hidden;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
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
      text-decoration: none;
      color: var(--dark);
    }

    .nav-menu a:hover {
      color: var(--primary);
    }

    .nav-menu a.active {
      color: var(--primary);
      font-weight: 600;
    }

    .nav-menu a.active::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 2px;
      background: var(--primary);
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
      border-radius: 50px;
      font-weight: 600;
      box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
      transition: var(--transition);
      text-decoration: none;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
    }

    /* Hero Section */
    .about-hero {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 100px 0;
      position: relative;
      overflow: hidden;
    }

    .about-hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="white"/></svg>');
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
      opacity: 0.1;
    }

    .hero-content {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 50px;
      align-items: center;
      position: relative;
      z-index: 1;
    }

    .hero-text h1 {
      font-size: 3.5rem;
      font-weight: 800;
      margin-bottom: 20px;
      line-height: 1.2;
    }

    .hero-icon {
      font-size: 3rem;
      margin-right: 15px;
      vertical-align: middle;
      animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }

    .hero-subtitle {
      font-size: 1.3rem;
      opacity: 0.9;
      margin-bottom: 30px;
      max-width: 600px;
    }

    .hero-image img {
      width: 100%;
      height: 400px;
      object-fit: cover;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      transform: perspective(1000px) rotateY(-10deg);
      transition: var(--transition);
    }

    .hero-image:hover img {
      transform: perspective(1000px) rotateY(0deg);
    }

    /* Main Content */
    .about-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 80px 20px;
    }

    /* Mission Section */
    .about-mission {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 60px;
      align-items: center;
      margin-bottom: 100px;
      animation: fadeIn 1s ease-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .mission-content h2 {
      font-size: 2.5rem;
      margin-bottom: 25px;
      color: var(--dark);
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .mission-content h2 i {
      color: var(--primary);
      font-size: 2rem;
    }

    .mission-content p {
      font-size: 1.1rem;
      color: var(--gray);
      line-height: 1.8;
      margin-bottom: 30px;
    }

    .mission-stats {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 30px;
      padding: 40px;
      background: white;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      position: relative;
      overflow: hidden;
    }

    .mission-stats::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(to right, var(--primary), var(--secondary));
    }

    .stat-item {
      text-align: center;
    }

    .stat-number {
      display: block;
      font-size: 3rem;
      font-weight: 800;
      color: var(--primary);
      line-height: 1;
      margin-bottom: 10px;
      background: linear-gradient(to right, var(--primary), var(--secondary));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }

    .stat-label {
      font-size: 1rem;
      color: var(--gray);
      font-weight: 500;
    }

    /* Features Section */
    .about-features {
      margin-bottom: 100px;
      text-align: center;
    }

    .about-features h2 {
      font-size: 2.5rem;
      margin-bottom: 50px;
      color: var(--dark);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 15px;
    }

    .about-features h2 i {
      color: var(--warning);
      font-size: 2rem;
    }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 30px;
    }

    .feature-card {
      background: white;
      padding: 40px 30px;
      border-radius: var(--border-radius);
      box-shadow: var(--card-shadow);
      transition: var(--transition);
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .feature-card:hover {
      transform: translateY(-10px);
      box-shadow: var(--shadow);
    }

    .feature-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(to right, var(--primary), var(--secondary));
      transform: scaleX(0);
      transform-origin: left;
      transition: var(--transition);
    }

    .feature-card:hover::before {
      transform: scaleX(1);
    }

    .feature-icon {
      width: 80px;
      height: 80px;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 25px;
      color: white;
      font-size: 2rem;
      transition: var(--transition);
    }

    .feature-card:hover .feature-icon {
      transform: rotateY(180deg) scale(1.1);
    }

    .feature-card h3 {
      font-size: 1.5rem;
      margin-bottom: 15px;
      color: var(--dark);
    }

    .feature-card p {
      color: var(--gray);
      line-height: 1.7;
    }

    /* Team Section */
    .about-team {
      margin-bottom: 100px;
      text-align: center;
    }

    .about-team h2 {
      font-size: 2.5rem;
      margin-bottom: 50px;
      color: var(--dark);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 15px;
    }

    .about-team h2 i {
      color: var(--accent);
      font-size: 2rem;
    }

    .team-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 40px;
    }

    .team-member {
      background: white;
      padding: 40px 30px;
      border-radius: var(--border-radius);
      box-shadow: var(--card-shadow);
      transition: var(--transition);
      position: relative;
      overflow: hidden;
    }

    .team-member:hover {
      transform: translateY(-10px);
      box-shadow: var(--shadow);
    }

    .team-member::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(to right, var(--primary), var(--secondary));
      transform: scaleX(0);
      transform-origin: left;
      transition: var(--transition);
    }

    .team-member:hover::after {
      transform: scaleX(1);
    }

    .member-avatar {
      width: 120px;
      height: 120px;
      background: linear-gradient(135deg, var(--light), var(--light-gray));
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 25px;
      color: var(--primary);
      font-size: 3rem;
      border: 5px solid white;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .team-member h3 {
      font-size: 1.5rem;
      margin-bottom: 10px;
      color: var(--dark);
    }

    .member-role {
      color: var(--primary);
      font-weight: 600;
      margin-bottom: 15px;
      font-size: 1.1rem;
    }

    .member-bio {
      color: var(--gray);
      line-height: 1.7;
    }

    /* Values Section */
    .about-values {
      margin-bottom: 100px;
    }

    .about-values h2 {
      font-size: 2.5rem;
      margin-bottom: 50px;
      color: var(--dark);
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .about-values h2 i {
      color: var(--danger);
      font-size: 2rem;
    }

    .values-content {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 40px;
    }

    .value-item {
      background: white;
      padding: 40px 30px;
      border-radius: var(--border-radius);
      box-shadow: var(--card-shadow);
      transition: var(--transition);
      position: relative;
      overflow: hidden;
    }

    .value-item:hover {
      transform: translateY(-10px);
      box-shadow: var(--shadow);
    }

    .value-item::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(to right, var(--success), var(--primary));
      transform: scaleX(0);
      transform-origin: left;
      transition: var(--transition);
    }

    .value-item:hover::before {
      transform: scaleX(1);
    }

    .value-header {
      display: flex;
      align-items: center;
      gap: 15px;
      margin-bottom: 20px;
    }

    .value-header i {
      font-size: 2.5rem;
      color: var(--success);
    }

    .value-header h3 {
      font-size: 1.5rem;
      color: var(--dark);
    }

    .value-item p {
      color: var(--gray);
      line-height: 1.7;
      padding-left: 55px;
    }

    /* CTA Section */
    .about-cta {
      background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
      color: white;
      padding: 80px 40px;
      border-radius: var(--border-radius);
      text-align: center;
      margin-bottom: 60px;
      position: relative;
      overflow: hidden;
    }

    .about-cta::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="white"/></svg>');
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
      opacity: 0.1;
    }

    .about-cta h2 {
      font-size: 2.5rem;
      margin-bottom: 20px;
      position: relative;
      z-index: 1;
    }

    .about-cta p {
      font-size: 1.2rem;
      opacity: 0.9;
      margin-bottom: 40px;
      max-width: 700px;
      margin-left: auto;
      margin-right: auto;
      position: relative;
      z-index: 1;
    }

    .cta-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 15px;
      padding: 18px 45px;
      background: white;
      color: var(--primary);
      border-radius: 50px;
      font-weight: 600;
      font-size: 1.2rem;
      text-decoration: none;
      transition: var(--transition);
      position: relative;
      z-index: 1;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .cta-btn:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
      background: var(--light);
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
      text-decoration: none;
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
      text-decoration: none;
      color: white;
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
      text-decoration: none;
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
      
      .hero-text h1 {
        font-size: 2.8rem;
      }
      
      .about-mission {
        grid-template-columns: 1fr;
        gap: 40px;
      }
      
      .mission-stats {
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        padding: 30px;
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
        font-size: 2.3rem;
      }
      
      .mission-stats {
        grid-template-columns: repeat(3, 1fr);
      }
      
      .stat-number {
        font-size: 2.5rem;
      }
    }

    @media (max-width: 576px) {
      .hero-text h1 {
        font-size: 2rem;
      }
      
      .hero-icon {
        font-size: 2.5rem;
      }
      
      .mission-stats {
        grid-template-columns: 1fr;
        gap: 30px;
      }
      
      .stat-item {
        text-align: center;
      }
      
      .about-cta {
        padding: 60px 20px;
      }
      
      .about-cta h2 {
        font-size: 2rem;
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
      
      .value-item p {
        padding-left: 0;
        margin-top: 15px;
      }
      
      .value-header {
        flex-direction: column;
        text-align: center;
        gap: 10px;
      }
    }

    /* Animations for scroll reveal */
    .reveal {
      opacity: 0;
      transform: translateY(30px);
      transition: all 0.8s ease;
    }

    .reveal.active {
      opacity: 1;
      transform: translateY(0);
    }
  </style>
</head>
<body>
    
    
    <!-- Header with Navigation -->
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
                <a href="about.php" class="active"><i class="fas fa-info-circle"></i> About</a>
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
  <section class="about-hero">
    <div class="hero-content">
        <div class="hero-text">
            <h1><span class="hero-icon">🎯</span> About Smart Quiz</h1>
            <p class="hero-subtitle">Empowering learners through interactive quizzes and engaging content. Join thousands of users who are transforming their learning experience.</p>
        </div>
        <div class="hero-image">
            <img src="https://images.unsplash.com/photo-1553877522-43269d4ea984?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Learning Illustration">
        </div>
    </div>
  </section>

  <main class="about-container">
    <!-- Mission Section -->
    <section class="about-mission reveal">
        <div class="mission-content">
            <h2><i class="fas fa-bullseye"></i> Our Mission</h2>
            <p>Smart Quiz is an interactive learning platform designed to make education enjoyable, accessible, and engaging. We believe that learning should be fun, and our platform transforms traditional quizzes into exciting challenges that help users expand their knowledge across various topics.</p>
            <p>Our goal is to create a comprehensive learning ecosystem where users can not only test their knowledge but also track their progress, compete with peers, and continuously improve their skills in a gamified environment.</p>
        </div>
        <div class="mission-image">
            <div class="mission-stats">
                <div class="stat-item">
                    <span class="stat-number">5000+</span>
                    <span class="stat-label">Active Users</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">200+</span>
                    <span class="stat-label">Quizzes</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">50+</span>
                    <span class="stat-label">Categories</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="about-features reveal">
        <h2><i class="fas fa-star"></i> Why Choose Smart Quiz?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-brain"></i>
                </div>
                <h3>Interactive Learning</h3>
                <p>Engage with dynamic quizzes that adapt to your learning pace and style for maximum knowledge retention. Our adaptive algorithms ensure personalized learning paths.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Progress Tracking</h3>
                <p>Monitor your improvement with detailed analytics and performance reports over time. Set goals and track your journey to mastery across different subjects.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Community Driven</h3>
                <p>Join a growing community of learners and educators who contribute to our expanding quiz database. Share knowledge and learn from peers worldwide.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3>Mobile Friendly</h3>
                <p>Access quizzes anytime, anywhere with our fully responsive design that works on all devices. Learn on-the-go with our mobile-optimized platform.</p>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="about-team reveal">
        <h2><i class="fas fa-users-cog"></i> Meet Our Team</h2>
        <div class="team-grid">
            <div class="team-member">
                <div class="member-avatar">
                    <i class="fas fa-user-tie"></i>
                </div>
                <h3>Madini Dilrangi</h3>
                <p class="member-role">Founder & Lead Developer</p>
                <p class="member-bio">Passionate about educational technology and creating engaging learning experiences. With over 8 years in ed-tech development.</p>
            </div>
            <div class="team-member">
                <div class="member-avatar">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h3>Sarah Johnson</h3>
                <p class="member-role">Content Curator</p>
                <p class="member-bio">Expert in curriculum development and educational content creation. Former university professor with 12+ years experience.</p>
            </div>
            <div class="team-member">
                <div class="member-avatar">
                    <i class="fas fa-user-cog"></i>
                </div>
                <h3>Alex Chen</h3>
                <p class="member-role">UX Designer</p>
                <p class="member-bio">Focuses on creating intuitive and accessible user interfaces for better learning experiences. Award-winning designer.</p>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="about-values reveal">
        <h2><i class="fas fa-heart"></i> Our Core Values</h2>
        <div class="values-content">
            <div class="value-item">
                <div class="value-header">
                    <i class="fas fa-lightbulb"></i>
                    <h3>Innovation</h3>
                </div>
                <p>Continuously improving our platform with the latest educational technologies and methodologies. We embrace change and seek creative solutions to learning challenges.</p>
            </div>
            <div class="value-item">
                <div class="value-header">
                    <i class="fas fa-handshake"></i>
                    <h3>Accessibility</h3>
                </div>
                <p>Making quality education accessible to everyone, regardless of location or background. We believe learning opportunities should be available to all.</p>
            </div>
            <div class="value-item">
                <div class="value-header">
                    <i class="fas fa-graduation-cap"></i>
                    <h3>Excellence</h3>
                </div>
                <p>Committed to providing high-quality, accurate, and engaging learning materials. We maintain rigorous standards for all educational content.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="about-cta reveal">
        <h2>Ready to Start Your Learning Journey?</h2>
        <p>Join thousands of learners who are already expanding their knowledge with Smart Quiz. Whether you're a student, professional, or lifelong learner, we have something for you.</p>
        <a href="index.php#quiz-section" class="cta-btn">
            <span>Explore Quizzes</span>
            <i class="fas fa-arrow-right"></i>
        </a>
    </section>
  </main>

  <footer>
    <div class="footer-content">
        <div class="footer-logo">
            <img src="images.jpeg" class="logo" alt="Quiz Logo">
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
        <p>© 2025 Smart Quiz </p>
    </div>
  </footer>

  <a href="#" class="scroll-top" id="scrollTop">
    <i class="fas fa-chevron-up"></i>
  </a>

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
                if (mobileMenuBtn) {
                    mobileMenuBtn.querySelector('i').classList.add('fa-bars');
                    mobileMenuBtn.querySelector('i').classList.remove('fa-times');
                }
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
        
        scrollTopBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Scroll reveal animation
        function reveal() {
            const reveals = document.querySelectorAll('.reveal');
            
            for (let i = 0; i < reveals.length; i++) {
                const windowHeight = window.innerHeight;
                const elementTop = reveals[i].getBoundingClientRect().top;
                const elementVisible = 150;
                
                if (elementTop < windowHeight - elementVisible) {
                    reveals[i].classList.add('active');
                } else {
                    reveals[i].classList.remove('active');
                }
            }
        }
        
        window.addEventListener('scroll', reveal);
        reveal(); // Initial check
        
        // Animate stats counter
        function animateStats() {
            const statNumbers = document.querySelectorAll('.stat-number');
            const statSection = document.querySelector('.about-mission');
            const sectionTop = statSection.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            
            if (sectionTop < windowHeight - 100) {
                statNumbers.forEach(stat => {
                    const target = parseInt(stat.textContent);
                    let current = 0;
                    const increment = target / 100;
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            stat.textContent = target + '+';
                            clearInterval(timer);
                        } else {
                            stat.textContent = Math.floor(current) + '+';
                        }
                    }, 20);
                });
                
                // Remove event listener after animation
                window.removeEventListener('scroll', animateStats);
            }
        }
        
        window.addEventListener('scroll', animateStats);
        
        // Hover animations for feature cards
        const featureCards = document.querySelectorAll('.feature-card');
        featureCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
        
        // Team member hover effect
        const teamMembers = document.querySelectorAll('.team-member');
        teamMembers.forEach(member => {
            member.addEventListener('mouseenter', function() {
                const avatar = this.querySelector('.member-avatar');
                avatar.style.transform = 'scale(1.1)';
                avatar.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.2)';
            });
            
            member.addEventListener('mouseleave', function() {
                const avatar = this.querySelector('.member-avatar');
                avatar.style.transform = 'scale(1)';
                avatar.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.1)';
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
        const yearSpan = document.querySelector('.footer-bottom p');
        if (yearSpan) {
            yearSpan.innerHTML = `© ${new Date().getFullYear()} Smart Quiz | Designed by Madini Dilrangi`;
        }
    });
  </script>
</body>
</html>