<?php
session_start();
session_destroy();

echo "Logout erfolgreich</br>";
echo '<a href="login.php">Wieder einloggen</a>';
?>
