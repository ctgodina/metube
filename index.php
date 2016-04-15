<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Login </title>
    
    
    <link rel="stylesheet" href="css/reset.css">

    
        <link rel="stylesheet" href="css/style.css">
		<style>
		 body {
			background-color: black;
		}
		
		</style>

    
    
    
  </head>

  <body>

    <div class="wrap" >
	<form method="post" action="index.php">

	<img src="images/metube_logo.png">

		<input name="username" type="text" placeholder="username" required>
		<div class="bar">
			<i></i>
		</div>
		<input name="password" type="password" placeholder="password" required>
		<p>.</p>
		<button type = "submit">Login</button> 
		<p>.</p>
	</form>
		<form method="post" action="register.php">

		<button type = "submit">Register Here</button>
		</form>
	</div>



    
     <script src="js/index.js"></script>

    
    
    
  </body>
</html>
<?php
session_start();
require "init.php";	
include_once "function.php";




if($_SERVER["REQUEST_METHOD"] == "POST"){

	$check = user_pass_check($_POST['username'],$_POST['password']); // Call functions from function.php
	if($check == 0) {
		Print '<script>alert("User not found");</script>'; //Prompts the user
		Print '<script>window.location.assign("index.php");</script>';
	}
	elseif($check==2) {
		Print '<script>alert("Incorrect Password");</script>'; //Prompts the user
		Print '<script>window.location.assign("index.php");</script>';
	}
	else if($check==1){
		$_SESSION['username']=$_POST['username']; //Set the $_SESSION['username']
		header('Location: home.php');
	}		
}

?>
