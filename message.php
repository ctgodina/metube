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
    textarea.top{
      width:100%;
    }
    textarea.body{
      width:100%;
      height:100px;
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
    if(!empty($_POST['submit'])){
      if(insert_message($_SESSION['username'], $_POST['receiver'], $_POST['subject'], $_POST['msg'])){
        Print '<script>alert("Sent message to: '.$_POST['receiver'].'");</script>'; //Prompts the user
        Print '<script>window.location.assign("message.php");</script>';
      }
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
          <li><div class="right"><form action="search.php" method="get"><input type="text" name="search_query" placeholder="search" required><input value="Search" name="submit_search" type="submit" /></form></div></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
    <div id="site_content">
      <div class="sidebar">
        <!-- insert your sidebar items here -->
        <h3>Mail</h3>
        <ul>
          <li><a href="inbox.php">Inbox</a></li>
          <li><a href="sentbox.php">Sent</a></li>
          <li><a href="message.php">Compose</a><li>
        </ul>
        <!--<h3>Search</h3>
        <form method="post" action="#" id="search_form">
          <p>
            <input class="search" type="text" name="search_field" value="Enter keywords....." />
            <input name="search" type="image" style="border: 0; margin: 0 0 -9px 5px;" src="style/search.png" alt="Search" title="Search" />
          </p>
        </form>-->
      </div>
      <div id="content">
        <!-- insert the page content here -->
        <?php $to=""; if(!empty($_GET['to'])) $to = $_GET['to']; ?>
		    <h1>Create Message</h1>
        <textarea class="top" name="receiver" form="sendmsg" placeholder="TO"><? echo $to; ?></textarea>
        <br></br>
        <textarea class="top" name="subject" form="sendmsg" placeholder="SUBJECT"></textarea>
        <br></br>
        <textarea class="body" name="msg" form="sendmsg" placeholder="ENTER MESSAGE"></textarea>
        <form method="post" action="message.php" 
        id="sendmsg">
          <input name="submit" type="submit">
        </form>
      </div>
    </div>
    <div id="footer">
      Copyright &copy; Soham Parekh 2016
    </div>
  </div>
</body>
</html>
