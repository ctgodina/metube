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
          <!-- put class="selected" in the li tag for the selected page - to highlight which page you're on -->
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
        
      </div>
      <div id="content">
		    <h1>My Groups</h1>

        <table>
          <tr>
            <th>Name</th>
            <th colspan="2" style="text-align:center">Actions</th>
          </tr>
        <?php
          $me = $_SESSION['username'];
          $query = "select groupid from group_user where userid=(select id from account where username='$me')";
          $result = mysql_query($query);
          if(!$result) die("failed to grab groups where i belong".mysql_error());
          while($result_row = mysql_fetch_array($result)){
            $groupid = $result_row[0];
            $gquery = "select name from groups where id=$groupid";
            $gresult = mysql_query($gquery);
            $group_row = mysql_fetch_array($gresult);
            $groupname = $group_row[0];
        ?>

          <tr>
            <td><a href="viewgroup.php?groupid=<?php echo $groupid; ?>"><?php echo $groupname; ?></a></td>
            <td>
              <form method="post" action="request.php?groupid=<?php echo $groupid; ?>">
                Topic to add:<input type="text" name="topictogroup"></input>
                <input value="Add Topic" name="addtopicgroupbutton" type="submit"></input>
                User to invite:<input type="text" name="usertogroup"></input>
                <input value="Invite User" name="addusergroupbutton" type="submit"/>
                <input value="Leave group" name="rmgroupbutton" type="submit"/>
              </form>
            </td>
          </tr>

        <?php
          }
        ?>

        </table>

        <br/><a href="creategroup.php">create group</a>
      </div>
    </div>

    <div id="footer">
      Copyright &copy; Soham Parekh 2016
    </div>
  </div>
</body>
</html>
