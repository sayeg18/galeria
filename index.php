<?php
  session_start();
  if (isset($_SESSION['user_id'])) {
    header('Location: /principal.php');
  }
  require 'cone.php';
  if (!empty($_POST['usuario']) && !empty($_POST['passw'])) {
    $records = $conn->prepare('SELECT id_usuario, usuario, pass FROM usuarios WHERE usuario = :usuario');
    $records->bindParam(':usuario', $_POST['usuario']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
    $message = '';
    if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
      $_SESSION['user_id'] = $results['id_usuario'];
      header("Location: /principal.php");
    } else {
      $message = 'Sorry, those credentials do not match';
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>
    <h1>Login</h1>
    <span>or <a href="signup.php">Registrate</a></span>
    <form action="principal.php" method="POST">
      <input name="usuario" type="text" placeholder="Introduce tu usuario">
      <input name="password" type="password" placeholder="Introduce tu contraseña">
      <input type="submit" value="Submit" <a href="principal.php"></a>
    </form>
  </body>
</html>
