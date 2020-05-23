<?php
  session_start();
  if(!isset($_SESSION['login']))
  {
    header('Location: index.php');
    exit();
  }
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
  <title>Profile Page</title>
</head>
<body>
  <?php
  echo "<p>Login: ".$_SESSION['login']."</p>";
  echo "<p>Password: ".$_SESSION['password']."</p>";
  ?>
   <p><a href = "settings.php">Update data</a><p>
   <p><a href = "logout.php">Log out</a><p>
   <p><a href = "delete.php">Delete user</a><p>
</body>
</html>
