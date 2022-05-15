<?php
	include_once("link.php");
	$token=$_COOKIE["tokenCookie"];
	$query="UPDATE Users SET Token=NULL WHERE Token='$token'";
	unset($_COOKIE["tokenCookie"]);
	mysqli_query($link, $query);
	header("Location: input.php");
?>