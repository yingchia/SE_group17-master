<?php
 require "dbconnect.php";
 session_start();
?>
<style>
body{
  background-color: #18BC9C;
  color: white;
  font-family: arial;
  padding: 80px;
}
table, th, td {
    width:1000px;
    border: 2px solid white;
    border-collapse: collapse;
}
th, td {
    padding: 20px;
    text-align: center;
    font-family: arial;
	font-size:20px;
}
h1{
    font-family: arial;
    font-size:80px;
}
h2{
    font-family: arial;
    font-size:40px;
}
h3{
    font-family: arial;
    font-size:40px;
}
button{
   background-color: #2C3E50;
   color:white;
   width:80px;
   height:30px;
   border-style:none;
   text-align: center;
   font-size: 20px;
   font-weight: bold;
}
li a {
   font-size: 30px;
   height: 32px;
}
</style>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<a href="startbootstrap-freelancer-gh-pages\index.html"><img src="home.png" width=50 align="right"></a>
<title>我的卡片</title>
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
		alert('重新輸入');
}
function getMoney(getYN){
	if(getYN == 1){
		alert(getYN);
		$.ajax({
			url: "getMoney.php",
			dataType: 'html',
			type: 'POST',
			data: {}, //optional, you can send field1=10, field2='abc' to URL by this
			error: function(response) { //the call back function when ajax call fails
				alert('Ajax request failed!');
				},
			success: function(response) { //the call back function when ajax call succeed
				alert(response);
				reloadpage();
				}
		});
	}
	else if(getYN == 0)
		alert("faily get money");
}
function checkSale() {
	now= new Date(); //get the current time
	//check each bomb with a for loop
	//array length: number of items in the global array: myArray
	for (i=0; i < myArray.length;i++) {	
		tday=new Date(myArray[i]['timer']); //convert the date string into date object in javascript
		if (tday <= now) { 
			//expired, set the explode image and text
			$("#bomb" + i).attr('src',"images/explode.jpg");
			$("#timer"+i).html("結束競價")
		} else {
			//set the bomb image  and calculate count down
			$("#bomb" + i).attr('src',"images/bomb.jpg");
			var time = Math.floor(tday-now)/1000;
			var min = Math.floor(time / 60);
			var second = Math.floor(time % 60);
			$("#timer"+i).html(min + "分" + second + "秒")		
		}
	}
}
function checkSale2() {
	now= new Date(); //get the current time
	//check each bomb with a for loop
	//array length: number of items in the global array: myArray
	for (i=0; i < twoArray.length;i++) {	
		tday=new Date(twoArray[i]['timer']); //convert the date string into date object in javascript
		if (tday <= now) { 
			//expired, set the explode image and text
			$("#bomb" + i).attr('src',"images/explode.jpg");
			$("#twotimer"+i).html("結束競價")
		} else {
			//set the bomb image  and calculate count down
			$("#bomb" + i).attr('src',"images/bomb.jpg");
			var time = Math.floor(tday-now)/1000;
			var min = Math.floor(time / 60);
			var second = Math.floor(time % 60);
			$("#twotimer"+i).html(min + "分" + second + "秒")		
		}
	}
}


//javascript, to set the timer on windows load event
window.onload = function () {
	//check the bomb status every 1 second
    setInterval(function () {
		checkSale()
		checkSale2()
    }, 1000);
};
function reloadpage(){
	window.location.reload();
}
</script>
</head>

<body>
<?php
if ( $_SESSION["uID"] < " ") {
	echo "<script>window.location.replace('loginForm.php');</script>";
	exit(0);
}
?>
<ul class="nav nav-pills">
<li><a href='loginForm.php'>logout</a><br></li>
</ul>
<center>
<div id="my card">
<?php
$myname = $_SESSION['uID'];
$i=1; //counter for bombs	
$card = "select * from card "; // 搜尋每個卡片
$result=mysqli_query($conn,$card) or die("db error");
$arr = array(); //define an array for bombs
$cardaccount = mysqli_num_rows($result);
$allcard = 0; //卡片玩家擁有個數
$getmoney = "select * from user where loginID = '$myname'";
$getmoneyres =mysqli_query($conn,$getmoney) or die("db error");
$getmoneyrow=mysqli_fetch_assoc($getmoneyres);
echo "<h1> Hi!$myname</h1>";
echo "<h2>目前金幣: ".$getmoneyrow['money']."<br><br></h2>"; // 玩家金錢
echo "<h3>我的卡片庫</h3>";
echo "<table>
	<tr>
		<td>ID</td>
		<td>卡片</td>
		<td>擁有張數</td>
		<td>欲售出張數</td>
		<td>底價</td>
		<td>剩餘時間</td>
		<td>拍賣</td>
	</tr>";
