<?php
include "mysqlClass.inc.php";


function user_exist_check ($username, $password){
	$query = "select * from account where username='$username'";
	$result = mysql_query( $query );
	if (!$result){
		die ("user_exist_check() failed. Could not query the database: <br />". mysql_error());
	}	
	else {
		$row = mysql_fetch_assoc($result);
		if($row == 0){
			$query = "insert into account (username, password) values ('$username','$password')";
			echo "insert query:" . $query;
			$insert = mysql_query( $query );
			if($insert)
				return 1;
			else
				die ("Could not insert into the database: <br />". mysql_error());		
		}
		else{
			return 2;
		}
	}
}

function insert_comment($mediaid, $username, $comment){
	$query = "insert into comments (content, media_id, user_id) values (";
	$query.= "'$comment',";
	$query.= "(select mediaid from media where mediaid=$mediaid),";
	$query.= "(select id from account where username='$username'))";
	$result = mysql_query($query);
	if(!$result){
		die("insert_comment failed.<br />". mysql_error());
	}
	else {
		return 1;
	}
}

// function comment_by_media($mediaid){
// 	$query = "select content from comments where media_id=$mediaid";
// 	$result = mysql_query($query);
// 	if(!$result){
// 		die("comment_by_media failed.<br />". mysql_error());
// 	}
// 	else {
// 		$row = mysql_fetch_row($result);
// 		return $row[0];
// 	}
// }

function user_by_id($uid){
	$query = "select username from account where id=$uid";
	$result = mysql_query($query);
	if(!$result){
		die("user_by_id failed.<br />". mysql_error());
	}
	else {
		$row = mysql_fetch_row($result);
		return $row[0];
	}
}

#security function that strips the special characters from data
#as a counter to CSS attacks etc
function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function user_pass_check($username, $password)
{
	
	$query = "select * from account where username='$username'";
	
	$result = mysql_query( $query );
		
	if (!$result)
	{
	   die ("user_pass_check() failed. Could not query the database: <br />". mysql_error());
	}
	else{
		if(mysql_num_rows($result) == 0)
			return 0; //empty results so say no username "_" not found in the database
		$row = mysql_fetch_row($result);
		if(strcmp($row[2],$password))
			return 2; //wrong password
		else 
			return 1; //Checked.
	}	
}

function updateMediaTime($mediaid)
{
	$query = "	update  media set lastaccesstime=NOW()
   						WHERE '$mediaid' = mediaid
					";
					 // Run the query created above on the database through the connection
    $result = mysql_query( $query );
	if (!$result)
	{
	   die ("updateMediaTime() failed. Could not query the database: <br />". mysql_error());
	}
}

function upload_error($result)
{
	//view erorr description in http://us2.php.net/manual/en/features.file-upload.errors.php
	switch ($result){
	case 1:
		return "UPLOAD_ERR_INI_SIZE";
	case 2:
		return "UPLOAD_ERR_FORM_SIZE";
	case 3:
		return "UPLOAD_ERR_PARTIAL";
	case 4:
		return "UPLOAD_ERR_NO_FILE";
	case 5:
		return "File has already been uploaded";
	case 6:
		return  "Failed to move file from temporary directory";
	case 7:
		return  "Upload file failed";
	}
}

function other()
{
	//You can write your own functions here.
}
	
?>
