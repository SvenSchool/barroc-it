<?php
	session_start();
	$title = "Development";
	require "includes/header.php";

	if ($_SESSION['role'] != 1) {
		if ($_SESSION['role'] != 4) {
			header("location:".ROOT);
			die();
		}
	}

	# LOGIC FOR DEVELOPMENT
	if (!isset($_GET['cid'])) {
		$custQuery = $db->select("SELECT * FROM customers WHERE Prospect = 'N' AND BKR = 'Y'");
	}

	if (isset($_GET['cid']) && isset($_GET['action']) && $_GET['action'] == "active") {
		$bind = ["nr" => $_GET['cid']];
		$activeProjQuery = $db->select("SELECT * FROM projects WHERE CustomerNR = :nr AND StatusProject = 'Active' OR StatusProject = 'Suspended'", $bind);
	}

	if (isset($_GET['cid']) && isset($_GET['action']) && $_GET['action'] == "inactive") {
		$bind = ["nr" => $_GET['cid']];
		$inactiveProjQuery = $db->select("SELECT * FROM projects WHERE CustomerNR = :nr AND StatusProject = 'Done'", $bind);
	}

	if ( isset($_POST['addSubmit']) &&
			 !empty($_POST['ProjectName']) &&
			 !empty($_POST['MaintenanceContract']) &&
			 !empty($_POST['Hardware']) &&
			 !empty($_POST['Software']) 
			) {

		$bind = ["nr" => $_GET['cid'], "name" => $_POST['ProjectName'], "maint" => $_POST['MaintenanceContract'], "hard" => $_POST['Hardware'], "soft" => $_POST['Software']];
		$addQuery = $db->insert("INSERT INTO projects (CustomerNR, ProjectName, MaintenanceContract, Hardware, Software) VALUES (:nr, :name, :maint, :hard, :soft)", $bind);

		if ($addQuery) {
			setMsg("Successfully added project <b>".$_POST['ProjectName']."</b>", 1);
			header("location:".ROOT."/development/".$_GET['cid']."/active/");
			die();
		} else {
			setMsg("Something went wrong while trying to add the project. Please try again!", 3);
			header("location:".ROOT."/development/".$_GET['cid']."/add/");
			die();
		}
	}

	if (isset($_GET['proj']) && isset($_GET['action']) && $_GET['action'] == "deactivate") {
		// Deactivate project
		$bind = ["proj" => $_GET['proj']];
		$deactivateQuery = $db->update("UPDATE projects SET StatusProject = 'Done' WHERE ProjectNR = :proj", $bind);

		if ($deactivateQuery) {
			setMsg("Successfully deactivated project with number <b>".$_GET['proj']."</b>", 1);
			header("location:".ROOT."/development/".$_GET['cid']."/active/");
			die();
		}

	} elseif(isset($_GET['proj']) && isset($_GET['action']) && $_GET['action'] == "activate") {
		// Activate project
		$bind = ["proj" => $_GET['proj']];
		$activateQuery = $db->update("UPDATE projects SET StatusProject = 'Active' WHERE ProjectNR = :proj", $bind);

		if ($activateQuery) {
			setMsg("Successfully activated project with number <b>".$_GET['proj']."</b>", 1);
			header("location:".ROOT."/development/".$_GET['cid']."/inactive/");
			die();
		}
	}

	if (isset($_GET['cid']) && isset($_GET['action']) && $_GET['action'] == "edit") {
		$bind = ["proj" => $_GET['proj']];
		$selEdit = $db->select("SELECT * FROM projects WHERE ProjectNR = :proj", $bind);

		if (
					isset($_POST['editSubmit']) &&
				 !empty($_POST['ProjectName']) &&
				 !empty($_POST['MaintenanceContract']) &&
				 !empty($_POST['Hardware']) &&
				 !empty($_POST['Software']) 
			 ) 
		{
			
			$bind = [
				"nr" => $selEdit[0]->ProjectNR, 
				"name" => $_POST['ProjectName'], 
				"maint" => $_POST['MaintenanceContract'], 
				"hard" => $_POST['Hardware'], 
				"soft" => $_POST['Software']
			];

			$editQuery = $db->update("UPDATE projects SET ProjectName = :name, MaintenanceContract = :maint, Hardware = :hard, Software = :soft WHERE ProjectNR = :nr", $bind);

			if ($editQuery) {
				setMsg("Successfully edited <b>".$_POST['ProjectName']."</b>.", 1);
				header("location:".ROOT."/development/".$_GET['cid']."/active/");
				die();
			} else {
				setMsg("Something went wrong while handling your request. Please try again later.", 3);
				header("location:".ROOT."/development/".$_GET['cid']."/edit/".$_GET['proj']."/");
				die();
			}
		}
	}

	$checkCredit = $db->select("SELECT customers.CustomerNR, projects.CustomerNR FROM customers INNER JOIN projects 
		WHERE customers.CustomerNR = projects.CustomerNR AND projects.StatusProject = 'Active'");

	if ($checkCredit) {
		$check1 = $db->select("SELECT CustomerNR FROM customers WHERE `Limit` < Credit");

		foreach ($check1 as $row) {
			$bind = ["nr" => $row->CustomerNR];
			$db->update("UPDATE projects SET StatusProject = 'Suspended' WHERE CustomerNR = :nr", $bind);
		}
	}

	$checkCredit2 = $db->select("SELECT customers.CustomerNR, projects.CustomerNR FROM customers INNER JOIN projects
		WHERE customers.CustomerNR = projects.CustomerNR AND projects.StatusProject = 'Suspended'");

	if ($checkCredit2) {
		$check2 = $db->select("SELECT CustomerNR FROM customers WHERE `Limit` >= Credit");

		foreach ($check2 as $row) {
			$bind = ["nr" => $row->CustomerNR];
			$db->update("UPDATE projects SET StatusProject = 'Active' WHERE CustomerNR = :nr", $bind);
		}
	}

	require "views/development.view.php";
	require "includes/footer.php";

	unset($_SESSION['msg']);
	unset($_SESSION['msglvl']);
?>