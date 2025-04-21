<?php
session_start();
include 'header.php';  // Načteme hlavičku
include 'config.php';  // Připojíme se k databázi

// Zpracování formuláře pro přidání novinky
if (isset($_POST['add_news'])) {
    $news_title = $_POST['news_title'];
    $news_content = $_POST['news_content'];

    // Přidání novinky do databáze
    $stmt = $conn->prepare("INSERT INTO news (title, content, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $news_title, $news_content);
    if ($stmt->execute()) {
        echo "<p class='success-msg'>Novinka byla úspěšně přidána.</p>";
    } else {
        echo "<p class='error-msg'>Došlo k chybě při přidávání novinky.</p>";
    }
}
?>

<link rel="stylesheet" href="admin_style.css">  <!-- Načteme styl pro admin panel -->
<main>
    <div class="admin-panel-container">
        <h2 class="admin-panel-header">Přidat novinku</h2>

        <form method="POST">
            <label for="news_title">Název novinky</label>
            <input type="text" name="news_title" id="news_title" required>

            <label for="news_content">Obsah novinky</label>
            <textarea name="news_content" id="news_content" rows="5" required></textarea>

            <button type="submit" name="add_news" class="admin-panel-btn">Přidat novinku</button>
        </form>
    </div>
</main>