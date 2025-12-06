<?php
$host = 'localhost';
$user = 'root';
$pass = 'Nethu@1129';
$db = 'online_quiz';

$conn = new mysqli($host, $user, $pass, $db,3309);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>
