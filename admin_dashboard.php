<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Smart Quiz</title>
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
            --header-height: 70px;
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
            padding: 20px;
            transition: var(--transition);
        }

        /* Top Header */
        .top-header {
            background: white;
            padding: 20px 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .welcome-message h1 {
            font-size: 1.8rem;
            color: var(--dark);
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .welcome-message p {
            color: var(--gray);
            font-size: 0.95rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .logout-btn {
            padding: 10px 20px;
            background: var(--light-gray);
            color: var(--dark);
            border-radius: 30px;
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logout-btn:hover {
            background: var(--danger);
            color: white;
            transform: translateY(-2px);
        }

        /* Dashboard Cards */
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
        }

        .stat-icon.quiz {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        }

        .stat-icon.question {
            background: linear-gradient(135deg, var(--success), #28b87a);
        }

        .stat-icon.user {
            background: linear-gradient(135deg, var(--secondary), #9d4edd);
        }

        .stat-content h3 {
            font-size: 2rem;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .stat-content p {
            color: var(--gray);
            font-size: 0.9rem;
        }

        /* Quizzes Table */
        .table-container {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            overflow: hidden;
            margin-bottom: 40px;
        }

        .table-header {
            padding: 25px 30px;
            border-bottom: 1px solid var(--light-gray);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-header h2 {
            font-size: 1.5rem;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .add-quiz-btn {
            padding: 12px 25px;
            background: linear-gradient(135deg, var(--success), #28b87a);
            color: white;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
        }

        .add-quiz-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(45, 206, 137, 0.3);
        }

        .quiz-table {
            width: 100%;
            border-collapse: collapse;
        }

        .quiz-table thead {
            background: var(--light);
        }

        .quiz-table th {
            padding: 18px 20px;
            text-align: left;
            font-weight: 600;
            color: var(--dark);
            border-bottom: 2px solid var(--light-gray);
        }

        .quiz-table tbody tr {
            transition: var(--transition);
        }

        .quiz-table tbody tr:hover {
            background: rgba(67, 97, 238, 0.05);
        }

        .quiz-table td {
            padding: 20px;
            border-bottom: 1px solid var(--light-gray);
            color: var(--dark);
        }

        .quiz-title {
            font-weight: 500;
            color: var(--dark);
        }

        .quiz-description {
            color: var(--gray);
            font-size: 0.9rem;
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 5px;
            border: none;
            cursor: pointer;
        }

        .btn-question {
            background: rgba(45, 206, 137, 0.1);
            color: var(--success);
            border: 1px solid rgba(45, 206, 137, 0.3);
        }

        .btn-question:hover {
            background: var(--success);
            color: white;
            transform: translateY(-2px);
        }

        .btn-edit {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary);
            border: 1px solid rgba(67, 97, 238, 0.3);
        }

        .btn-edit:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        .btn-delete {
            background: rgba(231, 76, 60, 0.1);
            color: var(--danger);
            border: 1px solid rgba(231, 76, 60, 0.3);
        }

        .btn-delete:hover {
            background: var(--danger);
            color: white;
            transform: translateY(-2px);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--light-gray);
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .empty-state p {
            color: var(--gray);
            max-width: 400px;
            margin: 0 auto 30px;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 25px;
            color: var(--gray);
            font-size: 0.9rem;
            border-top: 1px solid var(--light-gray);
            margin-top: 40px;
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
            }

            .mobile-menu-btn {
                display: block;
                background: none;
                border: none;
                font-size: 1.5rem;
                color: var(--dark);
                cursor: pointer;
            }

            .top-header {
                flex-direction: column;
                gap: 20px;
                align-items: flex-start;
            }

            .user-info {
                width: 100%;
                justify-content: space-between;
            }
        }

        @media (max-width: 768px) {
            .quiz-table {
                display: block;
                overflow-x: auto;
            }

            .action-buttons {
                flex-direction: column;
                min-width: 150px;
            }

            .btn-action {
                justify-content: center;
            }

            .table-header {
                flex-direction: column;
                gap: 20px;
                align-items: flex-start;
            }

            .add-quiz-btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .stats-cards {
                grid-template-columns: 1fr;
            }

            .main-content {
                padding: 15px;
            }

            .top-header {
                padding: 20px;
            }

            .welcome-message h1 {
                font-size: 1.5rem;
            }

            .table-header h2 {
                font-size: 1.3rem;
            }

            .quiz-table td, .quiz-table th {
                padding: 15px 10px;
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

        /* Animation for table rows */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .quiz-table tbody tr {
            animation: fadeIn 0.3s ease forwards;
            animation-delay: calc(var(--row-index) * 0.05s);
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
                <a href="admin_dashboard.php" class="active">
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
                <a href="#">
                    <i class="fas fa-users"></i>
                    User Management
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-chart-bar"></i>
                    Analytics
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
            <div class="welcome-message">
                <h1>
                    <i class="fas fa-user-shield"></i>
                    Welcome, <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Admin'; ?>
                </h1>
                <p>Manage your quizzes, questions, and platform settings</p>
            </div>
            
            <div class="user-info">
                <div class="user-avatar">
                    <?php 
                    $initials = isset($_SESSION['username']) ? strtoupper(substr($_SESSION['username'], 0, 2)) : 'AD';
                    echo $initials;
                    ?>
                </div>
                <a href="logout.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-cards">
            <?php
            // Get statistics
            $quiz_count = $conn->query("SELECT COUNT(*) as count FROM quizzes")->fetch_assoc()['count'];
            $question_count = $conn->query("SELECT COUNT(*) as count FROM questions")->fetch_assoc()['count'];
            $user_count = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
            ?>
            
            <div class="stat-card">
                <div class="stat-icon quiz">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="stat-content">
                    <h3><?php echo $quiz_count; ?></h3>
                    <p>Total Quizzes</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon question">
                    <i class="fas fa-question-circle"></i>
                </div>
                <div class="stat-content">
                    <h3><?php echo $question_count; ?></h3>
                    <p>Total Questions</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon user">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3><?php echo $user_count; ?></h3>
                    <p>Registered Users</p>
                </div>
            </div>
        </div>

        <!-- Quizzes Table -->
        <div class="table-container">
            <div class="table-header">
                <h2><i class="fas fa-list"></i> Manage Quizzes</h2>
                <a href="add_quiz.php" class="add-quiz-btn">
                    <i class="fas fa-plus"></i>
                    Add New Quiz
                </a>
            </div>

            <?php
            $result = $conn->query("SELECT * FROM quizzes ORDER BY id ASC");
            
            if($result->num_rows > 0):
            ?>
                <table class="quiz-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Quiz Title</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        while ($row = $result->fetch_assoc()):
                            $row_style = "--row-index: " . ($i - 1) . ";";
                        ?>
                            <tr style="<?php echo $row_style; ?>">
                                <td><?php echo $i; ?></td>
                                <td>
                                    <div class="quiz-title"><?php echo htmlspecialchars($row['title']); ?></div>
                                </td>
                                <td>
                                    <div class="quiz-description"><?php echo htmlspecialchars($row['description']); ?></div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="add_question.php?quiz_id=<?php echo $row['id']; ?>" class="btn-action btn-question">
                                            <i class="fas fa-plus"></i> Questions
                                        </a>
                                        <a href="edit_quiz.php?id=<?php echo $row['id']; ?>" class="btn-action btn-edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="delete_quiz.php?id=<?php echo $row['id']; ?>" class="btn-action btn-delete" onclick="return confirm('Are you sure you want to delete this quiz? This action cannot be undone.')">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php 
                        $i++;
                        endwhile; 
                        ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-clipboard-list"></i>
                    <h3>No Quizzes Found</h3>
                    <p>You haven't created any quizzes yet. Start by adding your first quiz!</p>
                    <a href="add_quiz.php" class="add-quiz-btn">
                        <i class="fas fa-plus"></i>
                        Create Your First Quiz
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Footer -->
        <footer>
            © <?php echo date('Y'); ?> Smart Quiz Platform | Admin Panel
            <br>
            <small>Logged in as: <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Admin'; ?></small>
        </footer>
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
            
            // Delete confirmation with sweet alert style
            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    if(!confirm('Are you sure you want to delete this quiz? All associated questions will also be deleted.')) {
                        e.preventDefault();
                    }
                });
            });
            
            // Table row hover effects
            const tableRows = document.querySelectorAll('.quiz-table tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.01)';
                    this.style.boxShadow = '0 5px 20px rgba(0,0,0,0.1)';
                });
                
                row.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                    this.style.boxShadow = 'none';
                });
            });
            
            // Update current time in header
            function updateTime() {
                const now = new Date();
                const timeElement = document.getElementById('currentTime');
                if(timeElement) {
                    timeElement.textContent = now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                }
            }
            
            // Update every minute
            setInterval(updateTime, 60000);
            updateTime();
        });
    </script>
</body>
</html>