<?php
	session_start();
	$title = "Login";
	require "includes/header.php";

	if (isset($_SESSION['name'])) {
		setMsg("You are already logged in, no need to do that again!", 2);
		header("location:".ROOT);
		die();
	}
	
	// if (isset($_POST['loginSubmit'])) {
	// 	$user = $_POST['loginName'];
	// 	$pass = $_POST['loginPass'];

	// 	$bind = ['user' => $_POST['loginName']];
	// 	$query = $db->select("SELECT * FROM users WHERE username = :user", $bind);
		
	// 	if ($db->getRows() == 1) {		
	// 		if (password_verify($pass, $query[0]->password)) {
	// 			// and if active
	// 			session_destroy();
	// 			session_start();
	// 			$_SESSION['name'] = $query[0]->username;
	// 			$_SESSION['role'] = $query[0]->userrole;
	// 			setMsg("You were successfully logged in.", 1);
	// 			header("location:".ROOT);
	// 			die();
	// 		}
	// 	}
	// }

	session_destroy();
	session_start();
	$_SESSION['name'] = "username";
	$_SESSION['role'] = "1";
	setMsg("You were successfully logged in.", 1);
	header("location:".ROOT);
	die();
	
	require "views/login.view.php";
	require "includes/footer.php";

	unset($_SESSION['msg']);
	unset($_SESSION['msglvl']);
?>