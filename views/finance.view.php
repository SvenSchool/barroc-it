<div class="panel-text">
    <h1>Finance panel</h1>
</div>

<div class='float_btn'>
	<a class='btn btn-primary' href='<?= ROOT."/logout/"?>'>Logout</a>
</div>  

<div class='float_btn'>
	<a class='btn btn-primary' href='<?= ROOT."/comments/"; ?>'>Comments</a>
</div>

<form action="<?= ROOT.'/search/' ?>" method="get" name="search" style="margin-bottom:10px;">
  <div class="input-group col-lg-3">
    <input hidden name="dept" value="finance">
    <input id="search-bar" name="searchQuery" class="form-control">
    
    <span class="input-group-btn">
      <button id="search-button" type="submit" class="btn btn-primary" type="button">Search</button>
    </span>
  </div>
</form>

<?php
	if (getMsg()) {
		echo getMsg();
	}
?>

<?php if(!isset($_GET['cid'])) { ?>
<table class='table table-striped'>
	<thead>
		<tr>
			<td class="col-sm-2">Companyname</td>
			<td class="col-sm-2">Bank account number</td>
			<td class="col-sm-2">Credit</td>
			<td class="col-sm-2">Revenue amount</td>
			<td class="col-sm-2">Limit</td>
			<td class="col-sm-2">Ledger account</td>
			<td class="col-sm-2">BKR</td>
			<td class="col-sm-2">Unpaid</td>
			<td class="col-sm-2">Paid</td>
			<td class="col-sm-2">Edit</td>
		</tr>
	</thead>
	<tbody>
<?php
	foreach ($custQuery as $row) {

		// Credit query

		echo "<tr><td>";
		echo $row->CompanyName;
		echo "</td><td>";
		echo $row->BankaccountNr;
		echo "</td><td>";
		echo "&euro;".$row->Credit;
		echo "</td><td>";
		echo "&euro;".$row->RevenueAmount;
		echo "</td><td>";
			if ($row->Limit < $row->Credit) {
				echo "<span style=\"color:red;\">&euro;".$row->Limit."</span>";
			} else {
				echo "&euro;".$row->Limit;
			}
		echo "</td><td>";
		echo $row->LedgerAccount;
		echo "</td><td>";
		echo $row->BKR;
		echo "</td><td>";
			if ($row->BKR == "Y") {
				echo "<a href=\"".ROOT."/finance/";
				echo $row->CustomerNR."/active/\" class=\"btn btn-primary\">View</a>";
				echo "</td><td>";
				echo "<a href=\"".ROOT."/finance/";
				echo $row->CustomerNR."/inactive/\" class=\"btn btn-primary\">View</a>";
				echo "</td><td>";
			} else {
				echo "<a href=\"\" class=\"btn btn-warning\">Check</a>";
				echo "</td><td>";
				echo "<a href=\"\" class=\"btn btn-warning\">BKR</a>";
				echo "</td><td>";
			}
		echo "<a href=\"".ROOT."/finance/";
		echo $row->CustomerNR."/edit/\" class=\"btn btn-success\">View</a>";
		echo "</td><td></tr>";
	}
?>
	</tbody>
</table>
<?php } elseif(isset($_GET['status']) && $_GET['status'] == "active") { ?>
	
<a href="<?= ROOT ?>/finance/<?= $_GET['cid'] ?>/add/" class="btn btn-success">Add an invoice</a>

<table class='table table-striped'>
	<thead>
		<tr>
			<td class="col-sm-2">Invoice Duration</td>
			<td class="col-sm-2">Quantity</td>
			<td class="col-sm-2">Description</td>
			<td class="col-sm-2">Price</td>
			<td class="col-sm-2">BTW</td>
			<td class="col-sm-2">Amount</td>
			<td class="col-sm-2">Paid</td>
		</tr>
	</thead>
	<tbody>
<?php
	foreach ($invQuery as $row) {
		echo "<tr><td>";	
		echo $row->InvoiceDuration;
		echo "</td><td>";
		echo $row->Quantity."x";
		echo "</td><td>";
		echo $row->Description;
		echo "</td><td>";
		echo "&euro;".$row->Price;
		echo "</td><td>";
		echo $row->BTW."%";
		echo "</td><td>";
		echo "&euro;".$row->Amount;
		echo "</td><td>";
		echo "<a href=\"".ROOT."/finance/";
		echo $row->CustomerNR."/edit/".$row->InvoiceNR."/\" class=\"btn btn-danger\">Set to paid</a>";
		echo "</td><td></tr>";
	}
	echo "</tbody>";
	echo "</table>";
?>

<?php } elseif(isset($_GET['status']) && $_GET['status'] == "inactive") { ?>

<table class='table table-striped'>
	<thead>
		<tr>
			<td class="col-sm-2">Invoice Duration</td>
			<td class="col-sm-2">Quantity</td>
			<td class="col-sm-2">Description</td>
			<td class="col-sm-2">Price</td>
			<td class="col-sm-2">BTW</td>
			<td class="col-sm-2">Amount</td>
			<td class="col-sm-2">Unpaid</td>
		</tr>
	</thead>
	<tbody>
<?php
	foreach ($invQuery as $row) {
		echo "<tr><td>";	
		echo $row->InvoiceDuration;
		echo "</td><td>";
		echo $row->Quantity."x";
		echo "</td><td>";
		echo $row->Description;
		echo "</td><td>";
		echo "&euro;".$row->Price;
		echo "</td><td>";
		echo $row->BTW."%";
		echo "</td><td>";
		echo "&euro;".$row->Amount;
		echo "</td><td>";
		echo "<a href=\"".ROOT."/finance/";
		echo $row->CustomerNR."/edit/".$row->InvoiceNR."/\" class=\"btn btn-danger\">Set to unpaid</a>";
		echo "</td><td></tr>";
	}
	echo "</tbody>";
	echo "</table>";
?>

<?php } elseif(isset($_GET['status']) && $_GET['status'] == "edit") {  ?>
	
<form action="" method="post">
  <legend>Edit a customer</legend>

  <div class="form-group col-sm-6">
   <label for="BankaccountNr">Bank account number</label>
   <input value="<?= $editQuery[0]->BankaccountNr ?>" type="text" class="form-control" name="BankaccountNr" placeholder="NL91ABNA0417164300">    
  </div>

  <div class="form-group col-sm-6">
  	<label for="LedgerAccount">Ledger account</label>
  	<input value="<?= $editQuery[0]->LedgerAccount ?>" type="text" class="form-control" name="LedgerAccount" placeholder="Ledgeraccount">   
  </div>

  <div class="form-group col-sm-6">
    <label for="Limit">Limit</label>
    <input value="<?= $editQuery[0]->Limit ?>" type="text" class="form-control" name="Limit" >    
  </div>

  <div class="form-group col-sm-6">
    <label for="BKR" <?php if($editQuery[0]->BKR == "Y") {echo "hidden";} ?>>BKR</label>
    <input value="<?= $editQuery[0]->BKR ?>" type="<?php if($editQuery[0]->BKR == "Y") {echo "hidden";}else{echo "text";}?>" class="form-control" name="BKR" placeholder="Y / N">    
  </div>
  
  <div class="form-group col-sm-12">
    <div class="float_left">
  	  <input name="customerEdit" type="submit" value="Save" class="btn btn-primary">     
    </div>
  </div>   
</form>

<?php } elseif (isset($_GET['status']) && $_GET['status'] == "add") { ?>

<form action="<?= ROOT.'/finance/'.$_GET['cid'].'/add/' ?>" method="post">
	<legend>Add an invoice</legend>
	<div class="form-group col-sm-6">
		<label for="InvoiceDuration">Invoice duration</label>
		<input type="date" class="form-control" name="InvoiceDuration" placeholder="2014-10-24" required>    
	</div>

	<div class="form-group col-sm-6">
		<label for="Quantity">Quantity</label>
		<input type="text" class="form-control" name="Quantity" placeholder="5" required>   
	</div>
    
	<div class="form-group col-sm-6 col-xs-6">
		<label for="Description">Description</label>
		<input type="text" class="form-control" name="Description" placeholder="Text" required>    
	</div>
    
	<div class="form-group col-sm-6">
		<label for="Price">Price</label>
		<input type="text" class="form-control" name="Price" placeholder="150" required>    
	</div>
    
	<div class="form-group col-sm-12">
		<input name="addSubmit" type="submit" value="Add" class="btn btn-primary">     
	</div>   
</form>

<?php } ?>

<?php if (isset($_GET['cid'])) : ?>
<a href="<?= ROOT ?>/finance/" class="btn btn-primary" style="float:left;">Go back</a>
<?php endif; ?>

<?php if ($_SESSION['role'] == 1): ?>
<a href="<?= ROOT ?>/admin/" class="btn btn-primary" style="float:left;">Back to admin page</a>
<?php endif; ?>