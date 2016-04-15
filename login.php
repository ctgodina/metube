<head>
	<title>Login</title>
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/style.css">
	<style>
	body{
		background-color: black;
	}
	</style>
</head>
<?php
session_start();

include_once "function.php";

if(isset($_POST['submit'])) {
		if($_POST['username'] == "" || $_POST['password'] == "") {
			$login_error = "One or more fields are missing.";
		}
		else {
			$check = user_pass_check($_POST['username'],$_POST['password']); // Call functions from function.php
			if($check == 0) {
				$login_error = "User ".$_POST['username']." not found.";
			}
			elseif($check==2) {
				$login_error = "Incorrect password.";
			}
			else if($check==1){
				$_SESSION['username']=$_POST['username']; //Set the $_SESSION['username']
				header('Location: browse.php');
			}		
		}
}


 
?>

	<div class="wrap">
	<form method="post" action="<?php echo "login.php"; ?>">
	<input type="text" placeholder="username" required>
	<input type="password" placeholder="password" required>
	<button>Login</button>
	<button>Reset</button>
	</form>
	</div>

<?php
  if(isset($login_error))
  {
  	echo "<div id='passwd_result'>".$login_error."</div>";
	/*echo '<script language=\"javascript\">';
	echo 'window.alert("SOMEMESSAGE")';
	echo '</script>';*/
  }
?>
