<!DOCTYPE html>
<?php
	session_start();
	include 'menu_user_authenticated.php';
	if(!isset($_SESSION["user_id"])){
		header("Location:index.php");
	}
	if($_SESSION["usertype"] != 1){
		header("Location:userMain.php");
	}
?>
<html>
	<head>

		<link href = "https://use.fontawesome.com/releases/v5.8.2/css/all.css" rel="stylesheet"></link>
		<link href = "user.css" rel="stylesheet"></link>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"/>
		<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.css"/>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/heatmapjs@2.0.2/heatmap.js"> </script>
		<script src="https://raw.githubusercontent.com/pa7/heatmap.js/develop/plugins/leaflet-heatmap/leaflet-heatmap.js"></script>
		<script src="map.js"></script>
		
		<script>
			$(document).ready(function(){
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function(){
					if(this.readyState == 4 && this.status == 200){
						var reply = JSON.parse(this.responseText);
						setTable1(reply.d1);
						setTable2(reply.d2);
						setTable3(reply.d3);
						setTable4(reply.d4);
						setTable5(reply.d5);
						setTable6(reply.d6);
					}
				}
				xhttp.open("POST", "adminTables.php");
				xhttp.send();
			});
			

			
			function setTable1(data){
				document.getElementById("table-container1").innerHTML = "";
				$('<table class = "table table-hover" id = "distr_1"></table>').appendTo($("#table-container1"));
				var table = document.getElementById("distr_1");
				var thead = table.createTHead();
				var row = thead.insertRow();
				var th = document.createElement("th");
				var text = document.createTextNode("Κατανομή των δραστηριοτήτων των χρηστών");
				th.appendChild(text);
				row.appendChild(th);
				var row = thead.insertRow();
				var th = document.createElement("th");
				var text = document.createTextNode("Δραστηριότητα");
				th.appendChild(text);
				row.appendChild(th);
				var th = document.createElement("th");
				var text = document.createTextNode("Ποσοστό");
				th.appendChild(text);
				row.appendChild(th);
			
				
				for(var element of data){
					var row = table.insertRow();
					for(key in element){
						var cell = row.insertCell();
						var text = document.createTextNode(element[key]);
						cell.appendChild(text);
					}
				}
			}
			
			
			function setTable2(data){
				document.getElementById("table-container2").innerHTML = "";
				$('<table class = "table table-hover" id = "distr_2"></table>').appendTo($("#table-container2"));
				var table = document.getElementById("distr_2");
				var thead = table.createTHead();
				var row = thead.insertRow();
				var th = document.createElement("th");
				var text = document.createTextNode("Κατανομή του πλήθους εγγραφών ανά χρήστη");
				th.appendChild(text);
				row.appendChild(th);
				var row = thead.insertRow();
				var th = document.createElement("th");
				var text = document.createTextNode("Χρήστης");
				th.appendChild(text);
				row.appendChild(th);
				var th = document.createElement("th");
				var text = document.createTextNode("Ποσοστό");
				th.appendChild(text);
				row.appendChild(th);
			
				
				for(var element of data){
					var row = table.insertRow();
					for(key in element){
						var cell = row.insertCell();
						var text = document.createTextNode(element[key]);
						cell.appendChild(text);
					}
				}
			}
			
			function setTable3(data){
				document.getElementById("table-container3").innerHTML = "";
				$('<table class = "table table-hover" id = "distr_3"></table>').appendTo($("#table-container3"));
				var table = document.getElementById("distr_3");
				var thead = table.createTHead();
				var row = thead.insertRow();
				var th = document.createElement("th");
				var text = document.createTextNode("Κατανομή του πλήθους εγγραφών ανά μήνα");
				th.appendChild(text);
				row.appendChild(th);
				var row = thead.insertRow();
				var th = document.createElement("th");
				var text = document.createTextNode("Μήνας");
				th.appendChild(text);
				row.appendChild(th);
				var th = document.createElement("th");
				var text = document.createTextNode("Ποσοστό");
				th.appendChild(text);
				row.appendChild(th);
			
				
				for(var element of data){
					var row = table.insertRow();
					for(key in element){
						var cell = row.insertCell();
						var text = document.createTextNode(element[key]);
						cell.appendChild(text);
					}
				}
			}
			
			function setTable4(data){
				document.getElementById("table-container4").innerHTML = "";
				$('<table class = "table table-hover" id = "distr_4"></table>').appendTo($("#table-container4"));
				var table = document.getElementById("distr_4");
				var thead = table.createTHead();
				var row = thead.insertRow();
				var th = document.createElement("th");
				var text = document.createTextNode("Κατανομή του πλήθους εγγραφών ανά ημέρα της εβδομάδας");
				th.appendChild(text);
				row.appendChild(th);
				var row = thead.insertRow();
				var th = document.createElement("th");
				var text = document.createTextNode("Ημέρα");
				th.appendChild(text);
				row.appendChild(th);
				var th = document.createElement("th");
				var text = document.createTextNode("Ποσοστό");
				th.appendChild(text);
				row.appendChild(th);
			
				
				for(var element of data){
					var row = table.insertRow();
					for(key in element){
						var cell = row.insertCell();
						var text = document.createTextNode(element[key]);
						cell.appendChild(text);
					}
				}
			}
			
			function setTable5(data){
				document.getElementById("table-container5").innerHTML = "";
				$('<table class = "table table-hover" id = "distr_5"></table>').appendTo($("#table-container5"));
				var table = document.getElementById("distr_5");
				var thead = table.createTHead();
				var row = thead.insertRow();
				var th = document.createElement("th");
				var text = document.createTextNode("Κατανομή του πλήθους εγγραφών ανά ώρα");
				th.appendChild(text);
				row.appendChild(th);
				var row = thead.insertRow();
				var th = document.createElement("th");
				var text = document.createTextNode("Ώρα");
				th.appendChild(text);
				row.appendChild(th);
				var th = document.createElement("th");
				var text = document.createTextNode("Ποσοστό");
				th.appendChild(text);
				row.appendChild(th);
			
				
				for(var element of data){
					var row = table.insertRow();
					for(key in element){
						var cell = row.insertCell();
						var text = document.createTextNode(element[key]);
						cell.appendChild(text);
					}
				}
			}
			
			function setTable6(data){
				document.getElementById("table-container6").innerHTML = "";
				$('<table class = "table table-hover" id = "distr_6"></table>').appendTo($("#table-container6"));
				var table = document.getElementById("distr_6");
				var thead = table.createTHead();
				var row = thead.insertRow();
				var th = document.createElement("th");
				var text = document.createTextNode("Κατανομή του πλήθους εγγραφών ανά έτος");
				th.appendChild(text);
				row.appendChild(th);
				var row = thead.insertRow();
				var th = document.createElement("th");
				var text = document.createTextNode("Έτος");
				th.appendChild(text);
				row.appendChild(th);
				var th = document.createElement("th");
				var text = document.createTextNode("Ποσοστό");
				th.appendChild(text);
				row.appendChild(th);
			
				
				for(var element of data){
					var row = table.insertRow();
					for(key in element){
						var cell = row.insertCell();
						var text = document.createTextNode(element[key]);
						cell.appendChild(text);
					}
				}
			}
			
			function searchForLocations(){
				if(!$('#all_month').is(":checked")){
					var month_from = $("#m_from")[0].selectedIndex;
					var month_to = $("#m_to")[0].selectedIndex;
					if(month_from > month_to){
						var temp = month_from;
						month_from = month_to;
						month_to = temp;
					}
				}
				else{
					var month_from = -1;
					var month_to = -1;
				}
				if(!$('#all_hour').is(":checked")){
					var hour_from = $("#h_from")[0].selectedIndex;
					var hour_to = $("#h_to")[0].selectedIndex;
					if(hour_from > hour_to){
						var temp = hour_from;
						hour_from = hour_to;
						hour_to = temp;
					}
				}
				else{
					var hour_from = -1;
					var hour_to = -1;
				}
				if(!$('#all_day').is(":checked")){
					var day_from = $("#d_from")[0].selectedIndex;
					var day_to = $("#d_to")[0].selectedIndex;
					if(day_from > day_to){
						var temp = day_from;
						day_from = day_to;
						day_to = temp;
					}
				}
				else{
					var day_from = -1;
					var day_to = -1;
				}
				if($("#y_from").val() != "" && $("#y_to").val() != ""){
					var year_from = $("#y_from").val();
					var year_to = $("#y_to").val();
					if(isNaN(year_from) || isNaN(year_to)){
						alert("Τα έτη πρέπει να είναι αριθμοί");
						return;
					}
					if(year_from > year_to){
						var temp = year_from;
						year_from = year_to;
						year_to = temp;
					}
				}
				else{
					var year_from = -1;
					var year_to = -1;
				}
				var act = document.getElementById("drast").selectedOptions;
				var all = [];
				if(act.length != 0){
					for(var i = 0; i < act.length; i++){	
						all.push(act[i].value);
					}
				}
				var xhttp = new XMLHttpRequest();
				var data = {month_from: month_from, month_to,year_from: year_from, year_to: year_to, hour_from: hour_from, hour_to: hour_to, day_from: day_from, day_to: day_to, activities: all};
				const jsonData = JSON.stringify(data);
				xhttp.onreadystatechange = function(){
					if(this.readyState == 4 && this.status == 200){
						var reply = JSON.parse(this.responseText);
						createMap(reply);
					}
				}
				xhttp.open("POST", "adminLocationData.php");
				xhttp.setRequestHeader("Content-Type", "application/json");
				xhttp.send(jsonData);
			}
			
			function exportToFile(){
				if(!$('#all_month').is(":checked")){
					var month_from = $("#m_from")[0].selectedIndex;
					var month_to = $("#m_to")[0].selectedIndex;
					if(month_from > month_to){
						var temp = month_from;
						month_from = month_to;
						month_to = temp;
					}
				}
				else{
					var month_from = -1;
					var month_to = -1;
				}
				if(!$('#all_hour').is(":checked")){
					var hour_from = $("#h_from")[0].selectedIndex;
					var hour_to = $("#h_to")[0].selectedIndex;
					if(hour_from > hour_to){
						var temp = hour_from;
						hour_from = hour_to;
						hour_to = temp;
					}
				}
				else{
					var hour_from = -1;
					var hour_to = -1;
				}
				if(!$('#all_day').is(":checked")){
					var day_from = $("#d_from")[0].selectedIndex;
					var day_to = $("#d_to")[0].selectedIndex;
					if(day_from > day_to){
						var temp = day_from;
						day_from = day_to;
						day_to = temp;
					}
				}
				else{
					var day_from = -1;
					var day_to = -1;
				}
				if($("#y_from").val() != "" && $("#y_to").val() != ""){
					var year_from = $("#y_from").val();
					var year_to = $("#y_to").val();
					if(isNaN(year_from) || isNaN(year_to)){
						alert("Τα έτη πρέπει να είναι αριθμοί");
						return;
					}
					if(year_from > year_to){
						var temp = year_from;
						year_from = year_to;
						year_to = temp;
					}
				}
				else{
					var year_from = -1;
					var year_to = -1;
				}
				var act = document.getElementById("drast").selectedOptions;
				var all = [];
				if(act.length != 0){
					for(var i = 0; i < act.length; i++){	
						all.push(act[i].value);
					}
				}
				var xhttp = new XMLHttpRequest();
				var data = {month_from: month_from, month_to,year_from: year_from, year_to: year_to, hour_from: hour_from, hour_to: hour_to, day_from: day_from, day_to: day_to, activities: all, type: $("#export_type")[0].selectedIndex };
				const jsonData = JSON.stringify(data);
				xhttp.onreadystatechange = function(){
					if(this.readyState == 4 && this.status == 200){
						alert("Επιτυχής εξαγωγή");
					}
				}
				xhttp.open("POST", "export.php");
				xhttp.setRequestHeader("Content-Type", "application/json");
				xhttp.send(jsonData);
			}
			
			function deleteAll(){
				var c = confirm("Θέλετε να διαγράψετε όλα τα δεδομένα;");
				if(c == true){
					var xhttp = new XMLHttpRequest();
					xhttp.onreadystatechange = function(){
						if(this.readyState == 4 && this.status == 200){
							if(this.responseText == 11){
								alert("Επιτυχής Διαγραφή");
								location.reload();
							}
							else{
								alert("Μη Επιτυχής Διαγραφή");
							}
						}
					}
					xhttp.open("POST", "delete.php");
					xhttp.send();
				}
			}
			
			function createMap(data){
				document.getElementById("map-container").innerHTML = "";
				$('<div id = "map"></div>').appendTo($("#map-container"));
				var map = L.map('map');
				L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
					attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
				}).addTo(map);
				map.setView([38.2462420, 21.7350847], 12);
				var drawnItems = new L.FeatureGroup();
				map.addLayer(drawnItems); 
				var mapData = {
					max: data.max,
					data: data.locations
				};
				console.log(mapData);
				var cfg = {
					"radius": 40,
					"max_opacity": 0.8,
					"scaleRadius": false,
					"useLocalExtrema": false,
					latField: 'latitude',
					lngField: 'longitude',
					valueField: 'c'
				};
				var heatmapLayer = new HeatmapOverlay(cfg);
				map.addLayer(heatmapLayer);
				heatmapLayer.setData(mapData);
			}
		</script>
		
	</head>
	<body>
	
	
		<div class="container-fluid" >
			<hr>
			<div class="row element">
				<div id = "table-container1"  class = "col-sm-4">
					<table class = "table table-hover" id = "distr_1"></table>
				</div>
				<div id = "table-container2" class = "col-sm-4">
					<table class = "table table-hover" id = "distr_2"></table>
				</div>
				<div id = "table-container3"  class = "col-sm-4">
					<table class = "table table-hover" id = "distr_3"></table>
				</div>
			</div>
			<div class="row element">
				<div id = "table-container4"  class = "col-sm-4">
					<table class = "table table-hover" id = "distr_4"></table>
				</div>
				<div id = "table-container5" class = "col-sm-4">
					<table class = "table table-hover" id = "distr_5"></table>
				</div>
				<div id = "table-container6"  class = "col-sm-4">
					<table class = "table table-hover" id = "distr_6"></table>
				</div>
			</div>
			<hr>
			<div class = "row element">
				<form>
					<div class = "container">
						<div class = "row">
							<div class = "col-sm-12">
								<div class = "form-group">
									<label class = "control-label">Δραστηριότητες</label> 
								</div>
								<div class = "col-12">
								<div class = "form-group">
									<select multiple class = "form-control" id = "drast">
										<option>EXITING_VEHICLE</option>
										<option>IN_BUS</option>
										<option>IN_CAR</option>
										<option>IN_RAIL_VEHICLE</option>
										<option>IN_FOUR_WHEELER_VEHICLE</option>
										<option>IN_ROAD_VEHICLE</option>
										<option>IN_TWO_WHEELER_VEHICLE</option>
										<option>ON_BICYCLE</option>
										<option>ON_FOOT</option>
										<option>RUNNING</option>
										<option>STILL</option>
										<option>TILTING</option>
										<option>UNKNOWN</option>
										<option>WALKING</option>
									</select>
								</div>
							</div>
							</div>
							
							
						</div>
						<div class = "row">
							<div class = "col-sm-5">
								<div class = "form-group">
								<label class = "control-label">Μήνας Από</label> 
								</div>
								<div class = "col-sm-5">
								<div class = "form-group">
									<select class="form-control" id = "m_from">
										<option>Ιανουάριος</option>
										<option>Φεβρουάριος</option>
										<option>Μάρτιος</option>
										<option>Απρίλιος</option>
										<option>Μάιος</option>
										<option>Ιούνιος</option>
										<option>Ιούλιος</option>
										<option>Αύγουστος</option>
										<option>Σεπτέμβριος</option>
										<option>Οκτώβριος</option>
										<option>Νοέμβριος</option>
										<option>Δεκέμβριος</option>
									</select>
								</div>
							</div>
							</div>
							<div class = "col-sm-5">
								<div class = "form-group">
								<label class = "control-label">Μήνας Έως</label>  
								</div>
								<div class = "col-sm-5">
								<div class = "form-group">
									<select class="form-control" id = "m_to">
										<option>Ιανουάριος</option>
										<option>Φεβρουάριος</option>
										<option>Μάρτιος</option>
										<option>Απρίλιος</option>
										<option>Μάιος</option>
										<option>Ιούνιος</option>
										<option>Ιούλιος</option>
										<option>Αύγουστος</option>
										<option>Σεπτέμβριος</option>
										<option>Οκτώβριος</option>
										<option>Νοέμβριος</option>
										<option>Δεκέμβριος</option>
									</select>
								</div>
							</div>
							</div>
							<div class = "col-sm-2">
								<div class = "form-group">
									<label><input type = "checkbox" id = "all_month" class = "form-control">όλοι οι μήνες</label>
								</div>
							</div>
						</div>
						<div class = "row">
							<div class = "col-sm-5">
								<div class = "form-group">
								<label class = "control-label">Ώρα Από</label> 
								</div>
								<div class = "col-sm-5">
								<div class = "form-group">
								<select class="form-control" id = "h_from">
										<option>00</option>
										<option>01</option>
										<option>02</option>
										<option>03</option>
										<option>04</option>
										<option>05</option>
										<option>06</option>
										<option>07</option>
										<option>08</option>
										<option>09</option>
										<option>10</option>
										<option>11</option>
										<option>12</option>
										<option>13</option>
										<option>14</option>
										<option>15</option>
										<option>16</option>
										<option>17</option>
										<option>18</option>
										<option>19</option>
										<option>20</option>
										<option>21</option>
										<option>22</option>
										<option>23</option>
									</select>
								</div>
							</div>
							</div>
							<div class = "col-sm-5">
								<div class = "form-group">
								<label class = "control-label">Ώρα Έως</label>  
								</div>
								<div class = "col-sm-5">
								<div class = "form-group">
								<select class="form-control" id = "h_to">
										<option>00</option>
										<option>01</option>
										<option>02</option>
										<option>03</option>
										<option>04</option>
										<option>05</option>
										<option>06</option>
										<option>07</option>
										<option>08</option>
										<option>09</option>
										<option>10</option>
										<option>11</option>
										<option>12</option>
										<option>13</option>
										<option>14</option>
										<option>15</option>
										<option>16</option>
										<option>17</option>
										<option>18</option>
										<option>19</option>
										<option>20</option>
										<option>21</option>
										<option>22</option>
										<option>23</option>
									</select>
								</div>
							</div>
							</div>
							<div class = "col-sm-2">
								<div class = "form-group">
								<label><input type = "checkbox" id = "all_hour" class = "form-control">όλες οι ώρες</label>
								</div>
							</div>
						</div>

						<div class = "row">
							<div class = "col-sm-5">
								<div class = "form-group">
								<label class = "control-label">Ημέρα από</label> 
								</div>
								<div class = "col-sm-5">
								<div class = "form-group">
								<select class="form-control" id = "d_from">
										<option>Κυριακή</option>
										<option>Δευτέρα</option>
										<option>Τρίτη</option>
										<option>Τετάρτη</option>
										<option>Πέμπτη</option>
										<option>Παρασκευή</option>
										<option>Σάββατο</option>
									</select>
								</div>
							</div>
							</div>
							<div class = "col-sm-5">
								<div class = "form-group">
								<label class = "control-label">Ημέρα Έως</label>  
								</div>
								<div class = "col-sm-5">
								<div class = "form-group">
								<select class="form-control" id = "d_to">
										<option>Κυριακή</option>
										<option>Δευτέρα</option>
										<option>Τρίτη</option>
										<option>Τετάρτη</option>
										<option>Πέμπτη</option>
										<option>Παρασκευή</option>
										<option>Σάββατο</option>
									</select>
								</div>
							</div>
							</div>
							<div class = "col-sm-2">
								<div class = "form-group">
								<label><input type = "checkbox" id = "all_day" class = "form-control">όλες οι ημέρες</label>
								</div>
							</div>
						</div>

						<div class = "row">
							<div class = "col-sm-5">
								<div class = "form-group">
								<label class = "control-label">Έτος από</label> 
								</div>
								<div class = "col-sm-5">
								<div class = "form-group">
								<input type = "text" class = "form-control" id = "y_from" />
								</div>
							</div>
							</div>
							<div class = "col-sm-5">
								<div class = "form-group">
								<label class = "control-label">Έτος Έως</label>  
								</div>
								<div class = "col-sm-5">
								<div class = "form-group">
								<input type = "text" class = "form-control" id = "y_to" />
								</div>
							</div>
							</div>
							
						</div>
					
						<div class = "row">
							<div class = "col-sm-12">
								<div class = "form-group">
									<label class = "control-label">Τύπος αρχείου εξαγωγής</label> 
								</div>
							</div>
							<div class = "col-sm-12">
								<div class = "form-group">
									<select class="form-control" id = "export_type">
										<option>CSV</option>
										<option>JSON</option>
									</select>
								</div>
							</div>
						</div>
						<button type = "button" class = "col-offset-2 btn btn-danger navbar-btn" onclick = "searchForLocations();">Αναζήτηση</button>
						<button type = "button" class = "col-offset-2 btn btn-danger navbar-btn" onclick = "exportToFile()">Εξαγωγή</button>
						<button type = "button" class = "col-offset-2 btn btn-danger navbar-btn" onclick = "deleteAll()">Διαγραφή</button>
					</div>
					
						<div id="map-container"style="width:800px; margin:0 auto;">
							<div id = "map"></div>
						</div>
					
				</form>
			</div>
		</div>
		
	</body>
</html>