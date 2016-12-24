<?php 
require "dbconnect.php";
session_start();
$myname = $_SESSION['uID'];
$money = 500;
for($n=1;$n<=8;$n++){
	$sql="select * from user ,mycard ,card where loginID = '$myname' and UID = MUID and CID = MCID and CID = $n";
	$res=mysqli_query($conn,$sql) or die("db error");
	$row = mysqli_fetch_assoc($res);
	$reduceCard = "update mycard set account = account - 1 where MUID = ".$row['UID']." and MCID = $n;";
	$result=mysqli_query($conn,$reduceCard) or die("db error");
}
$addmoney = "update user set money = money + '$money' where loginID = '$myname'" ;
$result=mysqli_query($conn,$addmoney) or die("db error");
echo "獲得".$money."元";
?>
