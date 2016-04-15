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

        </ul>
      </div>
    </div>
    <div id="site_content">
      <div class="sidebar">
        <!-- insert your sidebar items here -->

        <h3>Comments</h3>
        <ul>
          <li>coming soon</li>


        </ul>
        <form method="post" action="">
          <input type="text" placeholder="username" required>
        </form>
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
		<h1>Now Watching <?php if(!empty($_GET['id'])) echo $_GET['id'] ?></h1>
      <video width="320" height="240" controls>
        <source src=<?php echo $_GET['path'] ?> type=<?php echo $_GET['type'] ?> >
        <source src="movie.ogg" type="video/ogg">
        Your browser does not support the video tag.
      </video>
   

    <div id="upload result">
    <?php 
      if(isset($_REQUEST['result']) && $_REQUEST['result']!=0)
      {   
        echo upload_error($_REQUEST['result']);
      }
    ?>
    </div>
    <br/><br/>
    <?php

      $query = "SELECT * from media where username = '".$_SESSION["username"]."';"; 
      $result = mysql_query( $query );
      if (!$result){
         die ("Could not query the media table in the database: <br />". mysql_error());
      }
    ?>
        
    <h2>Your Videos</h2>
    <table width="50%" cellpadding="0" cellspacing="0">
      <?php
        while ($result_row = mysql_fetch_row($result)) //filename, username, type, mediaid, path
        { 
          $mediaid = $result_row[4];
          $filename = $result_row[0];
          $filenpath = $result_row[5];
          $title = $result_row[1];
          $type = $result_row[3];
      ?>
             <tr valign="top">      
        
        <td>
          <a href="browse.php?id=<?php echo $title;?>&&path=<?php echo $filenpath;?>&&type=<?php echo $type;?>"><?php echo $title;  ?></a> 
        </td>
        <td>
         <!-- <a href="<?php echo $filenpath;?>" target="_blank" onclick="javascript:saveDownload(<?php echo $result_row[5];?>);">Download</a>-->
         <a href ="<?php echo $filenpath ?>" download>Download</a>
        </td>
      </tr>
            <?php
        }
      ?>
    </table>
    </div>


      </div>
    </div>
    <div id="footer">
      Copyright &copy; Soham Parekh 2016
    </div>
  </div>
</body>
</html>
