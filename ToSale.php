<?php 
require "dbconnect.php";
$uid=(int)$_POST["uid"];
$cid=(int)$_POST["cid"];
$saleaccount = (int)$_POST["account"];
$price = (int)$_POST["price"];
$time = $_POST["time"];

$addtime = date("Y-m-d H:i:s",strtotime("+7 hours" . $time . "minutes")); //現在時間 + time分鐘
$sql = "insert into sale (SUID, SCID, saleAccount, salePrice, timer) 
				values ('$uid', '$cid', '$saleaccount', '$price', '$addtime');";
//$sql="update sale set timer ='$newD' where SID=$i";
$res=mysqli_query($conn,$sql) or die("db error");
$sql="update mycard set account = account - '$saleaccount' where MUID = $uid and MCID = $cid";
$res=mysqli_query($conn,$sql) or die("error");
echo "拍賣時間".$time."分鐘";
?>
