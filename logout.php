<?php
	session_start();
	$_SESSION['userid']=-1;
	session_destroy();
	header('Location: login.php');
?>