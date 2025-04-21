<?php
$host = 'localhost';
$user = 'root';
$password = 'root';
$database = 'auth_roles';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Připojení selhalo: " . $conn->connect_error);
}
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>