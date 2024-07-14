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
		$amount = $_POST['amt'];
		if(trim($amount) == "0") {
			$msg = "Invalid amount";
		}
		else if(!preg_match("/^[0-9.]*$/",trim($amount))) {
			$msg = "Invalid amount";
		}
		else if($amount>$balance) {
			$msg = "Insufficient wallet balance";
		}
		else {
			$phn = $_POST['phn'];
			if(strlen($phn) != 10 ) {
    			$msg = "Invalid phone number";
    		}
    		else if(!preg_match("/^[0-9]*$/",$phn)) {
    			$msg = "Invalid phone number";
    		}
    		else {
				$description = "Money sent to $phn";
				$description1 = "Money received from $phone";
				$amt = $balance - $amount;
				$type = "DR";
				$type1= "CR";
				$date = date('Y-m-d H:i:s');
				sleep(1);
				$date1 = date('Y-m-d H:i:s');
				$qry3 = "select * from transaction where phone='$phn' order by date desc";
				$qryverify = "select * from user where phone='$phn';";
				$res3 = mysqli_query($conn,$qry3);
				$resverify = mysqli_query($conn,$qryverify);
				if(mysqli_num_rows($resverify) == 0 ) {
					$msg = "Phone number not registered";
				}
				else if(!strcmp($phn, $phone)) {
					$msg = "Money cannot be transferred to your own account";
				}
				else {
					$bal = mysqli_fetch_assoc($res3);
					$balance1 = $bal["balance"];
					$amt1 = $balance1 + $amount;
					$qry4 = "insert into transaction(phone,description,amount,type,date,balance) values('$phone','$description','$amount','$type','$date','$amt');";
					$qry5 = "insert into transaction(phone,description,amount,type,date,balance) values('$phn','$description1','$amount','$type1','$date1','$amt1');";
					$res4 = mysqli_query($conn,$qry4);
					$res5 = mysqli_query($conn,$qry5);
					if($res4 && $res5) {
						$msg = "Money sent Successfully";
						$balance = $amt;
					}
				}
			}
		}
	}
	else
	{
		$msg="";
	}		
		
?>

<html>
<head>
<title>EWallet : Pay</title>
<link href="img/images.jpeg" rel="icon" />
<style>
body {font-family: Arial, Helvetica, sans-serif;}

#main {background-image: linear-gradient(-45deg,red,yellow,green);}

#warning {color: red;}
input[type=text] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
}

input:hover {
  opacity: 0.8;
}

#options>a {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
}

#options>a:hover {
  opacity: 0.8;
}
</style>
</head>
<body style="margin: 0;">
<div id="main" style="height: 100%; width: 100%;">
<div style="height: 15%; width: 100%; background-color: #b3ffe6; padding-top: 1%;">
<div style="height: 100%; width: 20%; float: left;">
<a href="home.php" >
<img style="padding-top: 2px; padding-left:30px; height: 80%; width: 40%;" src="img/images.jpeg" alt="Logo">
</a>
</div>
<div style="height: 100%; width: 60%; float: left;"><center><h1>Send Money</h1></center></div>
<div style="height: 100%; width: 10%; float: left;">
<div style="height: 15%; width: 100%;"></div>
<?php echo $name; ?><br> Balance : &#8377;<?php echo $balance ; ?>
</div>
<div style="height: 100%; width: 10%; float: left;">
<form action="" method="post">
<input type="submit" value="Logout" name="logout" />
</form>
</div>
</div>
<div style="height: 20%; width: 100%;"></div>
<center>
<div id="contents">
<form method="post" action="">
<table>
<tr>
<td><label for="uname"><b>Phone:</b></label></td>
<td><input type="text" name="phn" placeholder="Enter Mobile number" required /></td>
</tr>
<tr>
<td><label for="uname"><b>Amount:</b></label></td>
<td><input type="text" name="amt" placeholder="Enter amount to be sent" required /></td>
</tr>
</table>
<input type="submit" name="pay" value="Send" />
<div style="height: 10%;"></div>
<div id="warning">
<?php echo $msg; ?>
</div>
</form>
</div>
</center>
<div style="height: 15%"></div>
<center><a href="about.php" >About</a> | <a href="contact.php" >Contact us</a></center>
<div>
</body>
</html>