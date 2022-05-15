<?php
include_once("maincore.php");
include_once("tpl/tpl.php");

// Обоработчик Ajax

//массив начальных дат 
$array_param = array("date_from" => "2019-02-01", "date_to" => "2019-02-05");

//Запрос oracle
$temp_query = "SELECT TO_CHAR(date_in, 'dd.mm.yyyy HH24:MI') date_in, WEIGHT FROM w_all.action WHERE dev_id = 255 AND date_in BETWEEN TO_DATE (:date_from, 'yyyy-mm-dd') AND TO_DATE (:date_to, 'yyyy-mm-dd') ORDER BY date_in ASC";

//запись запроса 
$ora_query = oracle_query($temp_query, $array_param);

//Если ora_query = true то
if($ora_query){
	$i = 0;
	$counter_array = 0;
	//пока data = true 
	while ($data = oci_fetch_array($ora_query, OCI_ASSOC + OCI_RETURN_NULLS)) {
        if($i%12 == 0)
		{
			//запись даты в массив index 0
			$ret_data[0][$counter_array] = $data["DATE_IN"];
			//запись температуры в массив index 1
			$ret_data[1][$counter_array] = $data["WEIGHT"];
				
			//счетчик ++
			$counter_array++;
		}
		//счетчик ++
		$i++;
	}

	print_r($ret_data);
	echo "<hr>";
	
	$themp_average = array();
	$themp_av_values = array();
	$i = 0;
	

	//перебор даты 
	foreach($ret_data[0] as $key => $value){

		//если $current_date не существует то true 
		if(!isset($current_date))

			//current_date присвоим определенных формат даты  из value 
			$current_date = date_parse_from_format("d.m.Y H:i" , $value);

		//value_date присвоим определенных формат даты  из value 
		$value_date = date_parse_from_format("d.m.Y H:i" , $value);

		//если current_date['year'] равна  value_date['year'] и current_date['month'] равна   value_date['month'] и current_date['day'] равна value_date['day'] то 
		if($current_date['year'] == $value_date['year'] && $current_date['month'] == $value_date['month'] && $current_date['day'] == $value_date['day']){

			// в конец массива themp_average добавить ret_data[1][$key]
			array_push($themp_average, $ret_data[1][$key]);

			//иначе 
		}  else {

			//в themp_av_values присвоить сумму значений массива themp_average деленную на количество элементов массива  themp_average и округлить 
			$themp_av_values[$i++] = round(array_sum($themp_average) / count($themp_average), 0);
			
			$themp_average = array();

			// в конец массива themp_average добавить ret_data[1][$key]
			array_push($themp_average, $ret_data[1][$key]);
			$current_date = $value_date;
		}
	}

	//print_r($themp_av_values);
	print_r($themp_av_values);
}






/*
	foreach($ret_data[0] as $key => $value){
		if(!isset($current_date))
			$current_date = date_parse_from_format("d.m.Y H:i" , $value);
			
		//echo $key."<br><br>";
		
		$value_date = date_parse_from_format("d.m.Y H:i" , $value);
		
		/*
		print_r($current_date);
		echo "<br>----------------<bR>";
		print_r($value_date);
		echo "<Br>******************<br><br>";
		*
		
		if($current_date['year'] == $value_date['year'] && $current_date['month'] == $value_date['month'] && $current_date['day'] == $value_date['day']){
			array_push($themp_average, $ret_data[1][$key]);
			/*
			echo "PUSH!!!!!!!!!!!!!<br>";
			print_r($themp_average);
			echo "<br>==============<br>";
			echo $ret_data[1][$key];
			*
		}  else {
			/*
			echo "SUM!!!!!!!!!!!<br>";
			
			print_r(array_sum($themp_average));
			echo "<bR><br>";
			*
			
			$themp_av_values[$i++] = round(array_sum($themp_average) / count($themp_average), 1);
			$themp_average = array();
			array_push($themp_average, $ret_data[1][$key]);
			$current_date = $value_date;
			
			/*
			print_r($themp_av_values);
			echo "<br><br>";
			*
		}
		
		//echo "<hr>";
	}
*/









	
	/*
	$date = date_create_from_format('j.M.Y G:i', $ret_data[0][0]);
	echo date_format($date, 'Y-m-d');
	*/
	





/*
$array = array(0 => 0, 1 => 1, 2 => 2, 3 => "test", 4 => 4);


print_r($array);
echo "<hr>";

$i = 0;
foreach($array as $value){
	if($i%2 != 0){
		unset($array[$i]);
		echo "sdfgsdfg<br>";
	}
	
	$i++;
}


$i = 0;
foreach($array as $value){
	if($i >= 4){
		unset($array[$i]);
		echo "sdfgsdfg<br>";
		$i = 0;
	}else{
		$i++;
	}
}


print_r($array);
*/


//unset($array);



/*
if(count($_GET) > 0){
	print_r($_GET);
	echo "<br><br><br>";
}
	

$array = array("name" => "jhon", "age" => "21");

print_r($array);
echo "<hr>";


$array_str = serialize($array);
echo $array_str;

echo "<hr>";


$array_d = unserialize($array_str);
print_r($array_d);
*/



?>