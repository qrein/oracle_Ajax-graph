<?php 
include_once("maincore.php");
include_once("tpl/tpl.php");
// Обоработчик Ajax
if(isset($_GET['get_data']) && $_GET['get_data'] == "1")
{
	if(isset($_GET['date_from']) && isset($_GET['date_to']))
		$array_param = array("date_from" => $_GET['date_from'], "date_to" => $_GET['date_to']);
	else
		$array_param = array("date_from" => "2019-05-01", "date_to" => "2019-05-03");
		
	//$array_param = array("date_from" => date("d.m.Y"), "date_to" => date("d.m.Y"));
		
	$temp_query = "SELECT TO_CHAR(date_in, 'dd.mm.yyyy HH24:MI') date_in, WEIGHT FROM w_all.action WHERE dev_id = 255 AND date_in BETWEEN TO_DATE (:date_from, 'yyyy-mm-dd') AND TO_DATE (:date_to, 'yyyy-mm-dd') ORDER BY date_in ASC";
	$ora_query = oracle_query($temp_query, $array_param);
    if($ora_query){
    	
		
		$i = 0;
		$counter_array = 0;
		while ($data = oci_fetch_array($ora_query, OCI_ASSOC + OCI_RETURN_NULLS)) {
        	if($i%12 == 0){
				$ret_data[0][$counter_array] = $data["DATE_IN"];
				$ret_data[1][$counter_array] = $data["WEIGHT"];
				
				$counter_array++;
			}
			
			$i++;		
        }

		
		$MasX = "";
		$MasY = "";

	

	
		/*
		if ($counter_array > 12) {
			$ret_data['err_period'] = 1;
			$counter_array = 0;

		}
		*/

		
		for ($i = 0; $i < $counter_array; $i++) { 
			$MasX .= "<th align='center'>".$ret_data[0][$i]."</th>";
			$MasY .= "<td align='center'>".$ret_data[1][$i]."</td>";
		}
		
		$ret_data['tbl'] = "<div>
			<table class='table table-striped table-sm'>
				<thead>
					<tr>".$MasX."</tr>
				</thead>
				<tbody>
					<tr>".$MasY."</tr>
				</tbody>
			</table> </div>";

		echo json_encode($ret_data);

    }


	exit();
}






echo GetHeader();

?>



      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		<div class="btn-toolbar mb-2 mb-md-0">
		  <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle"type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" >
		    Часы
		  </button>
		  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			  	<form id="set_date" method='post'>
					  		
					  		<label for="inputDate">Дата от</label>
					  		<br><br>	
						    <label for="inputDate">Введите дату:</label>
						    <input type="date" name="date_from" class="form-control" >

							<br><br>			
							
							<label for="inputDate">Дата до</label>
							<br><br>
					   		<label for="inputDate">Введите дату:</label>
					   		<input type="date" name="date_to" class="form-control" >

					<button  type="button" class="btn btn-sm btn-outline-secondary "type="button" id="ButtonDate"   >
				   			Отправить
				 	</button>
                   </form>
				 	<script type="text/javascript">
				 	 

						
							$('#ButtonDate').on('click', function() {

																
									$.ajax({
										url: "graph.php?get_data=1",
										type: "GET",
										data: $('#set_date').serialize(),
										timeout: 10000,
											
										beforeSend: function(){
											//$("#login_submit").html("<img src='../img/loading.gif' />");
										},
										error: function(XMLHttpRequest, textStatus, ErrorThrown){
											//$("#login_submit").html("Войти");
											alert(textStatus);
										},
										success: function(answer){
											//console.log(answer);
											var temp_data = jQuery.parseJSON(answer);
											//temp_data = JSON.stringify(answer);
											
											//console.log(temp_data);
											
											//var modal_data = Object.values(temp_data['err_period']);
											//console.log(modal_data);
																						
											if(temp_data['err_period'] == 1){
												$("#modal-content").html("Вы ввели большой период, таблица не отобразиться<br>(больше 3ех дней)");
												$('#exampleModal2').modal('show');
												//$("#exampleModal2").show();
											}
											
											$("#tbl_temp").html(temp_data['tbl']);
											
//											console.log(Object.values(temp_data[0]));
											
											//var arrayX = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];
											//var arrayY = [20, 23, 15, 30, 10, 9, 3, 0, -10, -20, 0, 15];
											
											/*
											var array2X = JSON.stringify(temp_data[0]);
											var array2Y = temp_data[1];
											*/
											
											var array2X = Object.values(temp_data[0]);
											var array2Y = Object.values(temp_data[1]);
											
											//console.log(array2X);
											//console.log(array2Y);
											
											//console.log(array2X);
											
											array2Y.forEach(function(value, index) {
								    			array2Y[index] = parseFloat(value);
											});
											
											
											//console.log(array2Y);
											
											//alert(temp_data);

											$("#chart").shieldChart({
												theme: "bootstrap",
												primaryHeader: {
												text: "Температура"
											},	
											seriesSettings: {
												area: {
													pointMark: {
														enabled: true
													}
												}
											},
											axisX: {
												
												categoricalValues: array2X
											},
											dataSeries: [{
												seriesType: "area",
												collectionAlias: "Температура",
												
												data: array2Y
											},
											],


											events: {
												legendSeriesClick: function (e) {
														e.preventDefault();
												}
											}
											});
										}
									});

							});




					</script>

		  </ul>
		</div>
      </div>

	<div class="container">
  		<div class="row">
    		<div class="col-xl-12 col-md-4">
   			<!-- График -->

            <div  id="chart"  > </div>
    	</div>
  	 </div>
  </div>
  
  <div id="tbl_temp"></div>





<!--
<script type="text/javascript">

$("tr").each(function(index, answer){
    $(this).find("td").first().text(temp_data[index]);
})

</script>

-----------------

<script type="text/javascript">
	
	var string = $('html').attr('class');
	var ret_data = string.split(' ');
	var arrayLength = parseInt(ret_data.length);

	for (i=0; i<=arrayLength; i++) {
	  $("#table table-striped table-sm table") .append('<tr><td>'+ret_data[i]+'</td></tr>') 
	}



------------------



	var elm = $('#test'),
    table = $('<table>').appendTo(elm);

	$(document.documentElement.className.split(' ').each(function() {
	    table.append('<tr><td>'+this+'</td></tr>');
	});
	
------------------


	<script type="text/javascript">
		
		array2X.forEach(element => console.log(document));

	</script>	



</script>


-->


<?php
echo GetFooter();

?>
