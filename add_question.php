<?php
session_start();
include 'db_connect.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header("Location: index.php");
    exit;
}

$quiz_id = $_GET['quiz_id'] ?? null;
if(!$quiz_id){
    echo "<p style='text-align:center; color:red;'>❌ No quiz selected.</p>";
    exit;
}

// Get quiz details for display
$quiz_query = $conn->prepare("SELECT title, description FROM quizzes WHERE id = ?");
$quiz_query->bind_param("i", $quiz_id);
$quiz_query->execute();
$quiz_result = $quiz_query->get_result();
$quiz_data = $quiz_result->fetch_assoc();
$quiz_title = $quiz_data['title'] ?? 'Unknown Quiz';
$quiz_description = $quiz_data['description'] ?? '';

$message = '';
$message_type = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $question_text = $_POST['question_text'];
    $answers = $_POST['answers'];
    $correct_answer = $_POST['correct_answer'];

    $stmt = $conn->prepare("INSERT INTO questions (quiz_id, question_text) VALUES (?, ?)");
    $stmt->bind_param("is", $quiz_id, $question_text);
    $stmt->execute();
    $question_id = $conn->insert_id;
    $stmt->close();

    foreach($answers as $index => $answer_text){
        $is_correct = ($correct_answer == $index + 1) ? 1 : 0;
        $stmt = $conn->prepare("INSERT INTO answers (question_id, answer_text, is_correct) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $question_id, $answer_text, $is_correct);
        $stmt->execute();
        $stmt->close();
    }

    $message = "✅ Question added successfully!";
    $message_type = 'success';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Questions | Admin Panel</title>
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
            --sidebar-width: 250px;
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
            min-height: 100vh;
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 30px 20px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: var(--transition);
            z-index: 100;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-logo {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .sidebar-title {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .sidebar-title span {
            font-size: 0.85rem;
            opacity: 0.8;
            display: block;
            font-weight: 400;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 10px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: 10px;
            transition: var(--transition);
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            transform: translateX(5px);
        }

        .sidebar-menu i {
            width: 20px;
            text-align: center;
            font-size: 1.2rem;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 30px;
            transition: var(--transition);
        }

        /* Top Header */
        .top-header {
            background: white;
            padding: 25px 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .page-title h1 {
            font-size: 1.8rem;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .page-title p {
            color: var(--gray);
            font-size: 0.95rem;
        }

        .title-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--gray);
            font-size: 0.9rem;
        }

        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
            transition: var(--transition);
        }

        .breadcrumb a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .breadcrumb i {
            font-size: 0.8rem;
            opacity: 0.7;
        }

        /* Quiz Info Banner */
        .quiz-info-banner {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: var(--border-radius);
            padding: 25px 30px;
            margin-bottom: 30px;
            color: white;
            display: flex;
            align-items: center;
            gap: 20px;
            animation: slideIn 0.6s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .quiz-info-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
        }

        .quiz-info-content h3 {
            font-size: 1.5rem;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .quiz-info-content p {
            opacity: 0.9;
            font-size: 0.95rem;
        }

        /* Progress Steps */
        .progress-steps {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 40px;
            margin-bottom: 40px;
            position: relative;
        }

        .progress-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            position: relative;
            z-index: 2;
        }

        .step-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--light-gray);
            color: var(--gray);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.2rem;
            transition: var(--transition);
            border: 3px solid white;
            box-shadow: var(--card-shadow);
        }

        .progress-step.active .step-circle {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            transform: scale(1.1);
        }

        .progress-step.completed .step-circle {
            background: linear-gradient(135deg, var(--success), #28b87a);
            color: white;
        }

        .step-label {
            font-size: 0.9rem;
            color: var(--gray);
            font-weight: 500;
            text-align: center;
        }

        .progress-step.active .step-label {
            color: var(--primary);
            font-weight: 600;
        }

        .progress-line {
            position: absolute;
            top: 25px;
            left: 80px;
            right: 80px;
            height: 3px;
            background: var(--light-gray);
            z-index: 1;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(to right, var(--primary), var(--success));
            width: 33.33%;
            border-radius: 3px;
            transition: var(--transition);
        }

        /* Form Container */
        .form-container {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-header {
            padding: 30px;
            background: linear-gradient(135deg, #f8f9ff 0%, #eef1ff 100%);
            border-bottom: 1px solid var(--light-gray);
        }

        .form-header h2 {
            font-size: 1.5rem;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .form-header p {
            color: var(--gray);
            margin-top: 10px;
            font-size: 0.95rem;
        }

        /* Message Alert */
        .message-alert {
            margin: 20px 30px;
            padding: 20px;
            border-radius: 12px;
            animation: slideDown 0.5s ease;
            display: flex;
            align-items: center;
            gap: 15px;
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

        /* Form Content */
        .form-content {
            padding: 40px;
        }

        .form-section {
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 1.2rem;
            color: var(--dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light-gray);
        }

        /* Question Input */
        .question-input {
            position: relative;
        }

        .question-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: var(--dark);
            font-size: 1rem;
        }

        .label-hint {
            font-size: 0.85rem;
            color: var(--gray);
            font-weight: 400;
            margin-left: 5px;
        }

        .question-textarea {
            width: 100%;
            min-height: 150px;
            padding: 20px;
            border: 2px solid var(--light-gray);
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            transition: var(--transition);
            background: var(--light);
            resize: vertical;
        }

        .question-textarea:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
        }

        /* Answer Options */
        .answer-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .answer-option {
            position: relative;
            transition: var(--transition);
        }

        .answer-input-group {
            position: relative;
        }

        .answer-number {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1rem;
            z-index: 2;
            transition: var(--transition);
            border: 2px solid white;
        }

        .answer-input {
            width: 100%;
            padding: 18px 20px 18px 65px;
            border: 2px solid var(--light-gray);
            border-radius: 12px;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
            transition: var(--transition);
            background: var(--light);
        }

        .answer-input:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
        }

        .answer-option.correct .answer-input {
            border-color: var(--success);
            background: linear-gradient(135deg, rgba(76, 201, 240, 0.1), rgba(40, 184, 122, 0.1));
        }

        .answer-option.correct .answer-number {
            background: linear-gradient(135deg, var(--success), #28b87a);
        }

        /* Correct Answer Selector */
        .correct-answer-selector {
            background: linear-gradient(135deg, #f8f9ff 0%, #eef1ff 100%);
            border-radius: var(--border-radius);
            padding: 25px;
            margin-top: 30px;
            border: 2px dashed var(--light-gray);
        }

        .selector-title {
            font-size: 1.1rem;
            color: var(--dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .selector-title i {
            color: var(--success);
            font-size: 1.3rem;
        }

        .answer-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .answer-btn {
            flex: 1;
            min-width: 120px;
        }

        .answer-btn input[type="radio"] {
            display: none;
        }

        .answer-btn label {
            display: block;
            padding: 15px 25px;
            background: white;
            border: 2px solid var(--light-gray);
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 500;
            color: var(--dark);
            position: relative;
            overflow: hidden;
        }

        .answer-btn label:hover {
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .answer-btn input[type="radio"]:checked + label {
            background: linear-gradient(135deg, var(--success), #28b87a);
            color: white;
            border-color: var(--success);
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(76, 201, 240, 0.3);
        }

        .answer-btn label:after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }

        .answer-btn input[type="radio"]:checked + label:after {
            animation: ripple 1s ease-out;
        }

        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }
            100% {
                transform: scale(30, 30);
                opacity: 0;
            }
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 50px;
            padding-top: 30px;
            border-top: 1px solid var(--light-gray);
        }

        .btn {
            padding: 16px 35px;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            border: none;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: 0 6px 20px rgba(67, 97, 238, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(67, 97, 238, 0.4);
            background: linear-gradient(135deg, var(--primary-dark), var(--secondary));
        }

        .btn-secondary {
            background: var(--light-gray);
            color: var(--dark);
            box-shadow: none;
        }

        .btn-secondary:hover {
            background: #dee2e6;
            transform: translateY(-2px);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success), #28b87a);
            color: white;
            box-shadow: 0 6px 20px rgba(76, 201, 240, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(76, 201, 240, 0.4);
        }

        /* Tips Section */
        .tips-section {
            background: linear-gradient(135deg, #fff8e1 0%, #fff3cd 100%);
            border-radius: var(--border-radius);
            padding: 25px;
            margin-top: 40px;
            border-left: 5px solid var(--warning);
        }

        .tips-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            color: var(--dark);
            font-size: 1.1rem;
        }

        .tips-list {
            list-style: none;
            padding-left: 5px;
        }

        .tips-list li {
            margin-bottom: 10px;
            padding-left: 25px;
            position: relative;
            color: var(--gray);
        }

        .tips-list li:before {
            content: '✓';
            position: absolute;
            left: 0;
            color: var(--warning);
            font-weight: bold;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .mobile-menu-btn {
                display: block;
            }

            .top-header {
                flex-direction: column;
                gap: 20px;
                align-items: flex-start;
            }

            .page-title {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .title-icon {
                width: 50px;
                height: 50px;
                font-size: 1.5rem;
            }

            .quiz-info-banner {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .progress-steps {
                gap: 20px;
            }

            .progress-line {
                left: 50px;
                right: 50px;
            }
        }

        @media (max-width: 768px) {
            .form-content {
                padding: 30px 20px;
            }

            .answer-options {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
                gap: 20px;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .answer-buttons {
                flex-direction: column;
            }

            .answer-btn {
                min-width: 100%;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 15px;
            }

            .top-header {
                padding: 20px;
            }

            .page-title h1 {
                font-size: 1.5rem;
            }

            .quiz-info-banner {
                padding: 20px;
            }

            .form-header {
                padding: 20px;
            }

            .form-header h2 {
                font-size: 1.3rem;
            }

            .correct-answer-selector {
                padding: 20px;
            }
        }

        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 101;
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 50%;
            box-shadow: var(--shadow);
            border: none;
            font-size: 1.5rem;
            color: var(--primary);
            cursor: pointer;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 992px) {
            .mobile-menu-btn {
                display: flex;
            }
        }

        /* Overlay for mobile menu */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 99;
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* Loading State */
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
    </style>
</head>
<body>
    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" id="mobileMenuBtn">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="sidebar-title">
                Admin Panel
                <span>Smart Quiz</span>
            </div>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="admin_dashboard.php">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="index.php">
                    <i class="fas fa-home"></i>
                    Homepage
                </a>
            </li>
            <li>
                <a href="add_quiz.php">
                    <i class="fas fa-plus-circle"></i>
                    Add New Quiz
                </a>
            </li>
            <li>
                <a href="add_question.php?quiz_id=<?php echo $quiz_id; ?>" class="active">
                    <i class="fas fa-question-circle"></i>
                    Add Questions
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-cog"></i>
                    Settings
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Header -->
        <div class="top-header">
            <div class="page-title">
                <div class="title-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <div>
                    <h1>Add Questions</h1>
                    <p>Create engaging questions for your quiz participants</p>
                </div>
            </div>
            
            <div class="breadcrumb">
                <a href="admin_dashboard.php">Dashboard</a>
                <i class="fas fa-chevron-right"></i>
                <a href="add_quiz.php">Add Quiz</a>
                <i class="fas fa-chevron-right"></i>
                <span>Add Questions</span>
            </div>
        </div>

        <!-- Quiz Info Banner -->
        <div class="quiz-info-banner">
            <div class="quiz-info-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="quiz-info-content">
                <h3><?php echo htmlspecialchars($quiz_title); ?></h3>
                <p><?php echo htmlspecialchars($quiz_description); ?></p>
            </div>
        </div>

        <!-- Progress Steps -->
        <div class="progress-steps">
            <div class="progress-line">
                <div class="progress-fill"></div>
            </div>
            <div class="progress-step completed">
                <div class="step-circle">
                    <i class="fas fa-check"></i>
                </div>
                <div class="step-label">Create Quiz</div>
            </div>
            <div class="progress-step active">
                <div class="step-circle">2</div>
                <div class="step-label">Add Questions</div>
            </div>
            <div class="progress-step">
                <div class="step-circle">3</div>
                <div class="step-label">Preview & Publish</div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="form-container">
            <div class="form-header">
                <h2>
                    <i class="fas fa-plus-circle"></i>
                    Add New Question
                </h2>
                <p>Fill in the question details and answer options below</p>
            </div>

            <!-- Success Message -->
            <?php if($message): ?>
                <div class="message-alert <?php echo $message_type; ?>">
                    <i class="fas fa-check-circle"></i>
                    <div><?php echo $message; ?></div>
                </div>
            <?php endif; ?>

            <form method="POST" class="form-content" id="questionForm">
                <!-- Question Text Section -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-pen-alt"></i>
                        Question Text
                    </div>
                    <div class="question-input">
                        <label class="question-label">
                            Enter your question
                            <span class="label-hint">(Make it clear and engaging)</span>
                        </label>
                        <textarea 
                            class="question-textarea" 
                            name="question_text" 
                            id="question_text" 
                            placeholder="Type your question here... (e.g., 'What is the capital of France?')" 
                            required
                            rows="4"
                            oninput="updateCharCount(this, 'question-counter')"
                        ></textarea>
                        <div class="char-count" id="question-counter">0 characters</div>
                    </div>
                </div>

                <!-- Answer Options Section -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-list-ol"></i>
                        Answer Options
                    </div>
                    <p class="label-hint" style="margin-bottom: 20px;">Provide four distinct answer choices</p>
                    
                    <div class="answer-options" id="answerOptions">
                        <?php for($i = 0; $i < 4; $i++): ?>
                        <div class="answer-option" data-index="<?php echo $i; ?>">
                            <div class="answer-input-group">
                                <div class="answer-number"><?php echo $i + 1; ?></div>
                                <input 
                                    type="text" 
                                    class="answer-input" 
                                    name="answers[]" 
                                    id="answer_<?php echo $i; ?>"
                                    placeholder="Enter answer option <?php echo $i + 1; ?>"
                                    required
                                    data-index="<?php echo $i; ?>"
                                >
                            </div>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- Correct Answer Selection -->
                <div class="correct-answer-selector">
                    <div class="selector-title">
                        <i class="fas fa-check-circle"></i>
                        Mark Correct Answer
                    </div>
                    <p class="label-hint" style="margin-bottom: 20px;">Select which answer is correct</p>
                    
                    <div class="answer-buttons">
                        <?php for($i = 1; $i <= 4; $i++): ?>
                        <div class="answer-btn">
                            <input 
                                type="radio" 
                                name="correct_answer" 
                                id="correct_<?php echo $i; ?>" 
                                value="<?php echo $i; ?>"
                                <?php echo $i == 1 ? 'checked' : ''; ?>
                                required
                            >
                            <label for="correct_<?php echo $i; ?>">
                                Option <?php echo $i; ?>
                            </label>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="admin_dashboard.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Back to Dashboard
                    </a>
                    
                    <div style="display: flex; gap: 15px;">
                        <button type="reset" class="btn btn-secondary" id="resetBtn">
                            <i class="fas fa-redo"></i>
                            Clear Form
                        </button>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-save"></i>
                            Save Question
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tips Section -->
        <div class="tips-section">
            <div class="tips-title">
                <i class="fas fa-lightbulb"></i>
                Tips for Great Questions
            </div>
            <ul class="tips-list">
                <li>Keep questions clear and unambiguous</li>
                <li>Ensure answers are distinct from each other</li>
                <li>Use appropriate language for your audience</li>
                <li>Avoid trick questions unless intentional</li>
                <li>Mix different types of questions (factual, conceptual, applied)</li>
            </ul>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            mobileMenuBtn.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                sidebarOverlay.classList.toggle('active');
                this.querySelector('i').classList.toggle('fa-bars');
                this.querySelector('i').classList.toggle('fa-times');
            });
            
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                this.classList.remove('active');
                mobileMenuBtn.querySelector('i').classList.add('fa-bars');
                mobileMenuBtn.querySelector('i').classList.remove('fa-times');
            });
            
            // Close menu when clicking a link
            document.querySelectorAll('.sidebar-menu a').forEach(link => {
                link.addEventListener('click', function() {
                    if(window.innerWidth <= 992) {
                        sidebar.classList.remove('active');
                        sidebarOverlay.classList.remove('active');
                        mobileMenuBtn.querySelector('i').classList.add('fa-bars');
                        mobileMenuBtn.querySelector('i').classList.remove('fa-times');
                    }
                });
            });
            
            // Character counter for question
            function updateCharCount(textarea, counterId) {
                const counter = document.getElementById(counterId);
                const length = textarea.value.length;
                counter.textContent = `${length} characters`;
                
                if (length > 200) {
                    counter.style.color = 'var(--warning)';
                } else {
                    counter.style.color = 'var(--gray)';
                }
            }
            
            // Real-time correct answer highlighting
            const answerInputs = document.querySelectorAll('.answer-input');
            const radioButtons = document.querySelectorAll('input[name="correct_answer"]');
            
            answerInputs.forEach(input => {
                input.addEventListener('input', function() {
                    const index = this.getAttribute('data-index');
                    const option = document.querySelector(`.answer-option[data-index="${index}"]`);
                    
                    // Clear previous highlighting
                    document.querySelectorAll('.answer-option').forEach(opt => {
                        opt.classList.remove('correct');
                    });
                    
                    // Highlight the currently selected correct answer
                    const selectedRadio = document.querySelector('input[name="correct_answer"]:checked');
                    if (selectedRadio) {
                        const correctIndex = parseInt(selectedRadio.value) - 1;
                        const correctOption = document.querySelector(`.answer-option[data-index="${correctIndex}"]`);
                        if (correctOption) {
                            correctOption.classList.add('correct');
                        }
                    }
                });
            });
            
            // Update highlighting when radio selection changes
            radioButtons.forEach(radio => {
                radio.addEventListener('change', function() {
                    // Clear all
                    document.querySelectorAll('.answer-option').forEach(opt => {
                        opt.classList.remove('correct');
                    });
                    
                    // Highlight correct
                    const correctIndex = parseInt(this.value) - 1;
                    const correctOption = document.querySelector(`.answer-option[data-index="${correctIndex}"]`);
                    if (correctOption) {
                        correctOption.classList.add('correct');
                    }
                });
            });
            
            // Auto-select radio when typing in answer
            answerInputs.forEach(input => {
                input.addEventListener('input', function() {
                    if(this.value.trim() !== '') {
                        const index = parseInt(this.getAttribute('data-index')) + 1;
                        const radio = document.getElementById(`correct_${index}`);
                        if(radio) {
                            radio.checked = true;
                            radio.dispatchEvent(new Event('change'));
                        }
                    }
                });
            });
            
            // Form validation
            const form = document.getElementById('questionForm');
            const submitBtn = document.getElementById('submitBtn');
            
            form.addEventListener('submit', function(e) {
                const questionText = document.getElementById('question_text').value.trim();
                const answers = document.querySelectorAll('input[name="answers[]"]');
                let allFilled = true;
                let hasDuplicates = false;
                const answerValues = [];
                
                if(questionText === '') {
                    e.preventDefault();
                    showError('Please enter a question.');
                    document.getElementById('question_text').focus();
                    return;
                }
                
                if(questionText.length < 5) {
                    e.preventDefault();
                    showError('Question should be at least 5 characters long.');
                    document.getElementById('question_text').focus();
                    return;
                }
                
                answers.forEach((input, index) => {
                    const value = input.value.trim();
                    if(value === '') {
                        allFilled = false;
                        input.style.borderColor = 'var(--danger)';
                    } else {
                        input.style.borderColor = '';
                        // Check for duplicates
                        if(answerValues.includes(value.toLowerCase())) {
                            hasDuplicates = true;
                        }
                        answerValues.push(value.toLowerCase());
                    }
                });
                
                if(!allFilled) {
                    e.preventDefault();
                    showError('Please fill in all answer options.');
                    return;
                }
                
                if(hasDuplicates) {
                    e.preventDefault();
                    showError('Answer options should be unique. Please make each answer distinct.');
                    return;
                }
                
                // Show loading state
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
            });
            
            // Reset form button
            const resetBtn = document.getElementById('resetBtn');
            resetBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if(confirm('Are you sure you want to clear the form? All entered data will be lost.')) {
                    form.reset();
                    document.querySelectorAll('.answer-option').forEach(opt => {
                        opt.classList.remove('correct');
                    });
                    document.getElementById('question-counter').textContent = '0 characters';
                    document.getElementById('question_text').focus();
                }
            });
            
            // Error message function
            function showError(message) {
                // Remove existing error
                const existingError = document.querySelector('.message-alert.error');
                if(existingError) {
                    existingError.remove();
                }
                
                // Create error element
                const errorDiv = document.createElement('div');
                errorDiv.className = 'message-alert error';
                errorDiv.innerHTML = `
                    <i class="fas fa-exclamation-circle"></i>
                    <div>${message}</div>
                `;
                
                // Insert after form header
                const formContainer = document.querySelector('.form-container');
                const formHeader = document.querySelector('.form-header');
                formContainer.insertBefore(errorDiv, formHeader.nextSibling);
                
                // Auto-remove after 5 seconds
                setTimeout(() => {
                    errorDiv.style.opacity = '0';
                    errorDiv.style.transform = 'translateY(-10px)';
                    setTimeout(() => errorDiv.remove(), 300);
                }, 5000);
            }
            
            // Initialize highlighting for the default correct answer
            const defaultRadio = document.querySelector('input[name="correct_answer"]:checked');
            if(defaultRadio) {
                const correctIndex = parseInt(defaultRadio.value) - 1;
                const correctOption = document.querySelector(`.answer-option[data-index="${correctIndex}"]`);
                if(correctOption) {
                    correctOption.classList.add('correct');
                }
            }
        });
    </script>
</body>
</html>