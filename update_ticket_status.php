<?php
session_start();
include 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ticket_id'], $_POST['status'])) {
    $ticket_id = $_POST['ticket_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE tickets SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $ticket_id);
    $stmt->execute();

    header("Location: admin_tickets.php");
    exit;
}
