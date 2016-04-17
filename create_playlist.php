<?php
	if(isset($_POST['submit_create_playlist']))
	{
		Print '<script>alert("User Playlist created!");</script>'; //Prompts the user
      	Print '<script>window.location.assign("playlist.php");</script>';
	}
?>