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
		
		
?>

<html>
<head>
<title>Online Recharge Portal : Home</title>
<link href="img/images.jpeg" rel="icon" />
<style>
body {font-family: Arial, Helvetica, sans-serif;}

#main {background-image: linear-gradient(-45deg,red,yellow,green);}

input {
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

#options>a>img {
  width: 8%;
  height: 50%;
  margin: 8px 0;
}

#opt>a {
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
<div id="main" style="height: 100%;width: 100%;">
<div style="height: 15%; width: 100%; background-color: #b3ffe6; padding-top: 1%;">
<div style="height: 100%; width: 20%; float: left;">
<a href="home.php" >
<img style="padding-top: 2px; padding-left:30px; height: 80%; width: 40%;" src="img/images.jpeg" alt="Logo">
</a>
</div>
<div style="height: 100%; width: 60%; float: left;"><center><h1>Welcome to Online Recharge Portal</h1></center></div>
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
<div id="options" style="height: 30%; width: 100%;">
<a href="add.php" ><img src="img/addicon.png" alt="Add Money" /></a>
<a href="pay.php" ><img src="img/sendicon.png" alt="Pay" /></a>
<a href="recharge.php" ><img src="img/rechargeicon.png" alt="Recharge" /></a>
<a href="view.php" ><img src="img/viewicon.png" alt="History"></a>
</div>
</center>
<div style="height: 28%"></div>
<center><a href="about.php" >About</a> | <a href="contact.php" >Contact us</a></center>
</div>
</body>
</html>