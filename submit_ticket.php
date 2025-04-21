<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO tickets (user_id, subject, message, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iss", $user_id, $subject, $message);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php?ticket=success");
    exit;
}
?>