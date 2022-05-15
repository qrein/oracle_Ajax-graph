<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<style>
			body 
			{
			  margin: 0;
			  font-family: Arial, Helvetica, sans-serif;
			}

			.topnav 
			{
			  position: relative;
			  overflow: hidden;
			  background-color: #333;
			}

			.topnav a 
			{
			  float: left;
			  color: #f2f2f2;
			  text-align: center;
			  padding: 14px 16px;
			  text-decoration: none;
			  font-size: 17px;
			}

			.topnav a:hover 
			{
			  background-color: #ddd;
			  color: black;
			}

			.topnav a.active
			{
			  background-color: #4CAF50;
			  color: white;
			}

			.topnav-centered a 
			{
			  float: none;
			  position: absolute;
			  top: 50%;
			  left: 50%;
			  transform: translate(-50%, -50%);
			}

			.topnav-right 
			{
			  float: right;
			}

			/* Responsive navigation menu (for mobile devices) */
			@media screen and (max-width: 600px) 
			{
				.topnav a, .topnav-right 
				{
				float: none;
				display: block;
				}
			  
				.topnav-centered a 
				{
					position: relative;
					top: 0;
					left: 0;
					transform: none;
				}
			}
		</style>
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
				<a href="register.php">Зарегистрироваться</a>
				<a href="input.php">Войти</a>
			</div>
		</div>
	</body>
</html>