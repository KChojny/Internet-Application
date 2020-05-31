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
  <title>Settings</title>
  <style>
		.error
		{
			color:red;
			margin-top: 10px;
			margin-bottom: 10px;
		}
	</style>
</head>
<body>
  <p><a href = "update.php">Update data</a><p>
  <p><a href = "delete.php">Delete account</a><p>
  <p><a href = "profile.php">Return to profile</a><p>
</body>
</html>
