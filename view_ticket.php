<?php
session_start();
include 'config.php';

// Ověření, zda je uživatel přihlášen
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Získání ticketu podle ID
$ticket_id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT tickets.*, users.username FROM tickets JOIN users ON tickets.user_id = users.id WHERE tickets.id = ?");
$stmt->bind_param("i", $ticket_id);
$stmt->execute();
$result = $stmt->get_result();
$ticket = $result->fetch_assoc();

// Ověření, zda ticket existuje a zda má uživatel oprávnění k zobrazení
if (!$ticket || ($_SESSION['role'] !== 'admin' && $_SESSION['user_id'] != $ticket['user_id'])) {
    echo "Nemáte oprávnění k zobrazení tohoto ticketu.";
    exit;
}

// Zpracování odeslání zprávy do ticketu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['message'])) {
    $msg = $_POST['message'];
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("INSERT INTO ticket_messages (ticket_id, user_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $ticket_id, $user_id, $msg);
    $stmt->execute();
    header("Location: view_ticket.php?id=$ticket_id");
    exit;
}

// Získání všech zpráv v ticketu
$messages = $conn->prepare("SELECT ticket_messages.*, users.username FROM ticket_messages JOIN users ON ticket_messages.user_id = users.id WHERE ticket_id = ? ORDER BY ticket_messages.created_at ASC");
$messages->bind_param("i", $ticket_id);
$messages->execute();
$msg_result = $messages->get_result();

include 'header.php'; 
?>

<link rel="stylesheet" href="view_ticket.css">

<main class="ticket-chat">
    <h2>Ticket: <?php echo htmlspecialchars($ticket['subject']); ?></h2>

    <div class="chat-box">
        <?php while($msg = $msg_result->fetch_assoc()): ?>
            <div class="chat-msg <?php echo $msg['user_id'] == $_SESSION['user_id'] ? 'user' : 'admin'; ?>">
                <strong><?php echo htmlspecialchars($msg['username']); ?>:</strong>
                <p><?php echo htmlspecialchars($msg['message']); ?></p>
                <span><?php echo $msg['created_at']; ?></span>
            </div>
        <?php endwhile; ?>
    </div>

    <form method="post" class="chat-form">
        <textarea name="message" placeholder="Napiš zprávu..." required></textarea>
        <button type="submit">Odeslat</button>
    </form>
</main>

<?php include 'footer.php'; ?>
