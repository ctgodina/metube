<?php
	session_start();
    include_once "function.php";
    if(empty($_SESSION['username'])){
      Print '<script>alert("User not found");</script>'; //Prompts the user
      Print '<script>window.location.assign("index.php");</script>';
    }
	if(isset($_POST['submit_add_to_playlist']))	{
		if(add_to_playlist($_POST['playlistid'], $_GET['mediaid']) ){
		 Print '<script>alert("Added to playlist!");</script>'; //Prompts the user
	     Print '<script>window.location.assign("playlist.php");</script>';
	    }
	    else{
		 Print '<script>alert("Could not add to playlist");</script>'; //Prompts the user
	     Print '<script>window.location.assign("playlist.php");</script>';
	    }
	}
?>