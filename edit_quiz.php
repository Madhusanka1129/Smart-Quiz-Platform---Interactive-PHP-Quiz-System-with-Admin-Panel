<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit;
}

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM quizzes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$quiz = $result->fetch_assoc();

if (!$quiz) {
    header("Location: admin_dashboard.php");
    exit;
}

$msg = '';
$msg_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    $update = $conn->prepare("UPDATE quizzes SET title=?, description=? WHERE id=?");
    $update->bind_param("ssi", $title, $description, $id);
    if ($update->execute()) {
        $msg = "✅ Quiz updated successfully! Redirecting...";
        $msg_type = 'success';
        header("Refresh: 2; url=admin_dashboard.php");
    } else {
        $msg = "❌ Error updating quiz. Please try again.";
        $msg_type = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Quiz | Admin Dashboard</title>
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
            background: linear-gradient(135deg, var(--warning), #e76f51);
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

        /* Quiz Info Card */
        .quiz-info-card {
            background: linear-gradient(135deg, #f8f9ff 0%, #eef1ff 100%);
            border-radius: var(--border-radius);
            padding: 25px 30px;
            margin-bottom: 30px;
            border-left: 5px solid var(--primary);
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

        .quiz-info-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .quiz-info-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .quiz-info-header h3 {
            font-size: 1.4rem;
            color: var(--dark);
        }

        .quiz-info-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 15px;
        }

        .info-item {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .info-label {
            font-size: 0.85rem;
            color: var(--gray);
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .info-value {
            font-weight: 600;
            color: var(--dark);
            font-size: 1.1rem;
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
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.1rem;
            color: var(--dark);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
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

        /* Preview Section */
        .preview-section {
            background: var(--light);
            border-radius: var(--border-radius);
            padding: 25px;
            margin-top: 30px;
            border: 2px dashed var(--light-gray);
        }

        .preview-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
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

        /* Form Actions */
        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 40px;
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

        .btn-warning {
            background: linear-gradient(135deg, var(--warning), #e76f51);
            color: white;
            box-shadow: 0 6px 20px rgba(248, 150, 30, 0.3);
        }

        .btn-warning:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(248, 150, 30, 0.4);
        }

        .btn i {
            font-size: 1.2rem;
        }

        /* Danger Zone */
        .danger-zone {
            background: linear-gradient(135deg, #fff5f5 0%, #ffe3e3 100%);
            border-radius: var(--border-radius);
            padding: 25px;
            margin-top: 40px;
            border: 2px solid #ffc9c9;
        }

        .danger-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            color: var(--danger);
        }

        .danger-content p {
            color: #666;
            margin-bottom: 15px;
            font-size: 0.95rem;
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

            .quiz-info-content {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .form-content {
                padding: 30px 20px;
            }

            .form-actions {
                flex-direction: column;
                gap: 15px;
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

            .danger-zone .btn {
                width: 100%;
                margin-top: 10px;
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

            .quiz-info-card {
                padding: 20px;
            }

            .preview-section {
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

        /* Animation for form elements */
        .form-group {
            animation: fadeInUp 0.5s ease-out forwards;
            opacity: 0;
            transform: translateY(10px);
        }

        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.2s; }
        .form-group:nth-child(3) { animation-delay: 0.3s; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
                <a href="edit_quiz.php?id=<?php echo $id; ?>" class="active">
                    <i class="fas fa-edit"></i>
                    Edit Quiz
                </a>
            </li>
            <li>
                <a href="logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
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
                    <i class="fas fa-edit"></i>
                </div>
                <div>
                    <h1>Edit Quiz</h1>
                    <p>Update quiz details and save changes</p>
                </div>
            </div>
            
            <div class="breadcrumb">
                <a href="admin_dashboard.php">Dashboard</a>
                <i class="fas fa-chevron-right"></i>
                <span>Edit Quiz #<?php echo $id; ?></span>
            </div>
        </div>

        <!-- Quiz Info Card -->
        <div class="quiz-info-card">
            <div class="quiz-info-header">
                <div class="quiz-info-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <h3>Quiz Information</h3>
            </div>
            <div class="quiz-info-content">
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-hashtag"></i>
                        Quiz ID
                    </div>
                    <div class="info-value">#<?php echo $id; ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-calendar"></i>
                        Last Updated
                    </div>
                    <div class="info-value"><?php echo date('F j, Y'); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-question-circle"></i>
                        Questions Count
                    </div>
                    <div class="info-value">
                        <?php
                        $question_count = $conn->query("SELECT COUNT(*) as count FROM questions WHERE quiz_id = $id")->fetch_assoc()['count'];
                        echo $question_count;
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="form-container">
            <div class="form-header">
                <h2>
                    <i class="fas fa-edit"></i>
                    Edit Quiz Details
                </h2>
                <p>Update the quiz title and description below. Changes will be saved immediately.</p>
            </div>

            <!-- Success/Error Message -->
            <?php if($msg): ?>
                <div class="message-alert <?php echo $msg_type === 'success' ? 'success' : 'error'; ?>">
                    <i class="fas <?php echo $msg_type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
                    <div><?php echo $msg; ?></div>
                </div>
            <?php endif; ?>

            <form method="POST" class="form-content" id="editForm">
                <!-- Quiz Title -->
                <div class="form-group">
                    <label class="form-label" for="title">
                        Quiz Title
                        <span class="label-hint">(Required, max 100 characters)</span>
                    </label>
                    <div class="input-with-icon">
                        <i class="fas fa-heading"></i>
                        <input 
                            type="text" 
                            id="title" 
                            name="title" 
                            value="<?php echo htmlspecialchars($quiz['title']); ?>" 
                            required
                            maxlength="100"
                            oninput="updateCharCount(this, 'title-counter')"
                            placeholder="Enter quiz title"
                        >
                    </div>
                    <div class="char-count" id="title-counter">
                        <?php echo strlen($quiz['title']); ?>/100 characters
                    </div>
                </div>

                <!-- Quiz Description -->
                <div class="form-group">
                    <label class="form-label" for="description">
                        Description
                        <span class="label-hint">(Optional, max 500 characters)</span>
                    </label>
                    <div class="input-with-icon">
                        <i class="fas fa-align-left"></i>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="4"
                            maxlength="500"
                            oninput="updateCharCount(this, 'desc-counter')"
                            placeholder="Describe your quiz..."
                        ><?php echo htmlspecialchars($quiz['description']); ?></textarea>
                    </div>
                    <div class="char-count" id="desc-counter">
                        <?php echo strlen($quiz['description']); ?>/500 characters
                    </div>
                </div>

                <!-- Live Preview -->
                <div class="preview-section">
                    <div class="preview-title">
                        <i class="fas fa-eye"></i>
                        <h4>Live Preview</h4>
                    </div>
                    <div class="preview-card" id="previewCard">
                        <h4 id="previewTitle"><?php echo htmlspecialchars($quiz['title']); ?></h4>
                        <p id="previewDescription">
                            <?php echo $quiz['description'] ? htmlspecialchars($quiz['description']) : 'No description provided'; ?>
                        </p>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <div>
                        <a href="admin_dashboard.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Cancel
                        </a>
                    </div>
                    
                    <div style="display: flex; gap: 15px;">
                        <button type="reset" class="btn btn-secondary" id="resetBtn">
                            <i class="fas fa-redo"></i>
                            Reset
                        </button>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-save"></i>
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Danger Zone -->
        <div class="danger-zone">
            <div class="danger-header">
                <i class="fas fa-exclamation-triangle"></i>
                <h4>Danger Zone</h4>
            </div>
            <div class="danger-content">
                <p>Once you delete a quiz, there is no going back. Please be certain.</p>
                <a href="delete_quiz.php?id=<?php echo $id; ?>" 
                   class="btn btn-warning"
                   onclick="return confirmDelete()">
                    <i class="fas fa-trash-alt"></i>
                    Delete This Quiz
                </a>
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
            
            // Character counter
            function updateCharCount(element, counterId) {
                const counter = document.getElementById(counterId);
                const length = element.value.length;
                const maxLength = element.maxLength;
                
                counter.textContent = `${length}/${maxLength} characters`;
                counter.className = 'char-count';
                
                if (length > maxLength * 0.8) {
                    counter.classList.add('warning');
                }
                if (length >= maxLength) {
                    counter.classList.add('danger');
                }
                
                // Update preview
                if (element.id === 'title') {
                    document.getElementById('previewTitle').textContent = 
                        element.value || 'Quiz Title';
                } else if (element.id === 'description') {
                    document.getElementById('previewDescription').textContent = 
                        element.value || 'No description provided';
                    
                    // Update preview card border color based on content
                    const previewCard = document.getElementById('previewCard');
                    if (element.value.length > 0) {
                        previewCard.style.borderLeftColor = 'var(--success)';
                    } else {
                        previewCard.style.borderLeftColor = 'var(--primary)';
                    }
                }
            }
            
            // Live preview updates
            const titleInput = document.getElementById('title');
            const descInput = document.getElementById('description');
            
            titleInput.addEventListener('input', function() {
                updateCharCount(this, 'title-counter');
            });
            
            descInput.addEventListener('input', function() {
                updateCharCount(this, 'desc-counter');
            });
            
            // Form validation
            const form = document.getElementById('editForm');
            const submitBtn = document.getElementById('submitBtn');
            
            form.addEventListener('submit', function(e) {
                const title = titleInput.value.trim();
                
                if (!title) {
                    e.preventDefault();
                    showError('Please enter a quiz title.');
                    titleInput.focus();
                    return;
                }
                
                if (title.length < 3) {
                    e.preventDefault();
                    showError('Quiz title should be at least 3 characters long.');
                    titleInput.focus();
                    return;
                }
                
                // Check if there are changes
                const originalTitle = '<?php echo addslashes($quiz['title']); ?>';
                const originalDesc = '<?php echo addslashes($quiz['description']); ?>';
                
                if (title === originalTitle && descInput.value.trim() === originalDesc) {
                    e.preventDefault();
                    showError('No changes were made to the quiz.');
                    return;
                }
                
                // Show loading state
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner"></i> Saving...';
            });
            
            // Reset button
            const resetBtn = document.getElementById('resetBtn');
            resetBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (confirm('Are you sure you want to reset the form? All unsaved changes will be lost.')) {
                    // Reset to original values
                    titleInput.value = '<?php echo addslashes($quiz['title']); ?>';
                    descInput.value = '<?php echo addslashes($quiz['description']); ?>';
                    
                    // Update counters and preview
                    updateCharCount(titleInput, 'title-counter');
                    updateCharCount(descInput, 'desc-counter');
                    
                    // Reset preview card border
                    document.getElementById('previewCard').style.borderLeftColor = 'var(--primary)';
                    
                    showSuccess('Form has been reset to original values.');
                }
            });
            
            // Delete confirmation
            function confirmDelete() {
                const questionCount = <?php echo $question_count; ?>;
                let message = 'Are you sure you want to delete this quiz?';
                
                if (questionCount > 0) {
                    message += `\n\n⚠️ Warning: This quiz contains ${questionCount} question(s) that will also be deleted.`;
                }
                
                message += '\n\nThis action cannot be undone.';
                
                return confirm(message);
            }
            
            // Error message function
            function showError(message) {
                // Remove existing alerts
                const existingAlert = document.querySelector('.message-alert:not(.success)');
                if (existingAlert) {
                    existingAlert.remove();
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
            
            // Success message function
            function showSuccess(message) {
                // Remove existing alerts
                const existingAlert = document.querySelector('.message-alert');
                if (existingAlert) {
                    existingAlert.remove();
                }
                
                // Create success element
                const successDiv = document.createElement('div');
                successDiv.className = 'message-alert success';
                successDiv.innerHTML = `
                    <i class="fas fa-check-circle"></i>
                    <div>${message}</div>
                `;
                
                // Insert after form header
                const formContainer = document.querySelector('.form-container');
                const formHeader = document.querySelector('.form-header');
                formContainer.insertBefore(successDiv, formHeader.nextSibling);
                
                // Auto-remove after 3 seconds
                setTimeout(() => {
                    successDiv.style.opacity = '0';
                    successDiv.style.transform = 'translateY(-10px)';
                    setTimeout(() => successDiv.remove(), 300);
                }, 3000);
            }
            
            // Auto-save functionality (optional)
            let autoSaveTimeout;
            let lastSavedTitle = titleInput.value;
            let lastSavedDesc = descInput.value;
            
            function checkForChanges() {
                const currentTitle = titleInput.value;
                const currentDesc = descInput.value;
                
                return currentTitle !== lastSavedTitle || currentDesc !== lastSavedDesc;
            }
            
            // Optional: Add auto-save indicator
            titleInput.addEventListener('input', () => {
                clearTimeout(autoSaveTimeout);
                autoSaveTimeout = setTimeout(() => {
                    if (checkForChanges()) {
                        // Show saving indicator
                        const indicator = document.createElement('div');
                        indicator.className = 'message-alert';
                        indicator.innerHTML = '<i class="fas fa-save"></i> <div>Saving changes...</div>';
                        indicator.style.background = 'linear-gradient(135deg, #e6f7ff, #d1ecff)';
                        indicator.style.borderLeftColor = 'var(--primary)';
                        
                        const formContainer = document.querySelector('.form-container');
                        const formHeader = document.querySelector('.form-header');
                        formContainer.insertBefore(indicator, formHeader.nextSibling);
                        
                        setTimeout(() => {
                            indicator.style.opacity = '0';
                            setTimeout(() => indicator.remove(), 300);
                        }, 1000);
                        
                        lastSavedTitle = titleInput.value;
                        lastSavedDesc = descInput.value;
                    }
                }, 1000);
            });
            
            descInput.addEventListener('input', () => {
                clearTimeout(autoSaveTimeout);
                autoSaveTimeout = setTimeout(() => {
                    if (checkForChanges()) {
                        // Similar auto-save indicator
                    }
                }, 1000);
            });
        });
    </script>
</body>
</html>