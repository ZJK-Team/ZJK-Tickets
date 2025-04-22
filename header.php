<?php
session_start();
?>
<?php
echo '<pre>';
print_r($_SESSION);
echo '</pre>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="header.css">
</head>
<body>
<header>
    <!-- Logo v levém horním rohu -->
    <div class="logo">
        <img src="img/ZJK_Logo.png" alt="">
    </div>

    <div class="navbar">
        <a href="index.php">Domů</a>
        <a href="profile.php">Profil</a>
        <a> <?php echo htmlspecialchars($_SESSION['username']); ?> </a>
        <a href="logout.php">Odhlásit se</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="my_tickets.php">Moje Tickety</a>
        <?php endif; ?>

        <?php if (isset($_SESSION['role'])): ?>
            <!-- Navigace pro Admina -->
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="admin_dashboard.php" class="admin-nav-link">Admin Panel</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</header>
</body>
</html>