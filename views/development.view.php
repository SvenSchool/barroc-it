<div class="panel-text">
    <h1>Development panel</h1>
</div>

<div class='float_btn'>
	<a class='btn btn-primary' href='<?= ROOT."/logout/"?>'>Logout</a>
</div>  

<div class='float_btn'>
	<a class='btn btn-primary' href='<?= ROOT."/comments/"; ?>'>Comments</a>
</div>

<form action="<?= ROOT.'/search/' ?>" method="get" name="search" style="margin-bottom:10px;">
  <div class="input-group col-lg-3">
    <input hidden name="dept" value="development">
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
			<th class="col-sm-2">Companyname</th>
			<th class="col-sm-2">Contact person</th>
			<th class="col-sm-2">Email</th>
			<th class="col-sm-2">Phone number</th>
			<th class="col-sm-2">Fax number</th>
			<th class="col-sm-2">Zipcode</th>
			<th class="col-sm-2">Residence</th>
			<th class="col-sm-2">Address</th>
			<th class="col-sm-2">Active projects</th>
			<th class="col-sm-2">Inactive projects</th>
			<th class="col-sm-2">Amount of projects</th>
		</tr>
	</thead>
	<tbody>
<?php
	foreach ($custQuery as $cust) {
		// Credit query
		$bind = ["nr" => $cust->CustomerNR];
		$query = $db->select("SELECT count(ProjectNR) AS ProjectAmount FROM Projects WHERE CustomerNR = :nr", $bind);

		echo "<tr><td>";
		echo $cust->CompanyName;
		echo "</td><td>";
		echo $cust->ContactPerson;
		echo "</td><td>";
		echo $cust->Email;
		echo "</td><td>";
		echo $cust->TelephoneNumber;
		echo "</td><td>";
		echo $cust->FaxNumber;
		echo "</td><td>";
		echo $cust->Zipcode;
		echo "</td><td>";
		echo $cust->Residence;
		echo "</td><td>";
		echo $cust->Address;
		echo "</td><td>";
		echo "<a href=\"".ROOT."/development/".$cust->CustomerNR."/active/\">View</a>";
		echo "</td><td>";
		echo "<a href=\"".ROOT."/development/".$cust->CustomerNR."/inactive/\">View</a>";
		echo "</td><td>";
		echo $query[0]->ProjectAmount;
		echo "</td><td></tr>";
	}
?>

	</tbody>
</table>

