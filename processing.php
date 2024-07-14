<?php
	include 'dbcon.php';
	session_start();
	if(isset($_SESSION['user'])) {
		$phone = $_SESSION['user'];
		$qry1 = "select name from user where phone = '$phone';";
		$qry2 = "select * from transaction where phone = '$phone' order by date desc;";
		$res = mysqli_query($conn,$qry1);
		foreach(mysqli_fetch_assoc($res) as $row) {
			$_SESSION['name'] = $row;
		}
		$name = $_SESSION['name'];
		$res2 = mysqli_query($conn,$qry2);
		$val = mysqli_fetch_assoc($res2);
		$balance = $val["balance"];
	}
	else {
		header('location:index.php?msg=Please Login First');
	}
	if(isset($_POST['logout'])) {
		header('location:logout.php');
	}
	if(isset($_POST['pay'])) {
		$description = "Amount added to wallet";
		$amount = $_POST['amount'];
		$amt = $_POST['amount'] + $balance;
		$type = "CR";
		$date = date('Y-m-d H:i:s');
		$qry3 = "insert into transaction(phone,description,amount,type,date,balance) values('$phone','$description','$amount','$type','$date','$amt');";
		$res3 = mysqli_query($conn,$qry3);
		if($res3) {
		}
	}
?>

<html>
<head>
<title>Processing...</title>
</head>
<body style="margin: 0px;">
<div style="height: 100%;width: screen.width;background-color: gray;">
<div style="height: 30%; width: 100%;"></div>
<center>
<?php 
	
   $msg = "Amount added successfully";
   echo $msg;
	header('refresh: 2; url = ');
	header('refresh: 2; url = home.php');
?>
</center>
</div>
</body>
</html>