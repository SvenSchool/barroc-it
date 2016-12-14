<?php
	session_start();
	$title = "P&O";
	require "includes/header.php";

	if ($_SESSION['role'] != 1) {
		if ($_SESSION['role'] != 5) {
			header("location:".ROOT);
			die();
		}
	}
	
	if (!isset($_GET['uid'])) {
		$userQuery = $db->select("SELECT * FROM users WHERE active = 1");
	}

	if (isset($_GET['uid']) && !isset($_GET['action'])) {
		$bind = ["id" => $_GET['uid']];
		$userPortQuery = $db->select("SELECT * FROM portfolios WHERE uid = :id", $bind);
	}

	if (isset($_GET['uid']) && isset($_GET['action']) && $_GET['action'] == "add") {
		$bind = ["id" => $_GET['uid']];
		$portQuery = $db->select("SELECT * FROM portfolios WHERE uid = :id", $bind);

		if (isset($_POST['portAddSubmit']) &&
				!empty($_POST['portType']) &&
				!empty($_POST['portDesc']) &&
				!empty($_POST['portBegin']) &&
				!empty($_POST['portEnd'])
			) {

			if (empty($_POST['portCmnts'])) {
				$_POST['portCmnts'] = "";
			}

			$begin 	= strtotime($_POST['portBegin']);
			$end 		= strtotime($_POST['portEnd']);

			if ($end <= $begin) {
				setMsg("The starting date must be before the ending date.", 3);
				header("location:".ROOT."/personnel/".$_GET['uid']."/add/");
				die();
			}

			if ( !$end || !$begin) {
				setMsg("Please fill in a valid date.", 3);
				header("location:".ROOT."/personnel/".$_GET['uid']."/add/");
				die();
			}

			$bind = [
				"uid" 			=> $_GET['uid'],
				"type" 			=> htmlspecialchars($_POST['portType']),
				"descr" 		=> htmlspecialchars($_POST['portDesc']),
				"begin_dt"  => strtotime($_POST['portBegin']),
				"end" 			=> strtotime($_POST['portEnd']),
				"cmnt" 			=> htmlspecialchars($_POST['portCmnts'])
			];
			$addPortQuery = $db->insert("INSERT INTO portfolios (uid, type, descr, begin_date, end_date, comments) 
																		VALUES (:uid, :type, :descr, :begin_dt, :end, :cmnt)", $bind);

			if ($addPortQuery) {
				setMsg("Successfully added portfolio for user number <b>".$bind['uid']."</b>", 1);
				header("location:".ROOT."/personnel/".$bind['uid']."/");
				die();
			} else {
				setMsg("Something went wrong while trying to add portfolio for that user. Please try again.", 3);
				header("location:".ROOT."/personnel/".$bind['uid']."/add/");
				die();
			}
		}
	}

	if (isset($_GET['uid']) && isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['port'])) {
		$bind = ["id" => $_GET['port']];
		$portQuery = $db->select("SELECT * FROM portfolios WHERE id = :id", $bind);

		if (isset($_POST['portEditSubmit']) &&
				!empty($_POST['portType']) &&
				!empty($_POST['portDesc']) &&
				!empty($_POST['portBegin']) &&
				!empty($_POST['portEnd'])
			) {

			if (empty($_POST['portCmnts'])) {
				$_POST['portCmnts'] = "";
			}

			$begin 	= strtotime($_POST['portBegin']);
			$end 		= strtotime($_POST['portEnd']);

			if ($end <= $begin) {
				setMsg("The starting date must be before the ending date.", 3);
				header("location:".ROOT."/personnel/".$_GET['uid']."/edit/".$_GET['port']."/");
				die();
			}

			if ( !$end|| !$begin) {
				setMsg("Please fill in a valid date.", 3);
				header("location:".ROOT."/personnel/".$_GET['uid']."/edit/".$_GET['port']."/");
				die();
			}

			$bind = [
				"id" 				=> $_GET['port'],
				"uid"  			=> htmlspecialchars($_GET['uid']),
				"type" 			=> htmlspecialchars($_POST['portType']),
				"descr" 		=> htmlspecialchars($_POST['portDesc']),
				"begin_dt"	=> strtotime($_POST['portBegin']),
				"end" 			=> strtotime($_POST['portEnd']),
				"cmnt" 			=> htmlspecialchars($_POST['portCmnts'])
			];
			$editPortQuery = $db->update("UPDATE portfolios SET uid = :uid, type = :type, descr = :descr, begin_date = :begin_dt, 
				end_date = :end, comments = :cmnt WHERE id = :id", $bind);

			if ($editPortQuery) {
				setMsg("Successfully edited portfolio for user number <b>".$bind['uid']."</b>", 1);
				header("location:".ROOT."/personnel/".$bind['uid']."/");
				die();
			} else {
				setMsg("Something went wrong while trying to add portfolio for that user. Please try again.", 3);
				header("location:".ROOT."/personnel/".$bind['uid']."/edit/".$_GET['port']."/");
				die();
			}
		}
	}
	
	require "views/personnel.view.php";
	require "includes/footer.php";

	unset($_SESSION['msg']);
	unset($_SESSION['msglvl']);
?>