$(document).ready(function() {
	var temp_data;
	
	$.ajax({
		url: "graph.php?get_data=1",
		type: "GET",
		//data: $('#login_form').serialize(),
		timeout: 3000,
			
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
			
			//console.log(Object.values(temp_data[0]));
			
			if(temp_data['err_period'] == 1){
				$("#modal-content").html("Вы ввели большой период, таблица не отобразиться");
				$('#exampleModal2').modal('show');
				//$("#exampleModal2").show();
			}
			
			$("#tbl_temp").html(temp_data['tbl']);
			
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
	
	
	
	//alert(temp_data["x"]);
	
	/*
	$("#chart").shieldChart({
		theme: "bootstrap",
		primaryHeader: {
		text: "температура"
	},	
	seriesSettings: {
		area: {
			pointMark: {
				enabled: true
			}
		}
	},
	axisX: {
		//categoricalValues: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"]
		categoricalValues: temp_data["x"]
	},
	dataSeries: [{
		seriesType: "area",
		collectionAlias: "Ср. температура",
		//data: [20, 23, 15, 30, 10, 9, 3, 0, -10, -20, 0, 15]
		data: temp_data["y"]
	}],
	events: {
		legendSeriesClick: function (e) {
				e.preventDefault();
		}
	}
	});
	*/

	
});