<?php
include "mysqlClass.inc.php";


function user_exist_check ($username, $password){
	$username = test_input($username);
	$password = test_input($password);


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

function substring_before($mainstr, $teststr){
	$p = strpos($mainstr, $teststr);
	($p === false ? $out = $mainstr : $out = (substr($mainstr, 0, $p+strlen($teststr))));
	return $out;
}

function is_image($type){
	$type = substring_before($type, "/");
	return (strcmp($type, "image/")==0);
}

function grab_categories(){
	$query = "select distinct category from media";
	$result = mysql_query($query);
	if(!$result) die("failed to grab categories".mysql_error());
	return $result;
}


function filter_category($category){
	$query = "select * from media where category='$category'";
	$result = mysql_query($query);
	if(!$result) die("failed to grab categories".mysql_error());
	return $result;
}


function insert_contact ($owner, $contact){
	$owner = test_input($owner);
	$contact = test_input($contact);
	$query = "insert ignore into contacts (user1, user2) values";
	$query.= "('".$owner."','".$contact."')";
	$result = mysql_query($query);

	if(!$result){
		die("insert_contact failed.<br />". mysql_error());
	}
	else return $result;
}

function remove_from_group($username, $groupid){
	$query = "delete from group_user where groupid=$groupid and userid=";
	$query.= "(select id from account where username='$username');";
	$result = mysql_query($query);
	if(!$result) die("failed to remove from group".mysql_error());
	return 1;
}

//as of now just adds user later can make it so goes to a request list
//then accept the request calls this
function add_user_to_group($username, $groupid){
	$query = "insert into group_user (groupid, userid) values (";
	$query.= "$groupid,";
	$query.= "(select id from account where username='$username'))";
	$result = mysql_query($query);
	if(!$result) die("adding user to group failed: ".mysql_error());
	return 1;
}

function add_topic_to_group($topic, $groupid){
	//first add topic to topics
	$query = "insert into topics (name) values('$topic')";
	$result = mysql_query($query);
	if(!$result) die("adding topic to topics failed".mysql_error());

	$tquery = "insert into group_topic (groupid, topicid) values (";
	$tquery.= "$groupid, (select id from topics where name='$topic'))";
	$tresult = mysql_query($tquery);
	if(!$tresult) die ("adding topic to group failed.".mysql_error());
}


function remove_contact($user1, $user2){
	//friends has a unique index so no duplicate entries allowed
	//ufindex
	$user1 = test_input($user1);
	$user2 = test_input($user2);

	$fquery = "delete from contacts where user1='".$user1."' and user2='".$user2."';";
	$fresult = mysql_query($fquery);
	if(!$fresult){
		die("remove_friend failed.<br />". mysql_error());
	}
	else {
		return 1;
	}
}

function change_password($username, $oldpass, $password1, $password2){
	$username = test_input($username);
	$oldpass = test_input($oldpass);
	$password1 = test_input($password1);
	$password2 = test_input($password2);

	//Check if both passwords dont match
	if(strcmp($password1, $password2)){
		return -2;
	}

	//Check if old password is right 
	$query = "select password from account where username='$username'";
	$result = mysql_query($query);
	if(!$result) die("error changing pass.".mysql_error());
	$row = mysql_fetch_array($result);

	if(strcmp($row[0], $oldpass)){//not zero is wrong
		return -1;
	}
	else { //0 so correct
		$query = "update account set password='$password1' where username='$username'";
		$result = mysql_query($query);
		if(!$result) die("error changing pass.".mysql_error());
	}
}

function fetch_message($msgid){
	$msgid = test_input($msgid);

	$query = "select * from message where id=$msgid";
	$result = mysql_query($query);

	if(!$result){
		die("fetch_message failed.<br />". mysql_error());
	}
	else return $result;
}

function delete_spam($user){
	//first grab entries where user is doing the block
	$query = "select * from blocked where uname1='".$user."'";
	$result = mysql_query($query);
	if(!$result){
		die("delete_spam failed.<br />". mysql_error());
	}

	while($result_row = mysql_fetch_array($result)){
		$blockeduser = $result_row[2];
		$delquery = "delete from message where sender=";
		$delquery.= "(select id from account where username='$blockeduser')";
		$delquery.= "and receiver=(select id from account where username='$user');";
		$delresult = mysql_query($delquery);
		if(!$delresult) die("stage 1 spam delete failed. <br/>".mysql_error());
	}

	//last check entries where user is blocked
	$query = "select * from blocked where uname2='".$user."'";
	$result = mysql_query($query);
	if(!$result){
		die("delete_spam failed.<br />". mysql_error());
	}

	while($result_row = mysql_fetch_array($result)){
		$blockedby = $result_row[1];
		$delquery = "delete from message where sender=";
		$delquery.= "(select id from account where username='$user')";
		$delquery.= "and receiver=(select id from account where username='$blockedby');";
		$delresult = mysql_query($delquery);
		if(!$delresult) die("stage 2 spam delete failed. <br/>".mysql_error());
	}
}

function insert_comment($mediaid, $username, $comment){
	$mediaid = test_input($mediaid);
	$username = test_input($username);
	$comment = test_input($comment);


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

function insert_message($sender, $receiver, $subject, $msg){
	$sender = test_input($sender);
	$receiver = test_input($receiver);
	$subject = test_input($subject);
	$msg = test_input($msg);


	$query = "insert into message (sender, receiver, subject, msg) values (";
	$query.= "(select id from account where username='$sender'),";
	$query.= "(select id from account where username='$receiver'),";
	$query.= "'$subject',";
	$query.= "'$msg')";

	$result = mysql_query($query);

	if(!$result){
		die("insert_message failed.<br />". mysql_error());
	}
	else return 1;
}

function add_friend($fname1, $fname2){
	//friends has a unique index so no duplicate entries allowed
	//ufindex
	$fname1 = test_input($fname1);
	$fname2 = test_input($fname2);

	$fquery = "insert ignore into friends (fname1, fname2) values ('".$fname1."','".$fname2."');";
	$fresult = mysql_query($fquery);
	if(!$fresult){
		die("add_friend failed.<br />". mysql_error());
	}
	else {
		return 1;
	}
}

function remove_friend($fname1, $fname2){
	//friends has a unique index so no duplicate entries allowed
	//ufindex
	$fname1 = test_input($fname1);
	$fname2 = test_input($fname2);

	$fquery = "delete from friends where fname1='".$fname1."' and fname2='".$fname2."';";
	$fresult = mysql_query($fquery);
	if(!$fresult){
		die("remove_friend failed.<br />". mysql_error());
	}
	else {
		return 1;
	}
}


function add_to_playlist($playlistid, $mediaid){
	$fquery = "insert into playlist_media (playlistid, mediaid) values ('".$playlistid."','".$mediaid."');";
	$fresult = mysql_query($fquery);
	if(!$fresult){
		die("add failed.<br/>". mysql_error());
	}
	else {
		return 1;
	}
}

function block_user($user1, $user2){
	$query = "insert ignore into blocked (uname1, uname2) values ('".$user1."','".$user2."');";
	$result = mysql_query($query);
	if(!$result){
		die("block_user failed.<br/>". mysql_error());
	}
	else {
		return 1;
	}
}

function unblock_user($user1, $user2){
	$query = "delete from blocked where uname1='".$user1."' and uname2='".$user2."';";
	$result = mysql_query($query);
	if(!$result){
		die("unblock_user failed.<br/>". mysql_error());
	}
	else {
		return 1;
	}
}

function create_playlist($playlistname, $username){
	$fquery = "insert into playlist (name, username) values ('".$playlistname."','".$username."');";
	$fresult = mysql_query($fquery);
	if(!$fresult){
		die("add failed.<br/>". mysql_error());
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
	$uid = test_input($uid);
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
	$username = test_input($username);
	$password = test_input($password);

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


function make_group($user, $name){
	//add new group
	$query = "insert into groups (name) values ('$name')";
	$result = mysql_query($query);
	if(!$result) die("making group failed".mysql_error());

	//make sure creator is part of the group users
	$gquery = "insert into group_user (groupid, userid) values( ";
	$gquery.= "(select id from groups where name='$name'), ";
	$gquery.= "(select id from account where username='$user') )";
	$gresult = mysql_query($gquery);
	if(!$gquery) die ("make_group failed".mysql_error());
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
