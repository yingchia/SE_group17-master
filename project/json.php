<?php 
require "dbconnect.php";
$uid=(int)$_POST["uid"];
$sid=(int)$_POST["sid"];
$buyprice=(int)$_POST["buyprice"];
$newtime = date("Y-m-d H:i:s",strtotime("+ 420 minutes"));
//$sql="update sale set timer ='$newD' where SID=$i";
$sql = "insert into history (HUID, HSID, hisprice, histime) 
				values ('$uid', '$sid', '$buyprice', '$newtime');";
$res=mysqli_query($conn,$sql) or die("db error");
echo $newtime;
?>
