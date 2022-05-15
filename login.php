
<?php
	include_once ("maincore.php");
	include_once("tpl/tpl.php");
//	include_once("core.php");
	//echo GetLoginForm();

	if (isset($_POST['login']) && isset($_POST['password'])) {
		
		$errors = array("error_flag" => false, "error_text" => "");

		if($_POST['login'] != "") {
			if(preg_match("/^[a-z0-9]+$/i", $_POST['login'])){
				$login = strip_tags(trim($_POST['login']));
			} else{
				$errors['error_flag'] = true;
				$errors['error_text'] .= "incorrect login entry <br>";
			}
		} else {
			$errors['error_flag'] = true;
			$errors['error_text'] .= "login is empty <br>";
		}

		if($_POST['password'] != "")
		{
			if(preg_match("/^[a-z0-9]+$/i", $_POST['password'])){
				$password = strip_tags(trim($_POST['password']));
			}else{
				$errors['error_flag'] = true;
				$errors['error_text'] .= "incorrect password entry <br>";
			}
		}else {
			$errors['error_flag'] = true;
			$errors['error_text'] .= "password is empty <br>";				
		}
		
			
		
		if ($errors['error_flag']) {
			echo GetLoginForm($errors['error_text']);
		}else{
			$result_sql = mysql_query("SELECT * FROM ".$db_prefix."users WHERE (user_name='".$login."') AND (password='".md5($password)."') LIMIT 1");
			
			if(mysql_num_rows($result_sql) == 0){
				echo GetLoginForm("User not found");
			} else {
				$userdata = mysql_fetch_array($result_sql);
			
				$cookie_value = $userdata['user_id'].".".$userdata['password'];
				$cookie_exp = isset($_POST['remember_me']) ? time() + 3600*24*30 : time() + 3600*3;
				header("P3P: CP='NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM'");
				setcookie($cookie_prefix."remember", $cookie_value, $cookie_exp, "/", "", "0");
				
				redirect("index.php");
			}
		}
	} else {
		echo GetLoginForm();
	}
?>