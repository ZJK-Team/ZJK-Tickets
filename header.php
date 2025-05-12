<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="/styles/header.css">
    <script src="/script/burger.js" defer></script>
</head>
<body>
    <header>

        <div class="wrapper">

            <div class="wrapper-logo">
                <img src="img/ZJK_Logo.png" alt=""> 
            </div>

            <div class="wrapper-hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
          
        <nav>
        <div class="navbar">
        <a href="index.php">Domů</a>
        <a href="profile.php">Profil</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="my_tickets.php">Moje Tickety</a>
        <?php endif; ?>

        <?php if (isset($_SESSION['role'])): ?>
            <!-- Navigace pro Admina -->
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="admin_dashboard.php" class="admin-nav-link">Admin Panel</a>
            <?php endif; ?>
        <?php endif; ?>
        <a href="logout.php">Odhlásit se</a>
        <a id="nesvit"> <?php echo htmlspecialchars($_SESSION['username']); ?> </a>

    </div>

        </nav>
    </header>
    <main>


    </main>
    <footer>

    </footer>
</body>
</html>