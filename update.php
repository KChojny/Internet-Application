<?php
session_start();
require_once "connect.php";//pobranie danych bazy
if(!isset($_SESSION['login']))//cofanie nieautoryzowanego wejścia
{
  header('Location: index.php');
  exit();
}

if(isset($_POST['old_password']))
{
  $password = $_POST['old_password'];
  try
  {
    $connect = new mysqli($host, $db_user, $db_password, $db_name);
    if ($connect->connect_errno!=0) //łączenie do bazy
      throw new Exception(mysqli_connect_errno());
    else
    {
      $login = $_SESSION['login'];
      $result = ($connect -> query("SELECT * FROM user WHERE login = '$login'"));
      $row = $result -> fetch_assoc();
      $password_hash = $row['password'];
      if(password_verify($password, $password_hash))//sprawdzanie hasła
      {
        $new_row = $row;
        foreach( $new_row as $x => &$x_value)
        {
          $x_value = $_POST[$x];
          if($x_value != "")
          {
            if($x == "password")
              $x_value = password_hash($x_value,PASSWORD_DEFAULT);
            if($x == "login" && (($connect -> query("SELECT login FROM user WHERE $x = '$x_value'")) -> num_rows))
              $_SESSION['e_login'] = "Login is used!";
            else
            {
              if($connect -> query("UPDATE user SET $x = '$x_value' WHERE login = '$login'"))
                  $_SESSION['info'] = "Data is successful updated.";
              else
                throw new Exception($connect->error);
              if($x == "login")
                $login = $_SESSION['login'] = $x_value;
            }
          }
        }
        unset($x_value);
        $result -> free_result();
      }
      else
      {
        if ((strlen($password) == 0))
          $_SESSION['e_old_password']="Password is empty!";
        else
          $_SESSION['e_old_password'] = "Password is invalid!!";
      }
    }
  }
  catch(Exception $e)
  {
    echo "</br>";
    echo $x;
    echo "</br>";
    echo $x_value;
    echo "</br>";
    echo $login;

    echo '<span style="color:red">Error in connect with server!! '.$e.'</span>';
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
    .info
		{
			color:black;
			margin-top: 10px;
			margin-bottom: 10px;
		}
	</style>
</head>
<body>
  <?php
  if (isset($_SESSION['info']))
  {
    echo '<div class="info">'.$_SESSION['info'].'</div>';
    unset($_SESSION['info']);
  }
 ?>
  <p><form method="post">
    New login: <br/><input type="text" value="" name="login"/><br/>
     <?php //wyświetlenie komunikatu
 			if (isset($_SESSION['e_login']))
 			{
 				echo '<div class="error">'.$_SESSION['e_login'].'</div>';
 				unset($_SESSION['e_login']);
 			}
 		 ?>
     New password: <br/><input type="password" value=""
      name="password"/><br/>
      <?php //wyświetlenie komunikatu
  			if (isset($_SESSION['e_password']))
  			{
  				echo '<div class="error">'.$_SESSION['e_password'].'</div>';
  				unset($_SESSION['e_password']);
  			}
  		 ?>
    Confirm password: <br/><input type="password" value=""
     name="old_password"/><br/>
     <?php //wyświetlenie komunikatu
 			if (isset($_SESSION['e_old_password']))
 			{
 				echo '<div class="error">'.$_SESSION['e_old_password'].'</div>';
 				unset($_SESSION['e_old_password']);
 			}
 		 ?>
    <input type="Submit" value="Update data"/>
  </form></p>
    <p><a href = "profile.php">Return to profile</a><p>
    <p><a href = "settings.php">Return to settings</a><p>
</body>
</html>
