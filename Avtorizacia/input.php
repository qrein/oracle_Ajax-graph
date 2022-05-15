<?php
	ob_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Вход</title>
		<link rel="stylesheet" href="input.css">
	</head>
	<body>
		<fieldset>
			<center>
				<form method="post">
					<label class="Head">Вход</label><br><br>
					<div id="er" class="er"></div>
					<label>Логин</label><br>
					<input type="text" name="login" id="login"><br>
					<label>Пароль</label><br>
					<input type="password" name="password" id="password"><br>
					<input type="submit" name="input" value="Войти"><br><br>
					<script src="//ulogin.ru/js/ulogin.js"></script>
					<div id="uLogin" data-ulogin="display=panel;theme=flat;fields=first_name,last_name;providers=vkontakte,odnoklassniki,mailru,facebook;hidden=other;redirect_uri=http%3A%2F%2Favtorizacia%2Finput.php;mobilebuttons=0;"></div>
				</form>
				<a href="welcome.php">На главную</a>
			</center>
		</fieldset>
	</body>
</html>

<?php
	include_once("link.php");

	$s = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
    $user = json_decode($s, true);
    if(isset($_POST['token']) && !empty($_POST['token']))
	{
		$login=$user['identity'];
		$password=$user['uid'];

		$query="SELECT Login, Password FROM Users WHERE Login=?";
		if ($stmt=mysqli_prepare($link, $query)) 
		{
			mysqli_stmt_bind_param($stmt, 's', $login);
			mysqli_stmt_execute($stmt);
			$result=mysqli_stmt_get_result($stmt);
			if(mysqli_num_rows($result))
			{
				while ($row=mysqli_fetch_assoc($result))
				{
					if($row["Login"]==$login)
					{
						if(password_verify($password, $row["Password"]))
						{
							$bytes=bin2hex(openssl_random_pseudo_bytes(20));
							$query="UPDATE Users SET Token='$bytes' WHERE Login='$login'";
							mysqli_query($link, $query);
							/*setcookie("CookieToken", $bytes);
							setcookie("CookieLogin", $row['Login']);
							setcookie("CookieName", $user['first_name']);*/
							setcookie($tokenCookie, $bytes);
							header("Location: welcome.php?text=".$bytes);
						}
						else echo "Неверный логин или пароль";
					}
					else echo "Неверный логин или пароль";
				}
			}
			else echo "Неверный логин или пароль";
		}
	}
    //$user['network'] - соц. сеть, через которую авторизовался пользователь
    //$user['identity'] - уникальная строка определяющая конкретного пользователя соц. сети
    //$user['first_name'] - имя пользователя
    //$user['last_name'] - фамилия пользователя
                

	if(isset($_POST["input"]))
	{
		$login=$_POST["login"];
		$password=$_POST["password"];

		$query="SELECT Login, Password, Name FROM users WHERE Login=?";
		if ($stmt=mysqli_prepare($link, $query)) 
		{
			mysqli_stmt_bind_param($stmt, 's', $login);
			mysqli_stmt_execute($stmt);
			$result=mysqli_stmt_get_result($stmt);
			if(mysqli_num_rows($result))
			{
				while ($row=mysqli_fetch_assoc($result))
				{
					if($row["Login"]==$login)
					{
						if(password_verify($password, $row["Password"]))
						{
							$bytes=bin2hex(openssl_random_pseudo_bytes(20));
							$query="UPDATE Users SET Token='$bytes' WHERE Login='$login'";
							mysqli_query($link, $query);
							setcookie($tokenCookie, $bytes);
							/*setcookie("CookieToken", $bytes);
							setcookie("CookieName", $row['Name']);
							setcookie("CookieLogin", $row['Login']);*/
							header("Location: welcome.php?text=".$bytes);
						}
						else echo "<script>er.innerHTML='Неверный логин или пароль';</script>";
					}
					else echo "<script>er.innerHTML='Неверный логин или пароль';</script>";
				}
			}
			else echo "<script>er.innerHTML='Неверный логин или пароль';</script>";
		}
	}
	ob_end_flush();
?>