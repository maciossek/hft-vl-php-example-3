<?php
require_once __DIR__ . '/vendor/autoload.php';
session_start();

$user = 'root';
$password = 'root';
$db = 'temp';
$host = 'localhost';
$port = 8889;

$mysqli = new mysqli($host, $user, $password, $db, $port);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if(isset($_GET['login'])) {
   $email = $mysqli->real_escape_string($_POST['email']);
   $password = $_POST['password'];

   // $result = $mysqli->query("SELECT * FROM users WHERE email = '$email'");

   $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
   $stmt->bind_param('s', $email);
   $stmt->execute();
   $result = $stmt->get_result();
   $stmt->close();

   $user = $result->fetch_assoc();

   if ($user != null && $user['password'] == $password) {
     $_SESSION['userid'] = $user['firstname'];
     die('Login erfolgreich. Weiter zu <a href="geheim.php">internen Bereich</a>');
   } else {
     $errorMessage = "E-Mail oder Passwort war ungültig<br>";
   }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
  </head>
  <body>

  <?php
  if(isset($errorMessage)) {
   echo $errorMessage;
  }
  ?>

  <form action="?login=1" method="post">
  E-Mail:<br>
  <input type="email" size="40" maxlength="250" name="email"><br><br>

  Dein password:<br>
  <input type="password" size="40"  maxlength="250" name="password"><br>

  <input type="submit" value="Abschicken">
  </form>
  </body>
</html>
