<?php

if(preg_match("/maincore.php/i", $_SERVER['PHP_SELF'])){die();}

// Конфиг MySQL
$db_user = "root";
$db_pass = "12345678";
$db_name = "DataBase";
$db_host = "localhost";
$db_prefix = "";

// Куки
$cookie_prefix = "adm_";

error_reporting(E_ALL);
ini_set('display_errors', '1');

foreach ($_GET as $check_url) {
	if (!is_array($check_url)) {
		$check_url = str_replace("\"", "", $check_url);
		if ((preg_match("/<[^>]*script*\"?[^>]*>/i", $check_url)) || (preg_match("/<[^>]*object*\"?[^>]*>/i", $check_url)) ||
			(preg_match("/<[^>]*iframe*\"?[^>]*>/i", $check_url)) || (preg_match("/<[^>]*applet*\"?[^>]*>/i", $check_url)) ||
			(preg_match("/<[^>]*meta*\"?[^>]*>/i", $check_url)) || (preg_match("/<[^>]*style*\"?[^>]*>/i", $check_url)) ||
			(preg_match("/<[^>]*form*\"?[^>]*>/i", $check_url)) || (preg_match("/\([^>]*\"?[^)]*\)/i", $check_url)) ||
			(preg_match("/\"/i", $check_url))) {
		die ();
		}
	}
}
unset($check_url);
ob_start();

// Connect to Database
if(!@mysql_connect($db_host, $db_user, $db_pass)){
	die("Unable to establish connection to MySQL");
}elseif(!@mysql_select_db($db_name)){
	die("Unable to select MySQL database");
}

mysql_query("set character_set_client='utf8'");  
mysql_query("set character_set_results='utf8'");  
mysql_query("set collation_connection='utf8_general_ci'");


//$settings = mysql_fetch_array(mysql_query("SELECT *FROM ".$db_prefix."settings"));


// Авторизация
if(isset($_COOKIE[$cookie_prefix.'remember'])){
	$cookie_vars = explode(".", $_COOKIE[$cookie_prefix.'remember']);
	$cookie_1 = is_numeric($cookie_vars['0']) ? $cookie_vars['0'] : "0";
	$cookie_2 = $cookie_vars['1'];
	
	$result_sql = mysql_query("SELECT *FROM ".$db_prefix."users WHERE user_id='$cookie_1' AND password ='".$cookie_2."' LIMIT 1");
	unset($cookie_vars,$cookie_1,$cookie_2);
	
	if(mysql_num_rows($result_sql) != 0){
		$userdata = mysql_fetch_array($result_sql);
		
		$sql = "UPDATE users SET last_login='".time()."',last_ip='".$_SERVER['REMOTE_ADDR']."' WHERE user_id='".$userdata['user_id']."'";
		mysql_query($sql);
	}else{
		header("P3P: CP='NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM'");
		setcookie($cookie_prefix."remember", "", time() - 7200, "/", "", "0");
		redirect(BASEDIR);
	}
}


define("iMEMBER", $userdata['user_level'] == 101 ? true : false);
define("iADMIN", $userdata['user_level'] == 103 ? true : false);


function redirect($location, $script = false) {
	if(!$script){
		header("Location: ".str_replace("&amp;", "&", $location));
		exit;
	}else{
		echo "<script type='text/javascript'>document.location.href='".str_replace("&amp;", "&", $location)."'</script>\n";
		exit;
	}
}

function file_size($size) {
	$filesizename = array(" Bytes", " Kb", " Mb", " Gb", " Tb", " PB", " Eb", " Zb", " Yb");
	return $size ? round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i] : '0 Bytes';
}



// Config
$host = "IP adress to Oracle server";
$port = "1521";
$db_name = "Database Name";
$db_encoding = "UTF8";
$db_connection_type = "";
$db_username = "Database Username";
$db_password = "Database Password";


// Connect
$conn = oci_pconnect($db_username, $db_password, '//'.$host.':'.$port.'/'.$db_name.(($db_connection_type == '') ? '' : ':'.$db_connection_type), $db_encoding);

if (!$conn) {
	$e = oci_error();
	
	print_r($e);
	
} else {
	$q = oci_parse($conn, "ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD\"T\"HH24:MI:SS'");
	
	if($q != false) 
		oci_execute($q);
	
	// Close the Oracle connection
	//oci_close($connection);
}

function oracle_query($query, $array_param = array()){
	global $conn;
	
	$p = oracle_parse($conn, $query);
	
	if($p) {
		if(count($array_param) != 0){
			//oci_bind_by_name($stmt, ':filter', $filterStrJSON, 4000, SQLT_CHR);
			
			/*
			foreach($array_param as $key => $value){
				
				echo $key." -> ".$value."<br><br>";
				
				oci_bind_by_name($p, $key, $value);
			}
			*/
			
			oci_bind_by_name($p, ':date_from', $array_param['date_from']);
			oci_bind_by_name($p, ':date_to', $array_param['date_to']);
		}
		
		$result = oracle_execute($p);
		if ($result)
			return $p;
		
		return false;
		oci_free_statement($stmt);
	}
}

function oracle_parse($conn, $query){
	$result = oci_parse($conn, $query);
	
	if(!$result){
		$e = oci_error($connection);
		var_dump($e);
		trigger_error(htmlentities($e['message']), E_USER_ERROR);
		
		return false;
	} else {
		return $result;
	}
}

function oracle_execute($statement){
	$result = oci_execute($statement);
	if (!$result) {
		$e = oci_error($statement);
		print_r($e);
		
		trigger_error(htmlentities($e['message']), E_USER_ERROR);
	}
	
	return $result;
}







/*
// Create connection to Oracle
$conn = oci_connect("phphol", "welcome", "//localhost/orcl");
if (!$conn) {
   $m = oci_error();
   echo $m['message'], "\n";
   exit;
}
else {
   print "Connected to Oracle!";
}
// Close the Oracle connection
oci_close($conn);
*/

?>