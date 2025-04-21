<?php
session_start();
$conn = new mysqli('localhost', 'root', 'root', 'auth_roles');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$error = '';

// Zpracování registrace
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Ověření, zda jsou hesla stejná
    if ($password !== $confirm_password) {
        $error = "Hesla se neshodují.";
    } else {
        // Hashování hesla
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Kontrola, zda už uživatel s tímto jménem existuje
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Uživatel s tímto uživatelským jménem již existuje.";
        } else {
            // Vložení nového uživatele
            $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, 'user')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $username, $hashed_password);
            $stmt->execute();

            // Přesměrování na přihlášení po úspěšné registraci
            header("Location: login.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrace</title>
    <link rel="stylesheet" href="styles/signup.css">
</head>
<body>

    <div class="signup-container">
        <form action="signup.php" method="POST" class="signup-form">
            <h2>Registrace</h2>

            <!-- Zobrazení chybové zprávy -->
            <?php if ($error): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <input type="text" name="username" placeholder="Uživatelské jméno" required>
            <input type="password" name="password" placeholder="Heslo" required>
            <input type="password" name="confirm_password" placeholder="Potvrďte heslo" required>
            <button type="submit">Registrovat</button>
            <a href="login.php" class="login-link">Máte účet? Přihlaste se</a>
        </form>
    </div>

</body>
</html>
