<?php
 require "dbconnect.php";
 session_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style>
body{
  background-color: #18BC9C;
  font-family: arial;
  padding: 80px;
}
table, th, td {
    border: 2px solid white;
}
th, td {
    padding: 20px;
    text-align: center;
    font-family: arial;
	font-size:20px;
}
</style>
<script type="text/javascript" src="jquery.js"></script>

<script language="javascript">


function MyCard(UID ,CID, account){
	var p = "salePrice" + CID;
	var a = "saleAccount" + CID;
	var t = "saleTime" + CID;
	var Price = document.getElementById(p).value; //拍賣價錢
	var Account = document.getElementById(a).value;//拍賣數量
	var Addtime = document.getElementById(t).value;//拍賣時間
	if(Account > account)
		alert("數量錯誤");

	else if(Price && Account && Addtime){
		$.ajax({
			url: "ToSale.php",
			dataType: 'html',
			type: 'POST',
			data: { uid: UID , cid: CID, time: Addtime, price: Price, account: Account}, //optional, you can send field1=10, field2='abc' to URL by this
			error: function(response) { //the call back function when ajax call fails
				alert('Ajax request failed!');
				},
			success: function(response) { //the call back function when ajax call succeed
				alert(response);
				reloadpage();
				}
		});
	}
	else 
		alert('failed!');
}

function reloadpage(){
	window.location.reload();
}
</script>
</head>

<body>
<center>
<?php
$myname = $_SESSION['uID'];
$i=1; //counter for bombs	
$sql="select * from user ,mycard ,card 
	where loginID = '$myname' and UID = MUID and CID = MCID"; //select all bomb information from DB
$res=mysqli_query($conn,$sql) or die("db error");
$arr = array(); //define an array for bombs
echo "<h1> hi!$myname</h1>";
if(mysqli_num_rows($res) > 0){
	echo "<table width='100' border='1'>
	<tr>
		<td>ID</td>
		<td>name</td>
		<td>account</td>
		<td>saleaccount</td>
		<td>saleprice</td>
		<td>time</td>
	</tr>";
	while($row=mysqli_fetch_assoc($res)) {
		echo "<tr>
				<td>$i</td>
				<td>".$row['cardname']."</td>
				<td>".$row['account']."</td>
				<td><input name='saleAccount' type='text' id='saleAccount". $row['CID'] ."'/></td>
				<td><input name='salePrice' type='text' id='salePrice". $row['CID'] ."'/></td>
				<td><input name='saleTime' type='text' id='saleTime". $row['CID'] ."'/></td>
				<td><button type ='button' id='but' 
				onclick='MyCard(".$row['UID'].",".$row['CID'].",".$row['account'].")'>拍賣</button></td>
			</tr>";
		$i++;
	}	
}
?>
</center>
</body></html>