<?php
include 'db_connect.php';
$answers = $_POST['answer'] ?? [];
$quiz_id = $_POST['quiz_id'] ?? 0;
$score = 0;

// Get quiz details
$quiz = $conn->query("SELECT * FROM quizzes WHERE id=$quiz_id")->fetch_assoc();
$quiz_title = $quiz['title'] ?? 'Quiz';

// Calculate score
foreach ($answers as $question_id => $answer_id) {
    $check = $conn->query("SELECT * FROM answers WHERE id=$answer_id AND is_correct=1");
    if ($check->num_rows > 0) $score++;
}

$total = count($answers);
$percentage = ($total > 0) ? round(($score / $total) * 100) : 0;

// Determine result message and visual elements
if ($percentage == 100) {
    $message = "🎯 Perfect Score! You're a Quiz Master!";
    $emoji = "🏆";
    $color = "#4cc9f0";
    $bg_gradient = "linear-gradient(135deg, #4cc9f0, #2a9d8f)";
    $level = "Quiz Master";
    $encouragement = "Absolutely flawless! You've mastered this topic completely!";
} elseif ($percentage >= 85) {
    $message = "🌟 Outstanding Performance!";
    $emoji = "✨";
    $color = "#7209b7";
    $bg_gradient = "linear-gradient(135deg, #7209b7, #4361ee)";
    $level = "Expert";
    $encouragement = "Excellent work! You have an exceptional understanding of this subject!";
} elseif ($percentage >= 75) {
    $message = "👏 Great Job! Well done!";
    $emoji = "👍";
    $color = "#4361ee";
    $bg_gradient = "linear-gradient(135deg, #4361ee, #3a0ca3)";
    $level = "Advanced";
    $encouragement = "You're doing great! Keep up the fantastic work!";
} elseif ($percentage >= 60) {
    $message = "🙂 Good Effort!";
    $emoji = "💪";
    $color = "#f8961e";
    $bg_gradient = "linear-gradient(135deg, #f8961e, #e76f51)";
    $level = "Intermediate";
    $encouragement = "Solid performance! You're on the right track!";
} elseif ($percentage >= 40) {
    $message = "📚 Keep Learning!";
    $emoji = "📖";
    $color = "#f72585";
    $bg_gradient = "linear-gradient(135deg, #f72585, #b5179e)";
    $level = "Beginner";
    $encouragement = "Good try! Review the material and try again for better results!";
} else {
    $message = "💪 Don't Give Up!";
    $emoji = "🔁";
    $color = "#e63946";
    $bg_gradient = "linear-gradient(135deg, #e63946, #d00000)";
    $level = "Novice";
    $encouragement = "Everyone starts somewhere! Review the material and try again!";
}

