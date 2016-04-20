<!DOCTYPE HTML>
<html>

<head>
  <title>Request</title>
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
          <li><div class="right"><form action="search.php" method="get" ><input type="text" name="search_query" placeholder="search" required><input value="Search" name="submit_search" type="submit" /></form></div></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
    <div id="site_content">
    <h1> Request Handler </h1>
      <?php 
      $msg = "";
      $loc = "home.php";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          if (isset($_POST['friendbutton'])) {
            add_friend($_SESSION['username'], $_SESSION['uname']);
            $msg = "Added Friend: ".$_SESSION['username'];
          } 
          else if(isset($_POST['blockbutton'])) {
          //assume blocking friend
            block_user($_SESSION['username'], $_SESSION['uname']);
            $msg = "Blocked user: ".$_SESSION['uname'];
          }
          else if(isset($_POST['unfriendbutton'])){
            remove_friend($_SESSION['username'], $_SESSION['uname']);
            $msg = "Removed Friend: ".$_SESSION['uname'];
          }
          else if(isset($_POST['unblockbutton'])){
            unblock_user($_SESSION['username'], $_SESSION['uname']);
            $msg = "Unblocked: ".$_SESSION['uname'];
          }
          else if(isset($_POST['contactbutton'])){
            insert_contact($_SESSION['username'], $_SESSION['uname']);
            $msg = "Added contact: ".$_SESSION['uname'];
          }
          else if(isset($_POST['rmcontactbutton'])){
            remove_contact($_SESSION['username'], $_SESSION['uname']);
            $msg = "Removed Contact:".$_SESSION['uname'];
          }
          else if(isset($_POST['chpwdbutton'])){
            $code = change_password($_SESSION['username'], $_POST['opwd'], $_POST['npwd1'], $_POST['npwd2']);
            $loc = "editprofile.php";
            if($code == -1){
              $msg = "Incorrect password";
            }
            else if($code == -2){
              $msg = "Passwords don\'t match";
            }
            else {
              $msg = "Changed Password!";
            }
          }
          else if(isset($_POST['cgroupbutton'])){
            $code = make_group($_SESSION['username'], $_POST['groupname']);
            $msg = "Created new group: ".$_POST['groupname'];
            $loc  = "groups.php";
          }
          else if(isset($_POST['rmgroupbutton'])){
            remove_from_group($_SESSION['username'], $_GET['groupid']);
            $msg = "Removed from groupid: ".$_GET['groupid'];
            $loc = "groups.php";
          }
          else if(isset($_POST['addusergroupbutton'])){
            add_user_to_group($_POST['usertogroup'], $_GET['groupid']);
            $msg = "Invited ".$_POST['usertogroup']." to groupid: ".$_GET['groupid'];
            $loc = "groups.php";
          }
          else if(isset($_POST['addtopicgroupbutton'])){
            add_topic_to_group($_POST['topictogroup'], $_GET['groupid']);
            $msg = "Added topic ".$_POST['topictogroup']." to groupid: ".$_GET['groupid'];
            $loc = "viewgroup.php?groupid=".$_GET['groupid'];
          }
          Print '<script>alert("'.$msg.'");</script>';
          Print '<script>window.location.assign("'.$loc.'");</script>';
        }
      ?>
    </div>
    <div id="footer">
      Copyright &copy; Soham Parekh 2016
    </div>
  </div>
</body>
</html>
