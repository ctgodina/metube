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
    .rating {
    float:left;
    width:300px;
    }
    .rating span { float:right; position:relative; }
    .rating span input {
        position:absolute;
        top:0px;
        left:0px;
        opacity:0;
    }
    .rating span label {
        display:inline-block;
        width:30px;
        height:30px;
        text-align:center;
        color:#FFF;
        background:#ccc;
        font-size:30px;
        margin-right:2px;
        line-height:30px;
        border-radius:50%;
        -webkit-border-radius:50%;
    }
    .rating span:hover ~ span label,
    .rating span:hover label,
    .rating span.checked label,
    .rating span.checked ~ span label {
        background:#F90;
        color:#FFF;
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
        <!-- insert your sidebar items here -->

        <h3>Comments</h3>
        <ul>
          <li>
            <?php
            if(isset($_POST['submit']) && !empty($_GET['title'])){
              //if video selected and comment submitted
              insert_comment($_GET['id'], $_SESSION['username'], $_POST['comment']);
              header("Location:browse.php?".$_SERVER['QUERY_STRING']);
            }
            if(!empty($_GET['id'])){
              //display comments from the database
              $query = "select * from comments where media_id =".$_GET['id'].";";
              $result = mysql_query($query);
              if(!$result){
                die("Comment query failed <br />". mysql_error());
              }
              while($result_row = mysql_fetch_row($result)){
                $username= user_by_id($result_row[3]);
                
                echo "<pre>".$username.": ".$result_row[1]."</pre>";                
              }
            }
            ?>
          </li>
        </ul>

        <?php
        if(!empty($_GET['title'])){
        ?>
        <form method="post" action=
          <?php echo "browse.php?".
          "id=".$_GET['id']."&&".
          "title=".$_GET['title']."&&".
          "path=".$_GET['path']."&&".
          "type=".$_GET['type'];
          ?> 
        id="comsection">
          <input placeholder="Post Comment" name="submit" type="submit">
        </form>
        <textarea name="comment" form="comsection" placeholder="Enter Comment"></textarea>
        <?php
        }
        ?>
      </div>
      <div id="content">
        <!-- insert the page content here -->
		  <h1>Now Watching <?php if(!empty($_GET['title'])) echo $_GET['title'] ?></h1>
      <video width="320" height="240" controls
        <source src=<?php echo $_GET['path'] ?> type=<?php echo $_GET['type'] ?>>>
        Your browser does not support the video tag.
      </video>
      <?php
        



         /*echo "<form action=>"
         echo "<div class='rating'>";
         echo "  <span><input type='radio' name='rating' id='str5' value='5'><label for='str5'></label></span>";
         echo "  <span><input type='radio' name='rating' id='str4' value='4'><label for='str4'></label></span>";
         echo "  <span><input type='radio' name='rating' id='str3' value='3'><label for='str3'></label></span>";
         echo "  <span><input type='radio' name='rating' id='str2' value='2'><label for='str2'></label></span>";
         echo "  <span><input type='radio' name='rating' id='str1' value='1'><label for='str1'></label></span>";
         echo "</div>";*/
      ?>



      <?php  

        if(!empty($_GET['title']) )
        {
          echo "<form method='post' action= 'add_to_playlist.php?&&mediaid=".$_GET['id']."'> ";
          $query = "select * from playlist where username = '".$_SESSION['username']."';";
          $result = mysql_query($query) or die ("Could not access playlist table".mysql_error());
          $i=0;
          echo "<select name='playlistid'>";
          while($row = mysql_fetch_array($result) )
          {
             //echo $row[1]."<br>";
            echo "<option value='".$row[0]."'>".$row[1]."</option>";
          }
          echo  "</select>";
          echo "<input value='Add to playlist' name='submit_add_to_playlist' type='submit'>";
          echo "</form>";
        }
      ?> 

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
          <a href="browse.php?id=<?php echo $mediaid; ?>&&title=<?php echo $title;?>&&path=<?php echo $filenpath;?>&&type=<?php echo $type;?>"><?php echo $title;
          ?></a> 
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

    <h2>My Friends</h2>
    <table width="50%" cellpadding="0" cellspacing="0">
    <tr>
      <th>Username</th>
      <th colspan="2" style="text-align:center">Actions</th>
    </tr>
    <?php
    $query = "SELECT * from friends where fname1='".$_SESSION['username']."'";
    $result = mysql_query($query);

    while($result_row = mysql_fetch_array($result)){
      $friend = $result_row[1];
      ?>

    <tr>
      <td><a href="viewprofile.php?uname=<?php echo $friend;?>"><?php echo $friend; ?></a></td>
      <td><a href="message.php?to=<?php echo $friend; ?>">Send Message</a></td>
      <td><a href="viewprofile.php?uname=<?php echo $friend;?>" title="This can be done using buttons in the 
        profile of the user">Add/Remove/Block from List</a></td>
    </tr>

    <?php  
    }
    ?>
    </table>

    <h2>Browse by category</h2>
    <?php
    $categories = grab_categories();
    while($row = mysql_fetch_array($categories)){ 
    ?> 
      <a href="viewbycategory.php?c=<?php echo $row[0]; ?>"><?php echo $row[0];?></a>
    <?php
    }
    ?>
    </div>
    </div>
    </div>
    <div id="footer">
      Copyright &copy; Soham Parekh 2016
    </div>
  </div>
</body>
</html>
