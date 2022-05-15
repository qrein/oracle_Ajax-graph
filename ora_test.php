<?php
// Вывод на страницу в UTF-8
header("Content-Type: text/html; charset=utf-8");

// Устанавливаем вывод ошибок
//error_reporting(E_ALL);
ini_set('display_errors', '1');

// Config
$host = "IP adress to Oracle server";
$port = "1521";
$db_name = "Database name";
$db_encoding = "UTF8";
$db_connection_type = "";
$db_username = "Database username";
$db_password = "Database password";

$temp_query = "SELECT * FROM w_all.action WHERE dev_id = 255 AND date_in BETWEEN TO_DATE (:date_from, 'dd.mm.yyyy') AND TO_DATE (:date_to, 'dd.mm.yyyy') ORDER BY date_in ASC";

// Connect
$connection = oci_pconnect($db_username, $db_password, '//'.$host.':'.$port.'/'.$db_name.(($db_connection_type == '') ? '' : ':'.$db_connection_type), $db_encoding);

if (!$connection) {
	$e = oci_error();
	
	print_r($e);
	
} else {
	$q = oci_parse($connection, "ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD\"T\"HH24:MI:SS'");
	
	if($q != false) 
		oci_execute($q);
	
	// Select
	
	echo $temp_query."<hr>";
	$array_param = array("date_from" => "01.01.2019", "date_to" => "05.01.2019");
	
	$ora_query = oracle_query($connection, $temp_query, $array_param);
	if($ora_query){
		while ($data = oci_fetch_array($ora_query, OCI_ASSOC + OCI_RETURN_NULLS)) {
			print_r($data);
			echo "<br><br>";
		}
	}
	
	// Close the Oracle connection
	oci_close($connection);
}
function oracle_query($conn, $query, $array_param = array()){
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