<link rel="stylesheet" href="styles/admin_tickets.css">
<?php
session_start();
include 'config.php';

$tickets_query = $conn->query("SELECT tickets.id, users.username, subject, status, tickets.created_at FROM tickets JOIN users ON tickets.user_id = users.id ORDER BY tickets.created_at DESC");

include 'header.php';
?>

<main class="admin-tickets">
    <h2>Správa Ticketů</h2>

    <?php while ($ticket = $tickets_query->fetch_assoc()): ?>
        <div class="ticket-entry">
            <strong><?php echo htmlspecialchars($ticket['username']); ?></strong> <small>(<?php echo $ticket['created_at']; ?>)</small>
            <h4><?php echo htmlspecialchars($ticket['subject']); ?></h4>
            <p>Stav: <strong><?php echo htmlspecialchars($ticket['status']); ?></strong></p>
            <a href="view_ticket.php?id=<?php echo $ticket['id']; ?>">Zobrazit konverzaci</a>
            <form method="post" action="update_ticket_status.php">
                <input type="hidden" name="ticket_id" value="<?php echo $ticket['id']; ?>">
                <select name="status">
                    <option value="Otevřený" <?php echo $ticket['status'] === 'Otevřený' ? 'selected' : ''; ?>>Otevřený</option>
                    <option value="Vyřešený" <?php echo $ticket['status'] === 'Vyřešený' ? 'selected' : ''; ?>>Vyřešený</option>
                </select>
                <button type="submit">Upravit stav</button>
            </form>
        </div>
    <?php endwhile; ?>
</main>

<?php include 'footer.php'; ?>
