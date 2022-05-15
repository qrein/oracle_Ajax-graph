<?php
require_once "maincore.php";
require_once inTPL."theme.php";

$parametrs = array_values(array_filter(explode('/', $_SERVER['REQUEST_URI'])));
$m_result = "";


// Вывод формы для входа в систему
if($parametrs[0] == "login" && !iMEMBER && !iADMIN){
	$m_result = GetLoginForm();	
}


// Ajax обработчик входа в систему
if($parametrs[0] == "logined"){
	$errors = array();

	if($_POST['login'] != ""){
		if(preg_match("/^[a-z0-9]+$/i", $_POST['login']))
			$login = strip_tags(trim($_POST['login']));
		else
			$errors['login'] = 1;
	}else{
		$errors['login'] = 1;
	}
	
	if($_POST['password'] != ""){
		if(preg_match("/^[a-z0-9]+$/i", $_POST['password']))
			$password = strip_tags(trim($_POST['password']));
		else
			$errors['password'] = 1;
	}else{
		$errors['password'] = 1;
	}
	
	if(count($errors) != 0){
		header("Content-Type: text/html; charset=utf-8");
		$errors['status'] = "error";
		echo json_encode($errors);
		unset($errors,$login,$password);
		exit;
	}else{
		$result_sql = mysql_query("SELECT * FROM ".$db_prefix."users WHERE (user_name='".$login."') AND (password='".md5($password)."') LIMIT 1");
		if(mysql_num_rows($result_sql) != 0){
			$userdata = mysql_fetch_array($result_sql);
			
			$cookie_value = $userdata['user_id'].".".$userdata['password'];
			$cookie_exp = isset($_POST['remember_me']) ? time() + 3600*24*30 : time() + 3600*3;
			header("P3P: CP='NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM'");
			setcookie($cookie_prefix."remember", $cookie_value, $cookie_exp, "/", "", "0");

			header("Content-Type: text/html; charset=utf-8");
			$errors['status'] = "ok";
			$errors['redirect_url'] = exADMIN;
			echo json_encode($errors);
			unset($errors,$login,$password,$userdata);
			exit;
		}else{
			header("Content-Type: text/html; charset=utf-8");
			$errors['status'] = "error";
			$errors['combination'] = 1;
			echo json_encode($errors);
			unset($errors,$login,$password);
			exit;
		}
	}
}


// Ajax обработчик выхода из системы
if($parametrs[0] == "logout"){
	header("P3P: CP='NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM'");
	setcookie($cookie_prefix."remember", "", time() - 7200, "/", "", "0");
	header("Location: ".str_replace("&amp;", "&", exBASEDIR));
	exit;
}


// Вывод страницы
header("Content-Type: text/html; charset=utf-8");
//echo GetPage("SDMO","","",$m_result,"login");
echo $m_result;
?>