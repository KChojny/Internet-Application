<?php
  session_start();

  if(isset($_SESSION['login']) && ($_SESSION['login'] == true))
  {
    header('Location: profile.php');
    exit();
  }
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
  <title>KCHojny - Login Page</title>
</head>
<body>
  Login Form<br/><br/>
  <form action="login.php" method="post">
    Login: <br/><input type="text" name="login"/><br/>
    Password: <br/><input type="password" name="password"/><br/>
    <input type="Submit" value="Log In"/>
  </form>

  <?php
  if(isset($_SESSION['error'])){
  echo $_SESSION['error'];
  }
  ?>

</body>
</html>
