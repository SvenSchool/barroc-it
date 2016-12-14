<?php if ($_GET['dept'] == "development") { ?>
<table class='table table-striped'>
	<thead>
		<tr>
			<th class="col-sm-2">Projectname</th>
			<th class="col-sm-2">Hardware</th>
			<th class="col-sm-2">Software</th>
			<th class="col-sm-2">Active</th>
			<th class="col-sm-2">Inactive</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if ($searchQuery) {
				foreach ($searchQuery as $row) {
					echo "<tr>";
					echo "<td>".$row->ProjectName."</td>";
					echo "<td>".$row->Hardware."</td>";
					echo "<td>".$row->Software."</td>";
					echo "<td><a href='".ROOT."/development/".$row->CustomerNR."/active/'>View</a></td>";
					echo "<td><a href='".ROOT."/development/".$row->CustomerNR."/inactive/'>View</a></td>";
					echo "</tr>";
				}
			} else {
				echo "Your search query came up with no results! :(";
			}
		?>
	</tbody>
</table>
<?php } elseif($_GET['dept'] == "finance") { ?>
<table class='table table-striped'>
	<thead>
		<tr>
			<th class="col-sm-2">Companyname</th>
			<th class="col-sm-2">Bankaccount Number</th>
			<th class="col-sm-2">Unpaid</th>
			<th class="col-sm-2">Paid</th>
			<th class="col-sm-2">Edit</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if ($searchQuery) {
				foreach ($searchQuery as $row) {
					echo "<tr>";
					echo "<td>".$row->CompanyName."</td>";
					echo "<td>".$row->BankaccountNr."</td>";
					echo "<td><a href='".ROOT."/finance/".$row->CustomerNR."/active/'>View</a></td>";
					echo "<td><a href='".ROOT."/finance/".$row->CustomerNR."/inactive/'>View</a></td>";
					echo "<td><a href='".ROOT."/finance/".$row->CustomerNR."/edit/'>Edit</a></td>";
					echo "</tr>";
				}
			} else {
				echo "Your search query came up with no results! :(";
			}
		?>
	</tbody>
</table>
<?php } elseif($_GET['dept'] == "sales") { ?>
<table class='table table-striped'>
	<thead>
		<tr>
			<th class="col-sm-2">Companyname</th>
			<th class="col-sm-2">Contact person</th>
			<th class="col-sm-2">Email</th>
			<th class="col-sm-2">Open appointments</th>
			<th class="col-sm-2">Closed appointments</th>
			<th class="col-sm-2">View</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if ($searchQuery) {
				foreach ($searchQuery as $row) {
					echo "<tr>";
					echo "<td>".$row->CompanyName."</td>";
					echo "<td>".$row->ContactPerson."</td>";
					echo "<td><a href='mailto:".$row->Email."'>".$row->Email."</a></td>";
					echo "<td><a href='".ROOT."/sales/".$row->CustomerNR."/open/'>View</a></td>";
					echo "<td><a href='".ROOT."/sales/".$row->CustomerNR."/closed/'>View</a></td>";
					echo "<td><a href='".ROOT."/sales/".$row->CustomerNR."/'>Edit</a></td>";
					echo "</tr>";
				}
			} else {
				echo "Your search query came up with no results! :(";
			}
		?>
	</tbody>
</table>
<?php } elseif($_GET['dept'] == "personnel") { ?>
<table class='table table-striped'>
	<thead>
		<tr>
			<th class="col-sm-2">Type</th>
			<th class="col-sm-2">Description</th>
			<th class="col-sm-2">Begin date</th>
			<th class="col-sm-2">End date</th>
			<th class="col-sm-2">Comments</th>
			<th class="col-sm-2">View</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if ($searchQuery) {
				foreach ($searchQuery as $row) {
					echo "<tr>";
					echo "<td>".$row->type."</td>";
					echo "<td>".$row->descr."</td>";
					echo "<td>".date($row->begin_date)."</td>";
					echo "<td>".date($row->end_date)."</td>";
					echo "<td>".$row->comments."</td>";
					echo "<td><a href='".ROOT."/personnel/".$row->uid."/'>View</a></td>";
					echo "</tr>";
				}
			} else {
				echo "Your search query came up with no results! :(";
			}
		?>
	</tbody>
</table>
<?php } ?>

<a href="<?= ROOT ?>" class="btn btn-primary">Back</a>