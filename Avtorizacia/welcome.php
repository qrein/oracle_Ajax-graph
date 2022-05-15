<?php
	ob_start();

	include_once("link.php");

	$token=$_GET["text"];
	

	$query="SELECT name FROM users WHERE Token='$token'";
	if(!empty($token))
	{
		if($result=mysqli_query($link, $query))
		{
			if(mysqli_num_rows($result)) 
			{
				$row=mysqli_fetch_assoc($result);
			}
			else header("Location: index.php");
		}
		else header("Location: index.php");
	}
	else header("Location: index.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Главная страница</title>
		<link rel="stylesheet" href="welcome.css">
	</head>
	<body>
		<!-- Top navigation -->
		<div class="topnav">

			<!-- Centered link -->
			<div class="topnav-centered">
				<a href="#home" class="active">Home</a>
			</div>
			  
			<!-- Left-aligned links (default) -->
			<a href="#news">News</a>
			<a href="#contact">Contact</a>
			  
			<!-- Right-aligned links -->
			<div class="topnav-right">
				<a href="exit.php">Выход</a>
			</div>
		</div>

		<!-- <div class="UpMenu">
			<form method="post">
				
			</form>
		</div> -->
		<form>
			<p>Добро пожаловать, <?php echo $row["name"]; ?>!</p>
		</form>
	</body>
</html>

<?php
	ob_end_flush();
?>