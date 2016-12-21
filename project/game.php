<?php
 require "dbconnect.php";
 ?>

<html>
<style>
center{
  background-color: #18BC9C;
  color: white;
  font-family: arial;
}
table, th, td {
    border: 2px solid white;
}
th, td {
    padding: 10px;
    text-align: center;
    font-family: arial;
	font-size:20px;
}

</style>
<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="jquery.js"></script>

<script language="javascript">

function handleSale(saleID) {
	now= new Date(); //抓到目前的時間
	tday=new Date(myArray[saleID]['timer'])//資料庫的object
	var b = "buyPrice" + saleID;
	var buyPrice = document.getElementById(b).value;//取得"id = b"input的value
	console.log(now, tday)
	var minPrice = myArray[saleID]['salePrice'];//拍賣底價
	if (tday >= now && buyPrice > minPrice) {
		//use jQuery ajax to reset timer
		$.ajax({
			url: "salebuy.php",
			dataType: 'html',
			type: 'POST',
			data: { sid: myArray[saleID]['SID'], uid: myArray[saleID]['UID'], buyprice: buyPrice}, //optional, you can send field1=10, field2='abc' to URL by this
			error: function(response) { //the call back function when ajax call fails
				alert('Ajax request failed!');
				},
			success: function(response) { //the call back function when ajax call succeed
				alert("Bomb" + response);
				//myArray[saleID]['timer'] = txt;
				}
		});
	
	}
	else if(parseInt(buyPrice) < parseInt(minPrice)){
		alert("重新出價");
	}
	else if(tday < now){
		alert("稍後再試")
	}
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

//javascript, to set the timer on windows load event
window.onload = function () {
	//check the bomb status every 1 second
    setInterval(function () {
		checkSale()
    }, 1000);
};
</script>
</head>

<body >
<center>
<?php

$i=0; //counter for bombs
$sql="select * from sale, user , card where UID = SUID and CID = SCID"; //select all bomb information from DB
$res=mysqli_query($conn,$sql) or die("db error");
$arr = array(); //define an array for bombs
echo "<table width='100' border='1'>
	<tr>
		<td>ID</td>
		<td>cardname</td>
		<td>saleman</td>
		<td>saleaccount</td>
		<td>saleprice</td>
		<td>Buy price</td>
		<td>time</td>
	</tr>";
while($row=mysqli_fetch_assoc($res)) {
	$arr[] = $row; //store the row into the array
	//generate the image tag, the div tag for timer text. Note on the use of $i in tag ID
	echo "<tr>
			<td>".($i+1)."</td>
			<td>".$row['cardname']."</td>
			<td>".$row['loginID']."</td>
			<td>".$row['saleAccount']."</td>
			<td>".$row['salePrice']."</td>
			<td><input name='buyPrice' type='text' id='buyPrice$i'/></td>
			<td><div id='timer$i'>0</div><br /></td>
			<td><button type ='button' id='bomb$i' onclick='handleSale($i)'>出價</button></td>
		</tr>";
	$i++;
}

?>

<script>
<?php
	//print the bomb array to the web page as a javascript object
	echo "var myArray=" . json_encode($arr);
?>
</script>
</center>
 
</body>
</html>