<div class="panel-text">
    <h1>Sales panel</h1>
</div>

<div class='float_btn'>
	<a class='btn btn-primary' href='<?= ROOT."/logout/"?>'>Logout</a>
</div>  

<div class='float_btn'>
	<a class='btn btn-primary' href='<?= ROOT."/comments/"; ?>'>Comments</a>
</div>

<form action="<?= ROOT.'/search/' ?>" method="get" name="search" style="margin-bottom:10px;">
  <div class="input-group col-lg-3">
    <input hidden name="dept" value="sales">
    <input id="search-bar" name="searchQuery" class="form-control">
    
    <span class="input-group-btn">
      <button id="search-button" type="submit" class="btn btn-primary" type="button">Search</button>
    </span>
  </div>
</form>

<?php if(!isset($_GET['cid'])) : ?>
	<a href="<?= ROOT ?>/sales/add/" class="btn btn-success">Add a customer</a>
<?php elseif( isset($_GET['cid']) && intval($_GET['cid']) && !isset($_GET['action']) ) : ?>
  <div style="margin-bottom:10px;">
  	<a href="<?= ROOT.'/sales/'.$_GET['cid'].'/edit/' ?>" class="btn btn-success">Edit customer</a>
    <a href="<?= ROOT.'/sales/'.$_GET['cid'].'/new-appointment/' ?>" class="btn btn-primary">Create appointment</a>
  </div>
<?php endif; ?>


<?php
	if (getMsg()) {
		echo getMsg();
	}
?>

