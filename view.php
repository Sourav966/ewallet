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
		$res3 = mysqli_query($conn,$qry2);
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
<title>EWallet : History</title>
<link href="images.jpeg" rel="icon" />
<style>
body {font-family: Arial, Helvetica, sans-serif; background-image: linear-gradient(-45deg,red,yellow,green);}

#main {}

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
<style>
#hist {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#hist td, #hist th {
  border: 1px solid #ddd;
  padding: 8px;
}



#hist tr:hover {background-color: #ddd;}

#hist th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
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
<div style="height: 100%; width: 60%; float: left;"><center><h1>History</h1></center></div>
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
<table id="hist">
	<tr><th>Date</th><th>Description</th><th>Amount</th><th>Type</th><th>Balance</th></tr>
<?php
	while($row = mysqli_fetch_assoc($res3)) {
		?>
		<tr>
		<td><?php echo $row['date']; ?></td>
		<td><?php echo $row['description']; ?></td>
		<td><?php echo $row['amount']; ?></td>
		<td><?php echo $row['type']; ?></td>
		<td><?php echo $row['balance']; ?></td>
		</tr>
<?php		}
?>
</table>


</body>
</html>