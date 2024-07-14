<?php
    include 'dbcon.php';
    session_start();
    if(isset($_SESSION['user'])) {
    	header('location:home.php');
    }
    if(isset($_REQUEST['msg'])) {
    	$msg = $_REQUEST['msg'];
    }
    if(isset($_POST['submit'])) {
    	$phone = $_POST['ph'];
    	$password = $_POST['pwd'];
    	$qry1="select * from user where phone='$phone' and password='$password';";
    	$res=mysqli_query($conn,$qry1);
    	
    	if(mysqli_fetch_row($res)>0) {
    		$_SESSION['user'] = $phone;
    		header('location:home.php');		
    		}
    	else {
    		$msg = "Invalid Phone/Password.";
    		}
    		
    }
    if(isset($_POST['reg'])) {
    	$name = $_POST['regname'];
    	$regphone = trim($_POST['regph']);
    	$regpassword = $_POST['regpwd'];
    	$confirmpassword = $_POST['cnfpwd'];
    	if(strlen($regphone) != 10 ) {
    		$msg = "Invalid phone number";
    	}
    	else if(!preg_match("/^[0-9]*$/",$regphone)) {
    		$msg = "Invalid phone number";
    	}
    	else if(!preg_match("/^[A-Za-z ]*$/",$name)) {
    		$msg = "Name should contain only letters and space";
    	}
    	else if(strcmp($regpassword, $confirmpassword)) {
    		$msg = "Passwords do not match";
    	}
    	else if(strlen(trim($regpassword)) < 8 ) {
    		$msg = "Password must be atleast 8 characters long";
    	}
    	else {
    	$qry = "select * from user where phone='$regphone';";
    	$resverify = mysqli_query($conn,$qry);
    	if(mysqli_num_rows($resverify)>0) {
    		$msg = "Phone number already registered";
    	}
    	else {
    		$qry1="insert into user(name,phone,password) values ('$name','$regphone','$regpassword');";
    		$res1=mysqli_query($conn,$qry1);
    		$amt = "0";
    		$type = "--";
    		$date = date('Y-m-d H:i:s');
    		$description = "New Account Created";
    		$qry2 = "insert into transaction(phone,description,amount,type,date,balance) values ('$regphone','$description','$amt','$type','$date','$amt');";
    		$res2 = mysqli_query($conn,$qry2);
    		if($res1 && $res2) {
    			$msg = "Registration successful";
    		}
    		else {
    			$msg = "Registration failed";
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
<title>Login to Online Recharge Portal</title>
<link href="img/images.jpeg" rel="icon" />
<link herf="style.css" rel="style">
<style>
body {margin: 0px; font-family: Arial, Helvetica, sans-serif;}
#main {height: 100%; width: screen.width; background-image: linear-gradient(-45deg,red,yellow,green);}
#warning {color:red;}
/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

.loader { 
  height: 100%; 
  width: screen.width;
  background-image: linear-gradient(-45deg,red,yellow,green);
  display: grid;
  place-items:center;
  
}

/* Set a style for all buttons */
button {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  
}

button:hover {
  opacity: 0.8;
}

/* Extra styles for the cancel button */
.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

/* Center the image and position the close button */
.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
  position: relative;
}

img.avatar {
  width: 40%;
  border-radius: 50%;
}

.container {
  padding: 16px;
  border: radius 5px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  padding-top: 60px;
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
  border: 1px solid #888;
  width: 30%; /* Could be more or less, depending on screen size */
}

/* The Close Button (x) */
.close {
  position: absolute;
  right: 25px;
  top: 0;
  color: #000;
  font-size: 35px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: red;
  cursor: pointer;
}

/* Add Zoom Animation */
.animate {
  -webkit-animation: animatezoom 0.6s;
  animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
  from {-webkit-transform: scale(0)} 
  to {-webkit-transform: scale(1)}
}
  
@keyframes animatezoom {
  from {transform: scale(0)} 
  to {transform: scale(1)}
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}

</style>
</head>
<body onload="myFunction()">
<div id="loader">
        <div class="Loader">    
        	<div class="img">
	            <img src="img/images.jpeg">
	            <h1>SCM SERVICE</h1>
	        </div>
        </div>
    </div>

<div id="main" style="display:none;">
<center>
<div style="height: 10%;"></div>
<h1>Welcome to  Online Recharge Portal</h1>
<div style="height: 20%;"><center><img style="height: 80%; " src="img/images.jpeg" alt=""></center></div>
<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</button>
<button onclick="document.getElementById('id02').style.display='block'" style="width:auto;">Sign up</button>
<div style="height: 20%;"></div>
<div id="warning"><?php echo $msg; ?></div>
<div style="height: 20%"></div>
<a href="about.php" >About</a> | <a href="contact.php" >Contact us</a>
</center>
<div id="id01" class="modal">
  <form class="modal-content animate" action="" method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
      <h2>Login</h2>
    </div>

    <div class="container">
      <label for="uname"><b>Phone</b></label>
      <input type="text" placeholder="Enter Phone Number" name="ph" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="pwd" required>
        
      <button type="submit" name="submit">Login</button>
    </div>
  </form>
</div>

<div id="id02" class="modal">
  
  <form class="modal-content animate" action="" method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
      <h2>Register</h2>
    </div>

    <div class="container">
    
      <label for="uname"><b>Name</b></label>
      <input type="text" placeholder="Enter Your Name" name="regname" required>
      
      <label for="uname"><b>Phone</b></label>
      <input type="text" placeholder="Enter Phone Number" name="regph" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="regpwd" required>
      
      <label for="psw"><b>Confirm Password</b></label>
      <input type="password" placeholder="Enter Password Again" name="cnfpwd" required>
        
      <button type="submit" name="reg">Register</button>
    </div>
  </form>
</div>

<script>
// Get the modal
var modal = document.getElementById('id01');
var modal1 = document.getElementById('id02');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
    else if (event.target == modal1) {
        modal1.style.display = "none";
    }
}
function myFunction() {
        setTimeout(function() {
        document.getElementById("loader").style.display = "none";
        document.getElementById("main").style.display = "block"; }, 3000);
    }

</script>
</div>
</body>
</html>
