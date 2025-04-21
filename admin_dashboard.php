<?php
session_start();
include 'header.php';  // Načteme hlavičku
include 'config.php';  // Připojíme se k databázi
?>

<link rel="stylesheet" href="admin_panel.css">  <!-- Načteme styl pro admin panel -->
<main>
    <div class="main-container">
        <h2 class="admin-panel-header">Admin Panel</h2>

        <!-- Odkazy na různé administrativní akce -->
        <a href="chage_role.php" class="admin-panel-btn">Spravovat role</a>
        <a href="admin_tickets.php" class="admin-panel-btn">Tickets</a>

        <!-- Příklad tabulky pro správu uživatelů -->
        <table class="admin-panel-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Uživatelské jméno</th>
                    <th>Role</th>
                    <th>Akce</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Získání uživatelů z databáze
                $stmt = $conn->prepare("SELECT id, username, role FROM users");
                $stmt->execute();
                $stmt->bind_result($id, $username, $role);

                while ($stmt->fetch()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($id) . "</td>";
                    echo "<td>" . htmlspecialchars($username) . "</td>";
                    echo "<td>" . htmlspecialchars($role) . "</td>";
                    echo "<td><a href='chage_role.php?id=$id' class='admin-panel-btn'>Upravit</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</main>