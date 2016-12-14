<?php
	session_start();
	$title = "Finance";
	require "includes/header.php";

	if ($_SESSION['role'] != 1) {
		if ($_SESSION['role'] != 3) {
			header("location:".ROOT);
			die();
		}
	}

	if (isset($_GET['refresh'])) {
		header("location:".ROOT."/finance/");
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


	if (isset($_GET['status']) && $_GET['status'] == "active") {
		$bind = ["id" => $_GET['cid'], "stat" => 1];
		$invQuery = $db->select("SELECT * FROM invoices INNER JOIN customers ON 
														invoices.CustomerNR = customers.CustomerNR WHERE 
														invoices.CustomerNR = :id AND Status = :stat", $bind);
	}

	if (isset($_GET['status']) && $_GET['status'] == "inactive") {
		$bind = ["id" => $_GET['cid'], "stat" => 0];
		$invQuery = $db->select("SELECT * FROM invoices INNER JOIN customers ON 
														invoices.CustomerNR = customers.CustomerNR WHERE 
														invoices.CustomerNR = :id AND Status = :stat", $bind);
	}

	if (isset($_GET['status']) && $_GET['status'] == "edit") {
		$bind = ["id" => $_GET['cid']];
		$editQuery = $db->select("SELECT * FROM customers WHERE CustomerNR = :id", $bind);
	}

	if (isset($_GET['invoice'])) {
		$inv = $_GET['invoice'];

		$bind = ["nr" => $inv];
		$searchInvQuery = $db->select("SELECT status FROM invoices WHERE InvoiceNR = :nr LIMIT 1", $bind);
		// var_dump($searchInvQuery);

		if ($searchInvQuery[0]->status == 1) {
			$invUpdateQuery = $db->update("UPDATE invoices SET status = 0 WHERE InvoiceNR = :nr", $bind);
			setMsg("Successfully updated invoice number <b>".$inv."</b>.", 1);
			header("location:".ROOT."/finance/".$_GET['cid']."/active/");
			exit();
		} else {
			$invUpdateQuery = $db->update("UPDATE invoices SET status = 1 WHERE InvoiceNR = :nr", $bind);
			setMsg("Successfully updated invoice number <b>".$inv."</b>.", 1);
			header("location:".ROOT."/finance/".$_GET['cid']."/inactive/");
			exit();
		}
	}

	if (isset($_POST['customerEdit'])) {
		$bind = [
			"bank" => $_POST['BankaccountNr'],
			"ledg" => $_POST['LedgerAccount'],
			"bkr"  => $_POST['BKR'],
			"lim"  => $_POST['Limit'],
			"id"   => $_GET['cid']
						];
		$db->update("UPDATE customers SET BankaccountNr = :bank, LedgerAccount = :ledg, BKR = :bkr, `Limit` = :lim WHERE CustomerNR = :id", $bind);

		setMsg("Successfully updated <b>".$editQuery[0]->CompanyName."</b>!", 1);
		header("location:".ROOT."/finance/");
		exit();
	}

	if (isset($_POST['addSubmit'])) {
		$bind = [
			"dur" => $_POST['InvoiceDuration'],
			"quan" => $_POST['Quantity'],
			"descr"  => $_POST['Description'],
			"pri"  => $_POST['Price'],
			"id"   => $_GET['cid']
						];
		$db->insert("INSERT INTO invoices SET InvoiceDuration = :dur, Quantity = :quan, Description = :descr, Price = :pri, CustomerNR = :id", $bind);

		$bind = ["id" => $_GET['cid']];
		$addQuery = $db->select("SELECT CompanyName FROM customers WHERE CustomerNR = :id", $bind);

		$invNr = $db->select("SELECT MAX(InvoiceNR) AS max FROM Invoices");

		$bind = ["nr" => $invNr[0]->max];
		$amount = $db->select("SELECT SUM(((Quantity * Price) / 100) * 121) AS Amount FROM invoices WHERE InvoiceNR = :nr", $bind);

		$bind = ["amnt" => $amount[0]->Amount, "nr" => $invNr[0]->max];
		$db->update("UPDATE invoices SET Amount = :amnt WHERE InvoiceNR = :nr LIMIT 1", $bind);

		setMsg("Successfully added an invoice for <b>".$addQuery[0]->CompanyName."</b>!", 1);
		header("location:".ROOT."/finance/?refresh");
		exit();
	}
	
	require "views/finance.view.php";
	require "includes/footer.php";

	unset($_SESSION['msg']);
	unset($_SESSION['msglvl']);
?>