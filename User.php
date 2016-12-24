<?php
require("dbconnect.php");

function checkUser($uID, $Pwd) {
	global $conn;
	$uID =mysqli_real_escape_string($conn,$uID);
	$sql = "SELECT password FROM user WHERE loginID='$uID'";
	if ($result = mysqli_query($conn,$sql)) {
		if ($row=mysqli_fetch_assoc($result)) {
			if ($row['password'] === $Pwd) {
				return true;
			} 
		}
	}
	return false;
}



?>
