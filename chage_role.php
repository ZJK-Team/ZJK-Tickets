<?php
session_start();
include 'header.php';  // Načteme hlavičku
include 'config.php';  // Připojíme se k databázi

// Zpracování formuláře pro změnu role
if (isset($_POST['change_role'])) {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['new_role'];

    $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->bind_param("si", $new_role, $user_id);
    if ($stmt->execute()) {
        echo "<p class='success-msg'>Role uživatele byla úspěšně změněna.</p>";
    } else {
        echo "<p class='error-msg'>Došlo k chybě při změně role.</p>";
    }
}

// Načteme seznam uživatelů pro změnu role
$stmt = $conn->prepare("SELECT id, username, role FROM users");
$stmt->execute();
$stmt->bind_result($id, $username, $role);
?>

<link rel="stylesheet" href="admin_style.css">  <!-- Načteme styl pro admin panel -->
<main>
    <div class="admin-panel-container">
        <h2 class="admin-panel-header">Změna role uživatele</h2>

        <form method="POST">
            <table class="admin-panel-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Uživatelské jméno</th>
                        <th>Aktuální role</th>
                        <th>Nová role</th>
                        <th>Akce</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($stmt->fetch()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($id) . "</td>";
                        echo "<td>" . htmlspecialchars($username) . "</td>";
                        echo "<td>" . htmlspecialchars($role) . "</td>";
                        echo "<td>
                                <select name='new_role'>
                                    <option value='user'" . ($role === 'user' ? ' selected' : '') . ">Uživatel</option>
                                    <option value='admin'" . ($role === 'admin' ? ' selected' : '') . ">Admin</option>
                                </select>
                              </td>";
                        echo "<td><button type='submit' name='change_role' value='1' class='admin-panel-btn'>Změnit roli</button></td>";
                        echo "<input type='hidden' name='user_id' value='" . htmlspecialchars($id) . "'>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </form>
    </div>
</main>