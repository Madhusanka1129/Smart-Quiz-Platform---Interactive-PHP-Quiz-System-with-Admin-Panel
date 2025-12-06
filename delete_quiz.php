<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit;
}

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("DELETE FROM quizzes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: admin_dashboard.php");
exit;
?>
