<?php
	$link = mysqli_connect("127.0.0.1", "root", "12345678", "registration");
							
	if (!$link) 
	{
		echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
		echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}
?>