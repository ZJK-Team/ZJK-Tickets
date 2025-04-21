<?php
session_start();
include 'header.php';
include 'config.php';

// Načti novinky
$stmt = $conn->prepare("SELECT title, content, created_at FROM news ORDER BY created_at DESC");
$stmt->execute();
$stmt->bind_result($title, $content, $created_at);

$news_items = [];
while ($stmt->fetch()) {
    $news_items[] = ['title' => $title, 'content' => $content, 'created_at' => $created_at];
}
$stmt->close();
?>

<link rel="stylesheet" href="style.css">
<main class="main-content">
    <section class="hero">
        <h1>Vítejte na Arma 3 komunitní stránce</h1>
        <p>Nejlepší místo pro všechny operátory, taktiky a fanoušky vojenských simulací.</p>
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <a class="yt-link" href="https://www.youtube.com" target="_blank">Navštiv náš YouTube kanál</a>
            <a class="admin-link" href="admin_tickets.php">Správa Ticketů</a>
        <?php endif; ?>
    </section>
</main>

<?php include 'footer.php'; ?>