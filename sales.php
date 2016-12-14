<?php
	session_start();
	$title = "Sales";
	require "includes/header.php";

	if ($_SESSION['role'] != 1) {
		if ($_SESSION['role'] != 2) {
			header("location:".ROOT);
			die();
		}
	}

	if (isset($_GET['refresh'])) {
		header("location:".ROOT."/sales/");
	}
	
	$custQuery = $db->select("SELECT * FROM customers");

	foreach ($custQuery as $cust) {
		$bind = ["id" => $cust->CustomerNR];
		$totalAmount = $db->select("SELECT SUM(Amount) AS TotalAmount FROM invoices WHERE CustomerNR = :id AND Status = 1", $bind);
		$total = $totalAmount[0]->TotalAmount;

		$bind = ["cred" => $total, "nr" => $cust->CustomerNR];
		$db->update("UPDATE customers SET credit = :cred WHERE CustomerNR = :nr", $bind);

		$bind = ["id" => $cust->CustomerNR];
		$credit = $db->select("SELECT SUM(Amount) AS Amount FROM invoices WHERE CustomerNR = :id AND Status = 1", $bind);

		$bind = ["cred" => $credit[0]->Amount, "id" 	 => $cust->CustomerNR];
		$db->update("UPDATE customers SET Credit = :cred WHERE CustomerNR = :id LIMIT 1", $bind);

		$bind = ["id" => $cust->CustomerNR];
		$sum = $db->select("SELECT SUM(Amount) AS RevenueAmount FROM invoices WHERE CustomerNR = :id", $bind);

		$bind = ["sum" => $sum[0]->RevenueAmount, "id" => $cust->CustomerNR];
		$revUpdate = $db->update("UPDATE customers SET RevenueAmount = :sum WHERE CustomerNR = :id LIMIT 1", $bind);
	}

	if ( isset($_GET['cid']) && intval($_GET['cid']) ) {
		// check if they want to edit
		if (isset($_GET['action']) && $_GET['action'] == "edit") {
			$bind = ["id" => $_GET['cid']];
			$editQuery = $db->select("SELECT * FROM customers WHERE CustomerNR = :id LIMIT 1", $bind);

			if (isset($_POST['editSubmit'])) {

				// VOER QUERY UIT
				$bind = [
					"comp" 			 => $_POST['CompanyName'],
					"addr" 			 => $_POST['Address'],
					"zip"  			 => $_POST['Zipcode'],
					"res"  			 => $_POST['Residence'],
					"cont" 			 => $_POST['ContactPerson'],
					"init" 			 => $_POST['Initials'],
					"tele" 			 => $_POST['TelephoneNumber'],
					"fax"  			 => $_POST['FaxNumber'],
					"mail" 			 => $_POST['Email'],
					"o_nr" 			 => $_POST['OfferNumbers'],
					"o_st" 			 => $_POST['OfferStatus'],
					"dt" 			 	 => strtotime($_POST['DateOfAction']),
					"date_cont"  => strtotime($_POST['LastContactDate']),
					"next_act"   => strtotime($_POST['NextAction']),
					"sale_perc"  => $_POST['SalePercentage'],
					"id"  			 => $_GET['cid']
				];

				$editCustQuery = $db->update("UPDATE customers SET
						CompanyName = :comp, 
						Address = :addr, 
						Zipcode = :zip, 
						Residence = :res, 
						ContactPerson = :cont, 
						Initials = :init, 
						TelephoneNumber = :tele, 
						FaxNumber = :fax, 
						Email = :mail, 
						OfferNumbers = :o_nr,
						OfferStatus = :o_st, 
						DateOfAction = :dt, 
						LastContactDate = :date_cont, 
						NextAction = :next_act, 
						SalePercentage = :sale_perc 
					WHERE CustomerNR = :id", $bind);

				setMsg("Successfully edited <b>".$_POST['CompanyName'].".</b>", 1);
				header("location:".ROOT."/sales/".$_GET['cid']."/");
				die();
			}

		}

		// Get info from customer out of database
		$bind = ["id" => $_GET['cid']];
		$echoQuery = $db->select("SELECT * FROM customers WHERE CustomerNR = :id LIMIT 1", $bind);

		$CompanyName 			= $echoQuery[0]->CompanyName;
		$Address 					= $echoQuery[0]->Address;
		$Zipcode 					= $echoQuery[0]->Zipcode;
		$Residence 				= $echoQuery[0]->Residence;
		$ContactPerson 		= $echoQuery[0]->ContactPerson;
		$Initials 				= $echoQuery[0]->Initials;
		$TelephoneNumber  = $echoQuery[0]->TelephoneNumber;
		$FaxNumber 				= $echoQuery[0]->FaxNumber;
		$Email 						= $echoQuery[0]->Email;
		$OfferNumbers 		= $echoQuery[0]->OfferNumbers;
		$OfferStatus 			= $echoQuery[0]->OfferStatus;
		$DateOfAction 		= $echoQuery[0]->DateOfAction;
		$LastContactDate 	= $echoQuery[0]->LastContactDate;
		$NextAction 			= $echoQuery[0]->NextAction;
		$SalePercentage 	= $echoQuery[0]->SalePercentage;
  	$Prospect 				= $echoQuery[0]->Prospect;
		$CreditWorthy 		= $echoQuery[0]->CreditWorthy;
	}

	if (isset($_POST['aptAddSubmit']) && 
			isset($_POST['AptDate']) && 
			isset($_POST['AptTime']) &&
			isset($_POST['Contact']) && 
			isset($_POST['Place']) && 
			isset($_POST['Comments'])) {
		
		$time = $_POST['AptTime'];
		$time .= $_POST['AptDate'];
		$time = strtotime($time);

		$bind = [
			"a_tm"   => $time,
			"cont"   => $_POST['Contact'],
			"plac" 	 => $_POST['Place'],
			"cmnt" 	 => htmlspecialchars($_POST['Comments']),
			"id" 		 => $_GET['cid']
		];

		$aptAddQuery = $db->insert("INSERT INTO appointments (CustomerNR, Name, AptDate, Place, Comments) 
																VALUES (:id, :cont, :a_tm, :plac, :cmnt)", $bind);

		if ($aptAddQuery) {
			$bind = ["id" => $_GET['cid']];
			$query = $db->select("SELECT CompanyName FROM customers WHERE CustomerNR = :id", $bind);

			setMsg("Succesfully added appointment for <b>".$query[0]->CompanyName."</b>.", 1);
			header("location:".ROOT."/sales/".$_GET['cid']."/open/");
			die();
		}
	}

	if (isset($_GET['cid']) && isset($_GET['action']) && $_GET['action'] == "closed") {
		$bind = ["id" => $_GET['cid']];
		$closedApt = $db->select("SELECT * FROM appointments WHERE CustomerNR = :id AND status = 0", $bind);
	}

	if (isset($_GET['cid']) && isset($_GET['action']) && $_GET['action'] == "open") {
		$bind = ["id" => $_GET['cid']];
		$openApt = $db->select("SELECT * FROM appointments WHERE CustomerNR = :id AND status = 1", $bind);
	}

	if (isset($_GET['cid']) && isset($_GET['action']) && $_GET['action'] == "close" && isset($_GET['apt'])) {
		// close appointment
		$bind = ["nr" => $_GET['apt']];

		$query = $db->update("UPDATE appointments SET Status = 0 WHERE AppointmentNR = :nr", $bind);

		if ($query) {
			setMsg("Successfully closed the appointment with id <b>".$_GET['apt']."</b>.", 1);
			header("location:".ROOT."/sales/".$_GET['cid']."/open/");
			die();
		}
	}

	if ( isset($_POST['addSubmit']) && 
			!empty($_POST['CompanyName']) &&
			!empty($_POST['Address']) &&
			!empty($_POST['Zipcode']) &&
			!empty($_POST['Residence']) &&

			!empty($_POST['ContactPerson']) && 
			!empty($_POST['Initials']) && 
			!empty($_POST['TelephoneNumber']) && 
			!empty($_POST['FaxNumber']) && 
			!empty($_POST['Email']) &&
			
			!empty($_POST['OfferNumbers']) && 
			!empty($_POST['OfferStatus']) && 
			!empty($_POST['DateOfAction']) && 
			!empty($_POST['LastContactDate']) && 
			!empty($_POST['NextAction']) &&
			!empty($_POST['SalePercentage']) ) {

		if (!filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL)) {
			setMsg("That is not a valid E-mail address!", 2);
			echo "<form method='post' action='".ROOT."/sales/add/' id='postAddForm'>";
			echo "<input name='CompanyName' value='".$_POST['CompanyName']."'>";
			echo "<input name='Address' value='".$_POST['Address']."'>";
			echo "<input name='Zipcode' value='".$_POST['Zipcode']."'>";
			echo "<input name='Residence' value='".$_POST['Residence']."'>";
			echo "<input name='ContactPerson' value='".$_POST['ContactPerson']."'>";
			echo "<input name='Initials' value='".$_POST['Initials']."'>";
			echo "<input name='TelephoneNumber' value='".$_POST['TelephoneNumber']."'>";
			echo "<input name='FaxNumber' value='".$_POST['FaxNumber']."'>";
			echo "<input name='Email' value='".$_POST['Email']."'>";
			echo "<input name='OfferNumbers' value='".$_POST['OfferNumbers']."'>";
			echo "<input name='OfferStatus' value='".$_POST['OfferStatus']."'>";
			echo "<input name='DateOfAction' value='".strtotime($_POST['DateOfAction'])."'>";
			echo "<input name='LastContactDate' value='".strtotime($_POST['LastContactDate'])."'>";
			echo "<input name='NextAction' value='".strtotime($_POST['NextAction'])."'>";
			echo "<input name='SalePercentage' value='".$_POST['SalePercentage']."'>";
			echo "</form>";
			echo "<script type='text/javascript'>$('#postAddForm').submit();</script>";
			die();
		}

		$bind = [
			"comp" 			 => $_POST['CompanyName'],
			"addr" 			 => $_POST['Address'],
			"zip"  			 => $_POST['Zipcode'],
			"res"  			 => $_POST['Residence'],
			"cont" 			 => $_POST['ContactPerson'],
			"init" 			 => $_POST['Initials'],
			"tele" 			 => $_POST['TelephoneNumber'],
			"fax"  			 => $_POST['FaxNumber'],
			"mail" 			 => $_POST['Email'],
			"o_nr" 			 => $_POST['OfferNumbers'],
			"o_st" 			 => $_POST['OfferStatus'],
			"dt" 			 	 => $_POST['DateOfAction'],
			"date_cont"  => $_POST['LastContactDate'],
			"next_act"   => $_POST['NextAction'],
			"sale_perc"  => $_POST['SalePercentage'],
		];
		$addQuery = $db->insert("INSERT INTO customers (CompanyName, Address, Zipcode, Residence, ContactPerson, Initials, TelephoneNumber, FaxNumber, 
			Email, OfferNumbers, OfferStatus, DateOfAction, LastContactDate, NextAction, SalePercentage) VALUES (:comp, :addr, :zip, :res,
			:cont, :init, :tele, :fax, :mail, :o_nr, :o_st, :dt, :date_cont, :next_act, :sale_perc)", $bind);

		if ($addQuery) {
			// query succesvol
			setMsg("Successfully added <b>".$_POST['CompanyName']."</b>", 1);
			header("location:".ROOT."/sales/");
			die();
		} else {
			setMsg("Something went wrong, please contact the webmaster if this problem persists.", 3);
			header("location:".ROOT."/sales/add/");
			die();
		}
	}
	
	require "views/sales.view.php";
	require "includes/footer.php";

	unset($_SESSION['msg']);
	unset($_SESSION['msglvl']);
?>