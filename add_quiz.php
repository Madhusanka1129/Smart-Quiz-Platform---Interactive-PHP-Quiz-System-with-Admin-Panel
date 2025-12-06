<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    
    $stmt = $conn->prepare("INSERT INTO quizzes (title, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $description);

    if ($stmt->execute()) {
        $quiz_id = $conn->insert_id; 
        header("Location: add_question.php?quiz_id=" . $quiz_id);
        exit;
    } else {
        $msg = "❌ Error adding quiz.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Quiz | Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Variables & Base Styles */
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --secondary: #7209b7;
            --accent: #f72585;
            --success: #2dce89;
            --danger: #e74c3c;
            --warning: #f8961e;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --light-gray: #e9ecef;
            --sidebar-width: 250px;
            --transition: all 0.3s ease;
            --border-radius: 12px;
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
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            text-align: center;
        }

        .form-header h2 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .form-header p {
            opacity: 0.9;
            font-size: 0.95rem;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Form Content */
        .form-content {
            padding: 40px;
        }

        /* Error Message */
        .message {
            background: linear-gradient(135deg, var(--danger), #c0392b);
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 500;
            animation: shake 0.5s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .message.success {
            background: linear-gradient(135deg, var(--success), #28b87a);
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* Form Styles */
        .quiz-form {
            max-width: 800px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 30px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: var(--dark);
            font-size: 1rem;
        }

        .form-group .label-info {
            font-size: 0.85rem;
            color: var(--gray);
            font-weight: 400;
            margin-top: 5px;
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

        .char-count {
            text-align: right;
            font-size: 0.85rem;
            color: var(--gray);
            margin-top: 8px;
        }

        .char-count.warning {
            color: var(--warning);
        }

        .char-count.danger {
            color: var(--danger);
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 30px;
            margin-top: 40px;
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

        .btn i {
            font-size: 1.2rem;
        }

        /* Preview Section */
        .preview-section {
            background: var(--light);
            border-radius: var(--border-radius);
            padding: 30px;
            margin-top: 40px;
            border: 2px dashed var(--light-gray);
        }

        .preview-section h3 {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            color: var(--dark);
        }

        .preview-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--card-shadow);
            border-left: 5px solid var(--primary);
        }

        .preview-card h4 {
            color: var(--dark);
            margin-bottom: 10px;
            font-size: 1.3rem;
        }

        .preview-card p {
            color: var(--gray);
            line-height: 1.6;
        }

        /* Tips Section */
        .tips-section {
            background: linear-gradient(135deg, #fff8e1 0%, #fff3cd 100%);
            border-radius: var(--border-radius);
            padding: 25px;
            margin-top: 40px;
            border-left: 5px solid var(--warning);
        }

        .tips-section h3 {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            color: var(--dark);
        }

        .tips-section ul {
            padding-left: 20px;
            color: var(--gray);
        }

        .tips-section li {
            margin-bottom: 10px;
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
        }

        @media (max-width: 768px) {
            .form-content {
                padding: 30px 20px;
            }

            .form-actions {
                flex-direction: column;
                gap: 20px;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .form-header {
                padding: 25px 20px;
            }

            .form-header h2 {
                font-size: 1.3rem;
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

            .input-with-icon input,
            .input-with-icon textarea {
                padding: 15px 15px 15px 50px;
                font-size: 0.95rem;
            }

            .preview-section,
            .tips-section {
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

        /* Progress Indicator */
        .progress-indicator {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 40px;
            margin-bottom: 40px;
        }

        .progress-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            position: relative;
        }

        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--light-gray);
            color: var(--gray);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            transition: var(--transition);
        }

        .progress-step.active .step-number {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            transform: scale(1.1);
        }

        .step-label {
            font-size: 0.9rem;
            color: var(--gray);
            font-weight: 500;
        }

        .progress-step.active .step-label {
            color: var(--primary);
            font-weight: 600;
        }

        .progress-step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 20px;
            left: 60px;
            width: 80px;
            height: 2px;
            background: var(--light-gray);
        }

        .progress-step.active:not(:last-child)::after {
            background: linear-gradient(to right, var(--primary), var(--light-gray));
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
                <a href="add_quiz.php" class="active">
                    <i class="fas fa-plus-circle"></i>
                    Add New Quiz
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-question-circle"></i>
                    Manage Questions
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
                    <i class="fas fa-plus-circle"></i>
                </div>
                <div>
                    <h1>Create New Quiz</h1>
                    <p>Fill in the details below to create a new quiz</p>
                </div>
            </div>
            
            <div class="breadcrumb">
                <a href="admin_dashboard.php">Dashboard</a>
                <i class="fas fa-chevron-right"></i>
                <span>Create Quiz</span>
            </div>
        </div>

        <!-- Progress Indicator -->
        <div class="progress-indicator">
            <div class="progress-step active">
                <div class="step-number">1</div>
                <div class="step-label">Quiz Details</div>
            </div>
            <div class="progress-step">
                <div class="step-number">2</div>
                <div class="step-label">Add Questions</div>
            </div>
            <div class="progress-step">
                <div class="step-number">3</div>
                <div class="step-label">Preview & Publish</div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="form-container">
            <div class="form-header">
                <h2>
                    <i class="fas fa-clipboard-list"></i>
                    Quiz Information
                </h2>
                <p>Start by providing basic information about your quiz. You'll be able to add questions in the next step.</p>
            </div>

            <div class="form-content">
                <?php if ($msg): ?>
                    <div class="message">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo $msg; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="quiz-form" id="quizForm">
                    <!-- Quiz Title -->
                    <div class="form-group">
                        <label for="title">Quiz Title <span class="required">*</span></label>
                        <div class="label-info">Choose a clear and descriptive title for your quiz (Max 100 characters)</div>
                        <div class="input-with-icon">
                            <i class="fas fa-heading"></i>
                            <input 
                                type="text" 
                                id="title" 
                                name="title" 
                                placeholder="Enter quiz title (e.g., 'General Knowledge Quiz', 'JavaScript Fundamentals')" 
                                required
                                maxlength="100"
                                oninput="updateCharCount(this, 'title-count')"
                                value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>"
                            >
                        </div>
                        <div class="char-count" id="title-count">0/100 characters</div>
                    </div>

                    <!-- Quiz Description -->
                    <div class="form-group">
                        <label for="description">Description</label>
                        <div class="label-info">Describe what the quiz covers and who it's for (Max 500 characters)</div>
                        <div class="input-with-icon">
                            <i class="fas fa-align-left"></i>
                            <textarea 
                                id="description" 
                                name="description" 
                                placeholder="Describe your quiz. Include topics covered, difficulty level, and any prerequisites..."
                                maxlength="500"
                                oninput="updateCharCount(this, 'desc-count')"
                            ><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                        </div>
                        <div class="char-count" id="desc-count">0/500 characters</div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="admin_dashboard.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Back to Dashboard
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <span>Next: Add Questions</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </form>

                <!-- Preview Section -->
                <div class="preview-section">
                    <h3>
                        <i class="fas fa-eye"></i>
                        Live Preview
                    </h3>
                    <div class="preview-card" id="quizPreview">
                        <h4 id="previewTitle">Your Quiz Title Will Appear Here</h4>
                        <p id="previewDescription">Your quiz description will appear here once you start typing.</p>
                    </div>
                </div>

                <!-- Tips Section -->
                <div class="tips-section">
                    <h3>
                        <i class="fas fa-lightbulb"></i>
                        Tips for Creating Great Quizzes
                    </h3>
                    <ul>
                        <li>Keep titles clear and descriptive</li>
                        <li>Include relevant topics in the description</li>
                        <li>Specify the difficulty level</li>
                        <li>Mention the target audience</li>
                        <li>Use proper grammar and spelling</li>
                    </ul>
                </div>
            </div>
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
            
            // Initialize character counters
            updateCharCount(document.getElementById('title'), 'title-count');
            updateCharCount(document.getElementById('description'), 'desc-count');
            
            // Form validation
            const form = document.getElementById('quizForm');
            form.addEventListener('submit', function(e) {
                const title = document.getElementById('title').value.trim();
                const description = document.getElementById('description').value.trim();
                
                if (!title) {
                    e.preventDefault();
                    showError('Please enter a quiz title');
                    document.getElementById('title').focus();
                    return false;
                }
                
                if (title.length < 3) {
                    e.preventDefault();
                    showError('Quiz title should be at least 3 characters long');
                    document.getElementById('title').focus();
                    return false;
                }
                
                // Show loading state
                const submitBtn = form.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Quiz...';
            });
            
            // Real-time preview
            const titleInput = document.getElementById('title');
            const descInput = document.getElementById('description');
            const previewTitle = document.getElementById('previewTitle');
            const previewDesc = document.getElementById('previewDescription');
            
            titleInput.addEventListener('input', function() {
                const value = this.value.trim();
                previewTitle.textContent = value || 'Your Quiz Title Will Appear Here';
                updatePreviewStyle();
            });
            
            descInput.addEventListener('input', function() {
                const value = this.value.trim();
                previewDesc.textContent = value || 'Your quiz description will appear here once you start typing.';
                updatePreviewStyle();
            });
            
            function updatePreviewStyle() {
                const previewCard = document.getElementById('quizPreview');
                const hasContent = titleInput.value.trim() || descInput.value.trim();
                
                if (hasContent) {
                    previewCard.style.borderLeftColor = 'var(--success)';
                } else {
                    previewCard.style.borderLeftColor = 'var(--primary)';
                }
            }
        });
        
        function updateCharCount(input, counterId) {
            const counter = document.getElementById(counterId);
            const length = input.value.length;
            const maxLength = input.maxLength;
            
            counter.textContent = `${length}/${maxLength} characters`;
            
            // Update color based on usage
            counter.className = 'char-count';
            if (length > maxLength * 0.8) {
                counter.classList.add('warning');
            }
            if (length >= maxLength) {
                counter.classList.add('danger');
            }
        }
        
        function showError(message) {
            // Create error message element
            const errorDiv = document.createElement('div');
            errorDiv.className = 'message';
            errorDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${message}`;
            
            // Insert at the beginning of form content
            const formContent = document.querySelector('.form-content');
            const existingError = formContent.querySelector('.message');
            
            if (existingError) {
                existingError.remove();
            }
            
            formContent.insertBefore(errorDiv, formContent.firstChild);
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                if (errorDiv.parentNode) {
                    errorDiv.style.opacity = '0';
                    errorDiv.style.transform = 'translateY(-10px)';
                    setTimeout(() => errorDiv.remove(), 300);
                }
            }, 5000);
        }
    </script>
</body>
</html>