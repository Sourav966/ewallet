<?php
	session_start();
	if(isset($_SESSION['user'])) {
		session_destroy();
		header('location:index.php?msg=Logged out successfully');
	}
	else {
		header('location:index.php?msg=Already logged out');
	}
?>