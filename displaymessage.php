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
    a.button {
      font-size:large;
      background-color: orange;
      -webkit-appearance: button;
      -moz-appearance: button;
      appearance: button;

      text-decoration: none;
      color: initial;
    }
    p{
      font-size:medium;
      word-wrap: break-word;
    }
  </style>
</head>

<body>
  <?php 
    include_once "function.php";
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
      <?php
        $result = fetch_message($_GET['id']);
        $result_row = mysql_fetch_row($result);
        $sendid = $result_row[1];
        $recid = $result_row[2];
        $subject = $result_row[3];
        $message = $result_row[4];
      ?>
    		<h1>Displaying: <? echo $subject; ?></h1><br/><br/>
        <p><? echo $message; ?></p><br/><br/>
        <?php 
        if($_GET['risme']==1) 
          $id = $sendid;
        else $id = $recid;
        $query = "select username from account where id=$id";
        $result = mysql_query($query);
        if(!$result){
          die("displaymessage failed getting uname:".mysql_error());
        }
        $result_row = mysql_fetch_array($result);
        $username = $result_row[0];
        ?>
        <a href="message.php?to=<? $username ?>" class="button">Reply<a/>
      </div>
    </div>
    <div id="footer">
      Copyright &copy; Soham Parekh 2016
    </div>
  </div>
</body>
</html>
