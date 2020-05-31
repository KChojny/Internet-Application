<?php
session_start();
require_once "connect.php";//pobranie danych bazy
if(!isset($_SESSION['login']))//cofanie nieautoryzowanego wejścia
{
  header('Location: index.php');
  exit();
}



if(isset($_POST['password']))
{
  $password = $_POST['password'];

  if ((strlen($password) == 0))
      $_SESSION['e_password']="Password is empty!";

  try
  {
    $connect = new mysqli($host, $db_user, $db_password, $db_name);
    if ($connect->connect_errno!=0) //łączenie do bazy
      throw new Exception(mysqli_connect_errno());
    else
    {
      $login = $_SESSION['login'];
      $result = ($connect -> query("SELECT password FROM user WHERE login = '$login'"));
      $row = $result -> fetch_assoc();
      $password_hash = $row['password'];
      if(password_verify($password, $password_hash))//sprawdzanie hasła
      {
        if($connect -> query("DELETE FROM user WHERE login = '$login'"))//usuwanie konta
          header('Location: logout.php');
        else
          throw new Exception($connect->error);
      }
      else
        $_SESSION['e_password'] = "Password is invalid!!";
    }
  }
  catch(Exception $e)
  {
    echo '<span style="color:red">Error in connect with server!!</span>';
  }
  $connect->close();
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
  <p><form method="post">
    Confirm password: <br/><input type="password" value=""
     name="password"/><br/>
     <?php //wyświetlenie komunikatu
 			if (isset($_SESSION['e_password']))
 			{
 				echo '<div class="error">'.$_SESSION['e_password'].'</div>';
 				unset($_SESSION['e_password']);
 			}
 		 ?>
    <input type="Submit" value="Delete account"/>
  </form></p>
    <p><a href = "profile.php">Return to profile</a><p>
    <p><a href = "settings.php">Return to settings</a><p>
</body>
</html>
