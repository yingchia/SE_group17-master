<html>
<style>
body{
  background-color: #18BC9C;
  color: white;
  padding: 80px;
  font-family: arial;
  text-align: center;
  font-size:40px;
}
</style>

<body>
<?php
session_start();
require("User.php");
if(! isset($_POST["act"])) {
	exit(0);
}

$act =$_POST["act"];
switch($act) {
	case "login":
		$loginName = $_POST['id'];
		$password = $_POST['pwd'];
		if (checkUser($loginName, $password)) {
			//set login session mark
			$_SESSION['uID'] = $loginName;
			echo "login OK<br>";
			echo header("Location: startbootstrap-freelancer-gh-pages\index.html");
			//echo "<a href='startbootstrap-freelancer-gh-pages\index.html'>Home</a>";
		} else {
			//set login mark to empty
			$_SESSION['uID'] = "";
			echo "Login failed.<br>";
			echo "<a href='loginForm.php'>login</a>";
		}
	default:
}
?>
</body>
</html>
