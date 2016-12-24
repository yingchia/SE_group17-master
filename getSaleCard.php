<?php 
require "dbconnect.php";
session_start();
$myname = $_SESSION['uID'];
$sid = $_POST["sid"];
//echo $sid;
$maxprice = "select * from sale,history,user where HUID = UID and HSID = SID and SID ='$sid' order by hisprice desc";
$maxres = mysqli_query($conn,$maxprice) or die("db error");
$maxrow=mysqli_fetch_assoc($maxres);
//echo $maxrow['loginID'];
if($myname == $maxrow['loginID']){
	$SCID = $maxrow['SCID'];
	$saleAccount = $maxrow['saleAccount'];
	$UID = $maxrow['UID'];
	$checkcard="select * from mycard,user where MCID = ".$maxrow['SCID']." 
	and loginID ='$myname' and UID = MUID";
	$result=mysqli_query($conn,$checkcard) or die("db error");
	if(mysqli_num_rows($result)==0)
	{
		$addcard = "insert into mycard (MCID, account, MUID) 
				values ('$SCID', '$saleAccount', '$UID');";
		$addcardres=mysqli_query($conn,$addcard) or die("db error");
	}
	else{
		$addCard = "update mycard set account = account +".$maxrow['saleAccount']." where MUID = ".$maxrow['UID']." and MCID = ".$maxrow['SCID']."";
		$result=mysqli_query($conn,$addCard) or die("db error");
	}
	
	$reducemoney = "update user set money = money - ".$maxrow['hisprice']." where loginID = '$myname'" ;
	$result=mysqli_query($conn,$reducemoney) or die("db error");
	
	$setstate = "update sale set state = 1 where SID = '$sid'";
	$result=mysqli_query($conn,$setstate) or die("db error");
	
	$card = "select * from card where CID = ".$maxrow['SCID']."";
	$result=mysqli_query($conn,$card) or die("db error");
	$row=mysqli_fetch_assoc($result);
	echo "恭喜獲得".$row['cardname'];
	$getMoney= "update user set money = money + ".$maxrow['hisprice']." where UID = ".$maxrow['SUID']."";
	$getMoneyres=mysqli_query($conn,$getMoney) or die("db error");
	
	
}
?>
