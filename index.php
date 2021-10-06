<!DOCTYPE html>
<?php
session_start();
include 'menu_notauthenticated.php';

if(isset($_SESSION["usertype"]) && $_SESSION["usertype"] == 1){
		header("Location:adminMain.php");
	}
	if(isset($_SESSION["usertype"]) && $_SESSION["usertype"] == 0){
		header("Location:userMain.php");
	}


?>
<html>
	<head>
<!-- LINK GIA MODAL -->
<!-- Remember to include jQuery :) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

<!-- jQuery Modal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<!-- TELOS LINK GIA MODAL -->
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<link href = "https://use.fontawesome.com/releases/v5.8.2/css/all.css" rel="stylesheet"></link>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
		<link href = "https://use.fontawesome.com/releases/v5.8.2/css/all.css" rel="stylesheet"></link>
		<link href = "form.css" rel="stylesheet"></link>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
		
		<script>
			
			function openForm() {
  			document.getElementById("ex1").style.display = "block";
}
			function openForm2() {
  			document.getElementById("ex2").style.display = "block";
}
			function loginUser(){
				var email = $('#inputEmail').val();
				var pass = $('#inputPassword').val();
				var data = {email: email, pass: pass};
				const jsonData = JSON.stringify(data);
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function(){
					if(this.readyState == 4 && this.status == 200){
						if(this.responseText == 0){
							console.log(document.cookie);
							location.href = "userMain.php";
							alert("User Login Successful")
						}
						else if(this.responseText == 1){
							location.href = "adminMain.php";
							alert("Admin Login Successful")
						}
						else{
							alert("Λάθος όνομα χρήστη ή κωδικός πρόσβασης");
							
						}
					}
				}
				xhttp.open("POST", "login.php");
				xhttp.setRequestHeader("Content-Type", "application/json");
				console.log(jsonData);
				xhttp.send(jsonData);
			}
			</script>
			<script>
			function submitRegisterForm(){
				var email = $('#inputEmail2').val();
				var pass = $('#inputPassword2').val();
				var first = $('#inputFirst').val();
				var last = $('#inputLast').val();
				var data = {email: email, pass: pass, first: first,last: last};
				const jsonData = JSON.stringify(data);
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function(){
					if(this.readyState == 4 && this.status == 200){
						if(this.responseText == 1){
							alert("Επιτυχής εγγραφή");
							location.href = "userMain.php";
						}
					
						else{
							//alert("Υπήρξε ένα μη αναμενόμενο πρόβλημα με την εγγραφή");
							location.href = "userMain.php";
						}
					}
				}
				xhttp.open("POST", "register.php");
				xhttp.setRequestHeader("Content-Type", "application/json");
				xhttp.send(jsonData);
			}
</script>
		
<style>
body, html {
  height: 100%;
  margin: 0;
}

.bg {
  /* The image used */
  background-image: url("giphy4.gif");

  /* Full height */
  height: 100%; 

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}

	.modal {
   width: 300px;
   height: 300px;
   position: absolute;
   left: 50%;
   top: 50%; 
   margin-left: -150px;
   margin-top: -150px;
}
.container {
      max-width: 1920px;
      width: 100%;
}

</style>
		

</head>


<body class="bg"> 
 
 <!-- KWDIKAS GIA MODAL1 -->
<div id="ex1" class="modal">
<div class="container">
						<div class="card-body" >
							<h5 class="card-title text-center">Είσοδος</h5>
							<form class="form-signin" onsubmit="loginUser(); return false;">
								<div class="form-label-group">
									<input type="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus>
									<label for="inputEmail">Email</label>
								</div>
								<div class="form-label-group">
									<input type="password" id="inputPassword" class="form-control" placeholder="Κωδικός Πρόσβασης" required>
									<label for="inputPassword">Κωδικός Πρόσβασης</label>
								</div>
								
								<button class="btn btn-lg btn-primary btn-block text-uppercase" type="sumbit" >Εισοδος</button>
							</form>
						</div>
					</div>
				</div>
<div id="ex2" class="modal">	
<div class="container">
			
						<div class="card-body">
							<h5 class="card-title text-center">Εγγραφή Χρήστη</h5>
							<form id = "reg_form" class="form-signin"  onsubmit="submitRegisterForm(); return false;">
								<div class="form-label-group">
									<input type="email" id="inputEmail2" class="form-control" placeholder="Email" required autofocus>
									<label for="inputEmail2">Email</label>
								</div>
								<div class="form-label-group">
									<input type="password" id="inputPassword2" pattern="(?=^.{8,}$)(?=.*[0-9])(?=.*[A-Z])(?=.*[^A-Za-z0-9]).*" class="form-control" placeholder="Κωδικός Πρόσβασης" required>
									<label for="inputPassword2">Κωδικός Πρόσβασης</label>
								</div>
								<div class="form-label-group">
									<input type="text" id="inputFirst" class="form-control" placeholder="Όνομα" required>
									<label for="inputFirst">Όνομα</label>
								</div>
								<div class="form-label-group">
									<input type="text" id="inputLast" class="form-control" placeholder="Επώνυμο" required>
									<label for="inputLast">Επώνυμο</label>
								</div>
								<button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Εγγραφη</button>
							</form>
						</div>
					</div>	
				</div>	
				
	</body>
</html>

