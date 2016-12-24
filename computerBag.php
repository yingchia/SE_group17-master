<?php
 require "dbconnect.php";
 session_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="buti.css">

<script type="text/javascript" src="jquery.js"></script>

<script language="javascript">

function Bag(){
	if(Price && Account && Addtime){
		$.ajax({
			url: "ToSale.php",
			dataType: 'html',
			type: 'POST',
			data: { uid: UID , cid: CID, time: Addtime, price: Price, account: Account}, //optional, you can send field1=10, field2='abc' to URL by this
			error: function(response) { //the call back function when ajax call fails
				alert('Ajax request failed!');
				},
			success: function(response) { //the call back function when ajax call succeed
				alert('add bag');
				//reloadpage();
				}
		});
	}
	else 
		alert('failed!');
}

function reloadpage(){
	window.location.reload();
}

//javascript, to set the timer on windows load event
window.onload = function () {
	//check the bomb status every 1 second
    setInterval(function () {
		Bag()
    }, 1000*60*3); //12小時送一次福袋
};
</script>
</head>

<body>
<center>
<?php
$sql="select * from user where loginID = 'boss'"; //select all bomb information from DB
$res=mysqli_query($conn,$sql) or die("db error"); //define an array for bombs
$row=mysqli_fetch_assoc($res);
$randcard = rand(1,8); //隨機卡片
$randprice = rand(10,100); //隨機價錢
$randtime = rand(1,1); // 隨機時間
echo "<script>var UID =". $row['UID'] ."</script>";
echo "<script>var CID =". $randcard ."</script>";
echo "<script>var Price =". $randprice ."</script>";
echo "<script>var Addtime =". $randtime ."</script>";
echo "<script>var Account = 3</script>";
?>
</center>
</body></html>