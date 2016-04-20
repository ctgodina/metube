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
      <?php 
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['postbutton'])) {
          add_post($_SESSION['username'], $_GET['topicid'], $_POST['postcontent']);
          header("Location:viewtopic.php?".$_SERVER['QUERY_STRING']);
        }
      } 
      ?>
      <div id="content">
      <?php $topicid = $_GET['topicid']; ?>
  		<h1>Posts for topicid: <?php echo $topicid; ?></h1>
      <!-- List the topics -->
      <table>
        <tr>
          <th>Name</th>
          <th>Post</th>
        </tr>
        <?php 
          $query = "select * from posts where topicid=$topicid";
          $result = mysql_query($query);
          if(!$result) die("failed to grab posts".mysql_error());
          while($row = mysql_fetch_array($result)){
            $content=$row[2];
            $userid = $row[1];
            $uquery = "select username from account where id=$userid";
            $uresult = mysql_query($uquery);
            if(!$uresult) die("user grab for post".mysql_error());
            $urow = mysql_fetch_array($uresult);
            $username = $urow[0];
        ?>
            <tr><td><?php echo $username; ?></td><td><?php echo $content; ?></td></tr>

        <?php
          }
        ?>
        </tr>
      </table>   
      <!--Invite user to this group-->
      <form method="post" action="viewtopic.php?topicid=<?php echo $topicid; ?>">
        Post something:<input type="text" name="postcontent"></input>
        <input value="Post It" name="postbutton" type="submit"/>
      </form>   
      </div>
    </div>
    <div id="footer">
    Copyright &copy; Soham Parekh 2016
    </div>
  </div>
</body>
</html>