for($n = 1; $n<=$cardaccount;$n++){ // 印出每張卡片
	$card = "select * from card where CID = $n";
	$result=mysqli_query($conn,$card) or die("db error");
	while($cardrow=mysqli_fetch_assoc($result)) {
		$sql="select * from user ,mycard ,card 
			where loginID = '$myname' and UID = MUID and CID = MCID and CID = $n"; //select all bomb information from DB
		$res=mysqli_query($conn,$sql) or die("db error");
		$row=mysqli_fetch_assoc($res);
		echo "<tr>
				<td>$i</td>
				<td><img src=bunny".$n.".png width=100>".$cardrow['cardname']."</img></td>";
			if(mysqli_num_rows($res)==0) // 判斷玩家是否擁有這張卡片
				echo "<td>0</td>";
			else {
				echo "<td>".$row['account']."</td>"; //印出卡片數量
				$allcard++; //擁有卡片個數++
			}
		echo	"<td><input size='2' name='saleAccount' type='text' id='saleAccount". $row['CID'] ."'/></td>
				<td><input size='2' name='salePrice' type='text' id='salePrice". $row['CID'] ."'/></td>
				<td><input size='2' name='saleTime' type='text' id='saleTime". $row['CID'] ."'/></td>
				<td><button type ='button' id='but' 
				onclick='MyCard(".$row['UID'].",".$row['CID'].",".$row['account'].")'>拍賣</button></td>
			</tr>";
		$i++;
	}
}
echo "</table>";
?>
</div>
<?php
echo "<h3>交易紀錄</h3>";
$sidnum = "select DISTINCT SID from sale,history,user where HUID = UID and HSID = SID and loginID = '$myname' order by SID, hisprice desc";
$sidres=mysqli_query($conn,$sidnum) or die("db error");
$i=0;
$arr = array();
echo "<table>
	<tr>
		<td>ID</td>
		<td>賣方</td>
		<td>卡片</td>
		<td>張數</td>
		<td>交易價格</td>
		<td>剩餘時間</td>
	</tr>";
while($sidrow=mysqli_fetch_assoc($sidres)) {
	$history = "select * from sale,history,user,card where HUID = UID and HSID = SID and SID =".$sidrow['SID']." and CID = SCID order by hisprice desc";
	$historyres=mysqli_query($conn,$history) or die("db error");
	$historyrow=mysqli_fetch_assoc($historyres);
	$arr[] = $historyrow;
	if($historyrow['loginID'] == $myname){
	echo "<tr>
			<td>".($i+1)."</td>
			<td>".$historyrow['loginID']."</td>
			<td><img src=bunny".$historyrow['CID'].".png width=100>".$historyrow['cardname']."</img></td>
			<td>".$historyrow['saleAccount']."</td>
			<td>".$historyrow['hisprice']."</td>
			<td><div id='timer$i'>0</div><br /></td>
		</tr>";
	$i++;
	}
}
echo "</table>";
?>

<?php
echo "<h3>拍賣狀態</h3>";
$i=0; //counter for bombs
$twoarr = array();
$sql="select * from sale, user , card where UID = SUID and CID = SCID and loginID = '$myname' order by timer desc"; //select all bomb information from DB
$res=mysqli_query($conn,$sql) or die("db error");
echo "<table width='100' border='1'>
	<tr>
		<td>ID</td>
		<td>卡片</td>
		<td>售出張數</td>
		<td>底價</td>
		<td>剩餘時間</td>
		<td>出價者</td>
		<td>最高出價</td>
	</tr>";
while($row=mysqli_fetch_assoc($res)) {
	$twoarr[] = $row; //store the row into the array
	//generate the image tag, the div tag for timer text. Note on the use of $i in tag ID
	echo "<tr>
			<td>".($i+1)."</td>
			<td><img src=bunny".$row['CID'].".png width=100>".$row['cardname']."</img></td>
			<td>".$row['saleAccount']."</td>
			<td>".$row['salePrice']."</td>
			<td><div id='twotimer$i'>0</div><br /></td>";
	$maxprice = "select * from sale,history,user where HUID = UID and HSID = SID and SID =".$row['SID']." order by hisprice desc"; //找所有出價資料
	$maxres = mysqli_query($conn,$maxprice) or die("db error");
	$maxrow=mysqli_fetch_assoc($maxres);	
	echo "<td>".$maxrow['loginID']."</td>"; // 出價最高者
	echo "<td>".$maxrow['hisprice']."</td>";//出價最高價錢
	echo "</tr>";
	$i++;
}
echo "</table>";
?>
<script>
<?php
	//print the bomb array to the web page as a javascript object
	echo "var myArray=" . json_encode($arr);
	
?>
</script>
<script>
<?php
	//print the bomb array to the web page as a javascript object
	
	echo "var twoArray=" . json_encode($twoarr);
?>
</script>

<br><br><br><br>
<a href="#my card"><img src="top.png" width=80><br>Top</a>
</center>
</body>
</html>