// Get question details for review
$incorrect_questions = [];
foreach ($answers as $question_id => $answer_id) {
    $check = $conn->query("SELECT * FROM answers WHERE id=$answer_id AND is_correct=1");
    if ($check->num_rows == 0) {
        $question_data = $conn->query("SELECT question_text FROM questions WHERE id=$question_id")->fetch_assoc();
        $incorrect_questions[] = [
            'question_text' => $question_data['question_text'] ?? 'Question',
            'question_id' => $question_id
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results | Smart Quiz</title>
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
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Main Result Container */
        .result-container {
            width: 100%;
            max-width: 800px;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header */
        .result-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .quiz-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .result-subtitle {
            color: var(--gray);
            font-size: 1.2rem;
        }

        /* Main Result Card */
        .result-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .result-hero {
            background: <?php echo $bg_gradient; ?>;
            color: white;
            padding: 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .result-hero::before {
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

        .result-emoji {
            font-size: 4rem;
            margin-bottom: 20px;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .result-message {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
        }

        .result-level {
            font-size: 1.2rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        /* Score Section */
        .score-section {
            padding: 40px;
        }

        .score-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .score-title {
            font-size: 1.5rem;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .score-title i {
            color: <?php echo $color; ?>;
        }

        .score-badge {
            background: <?php echo $bg_gradient; ?>;
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Progress Circle */
        .progress-circle-container {
            display: flex;
            justify-content: center;
            margin: 30px 0;
        }

        .progress-circle {
            width: 200px;
            height: 200px;
            position: relative;
        }

        .circle-bg {
            fill: none;
            stroke: var(--light-gray);
            stroke-width: 8;
        }

        .circle-progress {
            fill: none;
            stroke: <?php echo $color; ?>;
            stroke-width: 8;
            stroke-linecap: round;
            stroke-dasharray: 565.48;
            stroke-dashoffset: 565.48;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
            animation: progressAnimation 2s ease-out forwards;
        }

        @keyframes progressAnimation {
            to {
                stroke-dashoffset: <?php echo 565.48 - (565.48 * $percentage / 100); ?>;
            }
        }

        .circle-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        .circle-percentage {
            font-size: 2.5rem;
            font-weight: 700;
            color: <?php echo $color; ?>;
        }

        .circle-label {
            font-size: 1rem;
            color: var(--gray);
        }

        /* Score Details */
        .score-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 40px;
        }

        .detail-card {
            background: var(--light);
            padding: 25px;
            border-radius: var(--border-radius);
            text-align: center;
            transition: var(--transition);
        }

        .detail-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-shadow);
        }

        .detail-icon {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 1.8rem;
            color: <?php echo $color; ?>;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .detail-value {
            font-size: 2rem;
            font-weight: 700;
            color: <?php echo $color; ?>;
            margin-bottom: 5px;
        }

        .detail-label {
            color: var(--gray);
            font-size: 0.95rem;
        }

        /* Encouragement Section */
        .encouragement-section {
            background: linear-gradient(135deg, #f8f9ff, #eef1ff);
            padding: 30px;
            border-radius: var(--border-radius);
            margin: 30px 0;
            border-left: 5px solid <?php echo $color; ?>;
        }

        .encouragement-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .encouragement-header i {
            color: <?php echo $color; ?>;
            font-size: 1.5rem;
        }

        .encouragement-header h3 {
            font-size: 1.3rem;
            color: var(--dark);
        }

        .encouragement-text {
            color: var(--gray);
            line-height: 1.6;
            font-size: 1.05rem;
        }

        /* Review Section */
        <?php if (!empty($incorrect_questions)): ?>
        .review-section {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 30px;
            margin-bottom: 30px;
        }

        .review-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .review-header i {
            color: var(--warning);
            font-size: 1.5rem;
        }

        .review-header h3 {
            font-size: 1.5rem;
            color: var(--dark);
        }

        .review-list {
            list-style: none;
        }

        .review-item {
            background: var(--light);
            padding: 20px;
            border-radius: var(--border-radius);
            margin-bottom: 15px;
            border-left: 5px solid var(--warning);
            transition: var(--transition);
        }

        .review-item:hover {
            transform: translateX(5px);
            box-shadow: var(--card-shadow);
        }

        .review-question {
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .review-question i {
            color: var(--warning);
        }

        .review-actions {
            margin-top: 10px;
        }

        .review-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            background: var(--light-gray);
            color: var(--dark);
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .review-btn:hover {
            background: #dee2e6;
            transform: translateY(-2px);
        }
        <?php endif; ?>

        /* Action Buttons */
        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 40px;
            justify-content: center;
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
            text-decoration: none;
            border: none;
            text-align: center;
            min-width: 180px;
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
            transform: translateY(-3px);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success), #2a9d8f);
            color: white;
            box-shadow: 0 6px 20px rgba(76, 201, 240, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(76, 201, 240, 0.4);
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning), #e76f51);
            color: white;
            box-shadow: 0 6px 20px rgba(248, 150, 30, 0.3);
        }

        .btn-warning:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(248, 150, 30, 0.4);
        }

        /* Share Results */
        .share-section {
            text-align: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid var(--light-gray);
        }

        .share-title {
            font-size: 1.2rem;
            color: var(--dark);
            margin-bottom: 20px;
        }

        .share-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .share-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: white;
            transition: var(--transition);
            text-decoration: none;
        }

        .share-btn.facebook { background: #1877f2; }
        .share-btn.twitter { background: #1da1f2; }
        .share-btn.whatsapp { background: #25d366; }
        .share-btn.copy { background: var(--gray); }

        .share-btn:hover {
            transform: translateY(-5px) scale(1.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .quiz-title {
                font-size: 2rem;
            }

            .result-message {
                font-size: 1.5rem;
            }

            .score-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .progress-circle {
                width: 150px;
                height: 150px;
            }

            .circle-percentage {
                font-size: 2rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .score-details {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .result-hero {
                padding: 30px 20px;
            }

            .quiz-title {
                font-size: 1.8rem;
            }

            .result-emoji {
                font-size: 3rem;
            }

            .score-section {
                padding: 30px 20px;
            }

            .encouragement-section {
                padding: 20px;
            }
        }

        /* Trophy Animation */
        .trophy-container {
            position: relative;
            width: 100px;
            height: 100px;
            margin: 0 auto 20px;
            animation: trophyFloat 3s ease-in-out infinite;
        }

        @keyframes trophyFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Celebration Animation */
        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background: <?php echo $color; ?>;
            opacity: 0;
        }

        /* Print Styles */
        @media print {
            .action-buttons,
            .share-section,
            .review-actions {
                display: none;
            }
            
            .result-card {
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
    </style>
</head>
<body>
    <div class="result-container">
        <!-- Header -->
        <div class="result-header">
            <h1 class="quiz-title"><?php echo htmlspecialchars($quiz_title); ?></h1>
            <p class="result-subtitle">Quiz Results</p>
        </div>

        <!-- Main Result Card -->
        <div class="result-card">
            <!-- Hero Section -->
            <div class="result-hero">
                <div class="result-emoji"><?php echo $emoji; ?></div>
                <h2 class="result-message"><?php echo $message; ?></h2>
                <p class="result-level">Achievement Level: <strong><?php echo $level; ?></strong></p>
            </div>

            <!-- Score Section -->
            <div class="score-section">
                <div class="score-header">
                    <h3 class="score-title">
                        <i class="fas fa-chart-bar"></i>
                        Your Score Summary
                    </h3>
                    <div class="score-badge"><?php echo $percentage; ?>%</div>
                </div>

                <!-- Progress Circle -->
                <div class="progress-circle-container">
                    <div class="progress-circle">
                        <svg width="200" height="200">
                            <circle class="circle-bg" cx="100" cy="100" r="90"></circle>
                            <circle class="circle-progress" cx="100" cy="100" r="90"></circle>
                        </svg>
                        <div class="circle-text">
                            <div class="circle-percentage"><?php echo $percentage; ?>%</div>
                            <div class="circle-label">Score</div>
                        </div>
                    </div>
                </div>

                <!-- Score Details -->
                <div class="score-details">
                    <div class="detail-card">
                        <div class="detail-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="detail-value"><?php echo $score; ?></div>
                        <div class="detail-label">Correct Answers</div>
                    </div>

                    <div class="detail-card">
                        <div class="detail-icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="detail-value"><?php echo $total - $score; ?></div>
                        <div class="detail-label">Incorrect Answers</div>
                    </div>

                    <div class="detail-card">
                        <div class="detail-icon">
                            <i class="fas fa-list-ol"></i>
                        </div>
                        <div class="detail-value"><?php echo $total; ?></div>
                        <div class="detail-label">Total Questions</div>
                    </div>

                    <div class="detail-card">
                        <div class="detail-icon">
                            <i class="fas fa-percentage"></i>
                        </div>
                        <div class="detail-value"><?php echo $percentage; ?>%</div>
                        <div class="detail-label">Accuracy Rate</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Encouragement Section -->
        <div class="encouragement-section">
            <div class="encouragement-header">
                <i class="fas fa-bullhorn"></i>
                <h3>Words of Encouragement</h3>
            </div>
            <p class="encouragement-text"><?php echo $encouragement; ?></p>
        </div>

        <!-- Review Section (only if there are incorrect answers) -->
        <?php if (!empty($incorrect_questions)): ?>
        <div class="review-section">
            <div class="review-header">
                <i class="fas fa-book-open"></i>
                <h3>Questions to Review</h3>
            </div>
            <ul class="review-list">
                <?php foreach ($incorrect_questions as $index => $question): ?>
                <li class="review-item">
                    <div class="review-question">
                        <i class="fas fa-question-circle"></i>
                        <span><?php echo htmlspecialchars($question['question_text']); ?></span>
                    </div>
                    <div class="review-actions">
                        <a href="javascript:void(0);" class="review-btn" onclick="reviewQuestion(<?php echo $question['question_id']; ?>)">
                            <i class="fas fa-redo"></i>
                            Review This Question
                        </a>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="index.php" class="btn btn-primary">
                <i class="fas fa-home"></i>
                Back to Home
            </a>
            
            <?php if ($percentage < 100): ?>
            <a href="quiz.php?id=<?php echo $quiz_id; ?>" class="btn btn-warning">
                <i class="fas fa-redo"></i>
                Retry Quiz
            </a>
            <?php endif; ?>
            
            <a href="index.php#quiz-section" class="btn btn-success">
                <i class="fas fa-list"></i>
                Try Another Quiz
            </a>
        </div>

        <!-- Share Results -->
        <div class="share-section">
            <h4 class="share-title">Share Your Results</h4>
            <div class="share-buttons">
                <a href="#" class="share-btn facebook" onclick="shareOnFacebook()">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="share-btn twitter" onclick="shareOnTwitter()">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="share-btn whatsapp" onclick="shareOnWhatsApp()">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a href="#" class="share-btn copy" onclick="copyResults()">
                    <i class="fas fa-copy"></i>
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Create confetti effect for high scores
            <?php if ($percentage >= 75): ?>
            createConfetti();
            <?php endif; ?>

            // Add celebration animation for perfect scores
            <?php if ($percentage == 100): ?>
            celebratePerfectScore();
            <?php endif; ?>

            // Print results
            function printResults() {
                window.print();
            }

            // Share functions
            function shareOnFacebook() {
                const text = `I scored ${<?php echo $percentage; ?>}% on "${<?php echo addslashes($quiz_title); ?>}" quiz! Try it yourself on Smart Quiz!`;
                const url = window.location.href;
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}&quote=${encodeURIComponent(text)}`, '_blank');
            }

            function shareOnTwitter() {
                const text = `🎯 I scored ${<?php echo $percentage; ?>}% on "${<?php echo addslashes($quiz_title); ?>}" quiz!`;
                const url = window.location.href;
                window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`, '_blank');
            }

            function shareOnWhatsApp() {
                const text = `I scored ${<?php echo $percentage; ?>}% on "${<?php echo addslashes($quiz_title); ?>}" quiz! Try it yourself: ${window.location.href}`;
                window.open(`https://wa.me/?text=${encodeURIComponent(text)}`, '_blank');
            }

            function copyResults() {
                const text = `Smart Quiz Results:\nQuiz: ${<?php echo addslashes($quiz_title); ?>}\nScore: ${<?php echo $score; ?>}/${<?php echo $total; ?>}\nPercentage: ${<?php echo $percentage; ?>}%\nLevel: ${<?php echo addslashes($level); ?>}`;
                
                navigator.clipboard.writeText(text).then(() => {
                    alert('Results copied to clipboard!');
                }).catch(err => {
                    console.error('Failed to copy: ', err);
                });
            }

            // Confetti effect
            function createConfetti() {
                const container = document.querySelector('.result-hero');
                const colors = ['<?php echo $color; ?>', '#4361ee', '#7209b7', '#f72585', '#4cc9f0'];
                
                for (let i = 0; i < 50; i++) {
                    const confetti = document.createElement('div');
                    confetti.className = 'confetti';
                    confetti.style.left = Math.random() * 100 + '%';
                    confetti.style.top = Math.random() * 100 + '%';
                    confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                    confetti.style.opacity = '0';
                    confetti.style.transform = `rotate(${Math.random() * 360}deg)`;
                    container.appendChild(confetti);
                    
                    // Animate confetti
                    setTimeout(() => {
                        confetti.style.transition = 'all 1s ease';
                        confetti.style.opacity = '1';
                        confetti.style.transform = `translate(${Math.random() * 100 - 50}px, ${Math.random() * 100 - 50}px) rotate(${Math.random() * 360}deg)`;
                        
                        // Remove after animation
                        setTimeout(() => {
                            confetti.style.opacity = '0';
                            setTimeout(() => confetti.remove(), 1000);
                        }, 2000);
                    }, i * 50);
                }
            }

            // Perfect score celebration
            function celebratePerfectScore() {
                const emoji = document.querySelector('.result-emoji');
                emoji.style.animation = 'bounce 1s ease-in-out infinite';
                
                // Add sparkle effect
                setInterval(() => {
                    emoji.style.textShadow = '0 0 20px rgba(255, 215, 0, 0.8)';
                    setTimeout(() => {
                        emoji.style.textShadow = 'none';
                    }, 300);
                }, 1000);
            }

            // Review question function
            window.reviewQuestion = function(questionId) {
                alert('In a real implementation, this would show the question details and correct answer.\nQuestion ID: ' + questionId);
                // You could implement a modal or redirect to a review page
            }

            // Add keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if (e.key === 'r' || e.key === 'R') {
                    window.location.href = 'quiz.php?id=<?php echo $quiz_id; ?>';
                } else if (e.key === 'h' || e.key === 'H') {
                    window.location.href = 'index.php';
                } else if (e.key === 'p' && e.ctrlKey) {
                    e.preventDefault();
                    printResults();
                }
            });

            // Display keyboard shortcuts info
            setTimeout(() => {
                console.log('Keyboard shortcuts available:');
                console.log('R - Retry quiz');
                console.log('H - Go home');
                console.log('Ctrl+P - Print results');
            }, 1000);
        });
    </script>
</body>
</html>