<?php
session_start();
require_once "connect.php";
if(!isset($_SESSION['login']))
{
  header('Location: index.php');
  exit();
}
$connect = @new mysqli($host,$db_user,$db_password,$db_name);
if($connect -> connect_errno != 0)
  echo "Error: ".$connect -> connect_errno;
else
{
  $new_login = $_POST['login'];
  $new_password = $_POST['password'];
  $login = $_SESSION['login'];
  if(!empty($new_login))
  {
    if($connect -> query("UPDATE user SET login = '$new_login' WHERE login = '$login'"))
    {
      $_SESSION['login'] = $new_login;
      header('Location: profile.php');
    }
    else
      throw new Exception($connect->error);
  }
  if(!empty($new_password))
  {
    if($connect -> query("UPDATE user SET password = '$new_password' WHERE login = '$login'"))
    {
      $_SESSION['password'] = $new_password;
      header('Location: profile.php');
    }
    else
      throw new Exception($connect->error);
  }
  $connect -> close();
}
?>
