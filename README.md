# Smart Quiz Platform 🧠


A complete, responsive web-based quiz platform built with PHP, MySQL, and modern frontend technologies. This system features an interactive quiz-taking interface, a comprehensive admin panel for quiz management, and a professional design with smooth animations.

---

## 📋 Features

### 🎯 Quiz System
* **Interactive Interface:** Smooth animations and card-based layout.
* **Instant Scoring:** Real-time feedback on quiz submission.
* **Progress Tracking:** Visual indicators of quiz progress.
* **Performance Analysis:** Detailed reports on correct/incorrect answers.
* **Review Mode:** Ability to review incorrect answers for learning.

### 👨‍💼 Admin Panel
* **Dashboard:** User-friendly statistics and overview.
* **CRUD Operations:** Full management (Create, Read, Update, Delete) for quizzes and questions.
* **Bulk Management:** Efficiently manage question banks.
* **Security:** Secure authentication system with PHP sessions.

### 🎨 Modern Design & Layout
* **Responsive:** Mobile-first design optimized for mobile, tablet, and desktop.
* **UI/UX:** Gradient designs, shadows, and consistent typography (Poppins/Montserrat).
* **Touch Friendly:** Optimized controls for mobile users.

### 🔒 Security
* **SQL Injection Prevention:** Uses prepared statements for all database queries.
* **Authentication:** Session-based login with input sanitization.
* **CSRF Protection:** Ready for implementation.

---

## 🛠️ Technology Stack

* **Backend:** PHP 7+, MySQL
* **Frontend:** HTML5, CSS3, JavaScript (ES6+)
* **Styling:** Custom CSS with CSS3 variables
* **Icons:** Font Awesome 6.4.0
* **Fonts:** Google Fonts (Poppins, Montserrat)

---

## 📁 Project Structure

```text
smart-quiz-platform/
│
├── index.php              # Home page with quiz listings
├── admin_login.php        # Admin authentication
├── admin_dashboard.php    # Admin main panel
├── add_quiz.php           # Create new quizzes
├── add_question.php       # Add questions to quizzes
├── edit_quiz.php          # Edit existing quizzes
├── quiz.php               # Quiz taking interface
├── result.php             # Quiz results page
├── about.php              # About us page
├── contact.php            # Contact page
├── logout.php             # Session logout
├── delete_quiz.php        # Quiz deletion
│
├── db_connect.php         # Database connection configuration
│
├── css/                   # Stylesheets directory
│   ├── style.css          # Main stylesheet
│   └── about.css          # About page styles
│
├── js/                    # JavaScript files
│   ├── script.js          # Main JavaScript
│   └── index.js           # Home page JavaScript
│
├── images/                # Image assets
│   └── images.jpeg        # Logo/placeholder images
│
└── database.sql           # Database schema
