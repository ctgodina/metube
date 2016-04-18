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
          <li><div class="right"><form action="search.php" method="get" ><input type="text" name="search_query" placeholder="search" required><input value="Search" name="submit_search" type="submit" /></form></div></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
    <div id="site_content">
      <div class="sidebar">
        <!-- insert your sidebar items here -->

        <h3>Suggestions</h3>
        <ul>
          <li>coming soon</li>

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
		<h1>Featured Video</h1>

		<video width="320" height="240" controls>
			<source src=<?php echo"'videos/leogoal.mp4'" ?> type="video/mp4">
			<source src="movie.ogg" type="video/ogg">
			Your browser does not support the video tag.
		</video>
    <?php
      $i = 0;
      $bool = false;
      $query = "Select fname2 from friends where fname1 = '".$_SESSION['username']."';";
      $result = mysql_query($query) or die("Could not access friends table".mysql_error());
      while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
        $friendsname[] = $row[0];
        $i++;
        $bool = true;
      }
    ?>

    <h1>New Content feed</h1>
    <ul>
    <?php
      if($bool){
    ?>
      <!-- put class="selected" in the li tag for the selected page - to highlight which page you're on -->
      <?php

        echo "<div STYLE='height: 500px; width: 400px; font-size: 12px; overflow: auto;'>";
          $i=0;
        while($i<count($friendsname))
        {
          /*What if friends do not have any media? */
          $query = "SELECT title, username, type, mediaid, path  FROM media WHERE username = '".$friendsname[$i]."' ORDER BY mediaid DESC LIMIT 1;";
          $result = mysql_query($query) or die("Could not access media table".mysql_error());
          while($row = mysql_fetch_array($result, MYSQL_NUM)){
            $title = $row[0];
            $username = $row[1];
            $type = $row[2];
            $mediaid = $row[3];
            $path = $row[4];
          }
          echo "  <li>";
          echo "    <video width='320' height='240' controls>";
          echo "      <source src=".$path." type =".$type." >";            
          echo "    </video>";
          echo "  </li>";
          echo $title." by ".$friendsname[$i];
          $i++;
        }
        echo "</div>";
      ?>
    <?php
      }      
    ?>
    </ul>
   
      </div>
    </div>
    <div id="footer">
      Copyright &copy; Soham Parekh 2016
    </div>
  </div>
</body>
</html>
