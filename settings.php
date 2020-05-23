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
  <title>Update Page</title>
</head>
<body>
  <p>Update data</p>
  <p><form action="update.php" method="post">
    Login: <br/><input type="text" name="login"/><br/>
    Password: <br/><input type="password" name="password"/><br/>
    <input type="Submit" value="Update"/>
  </form></p>
  <p><a href = "profile.php">Profile</a><p>
</body>
</html>
