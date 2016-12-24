<style>
body{
  background-color: #18BC9C;
  color: white;
  padding:90px;
  text-align: center;
  font-family: arial;
  font-size: 40px;
}
#but{
   background-color: #2C3E50;
   color:white;
   width:150px;
   height:50px;
   margin:30px;
   vertical-align:middle;
   border-style:none;
   text-align: center;
   font-size: 25px;
   font-weight: bold;
}

</style>

<?php
 require "dbconnect.php";
 session_start();
?>
<html>
<title>換取金錢</title>
<a href="startbootstrap-freelancer-gh-pages\index.html"><img src="home.png" width=50 align="right"></a><br><br>
<script type="text/javascript" src="jquery.js"></script>
<script language="javascript">
function getMoney(getYN){
	if(getYN == 1){
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
</script>
<body>
<?php
if ( $_SESSION["uID"] < " ") {
	///header("Location: loginForm.php");
	header("Location: loginForm.php");
	exit(0);
}
?>
<center>
<?php //換取金錢
$myname = $_SESSION['uID'];
$i=1; //counter for bombs	
$card = "select * from card "; // 搜尋每個卡片
$result=mysqli_query($conn,$card) or die("db error");
$arr = array(); //define an array for bombs
$cardaccount = mysqli_num_rows($result);
$allcard = 0; //卡片玩家擁有個數
while($i<=8){
    $sql="select * from user ,mycard ,card where CID = $i"; 
    $res=mysqli_query($conn,$sql) or die("db error");
    $row=mysqli_fetch_assoc($res);
    if(mysqli_num_rows($res)==0) // 判斷玩家是否擁有這張卡片
        echo "<td>0</td>";
    else {
        //echo "<td>".$row['account']."</td>"; //印出卡片數量
        $allcard++; //擁有卡片個數++
    }
    $i++;
}
if($allcard == 8){
    echo " <marquee behavior=side direction=right ><img src=\"startbootstrap-freelancer-gh-pages/img/portfolio/happy.png\" >";
	echo "<button type ='button' id='but' onclick='getMoney(1)'>換取金幣</button></marquee>";
    
}else{
    echo "<marquee behavior=side direction=right ><img src=\"startbootstrap-freelancer-gh-pages/img/portfolio/sad.png\">";
    echo "無法換取金幣,請耐心收集卡片</marquee>";
	
}    
?>
</center>
</body>
</html>