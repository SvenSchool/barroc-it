<?php
	session_start();
	$title = "Search";
	require "includes/header.php";

	switch ($_GET['dept']) {
		case 'sales':
			$bind = ["s" => "%".$_GET['searchQuery']."%"];
			$searchQuery = $db->select("SELECT * FROM customers WHERE CompanyName LIKE :s OR ContactPerson LIKE :s OR Email LIKE :s", $bind);
			break;

		case 'finance':
			$bind = ["s" => "%".$_GET['searchQuery']."%"];
			$searchQuery = $db->select("SELECT * FROM customers WHERE CompanyName LIKE :s OR BankaccountNr LIKE :s", $bind);
			break;

		case 'development':
			$bind = ["s" => "%".$_GET['searchQuery']."%"];
			$searchQuery = $db->select("SELECT * FROM projects WHERE ProjectName LIKE :s OR Software LIKE :s OR Hardware LIKE :s", $bind);
			break;

		case 'personnel':
			$bind = ["s" => "%".$_GET['searchQuery']."%"];
			$searchQuery = $db->select("SELECT * FROM portfolios WHERE type LIKE :s OR descr LIKE :s OR comments LIKE :s", $bind);
			break;


		
		default:
			setMsg("Something went wrong while trying to search for <b>".urldecode($_GET['searchQuery'])."</b>.", 3);
			echo "<script type=\"text/javascript\">history.go(-1)</script>";
			break;
	}

	require "views/search.view.php";
	require "includes/footer.php";
?>