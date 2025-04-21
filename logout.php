<?php
// Začátek session
session_start();

// Zrušení všech session proměnných
session_unset();

// Zničení session
session_destroy();

// Přesměrování na přihlašovací stránku
header("Location: login.php");
exit();
?>
