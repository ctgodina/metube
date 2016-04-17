<?php
	session_start();
    include_once "function.php";
    if(empty($_SESSION['username'])){
      Print '<script>alert("User not found");</script>'; //Prompts the user
      Print '<script>window.location.assign("index.php");</script>';
    }
	if(isset($_POST['submit_create_playlist']))	{
		if(create_playlist($_POST['playlist_name'], $_SESSION['username']) ){
		 Print '<script>alert("User Playlist created!");</script>'; //Prompts the user
	     Print '<script>window.location.assign("playlist.php");</script>';
	    }
	    else{
		 Print '<script>alert("Could not create playlist");</script>'; //Prompts the user
	     Print '<script>window.location.assign("playlist.php");</script>';
	    }
	}
?>