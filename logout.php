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
    session_start()
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
    		<h1>Successfully Logged out!</h1>
        <?php
          $_SESSION['username']="";
          $_SESSION['password']="";
          header("location:index.php");
        ?>		
      </div>
    </div>
    <div id="footer">
      Copyright &copy; Soham Parekh 2016
    </div>
  </div>
</body>
</html>
