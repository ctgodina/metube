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
  		<h1>Change Passwords</h1>
      <form method="post" action="request.php?<? echo $_SESSION['uid'];?>">
        Old Password: <input type="password" name = "opwd" required></input><br/>
        New Password:<input type="password" name = "npwd1" required></input><br/>
        Confirm password:<input type="password" name = "npwd2" required></input><br/>
        <input value="Change" name="chpwdbutton" type="submit"/>
      </form>
      </div>
    </div>
    <div id="footer">
    Copyright &copy; Soham Parekh 2016
    </div>
  </div>
</body>
</html>
