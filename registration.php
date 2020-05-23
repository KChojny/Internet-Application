<?php

	session_start();

	if (isset($_POST['login'], $_POST['password'], $_POST['re_password'])) //sprawdzanie zmiennych sesyjnych
	{
		//przypisywanie sesji do zmiennych
		$login = $_POST['login'];
		$password = $_POST['password'];
		$re_password = $_POST['re_password'];
		//warunki do spełnienia
		if ((strlen($login) == 0))
			$_SESSION['e_login'] = "Login is empty!";
		if ((strlen($login) > 20))
			$_SESSION['e_login'] = "Login must have less than 20 characters!";
		if (ctype_alnum($login) == false)
			$_SESSION['e_login'] = "Login must be without special signs!";
		if ((strlen($password) == 0))
				$_SESSION['e_password']="Password is empty!";
		if ((strlen($password) > 20))
			$_SESSION['e_password'] = "Login must have less than 20 characters!";
		if (($password != $re_password))
			$_SESSION['e_password']="Password and Repeat Password are different!";


		require_once "connect.php"; //pobieranie danych do bazy
		mysqli_report(MYSQLI_REPORT_STRICT);

		try
		{
			$connect = new mysqli($host, $db_user, $db_password, $db_name);
			if ($connect->connect_errno!=0) //łączenie do bazy
				throw new Exception(mysqli_connect_errno());
			else
			{
				if($result = $connect->query("SELECT login FROM user WHERE user='$login'"))
				{
					$number = $result->num_rows;
					if($number>0)
					{
						$_SESSION['e_login']="Login is in a database!!";
					}
				}
				if (!(isset($_SESSION['e_login'], $_SESSION['e_password'])))
					/*$options = [salt => , cost => 4];
					$password_hash = password_hash($password, PASSWORD_DEFAULT, $options)*/
					if ($connect -> query("INSERT INTO user VALUES ('$login', '$password','0')"))
						header('Location: index.php');
					else
						throw new Exception($connect->error);
				}
			}
			catch(Exception $e)
		{
				echo '<span style="color:red">'.$e.'</span>';
		}
			$connect->close();
		}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Registration Page</title>
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

	<form method="post">
		<p>Registration:<br/>
			<input type="text" value="<?php
			if (isset($_SESSION['login']))
			{
				echo $_SESSION['login'];
				unset($_SESSION['login']);
			}
		?>" name="login" />
		<p/>
		<?php
			if (isset($_SESSION['e_login']))
			{
				echo '<div class="error">'.$_SESSION['e_login'].'</div>';
				unset($_SESSION['e_login']);
			}
		?>

		<p>Password:<br/>
			<input type="password"  value="<?php
			if (isset($_SESSION['password']))
			{
				echo $_SESSION['password'];
				unset($_SESSION['password']);
			}
		?>" name="password" />
		<p/>
		<?php
			if (isset($_SESSION['e_password']))
			{
				echo '<div class="error">'.$_SESSION['e_password'].'</div>';
				unset($_SESSION['e_password']);
			}
		?>

		<p>Repeat Password:<br/>
			<input type="password"  value="<?php
			if (isset($_SESSION['re_password']))
			{
				echo $_SESSION['re_password'];
				unset($_SESSION['re_password']);
			}
		?>" name="re_password" />
		<p/>
		<?php
			if (isset($_SESSION['e_password']))
			{
				echo '<div class="error">'.$_SESSION['e_password'].'</div>';
				unset($_SESSION['e_password']);
			}
		?>
		<p><input type="submit" value="Registration" /></p>
	</form>

</body>
</html>
