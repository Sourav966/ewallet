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
	if(isset($_REQUEST['msg'])) {
		$msg = $_REQUEST['msg'];
	}
	else{
		$msg="";
	}
	if(isset($_POST['logout'])) {
		header('location:logout.php');
	}
	
?>

<html>
<head>
<title>EWallet : Add</title>
<link href="images.jpeg" rel="icon" />
<style>
body {font-family: Arial, Helvetica, sans-serif;}

#main {background-image: linear-gradient(-45deg,red,yellow,green);}

input[type=text] {
  width: 20%;
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
<img style="padding-top: 2px; padding-left:30px; height: 80%; width: 40%;" src="images.jpeg" alt="Logo">
</a>
</div>
<div style="height: 100%; width: 60%; float: left;"><center><h1>Add Money</h1></center></div>
<div style="height: 100%; width: 10%; float: left;">
<div style="height: 15%; width: 100%;"></div>
<?php echo $name; ?><br> Balance : <?php echo $balance ; ?>
</div>
<div style="height: 100%; width: 10%; float: left;">
<form action="" method="post">
<input type="submit" value="Logout" name="logout" />
</form>
</div>
</div>
<div style="height: 20%; width: 100%;"></div>
<center>
<form method="post" action="paymentpage.php">
<div>
<label for="uname"><b>Amount:</b></label>
<br><input type="text" name="amount" id="amount" required="" placeholder="Enter the Amount to be added" /><br><input type="submit" value="Add" name="add" />
</div>
<div style="height: 15%;"></div>
<div id="warning">
<?php echo $msg; ?>
</div><div style="height: 10%;"></div>
<div style="height: 20%"></div>
<center><a href="about.php" >About</a> | <a href="contact.php" >Contact us</a></center>
</form>
</center>
</div>
</body>
</html>