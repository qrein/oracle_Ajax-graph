<?php
	ob_start();
?>

<!DOCTYPE html>
<html>
	<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />		<title>Регистрация</title>
		<link rel="stylesheet" href="register.css">
	</head>
	<body>
		<fieldset>
			<center>
				<form method="post">
					<div id="log"></div>
					<label class="Head">Регистрация</label><br><br>
					
					<label>Имя</label><br>
					<div id="nm"></div>
					<input type="text" name="name" id="NameUser" pattern="[А-Яа-яЁё]+" value="<?php echo $_POST['name'] ?>" required><br>

					<label>Фамилия</label><br>
					<input type="text" name="famely" id="famely" pattern="[А-Яа-яЁё]+" value="<?php echo $_POST['famely'] ?>" required><br>
					
					<label>Логин</label><br>
					<div id="lg"></div>
					<input type="text" name="login" id="LoginUser" pattern="[A-Za-z]+[0-9]*" value="<?php echo $_POST['login'] ?>" required><br>

					<div class="password">
						<label for="password1">Пароль<br>
							<input type="password" name="password1" id="password1" pattern="[A-Za-z0-9]+" maxlength="32" minlength="6" placeholder="Введите пароль" value="" required>
							<a href="#" class="password-control" onclick="return show_hide_password(this);"></a>
							<div id="passw1"></div>
						</label>
					</div>
					
					<label>Подтверждение пароля<br></label>
					<input class="password2" type="password" name="password2" id="password2" pattern="[A-Za-z0-9]+" maxlength="32" minlength="6" required><br>
					<div id="error"></div>

					<br><input type="checkbox" name="Check" required> Принять <a href="lic.html">лицензионное соглашение</a><br>
			
					<input class="register" type="submit" name="Register" value="Зарегистрироваться">
					
					<script src="//ulogin.ru/js/ulogin.js"></script>
					<div id="uLogin" data-ulogin="display=panel;theme=flat;fields=first_name,last_name;providers=vkontakte,odnoklassniki,mailru,facebook;hidden=other;redirect_uri=http%3A%2F%2Favtorizacia%2Fregister.php;mobilebuttons=0;"></div>
				</form>
				<a href="welcome.php">На главную</a>
			</center>
		</fieldset>
		<script>
			function show_hide_password(target)
			{
				var input = document.getElementById('password1');
				if (input.getAttribute('type') == 'password') 
				{
					target.classList.add('view');
					input.setAttribute('type', 'text');
				} 
				else 
				{
					target.classList.remove('view');
					input.setAttribute('type', 'password');
				}
				return false;
			}
			nameUser.onfocus=function()
			{
				nm.innerHTML="<b>Используйте русские буквы</b>";
			}
			nameUser.onblur=function()
			{
				nm.innerHTML="";
			}
			loginUser.onfocus=function()
			{
				lg.innerHTML="<b>Используйте символы A-Z, a-z, 0-9</b>";
			}
			loginUser.onblur=function()
			{
				lg.innerHTML="";
			}

			password1.onfocus=function()
			{
				passw1.innerHTML="<b>Используйте символы A-Z, a-z, 0-9, длинной 6-32</b>";
			}
			password1.onblur=function()
			{
				passw1.innerHTML="";
			}
			password2.onblur=function()
			{
				let pw1= document.getElementById("password1").value;
				let pw2= document.getElementById("password2").value;
				
				if(pw1!=pw2) 
				{
					password2.classList.add('invalid');
    				error.innerHTML = 'Пароли не совпадают';
				}
				else error.innerHTML="";
			}
		</script>
	</body>
</html>

<?php
	include_once("link.php");
	$s = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
    $user = json_decode($s, true);
	if(isset($_POST['token']) && !empty($_POST['token']))
	{
        //$user['network'] - соц. сеть, через которую авторизовался пользователь
        //$user['identity'] - уникальная строка определяющая конкретного пользователя соц. сети
        //$user['first_name'] - имя пользователя
        //$user['last_name'] - фамилия пользователя

        $password=$user['uid'];
		$name=$user['first_name'];
		$login=$user['identity'];
		$famely=$user['last_name'];

		$query="SELECT login FROM Users WHERE login='$login'";
		$result=mysqli_query($link, $query);
		$row=mysqli_fetch_row($result);
		if($result=mysqli_query($link, $query))
		{
			if(!mysqli_num_rows($result))
			{
				$hash=password_hash($password, PASSWORD_BCRYPT);
				$query="INSERT INTO users(name, famely, login, password) VALUES ('$name', '$famely', '$login', '$hash')";
				mysqli_query($link, $query);
				header("Location: input.php");
			}
			else echo "<script>log.innerHTML='Такой логин зарегистрирован';</script>";
		}
		else "Ошибка выполнения запроса";
	}

	if(isset($_POST["Register"]))
	{      
		$pw1=$_POST["password1"];
		$pw2=$_POST["password2"];
		$name=$_POST["name"];
		$famely=$_POST["famely"];
		$login=$_POST["login"];

		if($pw1==$pw2)
		{
			$hash=password_hash($pw1, PASSWORD_BCRYPT);
			
			$query="SELECT login FROM users WHERE login='$login'";
			$result=mysqli_query($link, $query);
			$row=mysqli_fetch_row($result);
			if(!mysqli_num_rows($result))
			{
				$query="INSERT INTO users(name, famely, login, password) VALUES ('$name', '$famely', '$login', '$hash')";
				if(mysqli_query($link, $query))
				{
					header("Location: input.php");
					
				}
				else echo $query;
			}
			else echo "<script>log.innerHTML='Такой логин зарегистрирован';</script>";
		}
		else echo $pw1."   ".$pw2;
	}

	ob_end_flush();
?>