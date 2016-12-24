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
table, tr, td {
    width:1200px;
    border: 2px solid white;
    border-collapse: collapse;
}
tr, td {
    padding: 20px;
    text-align: center;
    font-family: arial;
	font-size:20px;
}
h1{
    font-family: arial;
    font-size:80px;
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
<a href="startbootstrap-freelancer-gh-pages\index.html"><img src="home.png" width=50 align="right"></a><br><br><br><br>

<title>卡片拍賣</title>

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
				reloadpage();
				//reloadpage();
				}
		});
	}
	else 
		alert('failed!');
}

function handleSale(saleID, uid) {
	now= new Date(); //抓到目前的時間
	tday=new Date(myArray[saleID]['timer'])//資料庫的object
	var b = "buyPrice" + saleID;
	var buyPrice = document.getElementById(b).value;//取得"id = b"input的value
	console.log(now, tday)
	var minPrice = myArray[saleID]['salePrice'];//拍賣底價
	var spendmoney = 0;
	for (i=0; i < myArray.length;i++) {
		var check = maxArray[i]['UID'];
		saleday=new Date(myArray[i]['timer'])
		if(check && maxArray[i]['UID'] == uid && saleday > now){
			spendmoney = spendmoney + parseInt(maxArray[i]['hisprice']);
			console.log(spendmoney)//競標總額
		}		
	}
	var remainmoney = parseInt(money) - spendmoney ;//目前競標剩下的錢
	if(tday < now){
		alert("稍後再試")
	}
	else if(parseInt(buyPrice) > parseInt(money) && (remainmoney-parseInt(buyPrice))<0)
		alert("金錢不足");
	else if (tday >= now && buyPrice > minPrice) {
		//use jQuery ajax to reset timer
		$.ajax({
			url: "salebuy.php",
			dataType: 'html',
			type: 'POST',
			data: { sid: myArray[saleID]['SID'], uid: uid, buyprice: buyPrice}, //optional, you can send field1=10, field2='abc' to URL by this
			error: function(response) { //the call back function when ajax call fails
				alert('Ajax request failed!');
				},
			success: function(response) { //the call back function when ajax call succeed
				alert(response);
				reloadpage();
				//myArray[saleID]['timer'] = txt;
				}
		});
	
	}
	else if(parseInt(buyPrice) < parseInt(minPrice)){
		alert("重新出價");
	}
}

function checkSale() {
	now= new Date(); //get the current time
	//check each bomb with a for loop
	//array length: number of items in the global array: myArray
	for (i=0; i < myArray.length;i++) {	
		tday=new Date(myArray[i]['timer']); //convert the date string into date object in javascript
		if (tday <= now) { 
		//console.log(maxArray[i]['loginID']);
		//console.log(maxArray[8]['loginID'].length);
		var check = maxArray[i]['loginID'];
			//expired, set the explode image and text
			//console.log(myArray[i]['state']);
			if(myArray[i]['state'] == 0 && myName == maxArray[i]['loginID'] && (check)){
				//console.log(i);
				//console.log(myName);
				console.log(maxArray[i]['loginID'])
				$.ajax({
				url: "getSaleCard.php",
				dataType: 'html',
				type: 'POST',
				data: { sid: myArray[i]['SID']}, //optional, you can send field1=10, field2='abc' to URL by this
					error: function(response) { //the call back function when ajax call fails
					alert('Ajax failed!');
					},
					success: function(response) { //the call back function when ajax call succeed
					alert(response);
					reloadpage();
				//myArray[saleID]['timer'] = txt;
					}
				});
			}
			$("#timer"+i).html("結束競價")
		} else {
			//set the bomb image  and calculate count down
			
			var time = Math.floor(tday-now)/1000;
			var min = Math.floor(time / 60);
			var second = Math.floor(time % 60);
			$("#timer"+i).html(min + "分" + second + "秒")		
		}
	}
}

