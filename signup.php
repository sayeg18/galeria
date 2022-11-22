<?php
  require 'cone.php';
  $message = '';
  if (!empty($_POST['usuario']) && !empty($_POST['pass'])) {
    $sql = "INSERT INTO usuarios (usuario, pass) VALUES (:usuario, :pass)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':usuario', $_POST['usuario']);
    $password = password_hash($_POST['pass'], PASSWORD_BCRYPT);
    $stmt->bindParam(':pass', $password);
    if ($stmt->execute()) {
      $message = 'Successfully created new user';
    } else {
      $message = 'Sorry there must have been an issue creating your account';
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Registrate</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>
    <h1>Registrate</h1>
    <span>or <a href="index.php">Login</a></span>
    <form action="signup.php" method="POST">
      <input name="usuario" type="text" placeholder="Registra tu usuario">
      <input name="pass" type="password" placeholder="Coloca tu contraseña">
      <input name="confirm_password" type="password" placeholder="Confirma tu contraseña">
      <input type="submit"  <a href="index.php" value="Submit"> </a>
    </form>
  </body>
</html>