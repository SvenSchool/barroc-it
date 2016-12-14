<?php
	session_start();
	require "includes/header.php";
	
	if (isset($_SESSION['role'])) {
		switch($_SESSION['role']) {
			case 1;
				header('location:'.ROOT.'/admin/');
				break;
			
			case 2:
				header('location:'.ROOT.'/sales/');
				break;
			
			case 3:
				header('location:'.ROOT.'/finance/');
				break;
			
			case 4:
				header('location:'.ROOT.'/development/');
				break;

			case 5:
				header('location:'.ROOT.'/personnel/');
				break;
			
			default:
				setMsg("Something went wrong verifying your account information, please try logging back in.", 3);
				header("location:".ROOT."/logout/");
		}
	} else {
		header("location:".ROOT."/login/");
	}
	
	require "includes/footer.php";
?>