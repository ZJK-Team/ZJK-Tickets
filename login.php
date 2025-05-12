<?php
session_start();
$conn = new mysqli('localhost', 'root', 'root', 'auth_roles');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Zpracování přihlašovacího formuláře
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Dotaz na uživatele podle uživatelského jména
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Ověření hesla a přihlášení
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {  // Ověření proti hashovanému heslu
            // Uložení informací o uživateli do session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Přesměrování na hlavní stránku
            header("Location: index.php");
            exit();
        } else {
            $error = "Nesprávné heslo.";
        }
    } else {
        $error = "Uživatel nenalezen.";
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přihlášení</title>
    <link rel="stylesheet" href="styles/login.css">
</head>
<body>

    <div class="login-container">
        <form action="login.php" method="POST" class="login-form">
            <h2>Přihlášení</h2>
            
            <!-- Zobrazení chyby pokud je nějaká -->
            <?php if (isset($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <input type="text" name="username" placeholder="Uživatelské jméno" required>
            <input type="password" name="password" placeholder="Heslo" required>
            <button type="submit">Přihlásit se</button>
            <a href="signup.php" class="signup-link">Zaregistrovat se</a>
        </form>
    </div>

</body>
</html>