<?php if(!isset($_GET['cid'])) { ?>

<table class='table table-striped'>
	<thead>
		<tr>
			<th class="col-sm-2">Companyname</th>
			<th class="col-sm-2">Contact person</th>
			<th class="col-sm-2">Email</th>
			<th class="col-sm-2">Phone number</th>
			<th class="col-sm-2">Fax number</th>
			<th class="col-sm-2">Prospect</th>
			<th class="col-sm-2">Open appointments</th>
			<th class="col-sm-2">Closed appointments</th>
			<th class="col-sm-2">View</th>
		</tr>
	</thead>
	<tbody>
<?php
	foreach ($custQuery as $row) {
		// Credit query
		echo "<tr><td>";
		echo $row->CompanyName;
		echo "</td><td>";
		echo $row->ContactPerson;
		echo "</td><td>";
		echo $row->Email;
		echo "</td><td>";
		echo $row->TelephoneNumber;
		echo "</td><td>";
		echo $row->FaxNumber;
		echo "</td><td>";
		echo $row->Prospect;
		echo "</td><td>";
		echo "<a href=\"".ROOT."/sales/".$row->CustomerNR."/open/\">View</a>";
		echo "</td><td>";
		echo "<a href=\"".ROOT."/sales/".$row->CustomerNR."/closed/\">View</a>";
		echo "</td><td>";
		echo "<a href=\"".ROOT."/sales/";
		echo $row->CustomerNR."/\" class=\"btn btn-success\">View</a>";
		echo "</td><td></tr>";
	}
?>
	</tbody>
</table>

<?php } elseif(isset($_GET['cid']) && $_GET['cid'] == "add") { ?>

<form action="<?= ROOT.'/sales/add/' ?>" method="post">
  <legend>Add Customer</legend>
    <div class="form-group col-sm-6">
     <label for="CompanyName">Company name</label>
     <input type="text" class="form-control" name="CompanyName" <?= isset($_POST['CompanyName']) ? "value='".$_POST['CompanyName']."'" : null; ?> >
    </div>

    <div class="form-group col-sm-6">
     <label for="Address">Address</label>
     <input type="text" class="form-control" name="Address" <?= isset($_POST['Address']) ? "value='".$_POST['Address']."'" : null; ?> >   
    </div>
    
    <div class="form-group col-sm-6">
     <label for="Zipcode">Zipcode</label>
     <input type="text" class="form-control" name="Zipcode" <?= isset($_POST['Zipcode']) ? "value='".$_POST['Zipcode']."'" : null; ?> >   
    </div>

    <div class="form-group col-sm-6">
     <label for="Residence">Residence</label>
     <input type="text" class="form-control" name="Residence" <?= isset($_POST['Residence']) ? "value='".$_POST['Residence']."'" : null; ?> >   
    </div>

    <div class="form-group col-sm-6">
     <label for="ContactPerson">Contact person</label>
     <input type="text" class="form-control" name="ContactPerson" <?= isset($_POST['ContactPerson']) ? "value='".$_POST['ContactPerson']."'" : null; ?> >   
    </div>

    <div class="form-group col-sm-6">
     <label for="Initials">Initials</label>
     <input type="text" class="form-control" name="Initials" <?= isset($_POST['Initials']) ? "value='".$_POST['Initials']."'" : null; ?> >   
    </div>

    <div class="form-group col-sm-6">
     <label for="TelephoneNumber">Telephone</label>
     <input type="text" class="form-control" name="TelephoneNumber" <?= isset($_POST['TelephoneNumber']) ? "value='".$_POST['TelephoneNumber']."'" : null; ?> >   
    </div>

    <div class="form-group col-sm-6">
     <label for="FaxNumber">Fax</label>
     <input type="text" class="form-control" name="FaxNumber" <?= isset($_POST['FaxNumber']) ? "value='".$_POST['FaxNumber']."'" : null; ?> >   
    </div>

    <div class="form-group col-sm-6">
     <label for="Email">Email</label>
     <input type="text" class="form-control" name="Email" <?= isset($_POST['Email']) ? "value='".$_POST['Email']."'" : null; ?> >   
    </div>

    <div class="form-group col-sm-6">
     <label for="OfferNumbers">Offer numbers</label>
     <input type="text" class="form-control" name="OfferNumbers" <?= isset($_POST['OfferNumbers']) ? "value='".$_POST['OfferNumbers']."'" : null; ?> >   
    </div>

    <div class="form-group col-sm-6">
     <label for="OfferStatus">Offer status</label>
     <input type="text" class="form-control" name="OfferStatus" <?= isset($_POST['OfferStatus']) ? "value='".$_POST['OfferStatus']."'" : null; ?> >   
    </div>

    <div class="form-group col-sm-6">
     <label for="DateOfAction">Date of action</label>
     <input type="date" class="form-control" name="DateOfAction" <?= isset($_POST['DateOfAction']) ? "value='".$_POST['DateOfAction']."'" : null; ?> >   
    </div>

    <div class="form-group col-sm-6">
     <label for="LastContactDate">Last contact date</label>
     <input type="date" class="form-control" name="LastContactDate" <?= isset($_POST['LastContactDate']) ? "value='".$_POST['LastContactDate']."'" : null; ?> >   
    </div>

    <div class="form-group col-sm-6">
     <label for="NextAction">Next action</label>
     <input type="date" class="form-control" name="NextAction" <?= isset($_POST['NextAction']) ? "value='".$_POST['NextAction']."'" : null; ?> >   
    </div>

    <div class="form-group col-sm-6">
     <label for="SalePercentage">Sale percentage</label>
     <input type="text" class="form-control" name="SalePercentage" <?= isset($_POST['SalePercentage']) ? "value='".$_POST['SalePercentage']."'" : null; ?> >   
    </div>

    <div class="form-group col-sm-6">
     <label for="CreditWorthy">Credit worthy</label>
     <input type="text" disabled class="form-control">   
    </div>

    <div class="form-group col-sm-12">
     <input name="addSubmit" type="submit" value="Add" class="btn btn-primary">     
    </div>
  </form>

<?php } elseif(isset($_GET['action']) && isset($_GET['cid']) && $_GET['action'] == "edit") {  ?>
	
<form action="<?= ROOT.'/sales/'.$_GET['cid'].'/edit/' ?>" method="post">
  <legend>Edit <?= $editQuery[0]->CompanyName ?></legend>
  <div class="form-group col-sm-6">
   <label for="CompanyName">Company name</label>
   <input type="text" class="form-control" name="CompanyName" placeholder="<?= $editQuery[0]->CompanyName ?>" <?= !empty($_POST['CompanyName']) ? "value='".$_POST['CompanyName']."'" : "value='".$editQuery[0]->CompanyName."'"; ?> >
  </div>

  <div class="form-group col-sm-6">
   <label for="Address">Address</label>
   <input type="text" class="form-control" name="Address" placeholder="<?= $editQuery[0]->Address ?>" <?= !empty($_POST['Address']) ? "value='".$_POST['Address']."'" : "value='".$editQuery[0]->Address."'"; ?> >   
  </div>
  
  <div class="form-group col-sm-6">
   <label for="Zipcode">Zipcode</label>
   <input type="text" class="form-control" name="Zipcode" placeholder="<?= $editQuery[0]->Zipcode ?>" <?= !empty($_POST['Zipcode']) ? "value='".$_POST['Zipcode']."'" : "value='".$editQuery[0]->Zipcode."'"; ?> >   
  </div>

  <div class="form-group col-sm-6">
   <label for="Residence">Residence</label>
   <input type="text" class="form-control" name="Residence" placeholder="<?= $editQuery[0]->Residence ?>" <?= !empty($_POST['Residence']) ? "value='".$_POST['Residence']."'" : "value='".$editQuery[0]->Residence."'"; ?> >   
  </div>

  <div class="form-group col-sm-6">
   <label for="ContactPerson">Contact person</label>
   <input type="text" class="form-control" name="ContactPerson" placeholder="<?= $editQuery[0]->ContactPerson ?>" <?= !empty($_POST['ContactPerson']) ? "value='".$_POST['ContactPerson']."'" : "value='".$editQuery[0]->ContactPerson."'"; ?> >   
  </div>

  <div class="form-group col-sm-6">
   <label for="Initials">Initials</label>
   <input type="text" class="form-control" name="Initials" placeholder="<?= $editQuery[0]->Initials ?>" <?= !empty($_POST['Initials']) ? "value='".$_POST['Initials']."'" : "value='".$editQuery[0]->Initials."'"; ?> >   
  </div>

  <div class="form-group col-sm-6">
   <label for="TelephoneNumber">Telephone</label>
   <input type="text" class="form-control" name="TelephoneNumber" placeholder="<?= $editQuery[0]->TelephoneNumber ?>" <?= !empty($_POST['TelephoneNumber']) ? "value='".$_POST['TelephoneNumber']."'" : "value='".$editQuery[0]->TelephoneNumber."'"; ?> >   
  </div>

  <div class="form-group col-sm-6">
   <label for="FaxNumber">Fax</label>
   <input type="text" class="form-control" name="FaxNumber" placeholder="<?= $editQuery[0]->FaxNumber ?>" <?= !empty($_POST['FaxNumber']) ? "value='".$_POST['FaxNumber']."'" : "value='".$editQuery[0]->FaxNumber."'"; ?> >   
  </div>

  <div class="form-group col-sm-6">
   <label for="Email">Email</label>
   <input type="text" class="form-control" name="Email" placeholder="<?= $editQuery[0]->Email ?>" <?= !empty($_POST['Email']) ? "value='".$_POST['Email']."'" : "value='".$editQuery[0]->Email."'"; ?> >   
  </div>

  <div class="form-group col-sm-6">
   <label for="OfferNumbers">Offer numbers</label>
   <input type="text" class="form-control" name="OfferNumbers" placeholder="<?= $editQuery[0]->OfferNumbers ?>" <?= !empty($_POST['OfferNumbers']) ? "value='".$_POST['OfferNumbers']."'" : "value='".$editQuery[0]->OfferNumbers."'"; ?> >   
  </div>

  <div class="form-group col-sm-6">
   <label for="OfferStatus">Offer status</label>
   <input type="text" class="form-control" name="OfferStatus" placeholder="<?= $editQuery[0]->OfferStatus ?>" <?= !empty($_POST['OfferStatus']) ? "value='".$_POST['OfferStatus']."'" : "value='".$editQuery[0]->OfferStatus."'"; ?> >   
  </div>

  <div class="form-group col-sm-6">
   <label for="DateOfAction">Date of action</label>
   <input type="date" class="form-control" name="DateOfAction" placeholder="<?= $editQuery[0]->DateOfAction ?>" <?= !empty($_POST['DateOfAction']) ? "value='".$_POST['DateOfAction']."'" : "value='".$editQuery[0]->DateOfAction."'"; ?> >   
  </div>

  <div class="form-group col-sm-6">
   <label for="LastContactDate">Last contact date</label>
   <input type="date" class="form-control" name="LastContactDate" placeholder="<?= $editQuery[0]->LastContactDate ?>" <?= !empty($_POST['LastContactDate']) ? "value='".$_POST['LastContactDate']."'" : "value='".$editQuery[0]->LastContactDate."'"; ?> >   
  </div>

  <div class="form-group col-sm-6">
   <label for="NextAction">Next action</label>
   <input type="text" class="form-control" name="NextAction" placeholder="<?= $editQuery[0]->NextAction ?>" <?= !empty($_POST['NextAction']) ? "value='".$_POST['NextAction']."'" : "value='".$editQuery[0]->NextAction."'"; ?> >   
  </div>

  <div class="form-group col-sm-6">
   <label for="SalePercentage">Sale percentage</label>
   <input type="text" class="form-control" name="SalePercentage" placeholder="<?= $editQuery[0]->SalePercentage ?>" <?= !empty($_POST['SalePercentage']) ? "value='".$_POST['SalePercentage']."'" : "value='".$editQuery[0]->SalePercentage."'"; ?> >   
  </div>

  <div class="form-group col-sm-6">
   <label for="CreditWorthy">Credit worthy</label>
   <input type="text" disabled class="form-control">   
  </div>

  <div class="form-group col-sm-12">
    <input name="editSubmit" type="submit" value="Submit" class="btn btn-primary">     
  </div>
 </form>

<?php } elseif(isset($_GET['action']) && isset($_GET['cid']) && $_GET['action'] == "closed") { ?>

<table class="table table-striped">
  <thead>
    <th>Contact</th>
    <th>Time</th>
    <th>Location</th>
    <th>Comments</th>
  </thead>
  <tbody>
    <?php 
      foreach ($closedApt as $apt) {
        echo "<tr><td>";
        echo $apt->Name;
        echo "</td><td>";
        echo date("l d F Y", $apt->AptDate)." at ".date("h:i A", $apt->AptDate);
        echo "</td><td>";
        echo $apt->Place;
        echo "</td><td>";
        echo $apt->Comments;
        echo "</td></tr>";
      }

    ?>
  </tbody>
</table>

<?php } elseif(isset($_GET['action']) && isset($_GET['cid']) && $_GET['action'] == "open") { ?>

<table class="table table-striped">
  <thead>
    <th>Contact</th>
    <th>Time</th>
    <th>Location</th>
    <th>Comments</th>
    <th>Close appointment</th>
  </thead>
  <tbody>
    <?php 
      foreach ($openApt as $apt) {
        echo "<tr><td>";
        echo $apt->Name;
        echo "</td><td>";
        echo date("l d F Y", $apt->AptDate)." at ".date("h:i A", $apt->AptDate);
        echo "</td><td>";
        echo $apt->Place;
        echo "</td><td>";
        echo $apt->Comments;
        echo "</td><td>";
        echo "<a href=\"".ROOT."/sales/".$_GET['cid']."/close/".$apt->AppointmentNR."/\">Close</a>";
        echo "</td></tr>";
      }
    ?>
  </tbody>
</table>

<?php } elseif(isset($_GET['action']) && isset($_GET['cid']) && $_GET['action'] == "new-appointment") { ?>

<form action="<?= ROOT.'/sales/'.$_GET['cid'].'/appointments/' ?>" method="POST">
  <legend>Add appointment</legend>

  <div class="form-group col-sm-6">
    <label for="Date">Date</label>
    <input type="date" class="form-control" name="AptDate" required>
  </div>

  <div class="form-group col-sm-6">
    <label for="Time">Time</label>
    <input type="time" class="form-control" name="AptTime" required>
  </div>

   <div class="form-group col-sm-6">
    <label for="Name">Person of contact</label>
    <input type="text" class="form-control" name="Contact" required> 
  </div>

  <div class="form-group col-sm-6">
    <label for="Place">Place</label>
    <input type="text" class="form-control" name="Place" required> 
  </div>

  <div class="form-group col-sm-6">
    <label for="Comments">Comments</label>
    <textarea class="form-control" name="Comments" required></textarea> 
  </div>

  <div class="form-group col-sm-12">
   <input name="aptAddSubmit" type="submit" value="Add" class="btn btn-primary">     
  </div>   
</form>

<?php } elseif(isset($_GET['cid']) && !isset($_GET['action'])) { ?>
  <table id="table-view" class="table table-striped">
    <tbody>
      <tr>
        <td><b>Company name</b></td>
        <td><?= $CompanyName; ?></td>
      </tr>

      <tr>
        <td><b>Address</b></td>
        <td><?= $Address; ?></td>
      </tr>

      <tr>
        <td><b>Postal Code</b></td>
        <td><?= $Zipcode; ?></td>
      </tr>

      <tr>
        <td><b>Residence</b></td>
        <td><?= $Residence; ?></td>
      </tr>

      <tr>
        <td><b>Contact Person</b></td>
        <td><?= $ContactPerson; ?></td>
      </tr>

      <tr>
        <td><b>Initials</b></td>
        <td><?= $Initials; ?></td>
      </tr>

      <tr>
        <td><b>Phone Number</b></td>
        <td><?= $TelephoneNumber; ?></td>
      </tr>

      <tr>
        <td><b>Fax Number</b></td>
        <td><?= $FaxNumber; ?></td>
      </tr>

      <tr>
        <td><b>E-mail</b></td>
        <td><?= $Email; ?></td>
      </tr>

      <tr>
        <td><b>Offer Numbers</b></td>
        <td><?= $OfferNumbers; ?></td>
      </tr>

      <tr>
        <td><b>Offer Status</b></td>
        <td><?= $OfferStatus; ?></td>
      </tr>

      <tr>
        <td><b>Date of Action</b></td>
        <td><?= $DateOfAction; ?></td>
      </tr>

      <tr>
        <td><b>Last Contact Cate</b></td>
        <td><?= $LastContactDate; ?></td>
      </tr>

      <tr>
        <td><b>Next Action</b></td>
        <td><?= $NextAction; ?></td>
      </tr>

      <tr>
        <td><b>Sales Percentage</b></td>
        <td><?= $SalePercentage; ?></td>
      </tr>

      <tr>
        <td><b>Prospect</b></td>
        <td><?= $Prospect; ?></td>
      </tr>

      <tr>
        <td><b>Credit Worthy</b></td>
        <td><?= $CreditWorthy; ?></td>
      </tr>
    </tbody>
  </table>

<?php } else {
    setMsg("Could not fetch customer data. Please try again later!", 3);
    header("location:".ROOT);
    die();
  }
?>

<?php if (isset($_GET['cid'])) : ?>
<a href="<?= ROOT ?>/sales/" class="btn btn-primary" style="float:left;">Go back</a>
<?php endif; ?>

<?php if ($_SESSION['role'] == 1): ?>
<a href="<?= ROOT ?>/admin/" class="btn btn-primary" style="float:left;">Back to admin page</a>
<?php endif ?>