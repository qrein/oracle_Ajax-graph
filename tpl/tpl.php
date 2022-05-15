<?php
function GetLoginForm($errors = "")
{
	return "
		<!DOCTYPE html>
		<html>

			<head>

				<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
				<title>Вход</title>
				<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl' crossorigin='anonymous'>
				<link rel='stylesheet' href='./CSS/main.css'>
			</head>
			<body>				
				<fieldset>
					<center>
						<form method='post'>
							<label class='Head'>Авторизация</label><br><br>
							<div id='er' class='er'></div>
							<label>Логин</label><br>
							<input type='text' name='login' id='login' ><br>
							<label>Пароль</label><br>
							<input type='password' name='password' id='password' ><br>

							<input type='checkbox' name='remember_me' checked='checked' />
							 Запомнить меня<br><br>


							<input type='submit' name='input' value='Войти'><br><br>
							<p>&copy; 2017–2021</p>				
						</form>
						</center>
				</fieldset>
				
				<br>
				<center><font color=red>".$errors."</font></center>
				<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js' integrity='sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0' crossorigin='anonymous'></script>
			</body>
		</html>


	";
}

function GetHeader(){
	return '<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Админка </title>
<script src="https://bootstraptema.ru/plugins/jquery/jquery-1.11.3.min.js"></script>    

<!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="CSS/dashboard.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/1151.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    
  </head>
  <body>


    
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">

 <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
          <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Админка</a>
				<div class="d-grid gap-2 d-md-block">
					<div class="topnav">

		    			<a class="navbar-brand" href="graph.php">График</a>
		    			<!-- Button trigger modal -->
						<a type="button" class="navbar-brand" data-bs-toggle="modal" data-bs-target="#exampleModal2">
						  оборудование 
						</a>


			  		</div>
				</div>
			</div>           
   </nav>
    <a href="exit.php" class="navbar-brand">Выйти</a>
</header>

	
	';
}


function TableError()
{
	return'<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>';
}


function GetFooter(){
	return'
      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>

  	
	<script src="https://bootstraptema.ru/plugins/2016/shieldui/script.js"></script>
 	<script src="includes/graph.js"></script> 
      

      <!-- Дополнительный JavaScript; выберите один из двух! -->

    <!-- Вариант 1: Bootstrap в связке с Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <!-- МОДАЛ-->


						<!-- Modal -->
						<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title" id="exampleModalLabel">Ошибка</h5>
						        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						      </div>
						      <div class="modal-body">
						        <div id="modal-content">
						        	      <h2>Таблица</h2>
								      <div class="table-responsive">
								        <table class="table table-striped table-sm">
								          <thead>
								            <tr>
								              <th>#</th>
								              <th>Header</th>
								              <th>Header</th>
								              <th>Header</th>
								              <th>Header</th>
								            </tr>
								          </thead>
								          <tbody>
								            <tr>
								              <td>1,001</td>
								              <td>random</td>
								              <td>data</td>
								              <td>placeholder</td>
								              <td>text</td>
								            </tr>
								            <tr>
								              <td>1,002</td>
								              <td>placeholder</td>
								              <td>irrelevant</td>
								              <td>visual</td>
								              <td>layout</td>
								            </tr>
								            <tr>
								              <td>1,003</td>
								              <td>data</td>
								              <td>rich</td>
								              <td>dashboard</td>
								              <td>tabular</td>
								            </tr>
								            <tr>
								              <td>1,003</td>
								              <td>information</td>
								              <td>placeholder</td>
								              <td>illustrative</td>
								              <td>data</td>
								            </tr>
								            <tr>
								              <td>1,004</td>
								              <td>text</td>
								              <td>random</td>
								              <td>layout</td>
								              <td>dashboard</td>
								            </tr>
								            <tr>
								              <td>1,005</td>
								              <td>dashboard</td>
								              <td>irrelevant</td>
								              <td>text</td>
								              <td>placeholder</td>
								            </tr>
								            <tr>
								              <td>1,006</td>
								              <td>dashboard</td>
								              <td>illustrative</td>
								              <td>rich</td>
								              <td>data</td>
								            </tr>
								            <tr>
								              <td>1,007</td>
								              <td>placeholder</td>
								              <td>tabular</td>
								              <td>information</td>
								              <td>irrelevant</td>
								            </tr>
								            <tr>
								              <td>1,008</td>
								              <td>random</td>
								              <td>data</td>
								              <td>placeholder</td>
								              <td>text</td>
								            </tr>
								            <tr>
								              <td>1,009</td>
								              <td>placeholder</td>
								              <td>irrelevant</td>
								              <td>visual</td>
								              <td>layout</td>
								            </tr>
								            <tr>
								              <td>1,010</td>
								              <td>data</td>
								              <td>rich</td>
								              <td>dashboard</td>
								              <td>tabular</td>
								            </tr>
								            <tr>
								              <td>1,011</td>
								              <td>information</td>
								              <td>placeholder</td>
								              <td>illustrative</td>
								              <td>data</td>
								            </tr>
								            <tr>
								              <td>1,012</td>
								              <td>text</td>
								              <td>placeholder</td>
								              <td>layout</td>
								              <td>dashboard</td>
								            </tr>
								            <tr>
								              <td>1,013</td>
								              <td>dashboard</td>
								              <td>irrelevant</td>
								              <td>text</td>
								              <td>visual</td>
								            </tr>
								            <tr>
								              <td>1,014</td>
								              <td>dashboard</td>
								              <td>illustrative</td>
								              <td>rich</td>
								              <td>data</td>
								            </tr>
								            <tr>
								              <td>1,015</td>
								              <td>random</td>
								              <td>tabular</td>
								              <td>information</td>
								              <td>text</td>
								            </tr>
								          </tbody>
								        </table>
								      </div>
						        </div>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Хорошо</button>
						        
						      </div>
						    </div>
						  </div>
						</div>
  </body>
</html>




	';
}

?>