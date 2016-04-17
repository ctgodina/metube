<!DOCTYPE HTML>
<html>

<head>
  <title>MeTube Home</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="css/style2.css" title="style" />
  <style>
    table {
      table-layout: fixed;
    }
		 body {
			background-color: black;
		}
    td {
      max-width: 200px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
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
		    <h1>Sent Messages</h1>
       
        <!-- DISPLAY Sent message subjects -->






        <?php

        $query = "SELECT id, receiver, subject, msg from message where sender=";
        $query.= "(select id from account where username='".$_SESSION['username']."')";
        $result = mysql_query( $query );
        if (!$result){
           die ("Failed to retrieve sent messages: <br />". mysql_error());
        }
        ?>
          
        <table width="50%" cellpadding="0" cellspacing="0">
        <tr>
          <th>Receiver</th>
          <th>Subject</th>
          <th>Content</th>
        </tr>
        <?php
          while ($result_row = mysql_fetch_row($result)) 
          {
            //Grab receiver from id.
            $msgid = $result_row[0];
            $recid = $result_row[1];
            $subj = $result_row[2];
            $mesj = $result_row[3];

            $userquery = "SELECT username from account where id = '$recid'";
            $userresult = mysql_query($userquery);
            if(!$userresult){
              die("Retrieving receiver username failed: <br/>". mysql_error());
            }
            $recuname = mysql_fetch_row($userresult);
            $recuname = $recuname[0];
        ?>
        <tr valign="top">
          <td>
            <a href="message.php?to=<? echo $recuname; ?>"><?php echo $recuname; ?></a>
          </td>        
          <td>
            <a href="displaymessage.php?id=<? echo $msgid; ?>&&risme=0"><? echo $subj; ?></a>
          </td>
          <td>
            <?php echo $mesj; ?>
          </td>
        </tr>
              <?php
          }
        ?>
        </table>








      </div>
    </div>
    <div id="footer">
      Copyright &copy; Soham Parekh 2016
    </div>
  </div>
</body>
</html>
