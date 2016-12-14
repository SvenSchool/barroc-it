<?php
	require "includes/header.php";
	session_start();
	session_destroy();
	unset($_SESSION);

	session_start();
	setMsg("You were successfully logged out.", 1);
	header("location:".ROOT."/login/");
?>