//javascript, to set the timer on windows load event
window.onload = function () {
	//check the bomb status every 1 second
    setInterval(function () {
		checkSale()
    }, 1000);
	setInterval(function () {
		Bag()
    }, 1000*60*15);
};
function reloadpage(){
	window.location.reload();
}
</script>
</head>

<body >
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
<?php
$i=0; //counter for bombs
$sql="select * from sale, user , card where UID = SUID and CID = SCID order by timer desc"; //select all bomb information from DB
$res=mysqli_query($conn,$sql) or die("db error");
$arr = array();
$arr1 = array(); //define an array for bombs
$myname = $_SESSION['uID'];
$mynamesql="select * from user where loginID ='$myname'";
$mynameres=mysqli_query($conn,$mynamesql) or die("db error");
$mynamerow=mysqli_fetch_assoc($mynameres);
echo "<h1> Hi!$myname</h1>";
echo "<h2>目前金幣: ".$mynamerow['money']."<br><br></h2>";
echo "<script>var money = ".$mynamerow['money']."</script>";
echo "<table>
	<tr>
		<td>ID</td>
		<td>卡片</td>
		<td>賣家</td>
		<td>拍賣張數</td>
		<td>底價</td>
		<td>出價</td>
		<td>計時</td>
		<td>送出</td>
		<td>買家</td>
		<td>目前出價</td>
	</tr>";
while($row=mysqli_fetch_assoc($res)) {
	$arr[] = $row; //store the row into the array
	//generate the image tag, the div tag for timer text. Note on the use of $i in tag ID
	echo "<tr>
			<td>".($i+1)."</td>";
		if($row['loginID'] == "boss")
			echo "<td><img src=bag.png width=70></img></td>";
		else
			echo "<td><img src=bunny".$row['CID'].".png width=80>".$row['cardname']."</img></td>";
	echo	"<td>".$row['loginID']."</td>
			<td>".$row['saleAccount']."</td>
			<td>".$row['salePrice']."</td>
			<td><input name='buyPrice' type='text' id='buyPrice$i' size='2'/></td>
			<td><div id='timer$i'>0</div><br /></td>	
			<td><button type ='button' id='bomb$i' 
			onclick='handleSale($i,".$mynamerow['UID'].")'>出價</button></td>";
	$maxprice = "select * from sale,history,user where HUID = UID and HSID = SID and SID = ".$row['SID']." and hisprice=(select MAX(hisprice) from sale,history,user where HUID = UID and HSID = SID and SID =".$row['SID']." order by hisprice desc) order by hisprice desc";
	//找所有出價資料
	$maxres = mysqli_query($conn,$maxprice) or die("db error");
	$maxrow=mysqli_fetch_assoc($maxres);
	$nullquestion = array("0", "0","0", "0");
	if($maxrow == null)
		array_push($arr1,$nullquestion);
	else
		array_push($arr1,$maxrow);
	echo "<td>".$maxrow['loginID']."</td>"; // 出價最高者
	echo "<td>".$maxrow['hisprice']."</td>";//出價最高價錢
	echo "</tr>";
	$i++;
}
?>

<script>
<?php
	echo "var myArray=" . json_encode($arr);
?>
</script>
<script>
<?php
	echo "var maxArray=" . json_encode($arr1);
	
?>
</script>
<script>
<?php
	echo "var myName=" . json_encode($myname);
?>
</script>
<?php
$sql="select * from user where loginID = 'boss'"; //select all bomb information from DB
$res=mysqli_query($conn,$sql) or die("db error"); //define an array for bombs
$row=mysqli_fetch_assoc($res);
$randcard = rand(1,8); //隨機卡片
$randprice = rand(10,100); //隨機價錢
$randtime = rand(0,1); // 隨機時間
echo "<script>var UID =". $row['UID'] ."</script>";
echo "<script>var CID =". $randcard ."</script>";
echo "<script>var Price =". $randprice ."</script>";
echo "<script>var Addtime =". $randtime ."</script>";
echo "<script>var Account = 3</script>";
?>

</center>

</body>
</html>