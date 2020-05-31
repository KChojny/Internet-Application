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
    echo "Error: ".$connect -> connect_errno;
  else
  {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $login = htmlentities($login, ENT_QUOTES, "UTF-8");
    $password = htmlentities($password, ENT_QUOTES, "UTF-8");
    if ($result = $connect -> query(
      sprintf("SELECT * FROM user WHERE login = '%s'",
      mysqli_real_escape_string($connect, $login),
      mysqli_real_escape_string($connect, $password)))
    ); {
      $number = $result -> num_rows;
      $row = $result -> fetch_assoc();

      if($number == 1 && password_verify($_POST['password'], $row['password']))
      {
          $_SESSION['login'] = true;
          $_SESSION['login'] = $row['login'];
          $_SESSION['password'] = $_POST['password'];
          $_SESSION['password_hash_db'] = $row['password'];

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
