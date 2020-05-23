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
  $login = $_SESSION['login'];
  if($connect -> query("DELETE FROM user WHERE login = '$login'"))
    header('Location: logout.php');
  else
    throw new Exception($connect->error);
  $connect -> close();
}
?>
