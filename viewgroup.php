<!DOCTYPE HTML>
<html>

<head>
  <title>MeTube Home</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="css/style2.css" title="style" />
  <style>
		 body {
			background-color: black;
		}
  </style>
</head>

<body>
  <?php 
    session_start();
    include_once "function.php";
    if(empty($_SESSION['username'])){
      Print '<script>alert("User not found");</script>'; //Prompts the user
      Print '<script>window.location.assign("index.php");</script>';
    }
  ?>
  <div id="main">
    <div id="header">
      <div id="logo">
        <div id="logo_text">
    			<div class="right">				
    				<img src="images/metube_logo.png" alt="Clemson" style="width:191px;height:60px;">
             <h2> Welcome
              <?php
                echo $_SESSION['username'];
              ?>
              <br/>
              <a style="color:white;" href="editprofile.php">edit profile</a>
            </h2>
    			</div>
        </div>
      </div>

      <div id="menubar">
        <ul id="menu">
          <li class="selected"><a href="home.php">Home</a></li>
          <li><a href="browse.php">Browse</a></li>
          <li><a href="upload.php">Upload</a></li>
          <li><a href="message.php">Messages</a></li>
          <li><a href="playlist.php">Playlists</a></li>
          <li><a href="groups.php">Groups</a></li>
          <li><div class="right"><form action="search.php" method="get"><input type="text" name="search_query" placeholder="search" required><input value="Search" name="submit_search" type="submit" /></form></div></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
    <div id="site_content">
      <div class="sidebar">
        <h3>Suggestions</h3>
        <ul>
          <li>coming soon</li>
        </ul>
      </div>
      <div id="content">
  		<h1>Topics</h1>
      <!-- List the topics -->
      <?php $groupid = $_GET['groupid']; ?>
      <table>
        <tr><th>Name</th></tr>
        <?php 
          $query = "select topicid from group_topic where groupid=$groupid";
          $result = mysql_query($query);
          if(!$result) die("failed to grab topics".mysql_error());
          while($row = mysql_fetch_array($result)){
            $topicid=$row[0];
            $tquery = "select name from topics where id=$topicid";
            $tresult = mysql_query($tquery);
            if(!$tresult) die ("failed to display topic".mysql_error());
            $trow = mysql_fetch_array($tresult);
            $topicname = $trow[0];
        ?>
            <tr><td><a href="viewtopic.php?topicid=<?php echo $topicid; ?>">
              <?php echo $topicname; ?></a></td></tr>

        <?php
          }
        ?>
      </table>   
      <h1>Users</h1>
      <table>
        <tr><th>Name</th></tr>
        <?php 
          $uquery = "select userid from group_user where groupid=$groupid";
          $uresult = mysql_query($uquery);
          if(!$result) die("failed to grab topics".mysql_error());
          while($urow = mysql_fetch_array($uresult)){
            $userid=$urow[0];
            $utquery = "select username from account where id=$userid";
            $utresult = mysql_query($utquery);
            if(!$utresult) die ("failed to ".$utquery.$userid.mysql_error());
            $utrow = mysql_fetch_array($utresult);
            $username = $utrow[0];
        ?>
            <tr><td><?php echo $username; ?></td></tr>

        <?php
          }
        ?>
      </table>  
      <!--Invite user to this group-->
      <form method="post" action="request.php?groupid=<?php echo $groupid; ?>">
        User to invite:<input type="text" name="usertogroup"></input><br/>
        Topic to add:<input type="text" name="topictogroup"></input><br/>
        <input value="Add Topic" name="addtopicgroupbutton" type="submit"></input>
        <input value="Invite User" name="addusergroupbutton" type="submit"/>
        <input value="Leave group" name="rmgroupbutton" type="submit"/>
      </form>   
      </div>
    </div>
    <div id="footer">
    Copyright &copy; Soham Parekh 2016
    </div>
  </div>
</body>
</html>
