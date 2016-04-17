<!DOCTYPE HTML>
<html>

<head>
  <title>MeTube Playlist</title>
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
          <li class="selected"><a href="playlist.php">Playlists</a></li>
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
      </div>
      <div id="content">
    <br>
    <form action="create_playlist.php" method="post" ><input type="text" name="playlist_name" placeholder="Enter Playlist Name" required><input value="Create Playlist" name="submit_create_playlist" type="submit" /></form>
            <!-- insert the page content here -->

    <?php
      $i = 0;
      $query = "Select * from playlist where username = '".$_SESSION['username']."';";
      $result = mysql_query($query) or die("Could not access friends table".mysql_error());
      while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
        $playlistid[] = $row[0];
        $playlistname[] = $row[1];
        $i++;
      }
    ?>

    <h1>Your Playlists</h1>

      <?php
      $x=0;

      while($x<count($playlistid) )
      {
            echo "</br>";
            echo "<h3 style='color:orange;'>".$playlistname[$x]."</h3></br>";
            echo "</br>";
            $query = "SELECT mediaid  FROM playlist_media WHERE playlistid = '".$playlistid[$x]."' ;";
            $result = mysql_query($query) or die("Could not access playlist_media table".mysql_error());
            while($row = mysql_fetch_array($result))
            {
              $media_array[]=$row[0];
              //echo $row[0]."<br>";
            }
            
            echo "<div STYLE='height: 500px; width: 400px; font-size: 12px; overflow: auto;'>";
            echo "<ul>";
            if(!empty($media_array))
            {
                $i=0;
                while($i<count($media_array))
                {
                  echo $media_array[$i];
                  $query = "SELECT title, username, type, mediaid, path  FROM media WHERE mediaid = '".$media_array[$i]."' ;";
                  $result = mysql_query($query) or die("Could not access media table".mysql_error());
                  while($row = mysql_fetch_array($result, MYSQL_NUM))
                  {
                    $title = $row[0];
                    $username = $row[1];
                    $type = $row[2];
                    $mediaid = $row[3];
                    $path = $row[4];

                    echo "  <li>";
                    echo "    <video width='320' height='240' controls>";
                    echo "      <source src=".$path." type =".$type." >";            
                    echo "    </video>";
                    echo "  </li>";
                    echo $title;
                  }
                  $i++;
                }
            }
            echo "</ul>";
            echo "</div>";
            $x++;
        }
      ?>

   
      </div>
    </div>
    <div id="footer">
      Copyright &copy; Soham Parekh 2016
    </div>
  </div>
</body>
</html>
