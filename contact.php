<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us | Smart Quiz Platform</title>
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
      background: linear-gradient(135deg, #f5f7ff 0%, #eef1ff 100%);
      color: var(--dark);
      line-height: 1.6;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* Header Styles */
    header {
      background: white;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      padding: 15px 0;
      position: sticky;
      top: 0;
      z-index: 1000;
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

    /* Main Content */
    main {
      flex: 1;
      padding: 80px 20px;
      max-width: 1200px;
      margin: 0 auto;
      width: 100%;
    }

    /* Contact Hero */
    .contact-hero {
      text-align: center;
      margin-bottom: 60px;
      animation: fadeIn 1s ease-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .contact-hero h1 {
      font-size: 3.5rem;
      font-weight: 800;
      margin-bottom: 20px;
      background: linear-gradient(to right, var(--primary), var(--secondary));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 20px;
    }

    .contact-hero h1 i {
      font-size: 3rem;
      animation: bounce 2s infinite;
    }

    @keyframes bounce {
      0%, 100% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-10px);
      }
    }

    .contact-hero p {
      font-size: 1.3rem;
      color: var(--gray);
      max-width: 700px;
      margin: 0 auto;
    }

    /* Contact Container */
    .contact-container {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 60px;
      margin-bottom: 80px;
    }

    @media (max-width: 992px) {
      .contact-container {
        grid-template-columns: 1fr;
        gap: 40px;
      }
    }

    /* Contact Info */
    .contact-info {
      animation: slideInLeft 0.8s ease-out;
    }

    @keyframes slideInLeft {
      from {
        opacity: 0;
        transform: translateX(-50px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .contact-info h2 {
      font-size: 2.2rem;
      margin-bottom: 30px;
      color: var(--dark);
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .contact-info h2 i {
      color: var(--primary);
      font-size: 2rem;
    }

    .info-card {
      background: white;
      padding: 30px;
      border-radius: var(--border-radius);
      box-shadow: var(--card-shadow);
      margin-bottom: 30px;
      transition: var(--transition);
      border-left: 5px solid var(--primary);
    }

    .info-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow);
    }

    .info-card h3 {
      font-size: 1.3rem;
      margin-bottom: 15px;
      color: var(--dark);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .info-card h3 i {
      color: var(--primary);
      font-size: 1.2rem;
    }

    .info-card p {
      color: var(--gray);
      margin-bottom: 10px;
      font-size: 1.1rem;
    }

    .contact-methods {
      display: flex;
      flex-direction: column;
      gap: 20px;
      margin-top: 30px;
    }

    .contact-method {
      display: flex;
      align-items: center;
      gap: 15px;
      padding: 15px;
      background: white;
      border-radius: var(--border-radius);
      box-shadow: var(--card-shadow);
      transition: var(--transition);
      text-decoration: none;
      color: var(--dark);
    }

    .contact-method:hover {
      transform: translateX(10px);
      box-shadow: var(--shadow);
      background: var(--light);
    }

    .method-icon {
      width: 50px;
      height: 50px;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.3rem;
      flex-shrink: 0;
    }

    .method-content h4 {
      font-size: 1.1rem;
      margin-bottom: 5px;
      color: var(--dark);
    }

    .method-content p {
      color: var(--gray);
      font-size: 0.95rem;
    }

    /* Contact Form */
    .contact-form-section {
      animation: slideInRight 0.8s ease-out;
    }

    @keyframes slideInRight {
      from {
        opacity: 0;
        transform: translateX(50px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .contact-form-section h2 {
      font-size: 2.2rem;
      margin-bottom: 30px;
      color: var(--dark);
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .contact-form-section h2 i {
      color: var(--success);
      font-size: 2rem;
    }

    .contact-form {
      background: white;
      padding: 40px;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
    }

    .form-group {
      margin-bottom: 25px;
    }

    .form-group label {
      display: block;
      margin-bottom: 10px;
      font-weight: 600;
      color: var(--dark);
      font-size: 1rem;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .form-group label i {
      color: var(--primary);
      font-size: 1.1rem;
      width: 20px;
    }

    .input-with-icon {
      position: relative;
    }

    .input-with-icon i {
      position: absolute;
      left: 20px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--gray);
      font-size: 1.2rem;
      transition: var(--transition);
    }

    .input-with-icon input,
    .input-with-icon textarea {
      width: 100%;
      padding: 18px 20px 18px 60px;
      border: 2px solid var(--light-gray);
      border-radius: 12px;
      font-size: 1rem;
      font-family: 'Poppins', sans-serif;
      transition: var(--transition);
      background: var(--light);
      resize: vertical;
    }

    .input-with-icon textarea {
      min-height: 150px;
      padding-top: 20px;
      line-height: 1.6;
    }

    .input-with-icon input:focus,
    .input-with-icon textarea:focus {
      outline: none;
      border-color: var(--primary);
      background: white;
      box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
    }

    .input-with-icon input:focus + i,
    .input-with-icon textarea:focus + i {
      color: var(--primary);
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    @media (max-width: 576px) {
      .form-row {
        grid-template-columns: 1fr;
      }
    }

    .btn {
      padding: 18px 45px;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: white;
      border: none;
      border-radius: 12px;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      width: 100%;
      box-shadow: 0 6px 20px rgba(67, 97, 238, 0.3);
    }

    .btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(67, 97, 238, 0.4);
      background: linear-gradient(135deg, var(--primary-dark), var(--secondary));
    }

    .btn i {
      font-size: 1.2rem;
    }

    .btn.loading {
      position: relative;
      color: transparent;
    }

    .btn.loading:after {
      content: '';
      position: absolute;
      width: 24px;
      height: 24px;
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      border-top-color: white;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    /* FAQ Section */
    .faq-section {
      margin-top: 80px;
      animation: fadeIn 1s ease-out 0.5s both;
    }

    .faq-section h2 {
      font-size: 2.2rem;
      margin-bottom: 40px;
      color: var(--dark);
      text-align: center;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 15px;
    }

    .faq-section h2 i {
      color: var(--warning);
      font-size: 2rem;
    }

    .faq-container {
      max-width: 800px;
      margin: 0 auto;
    }

    .faq-item {
      background: white;
      margin-bottom: 15px;
      border-radius: var(--border-radius);
      box-shadow: var(--card-shadow);
      overflow: hidden;
      transition: var(--transition);
    }

    .faq-item:hover {
      box-shadow: var(--shadow);
    }

    .faq-question {
      padding: 25px;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: 600;
      color: var(--dark);
      font-size: 1.1rem;
      transition: var(--transition);
    }

    .faq-question:hover {
      background: var(--light);
    }

    .faq-question i {
      color: var(--primary);
      font-size: 1.2rem;
      transition: var(--transition);
    }

    .faq-item.active .faq-question i {
      transform: rotate(180deg);
    }

    .faq-answer {
      padding: 0 25px;
      max-height: 0;
      overflow: hidden;
      transition: all 0.3s ease;
      color: var(--gray);
      line-height: 1.7;
    }

    .faq-item.active .faq-answer {
      padding: 0 25px 25px;
      max-height: 500px;
    }

    /* Map Section */
    .map-section {
      margin-top: 80px;
      animation: fadeIn 1s ease-out 0.8s both;
    }

    .map-section h2 {
      font-size: 2.2rem;
      margin-bottom: 30px;
      color: var(--dark);
      text-align: center;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 15px;
    }

    .map-section h2 i {
      color: var(--danger);
      font-size: 2rem;
    }

    .map-container {
      background: white;
      padding: 30px;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
    }

    .map-placeholder {
      height: 300px;
      background: linear-gradient(135deg, var(--light), var(--light-gray));
      border-radius: var(--border-radius);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      color: var(--gray);
      font-size: 1.2rem;
    }

    .map-placeholder i {
      font-size: 4rem;
      margin-bottom: 20px;
      color: var(--primary);
      opacity: 0.5;
    }

    /* Footer */
    footer {
      background: var(--dark);
      color: white;
      padding: 60px 0 0;
      margin-top: auto;
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
      
      .contact-hero h1 {
        font-size: 2.5rem;
      }
      
      .contact-form {
        padding: 30px 20px;
      }
      
      .contact-info h2,
      .contact-form-section h2,
      .faq-section h2,
      .map-section h2 {
        font-size: 1.8rem;
      }
    }

    @media (max-width: 576px) {
      .contact-hero h1 {
        font-size: 2rem;
        flex-direction: column;
        gap: 10px;
      }
      
      .contact-hero h1 i {
        font-size: 2.5rem;
      }
      
      .contact-hero p {
        font-size: 1.1rem;
      }
      
      .info-card {
        padding: 20px;
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

    /* Success Message */
    .message-alert {
      padding: 20px;
      border-radius: 12px;
      margin-bottom: 30px;
      animation: slideDown 0.5s ease;
      display: flex;
      align-items: center;
      gap: 15px;
      display: none;
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .message-alert.success {
      background: linear-gradient(135deg, #d4edda, #c3e6cb);
      color: #155724;
      border-left: 5px solid var(--success);
    }

    .message-alert.error {
      background: linear-gradient(135deg, #f8d7da, #f5c6cb);
      color: #721c24;
      border-left: 5px solid var(--danger);
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
                <a href="about.php"><i class="fas fa-info-circle"></i> About</a>
                <a href="contact.php" class="active"><i class="fas fa-envelope"></i> Contact</a>
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

  <main>
    <!-- Contact Hero -->
    <section class="contact-hero">
      <h1>
        <i class="fas fa-headset"></i>
        Get in Touch
      </h1>
      <p>Have questions, feedback, or need support? We're here to help! Reach out to us and we'll get back to you as soon as possible.</p>
    </section>

    <!-- Contact Container -->
    <div class="contact-container">
      <!-- Contact Info -->
      <section class="contact-info">
        <h2><i class="fas fa-info-circle"></i> Contact Information</h2>
        
        <div class="info-card">
          <h3><i class="fas fa-map-marker-alt"></i> Our Location</h3>
          <p>123 Learning Street, Education City</p>
          <p>Knowledge District, 12345</p>
          <p>Smart Country</p>
        </div>

        <div class="info-card">
          <h3><i class="fas fa-clock"></i> Business Hours</h3>
          <p><strong>Monday - Friday:</strong> 9:00 AM - 6:00 PM</p>
          <p><strong>Saturday:</strong> 10:00 AM - 4:00 PM</p>
          <p><strong>Sunday:</strong> Closed</p>
        </div>

        <div class="contact-methods">
          <a href="mailto:support@smartquiz.com" class="contact-method">
            <div class="method-icon">
              <i class="fas fa-envelope"></i>
            </div>
            <div class="method-content">
              <h4>Email Us</h4>
              <p>support@smartquiz.com</p>
            </div>
          </a>

          <a href="tel:+1234567890" class="contact-method">
            <div class="method-icon">
              <i class="fas fa-phone"></i>
            </div>
            <div class="method-content">
              <h4>Call Us</h4>
              <p>+1 (234) 567-890</p>
            </div>
          </a>

          <a href="#" class="contact-method">
            <div class="method-icon">
              <i class="fas fa-comments"></i>
            </div>
            <div class="method-content">
              <h4>Live Chat</h4>
              <p>Available during business hours</p>
            </div>
          </a>
        </div>
      </section>

      <!-- Contact Form -->
      <section class="contact-form-section">
        <h2><i class="fas fa-paper-plane"></i> Send us a Message</h2>
        
        <!-- Success/Error Message -->
        <div class="message-alert success" id="successMessage" style="display: none;">
          <i class="fas fa-check-circle"></i>
          <div>Your message has been sent successfully! We'll get back to you soon.</div>
        </div>

        <div class="message-alert error" id="errorMessage" style="display: none;">
          <i class="fas fa-exclamation-circle"></i>
          <div>There was an error sending your message. Please try again.</div>
        </div>

        <form class="contact-form" id="contactForm">
          <div class="form-row">
            <div class="form-group">
              <label for="name"><i class="fas fa-user"></i> Your Name</label>
              <div class="input-with-icon">
                <i class="fas fa-user"></i>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required>
              </div>
            </div>

            <div class="form-group">
              <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
              <div class="input-with-icon">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="subject"><i class="fas fa-tag"></i> Subject</label>
            <div class="input-with-icon">
              <i class="fas fa-tag"></i>
              <input type="text" id="subject" name="subject" placeholder="What is this regarding?" required>
            </div>
          </div>

          <div class="form-group">
            <label for="message"><i class="fas fa-comment-dots"></i> Your Message</label>
            <div class="input-with-icon">
              <i class="fas fa-comment-dots"></i>
              <textarea id="message" name="message" placeholder="Please describe your inquiry in detail..." required></textarea>
            </div>
          </div>

          <button type="submit" class="btn" id="submitBtn">
            <i class="fas fa-paper-plane"></i>
            Send Message
          </button>
        </form>
      </section>
    </div>

    <!-- FAQ Section -->
    <section class="faq-section">
      <h2><i class="fas fa-question-circle"></i> Frequently Asked Questions</h2>
      
      <div class="faq-container">
        <div class="faq-item">
          <div class="faq-question">
            <span>How can I create a quiz?</span>
            <i class="fas fa-chevron-down"></i>
          </div>
          <div class="faq-answer">
            <p>To create a quiz, you need to have an admin account. Contact us to request admin access, and once approved, you can log in to the admin panel and use the "Add Quiz" feature to create new quizzes.</p>
          </div>
        </div>

        <div class="faq-item">
          <div class="faq-question">
            <span>Is Smart Quiz free to use?</span>
            <i class="fas fa-chevron-down"></i>
          </div>
          <div class="faq-answer">
            <p>Yes! Smart Quiz is completely free for all users. We believe in making quality education accessible to everyone without any cost barriers.</p>
          </div>
        </div>

        <div class="faq-item">
          <div class="faq-question">
            <span>How can I report an issue with a quiz?</span>
            <i class="fas fa-chevron-down"></i>
          </div>
          <div class="faq-answer">
            <p>If you encounter any issues with a quiz, please contact us using the form above. Include the quiz title, question number, and a description of the issue for faster resolution.</p>
          </div>
        </div>

        <div class="faq-item">
          <div class="faq-question">
            <span>Can I use Smart Quiz for my classroom?</span>
            <i class="fas fa-chevron-down"></i>
          </div>
          <div class="faq-answer">
            <p>Absolutely! Many educators use Smart Quiz for their classrooms. You can create custom quizzes for your students and track their progress through our admin dashboard.</p>
          </div>
        </div>

        <div class="faq-item">
          <div class="faq-question">
            <span>How do I reset my admin password?</span>
            <i class="fas fa-chevron-down"></i>
          </div>
          <div class="faq-answer">
            <p>If you've forgotten your admin password, please contact our support team at support@smartquiz.com with your registered email address, and we'll help you reset it.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
      <h2><i class="fas fa-map-marked-alt"></i> Find Us</h2>
      
      <div class="map-container">
        <div class="map-placeholder">
          <i class="fas fa-map"></i>
          <p>Interactive Map Location</p>
          <small>(Map integration available with Google Maps API)</small>
        </div>
      </div>
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
        <p>© 2025 Smart Quiz | Designed by S P Madhusanka</p>
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
        
        // FAQ Accordion
        const faqItems = document.querySelectorAll('.faq-item');
        
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            
            question.addEventListener('click', function() {
                // Close all other items
                faqItems.forEach(otherItem => {
                    if (otherItem !== item) {
                        otherItem.classList.remove('active');
                    }
                });
                
                // Toggle current item
                item.classList.toggle('active');
            });
        });
        
        // Form submission
        const contactForm = document.getElementById('contactForm');
        const submitBtn = document.getElementById('submitBtn');
        const successMessage = document.getElementById('successMessage');
        const errorMessage = document.getElementById('errorMessage');
        
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Basic validation
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const subject = document.getElementById('subject').value.trim();
            const message = document.getElementById('message').value.trim();
            
            if (!name || !email || !subject || !message) {
                showMessage('error', 'Please fill in all required fields.');
                return;
            }
            
            if (!isValidEmail(email)) {
                showMessage('error', 'Please enter a valid email address.');
                return;
            }
            
            // Show loading state
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            
            // Simulate form submission (replace with actual AJAX call)
            setTimeout(() => {
                // In a real application, you would send data to server here
                // For demo purposes, we'll simulate success
                
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
                
                // Show success message
                showMessage('success', 'Message sent successfully! We\'ll get back to you soon.');
                
                // Reset form
                contactForm.reset();
                
                // Scroll to success message
                successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 2000);
        });
        
        // Email validation
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
        
        // Show message function
        function showMessage(type, text) {
            // Hide both messages first
            successMessage.style.display = 'none';
            errorMessage.style.display = 'none';
            
            if (type === 'success') {
                successMessage.querySelector('div').textContent = text;
                successMessage.style.display = 'flex';
            } else {
                errorMessage.querySelector('div').textContent = text;
                errorMessage.style.display = 'flex';
            }
            
            // Auto-hide message after 5 seconds
            setTimeout(() => {
                if (type === 'success') {
                    successMessage.style.display = 'none';
                } else {
                    errorMessage.style.display = 'none';
                }
            }, 5000);
        }
        
        // Input focus effects
        const inputs = document.querySelectorAll('.input-with-icon input, .input-with-icon textarea');
        
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });
        
        // Contact method hover effects
        const contactMethods = document.querySelectorAll('.contact-method');
        
        contactMethods.forEach(method => {
            method.addEventListener('mouseenter', function() {
                const icon = this.querySelector('.method-icon');
                icon.style.transform = 'scale(1.1) rotate(5deg)';
            });
            
            method.addEventListener('mouseleave', function() {
                const icon = this.querySelector('.method-icon');
                icon.style.transform = 'scale(1) rotate(0deg)';
            });
        });
        
        // Scroll animations
        const sections = document.querySelectorAll('.contact-info, .contact-form-section, .faq-section, .map-section');
        
        function checkScroll() {
            sections.forEach(section => {
                const sectionTop = section.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;
                
                if (sectionTop < windowHeight - 100) {
                    section.style.opacity = '1';
                    section.style.transform = 'translateY(0)';
                }
            });
        }
        
        // Initialize sections with hidden state
        sections.forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(20px)';
            section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        });
        
        window.addEventListener('scroll', checkScroll);
        checkScroll(); // Initial check
        
        // Dynamic year in footer
        const yearSpan = document.querySelector('.footer-bottom p');
        if (yearSpan) {
            yearSpan.innerHTML = `© ${new Date().getFullYear()} Smart Quiz | Designed by Madini Dilrangi`;
        }
    });
  </script>
</body>
</html>