<?php
	include_once "function.php";
	if(!empty($_GET['mediaid']))
	{
	 entered_rating($_GET['mediaid'], $_POST['rating']);	 
	}
	Print '<script>alert("Rating Entered!");</script>'; //Prompts the user
    Print '<script>window.location.assign("browse.php");</script>';
?>