<?php
	} elseif(isset($_GET['cid']) && isset($_GET['action']) && $_GET['action'] == "active") {
?>
	
	<a href="<?= ROOT ?>/development/<?= $_GET['cid'] ?>/add/" class="btn btn-success">Add a project</a>

<table class='table table-striped'>
	<thead>
		<tr>
			<th class="col-sm-2">Project Name</th>
			<th class="col-sm-2">Maintenance Contract</th>
			<th class="col-sm-2">Hardware</th>
			<th class="col-sm-2">Software</th>
			<th class="col-sm-2">Edit</th>
			<th class="col-sm-2">Deactivate</th>
		</tr>
	</thead>

	<tbody>
		<?php
			foreach ($activeProjQuery as $proj) {
				echo "<tr>";
				
				if ($proj->StatusProject == "Suspended") {
					echo "<td class='project-susp' title='This project is suspended.'><span>".$proj->ProjectName."</span></td>";
				} else {
					echo "<td>".$proj->ProjectName."</td>";
				}

				echo "<td>".$proj->MaintenanceContract."</td>";
				echo "<td>".$proj->Hardware."</td>";
				echo "<td>".$proj->Software."</td>";
				echo "<td><a href=\"".ROOT."/development/".$_GET['cid']."/edit/".$proj->ProjectNR."/\">Edit</a></td>";
				echo "<td><a href=\"".ROOT."/development/".$_GET['cid']."/deactivate/".$proj->ProjectNR."/\">Deactivate</a></td>";
			}
		?>
	</tbody>
</table>

<?php
	} elseif(isset($_GET['cid']) && isset($_GET['action']) && $_GET['action'] == "inactive") {
?>

<table class='table table-striped'>
	<thead>
		<tr>
			<th class="col-sm-2">Project Name</th>
			<th class="col-sm-2">Maintenance Contract</th>
			<th class="col-sm-2">Hardware</th>
			<th class="col-sm-2">Software</th>
			<th class="col-sm-2">Activate</th>
		</tr>
	</thead>

	<tbody>
		<?php
			foreach ($inactiveProjQuery as $proj) {
				echo "<tr>";
				echo "<td>".$proj->ProjectName."</td>";
				echo "<td>".$proj->MaintenanceContract."</td>";
				echo "<td>".$proj->Hardware."</td>";
				echo "<td>".$proj->Software."</td>";
				echo "<td><a href=\"".ROOT."/development/".$_GET['cid']."/activate/".$proj->ProjectNR."/\">Activate</a></td>";
			}
		?>
	</tbody>
</table>

<?php	} elseif(isset($_GET['cid']) && isset($_GET['action']) && $_GET['action'] == "add") { ?>

<form action="<?= ROOT ?>/development/<?= $_GET['cid'] ?>/add/" method="post">
	<div class="form-group col-sm-6">
    <label for="ProjectName">Project Name</label>
    <input type="text" class="form-control" name="ProjectName" <?= isset($_POST['ProjectName']) ? "value='".$_POST['ProjectName']."'" : null ?>>   
  </div>

  <div class="form-group col-sm-6">
    <label for="MaintenanceContract">Maintenance Contract</label>
    <select class="form-control" name="MaintenanceContract" <?= isset($_POST['MaintenanceContract']) ? "style='border:1px solid red;'" : null ?>>
    	<option value="Y">Yes</option>
    	<option value="N">No</option>
    </select>
  </div>

  <div class="form-group col-sm-6">
  	<label for="Hardware">Hardware</label>
  	<input type="text" class="form-control" name="Hardware" <?= isset($_POST['Hardware']) ? "value='".$_POST['Hardware']."'" : null ?>>   
  </div>

  <div class="form-group col-sm-6">
  	<label for="Software">Software</label>
  	<input type="text" class="form-control" name="Software" <?= isset($_POST['Software']) ? "value='".$_POST['Software']."'" : null ?>>   
  </div>

  <div class="form-group col-sm-6">
    <input type="submit" name="addSubmit" class="btn btn-primary">   
   </div>
</form>

<?php } elseif(isset($_GET['cid']) && isset($_GET['action']) && $_GET['action'] == "edit") { ?>

<form action="<?= ROOT ?>/development/<?= $_GET['cid'] ?>/edit/<?= $_GET['proj'] ?>/" method="post">
	<div class="form-group col-sm-6">
    <label for="ProjectName">Project Name</label>
    <input type="text" class="form-control" name="ProjectName" value="<?= isset($_POST['ProjectName']) ? $_POST['ProjectName'] : $selEdit[0]->ProjectName ?>">   
  </div>

  <div class="form-group col-sm-6">
    <label for="MaintenanceContract">Maintenance Contract</label>
    <select class="form-control" name="MaintenanceContract" style="border:1px solid red;">
    	<option value="Y">Yes</option>
    	<option value="N">No</option>
    </select>
  </div>

  <div class="form-group col-sm-6">
  	<label for="Hardware">Hardware</label>
  	<input type="text" class="form-control" name="Hardware" value="<?= isset($_POST['Hardware']) ? $_POST['Hardware'] : $selEdit[0]->Hardware ?>">   
  </div>

  <div class="form-group col-sm-6">
  	<label for="Software">Software</label>
  	<input type="text" class="form-control" name="Software" value="<?= isset($_POST['Software']) ? $_POST['Software'] : $selEdit[0]->Software ?>">   
  </div>

  <div class="form-group col-sm-6">
    <input type="submit" name="editSubmit" class="btn btn-primary">   
  </div>
</form>

<?php } ?>

<?php if (isset($_GET['cid'])) : ?>
<a href="<?= ROOT ?>/development/" class="btn btn-primary" style="float:left;">Go back</a>
<?php endif; ?>

<?php if ($_SESSION['role'] == 1): ?>
<a href="<?= ROOT ?>/admin/" class="btn btn-primary" style="float:left;">Back to admin page</a>
<?php endif; ?>