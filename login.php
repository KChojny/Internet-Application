<?php

  session_start();
  require_once "connect.php";

  if(!isset($_POST['login']) || (!isset($_POST['password'])))
  {
    header('Location: index.php');
    exit();
  }

  $connect = @new mysqli($host,$db_user,$db_password,$db_name);
  if($connect -> connect_errno != 0)
  {
    echo "Error: ".$connect -> connect_errno;
  }
  else
  {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $login = htmlentities($login, ENT_QUOTES, "UTF-8");
    $password = htmlentities($password, ENT_QUOTES, "UTF-8");

    if($result = $connect -> query(
    sprintf("SELECT * FROM users WHERE nick = '%s' AND password = '%s' ",
    mysqli_real_escape_string($connect, $login),
    mysqli_real_escape_string($connect, $password))));
    {
      $number = $result -> num_rows;
      if($number > 0)
      {
        $_SESSION['login'] = true;
        $row = $result -> fetch_assoc();
        $_SESSION['id'] = $row['id'];
        $_SESSION['nick'] = $row['nick'];
        $_SESSION['age'] = $row['age'];
        $_SESSION['gender'] = $row['gender'];
        $_SESSION['country'] = $row['country'];
        $_SESSION['city'] = $row['city'];

        unset($_SESSION['error']);
        $result -> free_result();
        header('Location: profile.php');
      }
      else
      {
        $_SESSION['error'] = '<span style = "color:red">Invalid login or password</span>';
        header('Location:index.php');
      }
    }
    $connect->close();
  }
?>
