<?php
	session_start();
	$title = "Admin";
	require "includes/header.php";

	if (isset($_SESSION['role']) && $_SESSION['role'] != 1) {
		header("location:".ROOT);
		die();
	}
	
	require "views/admin.view.php";
	require "includes/footer.php";

	unset($_SESSION['msg']);
	unset($_SESSION['msglvl']);
?>