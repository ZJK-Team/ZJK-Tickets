<?php
session_start();
include 'header.php';  // Zajistíme, že se načte hlavička
include 'config.php';  // Připojíme se k databázi

// Pokud uživatel není přihlášen, přesměrujeme ho na přihlašovací stránku
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Připojíme se k databázi a načteme údaje uživatele
$stmt = $conn->prepare("SELECT username, role FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);  // Parametr pro ID přihlášeného uživatele
$stmt->execute();
$stmt->bind_result($username, $role);
$stmt->fetch();  // Načteme údaje
?>

<link rel="stylesheet" href="style.css">
<main class="profile-main">
    <div class="main-container-profile">
        <h2>Váš profil</h2>
        <p><strong>Uživatelské jméno:</strong> <?php echo htmlspecialchars($username); ?></p>
        <p><strong>Role:</strong> <?php echo htmlspecialchars($role); ?></p>
        <!-- Podmíněný zobrazení odkazu pro Admin panel -->
        <?php if ($role === 'admin'): ?>
            <p><a href="admin_dashboard.php" class="admin-panel-link">Admin Panel</a></p><img id="img_profile" src="/img/admin.png" alt=""> 
        <?php endif; ?>
        <?php if ($role === 'user'): ?>
            <img id="img_profile" src="/img/User.png" alt="">
        <?php endif; ?>
    </div>
</main>

<?php include 'footer.php'; ?>
