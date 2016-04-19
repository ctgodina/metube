<?php
session_start();
include_once "function.php";

/******************************************************
*
* upload document from user
*
*******************************************************/

$username=$_SESSION['username'];

if(empty($_SESSION['username'])){
  Print '<script>alert("User not found");</script>'; //Prompts the user
  Print '<script>window.location.assign("index.php");</script>';
}
//Create Directory if doesn't exist
if(!file_exists('uploads/')){
	mkdir('uploads/');
	chmod('uploads', 0755);
}
$dirfile = 'uploads/'.$username.'/';
if(!file_exists($dirfile))
	mkdir($dirfile);
	chmod($dirfile, 0755);
	if($_FILES["file"]["error"] > 0 )
	{ 	$result=$_FILES["file"]["error"];} //error from 1-4
	else
	{
		$upfile = $dirfile.urlencode($_FILES["file"]["name"]);
	  
	  $duplicate_attach = 0;
	  while(file_exists($upfile))
  	// if(file_exists($upfile))
	  {
	  	//if file with same name exists then change it by adding numbers
	  	$upfile = $upfile.urlencode($duplicate_attach);
	  	$duplicate_attach++;
	  }
	  // else{
			if(is_uploaded_file($_FILES["file"]["tmp_name"]))
			{
				if(!move_uploaded_file($_FILES["file"]["tmp_name"],$upfile))
				{
					$result="6"; //Failed to move file from temporary directory
				}
				else /*Successfully upload file*/
				{
					//insert into media table
					$insert = "insert into media(mediaid, filename, title, username,type, path, category)".
							  "values(NULL,'". urlencode($_FILES["file"]["name"])."','".$_POST["title"]."','$username','".$_FILES["file"]["type"]."', '$upfile','".$_POST["category"]."')";
					$queryresult = mysql_query($insert)
						  or die("Insert into Media error in media_upload_process.php " .mysql_error());
					$result="0";
					chmod($upfile, 0644);
				}
			}
			else  
			{
					$result="7"; //upload file failed
			}
		}
	// }
	
	//You can process the error code of the $result here.
?>

<meta http-equiv="refresh" content="0;url=browse.php?result=<?php echo $result;?>">
