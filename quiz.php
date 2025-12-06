<?php
include 'db_connect.php';
$quiz_id = $_GET['id'];
$quiz = $conn->query("SELECT * FROM quizzes WHERE id=$quiz_id")->fetch_assoc();
$questions = $conn->query("SELECT * FROM questions WHERE quiz_id=$quiz_id");

// Get total questions count
$question_count = $questions->num_rows;

// Check if quiz exists
if (!$quiz) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($quiz['title']); ?> | Smart Quiz</title>
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

        /* Main Content */
        .quiz-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* Quiz Header */
        .quiz-header {
            background: white;
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--card-shadow);
            margin-bottom: 30px;
            animation: slideDown 0.6s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .quiz-title {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .quiz-title h1 {
            font-size: 2.2rem;
            color: var(--dark);
            flex: 1;
        }

        .quiz-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.8rem;
        }

        .quiz-description {
            color: var(--gray);
            font-size: 1.1rem;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .quiz-meta {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--light-gray);
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--gray);
        }

        .meta-item i {
            color: var(--primary);
            font-size: 1.2rem;
        }

        /* Progress Bar */
        .progress-container {
            background: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--card-shadow);
            margin-bottom: 30px;
            position: sticky;
            top: 80px;
            z-index: 999;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .progress-title {
            font-weight: 600;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .progress-title i {
            color: var(--primary);
        }

        .progress-text {
            font-size: 0.9rem;
            color: var(--gray);
        }

        .progress-bar {
            height: 12px;
            background: var(--light-gray);
            border-radius: 6px;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 6px;
            width: 0%;
            transition: width 0.5s ease;
        }

        .progress-labels {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            color: var(--gray);
        }

        /* Quiz Form */
        .quiz-form {
            background: white;
            border-radius: var(--border-radius);
            padding: 40px;
            box-shadow: var(--shadow);
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

        /* Questions */
        .question-container {
            margin-bottom: 50px;
            opacity: 0;
            transform: translateY(20px);
            transition: var(--transition);
        }

        .question-container.active {
            opacity: 1;
            transform: translateY(0);
        }

        .question-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--light-gray);
        }

        .question-number {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .question-text {
            font-size: 1.4rem;
            color: var(--dark);
            font-weight: 500;
            line-height: 1.4;
        }

        /* Answer Options */
        .answer-options {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .answer-option {
            position: relative;
        }

        .answer-input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .answer-label {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            background: var(--light);
            border: 2px solid var(--light-gray);
            border-radius: 12px;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .answer-label:hover {
            border-color: var(--primary);
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .answer-input:checked + .answer-label {
            border-color: var(--primary);
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.1), rgba(58, 12, 163, 0.05));
            transform: translateX(10px);
            box-shadow: 0 5px 20px rgba(67, 97, 238, 0.1);
        }

        .answer-input:checked + .answer-label::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(to bottom, var(--primary), var(--secondary));
        }

        .answer-letter {
            width: 40px;
            height: 40px;
            background: white;
            border: 2px solid var(--light-gray);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--gray);
            flex-shrink: 0;
            transition: var(--transition);
        }

        .answer-input:checked + .answer-label .answer-letter {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border-color: var(--primary);
        }

        .answer-text {
            font-size: 1.1rem;
            color: var(--dark);
            flex: 1;
        }

        /* Navigation Buttons */
        .quiz-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 50px;
            padding-top: 30px;
            border-top: 1px solid var(--light-gray);
        }

        .nav-btn {
            padding: 15px 35px;
            background: var(--light-gray);
            color: var(--dark);
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .nav-btn:hover {
            background: #dee2e6;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .nav-btn.next {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: 0 5px 20px rgba(67, 97, 238, 0.3);
        }

        .nav-btn.next:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--secondary));
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(67, 97, 238, 0.4);
        }

        .nav-btn.hidden {
            visibility: hidden;
        }

        .nav-btn i {
            font-size: 1.2rem;
        }

        .nav-btn.next i {
            transform: rotate(180deg);
        }

        /* Quiz Timer */
        .quiz-timer {
            background: linear-gradient(135deg, #fff3cd, #ffeaa7);
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 15px;
            border-left: 5px solid var(--warning);
        }

        .timer-icon {
            width: 50px;
            height: 50px;
            background: var(--warning);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .timer-content h3 {
            font-size: 1.2rem;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .timer-display {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--warning);
            font-family: 'Montserrat', monospace;
        }

        /* Quiz Footer */
        .quiz-footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid var(--light-gray);
            color: var(--gray);
            font-size: 0.95rem;
        }

        /* Instructions */
        .instructions {
            background: linear-gradient(135deg, #e6f7ff, #d1ecff);
            border-radius: var(--border-radius);
            padding: 25px;
            margin-bottom: 30px;
            border-left: 5px solid var(--success);
        }

        .instructions-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .instructions-header i {
            color: var(--success);
            font-size: 1.5rem;
        }

        .instructions-header h3 {
            font-size: 1.3rem;
            color: var(--dark);
        }

        .instructions-list {
            list-style: none;
            padding-left: 0;
        }

        .instructions-list li {
            margin-bottom: 10px;
            padding-left: 25px;
            position: relative;
            color: var(--gray);
        }

        .instructions-list li:before {
            content: '•';
            position: absolute;
            left: 10px;
            color: var(--success);
            font-weight: bold;
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
            
            .quiz-header {
                padding: 25px;
            }
            
            .quiz-title h1 {
                font-size: 1.8rem;
            }
            
            .quiz-form {
                padding: 25px;
            }
            
            .question-text {
                font-size: 1.2rem;
            }
            
            .quiz-navigation {
                flex-direction: column;
                gap: 15px;
            }
            
            .nav-btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .quiz-container {
                padding: 0 15px;
            }
            
            .quiz-title {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .quiz-icon {
                width: 50px;
                height: 50px;
                font-size: 1.5rem;
            }
            
            .quiz-meta {
                flex-direction: column;
                gap: 15px;
            }
            
            .answer-label {
                padding: 15px;
            }
            
            .answer-letter {
                width: 35px;
                height: 35px;
            }
        }

        /* Loading State */
        .loading {
            display: none;
            text-align: center;
            padding: 60px 20px;
        }

        .loading i {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 20px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Question Counter */
        .question-counter {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            color: var(--gray);
            font-size: 0.95rem;
        }

        .counter-dots {
            display: flex;
            gap: 5px;
        }

        .counter-dot {
            width: 10px;
            height: 10px;
            background: var(--light-gray);
            border-radius: 50%;
            transition: var(--transition);
        }

        .counter-dot.active {
            background: var(--primary);
        }

        .counter-dot.answered {
            background: var(--success);
        }

        /* Confirmation Dialog */
        .confirmation-dialog {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }

        .dialog-content {
            background: white;
            border-radius: var(--border-radius);
            padding: 40px;
            max-width: 500px;
            width: 90%;
            box-shadow: var(--shadow);
            animation: dialogShow 0.3s ease-out;
        }

        @keyframes dialogShow {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .dialog-content h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dialog-content p {
            color: var(--gray);
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .dialog-buttons {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
        }

        .dialog-btn {
            padding: 12px 25px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .dialog-btn.cancel {
            background: var(--light-gray);
            color: var(--dark);
        }

        .dialog-btn.cancel:hover {
            background: #dee2e6;
        }

        .dialog-btn.submit {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }

        .dialog-btn.submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <div class="logo-container">
                <img src="images.jpeg" class="logo" alt="Quiz Logo">
                <h1 class="site-title">Smart Quiz</h1>
            </div>
            <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <nav class="nav-menu" id="navMenu">
                <a href="index.php"><i class="fas fa-home"></i> Home</a>
                <a href="about.php"><i class="fas fa-info-circle"></i> About</a>
                <a href="contact.php"><i class="fas fa-envelope"></i> Contact</a>
            </nav>
        </div>
    </header>

    <!-- Main Quiz Container -->
    <div class="quiz-container">
        <!-- Quiz Header -->
        <div class="quiz-header">
            <div class="quiz-title">
                <div class="quiz-icon">
                    <i class="fas fa-brain"></i>
                </div>
                <h1><?php echo htmlspecialchars($quiz['title']); ?></h1>
            </div>
            
            <?php if ($quiz['description']): ?>
                <p class="quiz-description"><?php echo htmlspecialchars($quiz['description']); ?></p>
            <?php endif; ?>
            
            <div class="quiz-meta">
                <div class="meta-item">
                    <i class="fas fa-question-circle"></i>
                    <span><?php echo $question_count; ?> Questions</span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-clock"></i>
                    <span>Estimated time: <?php echo ceil($question_count * 0.5); ?> minutes</span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-chart-line"></i>
                    <span>Test your knowledge</span>
                </div>
            </div>
        </div>

        <!-- Instructions -->
        <div class="instructions">
            <div class="instructions-header">
                <i class="fas fa-info-circle"></i>
                <h3>Instructions</h3>
            </div>
            <ul class="instructions-list">
                <li>Read each question carefully before answering</li>
                <li>Select only one answer for each question</li>
                <li>You can navigate between questions using Previous/Next buttons</li>
                <li>Submit the quiz when you've answered all questions</li>
                <li>Your score will be displayed after submission</li>
            </ul>
        </div>

        <!-- Progress Bar -->
        <div class="progress-container">
            <div class="progress-header">
                <div class="progress-title">
                    <i class="fas fa-chart-bar"></i>
                    <span>Quiz Progress</span>
                </div>
                <div class="progress-text">
                    <span id="currentQuestion">1</span> of <?php echo $question_count; ?> questions
                </div>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill"></div>
            </div>
            <div class="progress-labels">
                <span>0%</span>
                <span>50%</span>
                <span>100%</span>
            </div>
        </div>

        <!-- Question Counter Dots -->
        <div class="question-counter">
            <span>Question:</span>
            <div class="counter-dots" id="counterDots">
                <?php for ($i = 1; $i <= $question_count; $i++): ?>
                    <div class="counter-dot" data-question="<?php echo $i; ?>"></div>
                <?php endfor; ?>
            </div>
        </div>

        <!-- Quiz Form -->
        <form action="result.php" method="POST" id="quizForm">
            <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
            <div class="quiz-form">
                <?php
                $questions->data_seek(0); // Reset pointer
                $index = 1;
                while($q = $questions->fetch_assoc()):
                    $answers = $conn->query("SELECT * FROM answers WHERE question_id={$q['id']}");
                    $letters = ['A', 'B', 'C', 'D'];
                    $letter_index = 0;
                ?>
                    <div class="question-container" id="question-<?php echo $index; ?>" <?php echo $index > 1 ? 'style="display: none;"' : ''; ?>>
                        <div class="question-header">
                            <div class="question-number"><?php echo $index; ?></div>
                            <div class="question-text"><?php echo htmlspecialchars($q['question_text']); ?></div>
                        </div>
                        
                        <div class="answer-options">
                            <?php while($a = $answers->fetch_assoc()): ?>
                                <div class="answer-option">
                                    <input type="radio" 
                                           class="answer-input" 
                                           id="answer-<?php echo $q['id']; ?>-<?php echo $a['id']; ?>" 
                                           name="answer[<?php echo $q['id']; ?>]" 
                                           value="<?php echo $a['id']; ?>"
                                           data-question="<?php echo $index; ?>">
                                    <label for="answer-<?php echo $q['id']; ?>-<?php echo $a['id']; ?>" class="answer-label">
                                        <div class="answer-letter"><?php echo $letters[$letter_index]; ?></div>
                                        <div class="answer-text"><?php echo htmlspecialchars($a['answer_text']); ?></div>
                                    </label>
                                </div>
                                <?php $letter_index++; ?>
                            <?php endwhile; ?>
                        </div>
                    </div>
                <?php 
                    $index++;
                endwhile; 
                ?>

                <!-- Quiz Navigation -->
                <div class="quiz-navigation">
                    <button type="button" class="nav-btn prev" id="prevBtn" style="visibility: hidden;">
                        <i class="fas fa-arrow-left"></i>
                        Previous
                    </button>
                    
                    <?php if ($question_count > 1): ?>
                        <button type="button" class="nav-btn next" id="nextBtn">
                            Next
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    <?php else: ?>
                        <button type="submit" class="nav-btn next">
                            Submit Quiz
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    <?php endif; ?>
                </div>

                <!-- Final Submit Button -->
                <div class="quiz-footer">
                    <p>Make sure you've answered all questions before submitting</p>
                    <button type="button" class="nav-btn next" id="finalSubmitBtn" style="display: <?php echo $question_count > 1 ? 'none' : 'none'; ?>; margin-top: 20px;">
                        <i class="fas fa-check-circle"></i>
                        Submit All Answers
                    </button>
                </div>
            </div>
        </form>

        <!-- Confirmation Dialog -->
        <div class="confirmation-dialog" id="confirmationDialog">
            <div class="dialog-content">
                <h3><i class="fas fa-exclamation-circle"></i> Submit Quiz?</h3>
                <p>You have answered <span id="answeredCount">0</span> out of <?php echo $question_count; ?> questions. Are you sure you want to submit your answers?</p>
                <div class="dialog-buttons">
                    <button type="button" class="dialog-btn cancel" id="cancelSubmit">Continue Quiz</button>
                    <button type="button" class="dialog-btn submit" id="confirmSubmit">Submit Answers</button>
                </div>
            </div>
        </div>
    </div>

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
            document.querySelectorAll('.nav-menu a').forEach(link => {
                link.addEventListener('click', function() {
                    navMenu.classList.remove('active');
                    mobileMenuBtn.querySelector('i').classList.add('fa-bars');
                    mobileMenuBtn.querySelector('i').classList.remove('fa-times');
                });
            });
            
            // Quiz variables
            const totalQuestions = <?php echo $question_count; ?>;
            let currentQuestion = 1;
            const answeredQuestions = new Set();
            
            // Initialize progress
            updateProgress();
            updateCounterDots();
            
            // Navigation functions
            function showQuestion(questionNumber) {
                // Hide all questions
                document.querySelectorAll('.question-container').forEach(q => {
                    q.style.display = 'none';
                    q.classList.remove('active');
                });
                
                // Show current question
                const currentQ = document.getElementById('question-' + questionNumber);
                if (currentQ) {
                    currentQ.style.display = 'block';
                    setTimeout(() => {
                        currentQ.classList.add('active');
                    }, 50);
                }
                
                // Update navigation buttons
                document.getElementById('prevBtn').style.visibility = questionNumber === 1 ? 'hidden' : 'visible';
                document.getElementById('nextBtn').style.display = questionNumber === totalQuestions ? 'none' : 'flex';
                document.getElementById('finalSubmitBtn').style.display = questionNumber === totalQuestions ? 'flex' : 'none';
                
                // Update progress
                currentQuestion = questionNumber;
                updateProgress();
                updateCounterDots();
            }
            
            function nextQuestion() {
                if (currentQuestion < totalQuestions) {
                    showQuestion(currentQuestion + 1);
                }
            }
            
            function prevQuestion() {
                if (currentQuestion > 1) {
                    showQuestion(currentQuestion - 1);
                }
            }
            
            // Update progress bar
            function updateProgress() {
                const progress = ((currentQuestion - 1) / totalQuestions) * 100;
                document.getElementById('progressFill').style.width = progress + '%';
                document.getElementById('currentQuestion').textContent = currentQuestion;
            }
            
            // Update counter dots
            function updateCounterDots() {
                const dots = document.querySelectorAll('.counter-dot');
                dots.forEach((dot, index) => {
                    dot.classList.remove('active');
                    if (index + 1 === currentQuestion) {
                        dot.classList.add('active');
                    }
                    
                    const questionNum = index + 1;
                    if (answeredQuestions.has(questionNum)) {
                        dot.classList.add('answered');
                    } else {
                        dot.classList.remove('answered');
                    }
                });
            }
            
            // Track answered questions
            document.querySelectorAll('.answer-input').forEach(input => {
                input.addEventListener('change', function() {
                    const questionNum = parseInt(this.getAttribute('data-question'));
                    answeredQuestions.add(questionNum);
                    updateCounterDots();
                    
                    // Update answered count for confirmation dialog
                    document.getElementById('answeredCount').textContent = answeredQuestions.size;
                });
            });
            
            // Navigation button events
            document.getElementById('nextBtn').addEventListener('click', nextQuestion);
            document.getElementById('prevBtn').addEventListener('click', prevQuestion);
            
            // Click counter dots to navigate
            document.querySelectorAll('.counter-dot').forEach(dot => {
                dot.addEventListener('click', function() {
                    const questionNum = parseInt(this.getAttribute('data-question'));
                    showQuestion(questionNum);
                });
            });
            
            // Final submit button
            const finalSubmitBtn = document.getElementById('finalSubmitBtn');
            const confirmationDialog = document.getElementById('confirmationDialog');
            const cancelSubmitBtn = document.getElementById('cancelSubmit');
            const confirmSubmitBtn = document.getElementById('confirmSubmit');
            
            if (finalSubmitBtn) {
                finalSubmitBtn.addEventListener('click', function() {
                    document.getElementById('answeredCount').textContent = answeredQuestions.size;
                    confirmationDialog.style.display = 'flex';
                });
            }
            
            cancelSubmitBtn.addEventListener('click', function() {
                confirmationDialog.style.display = 'none';
            });
            
            confirmSubmitBtn.addEventListener('click', function() {
                // Submit the form
                document.getElementById('quizForm').submit();
            });
            
            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowRight' || e.key === ' ') {
                    e.preventDefault();
                    nextQuestion();
                } else if (e.key === 'ArrowLeft') {
                    e.preventDefault();
                    prevQuestion();
                } else if (e.key >= '1' && e.key <= '9') {
                    const num = parseInt(e.key);
                    if (num <= totalQuestions) {
                        showQuestion(num);
                    }
                }
            });
            
            // Answer selection animation
            document.querySelectorAll('.answer-label').forEach(label => {
                label.addEventListener('click', function() {
                    // Add visual feedback
                    this.style.transform = 'translateX(10px) scale(1.02)';
                    setTimeout(() => {
                        this.style.transform = 'translateX(10px) scale(1)';
                    }, 200);
                });
            });
            
            // Auto-save answers (optional - could be implemented with localStorage)
            function saveProgress() {
                const answers = {};
                document.querySelectorAll('.answer-input:checked').forEach(input => {
                    const questionId = input.name.match(/\[(\d+)\]/)[1];
                    answers[questionId] = input.value;
                });
                localStorage.setItem('quiz_' + <?php echo $quiz_id; ?>, JSON.stringify(answers));
            }
            
            // Load saved answers
            function loadProgress() {
                const saved = localStorage.getItem('quiz_' + <?php echo $quiz_id; ?>);
                if (saved) {
                    const answers = JSON.parse(saved);
                    Object.keys(answers).forEach(questionId => {
                        const input = document.querySelector(`input[name="answer[${questionId}]"][value="${answers[questionId]}"]`);
                        if (input) {
                            input.checked = true;
                            const questionNum = parseInt(input.getAttribute('data-question'));
                            answeredQuestions.add(questionNum);
                        }
                    });
                    updateCounterDots();
                    document.getElementById('answeredCount').textContent = answeredQuestions.size;
                }
            }
            
            // Auto-save on answer selection
            document.querySelectorAll('.answer-input').forEach(input => {
                input.addEventListener('change', saveProgress);
            });
            
            // Load saved answers on page load
            loadProgress();
            
            // Confirm before leaving page
            window.addEventListener('beforeunload', function(e) {
                if (answeredQuestions.size > 0) {
                    e.preventDefault();
                    e.returnValue = 'You have unsaved answers. Are you sure you want to leave?';
                }
            });
            
            // Initialize first question
            showQuestion(1);
        });
    </script>
</body>
</html>