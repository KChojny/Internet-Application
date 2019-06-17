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
  <title>KCHojny - Profile Page</title>
</head>
<body>
  <?php
  echo "<p>Nick: ".$_SESSION['nick']."</p>";
  echo "<p>Age: ".$_SESSION['age']."</p>";
  echo "<p>Gender: ".$_SESSION['gender']."</p>";
  echo "<p>Country: ".$_SESSION['country']."</p>";
  echo "<p>Town: ".$_SESSION['city']."</p>";
  echo '<a href = "logout.php">Log out</a>';
  ?>
</body>
</html>
