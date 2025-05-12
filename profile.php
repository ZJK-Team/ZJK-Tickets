<?php
session_start();
include 'header.php';
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $conn->prepare("SELECT username, role FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);  
$stmt->execute();
$stmt->bind_result($username, $role);
$stmt->fetch();
?>

<link rel="stylesheet" href="styles/style.css">
<main class="profile-main">
    <div class="main-container-profile">
        <h2>Váš profil</h2>
        <p><strong>Uživatelské jméno:</strong> <?php echo htmlspecialchars($username); ?></p>
        <p><strong>Role:</strong> <?php echo htmlspecialchars($role); ?></p>

        <div class="contr_png">
            <?php if ($role === 'admin'): ?>
                <img id="img_profile" src="/img/admin.png" alt=""> 
            <?php endif; ?>
            <?php if ($role === 'user'): ?>
                <img id="img_profile" src="/img/User.png" alt="">
            <?php endif; ?>
        </div>

    </div>
</main>

<?php include 'footer.php'; ?>

