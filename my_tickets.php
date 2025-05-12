<link rel="stylesheet" href="styles/my_tickets.css">
<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['subject'])) {
    $subject = $_POST['subject'];
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("INSERT INTO tickets (user_id, subject) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $subject);
    $stmt->execute();
    header("Location: my_tickets.php");
    exit;
}

$tickets_query = $conn->prepare("SELECT id, subject, status, created_at FROM tickets WHERE user_id = ? ORDER BY created_at DESC");
$tickets_query->bind_param("i", $_SESSION['user_id']);
$tickets_query->execute();
$tickets_result = $tickets_query->get_result();

include 'header.php';
?>

<main class="user-tickets">
  
    <h2>Moje tickety</h2>

    <form method="post">
        <label for="subject">Předmět ticketu</label>
        <input type="text" name="subject" required>
        <button type="submit">Vytvořit ticket</button>
    </form>

    <h3>Seznam vašich ticketů</h3>
    <?php while ($ticket = $tickets_result->fetch_assoc()): ?>
        <div class="ticket-entry">
            <strong><?php echo htmlspecialchars($ticket['subject']); ?></strong>
            <p>Stav: <?php echo htmlspecialchars($ticket['status']); ?></p>
            <a href="view_ticket.php?id=<?php echo $ticket['id']; ?>">Zobrazit konverzaci</a>
    <?php endwhile; ?>
    </div>
</main>

<?php include 'footer.php'; ?>
