<!DOCTYPE html>
<?php
	session_start();
	include 'menu_user_authenticated.php';
	if(!isset($_SESSION["user_id"])){
		header("Location:index.php");
	}
	if($_SESSION["usertype"] != 0){
		header("Location:adminMain.php");
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
						var d = new Date();
						var reply = JSON.parse(this.responseText);
						$('#current_label').append('Οικολογική Μετακίνηση για τον μήνα '+(d.getMonth()+1)+': '+reply.echo+"%");
						createTable(reply.echo_year);
						$('#range_label').append('Οι εγγραφές σας ξεκινάνε από '+reply.range.start+' έως '+reply.range.end);
						$('#uploaded').append('Τελευταίο upload: '+reply.upload);
					}
				}
				xhttp.open("POST", "userTables.php");
				xhttp.send();
			});
			
			function createTable(data){
				document.getElementById("table-container").innerHTML = "";
				$('<table class = "table table-hover" id = "past_year"></table>').appendTo($("#table-container"));
				var table = document.getElementById("past_year");
				var thead = table.createTHead();
				var row = thead.insertRow();
				var th = document.createElement("th");
				var text = document.createTextNode("Score Οικολογικής Μετακίνησης Περασμένου έτους");
				th.appendChild(text);
				row.appendChild(th);
				var row = thead.insertRow();
				var th = document.createElement("th");
				var text = document.createTextNode("Ημερομηνία");
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
			
			function userSearch(){
				var m_from = $("#m_from")[0].selectedIndex;
				var m_to =  $("#m_to")[0].selectedIndex;
				var y_from = $("#y_from").val();
				var y_to = $("#y_to").val();
				if(y_from == "" || ""){
					alert("Παρακαλώ δώστε ένα έτος και στα δύο πεδία");
					return;
				}
				if(isNaN(y_from) || isNaN(y_to)){
					alert("Τα έτη πρέπει να είναι αριθμοί");
					return;
				}
				if(y_from > y_to){
					var temp = y_from;
					y_from = y_to;
					y_to = temp;
				}
				if(m_from > m_to){
					var temp = m_from;
					m_from = m_to;
					m_to = temp;
				}
				var xhttp = new XMLHttpRequest();
				var data = {from_month: m_from, to_month: m_to, from_year: y_from, to_year: y_to};
				const jsonData = JSON.stringify(data);
				xhttp.onreadystatechange = function(){
					if(this.readyState == 4 && this.status == 200){
						var reply = JSON.parse(this.responseText);
						createTableType(reply.percent);
						createTableDay(reply.day);
						createTableHour(reply.hour);
						createMap(reply.locations);
					}
				}
				xhttp.open("POST", "userData.php");
				xhttp.setRequestHeader("Content-Type", "application/json");
				xhttp.send(jsonData);
			}
			
			function createTableType(data){
				document.getElementById("table-container2").innerHTML = "";
				$('<table class = "table table-hover" id = "type"></table>').appendTo($("#table-container2"));
				var table = document.getElementById("type");
				var thead = table.createTHead();
				var row = thead.insertRow();
				var th = document.createElement("th");
				var text = document.createTextNode("ποσοστό εγγραφών ανά είδος δραστηριότητας");
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
			
			function createTableDay(data){
				document.getElementById("table-container3").innerHTML = "";
				$('<table class = "table table-hover" id = "day"></table>').appendTo($("#table-container3"));
				var table = document.getElementById("day");
				var thead = table.createTHead();
				var row = thead.insertRow();
				var th = document.createElement("th");
				var text = document.createTextNode("ημέρα της εβδομάδας με τις περισσότερες εγγραφές ανά είδος δραστηριότητας");
				th.appendChild(text);
				row.appendChild(th);
				var row = thead.insertRow();
				var th = document.createElement("th");
				var text = document.createTextNode("Ημέρα");
				th.appendChild(text);
				row.appendChild(th);
				var th = document.createElement("th");
				var text = document.createTextNode("Δραστηριότητα");
				th.appendChild(text);
				row.appendChild(th);
				var th = document.createElement("th");
				var text = document.createTextNode("Αριθμός");
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
			
			function createTableHour(data){
				document.getElementById("table-container4").innerHTML = "";
				$('<table class = "table table-hover" id = "hour"></table>').appendTo($("#table-container4"));
				var table = document.getElementById("hour");
				var thead = table.createTHead();
				var row = thead.insertRow();
				var th = document.createElement("th");
				var text = document.createTextNode("ώρα της ημέρας με τις περισσότερες εγγραφές ανά είδος δραστηριότητας");
				th.appendChild(text);
				row.appendChild(th);
				var row = thead.insertRow();
				var th = document.createElement("th");
				var text = document.createTextNode("Ωρα");
				th.appendChild(text);
				row.appendChild(th);
				var th = document.createElement("th");
				var text = document.createTextNode("Δραστηριότητα");
				th.appendChild(text);
				row.appendChild(th);
				var th = document.createElement("th");
				var text = document.createTextNode("Αριθμός");
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
	<style>
		#user_exit a:link{
			text-decoration:none;
		}
	</style>
		<div class="container-fluid" >
			<hr>
			<div class="row element">
				<div class = "col-3">
					<label id = "current_label"></label>
				</div>
				<div id = "table-container" class = "col-3">
					<table class = "table table-hover" id = "past_year"></table>
				</div>
				<div class = "col-3">
					<label id = "range_label"></label>
				</div>
				<div class = "col-3">
					<label id = "uploaded"></label>
				</div>
			</div>
			<hr>
			<div class = "row element">
				<form>
						<div class = "row">
							<div class = "col-sm-6">
								<div class = "form-group">
								<label class = "control-label">Μήνας Από</label> 
								</div>
								<div class = "col-sm-6">
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
							<div class = "col-sm-6">
								<div class = "form-group">
								<label class = "control-label">Μήνας Έως</label>  
								</div>
								<div class = "col-sm-6">
								<div class = "form-group">
								<select class="form-control" id = "m_to" >
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
							
						</div>
						<div class = "row">
							<div class = "col-sm-6">
								<div class = "form-group">
								<label class = "control-label">Έτος από</label> 
								</div>
								<div class = "col-sm-5">
								<div class = "form-group">
								<input type = "text" class = "form-control" id = "y_from" />
								</div>
							</div>
							</div>
							<div class = "col-sm-6">
								<div class = "form-group">
								<label class = "control-label">Έτος Έως</label>  
								</div>
								<div class = "col-sm-5">
								<div class = "form-group">
								<input type = "text" class = "form-control" id = "y_to" />
								</div>
								<button type = "button" class = "col-lg-offset-2 btn btn-danger navbar-btn" onclick = "userSearch()">Αναζήτηση</button>
							</div>
							</div>
							
						</div>
						
					</div>
					
				</form>
			</div>
			<div class = "row element">
				<div class="row element">
					<div id = "table-container2" class = "col-4">
						<table class = "table table-hover" id = "type"></table>
					</div>
					<div id = "table-container3" class = "col-4">
						<table class = "table table-hover" id = "day"></table>
					</div>
					<div id = "table-container4" class = "col-4">
						<table class = "table table-hover" id = "hour"></table>
					</div>
				</div>
			</div>
			<div class = "row element">
				<div id="map-container">
					<div id = "map"></div>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class = "col-lg-3">
					<label>Upload Δεδομένων</label>
				</div>
				<div class = "col-lg-9">
					<form action="upload.php" method="post" enctype="multipart/form-data">
						Filename: <input type="file" name="file" id="file"><br /><br />
						<input type="submit" class = "btn btn-danger navbar-btn" name="submit" value="Ανέβασμα">
					</form>
				</div>
			</div>
			<hr>

		</div>
	</body>
</html>