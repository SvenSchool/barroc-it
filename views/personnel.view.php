<div class="panel-text">
    <h1>P&amp;O panel</h1>
</div>

<div class='float_btn'>
	<a class='btn btn-primary' href='<?= ROOT."/logout/" ?>'>Logout</a>
</div>  

<div class='float_btn'>
	<a class='btn btn-primary' href='<?= ROOT."/comments/" ?>'>Comments</a>
</div>

<form action="<?= ROOT.'/search/' ?>" method="get" name="search" style="margin-bottom:10px;">
  <div class="input-group col-lg-3">
    <input hidden name="dept" value="personnel">
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


<?php if (!isset($_GET['uid'])) { ?>
  <table class="table table-striped">
    <thead>
      <th>User ID</th>
      <th>Username</th>
      <th>Amount of portfolios</th>
      <th>View</th>
    </thead>
    <tbody>
      <?php
        foreach ($userQuery as $row) {
          $bind = ["uid" => $row->uid];
          $query = $db->select("SELECT Count(uid) AS Amount FROM portfolios WHERE uid = :uid", $bind);
          echo "<tr>";
          echo "<td>".$row->uid."</td>";
          echo "<td>".$row->username."</td>";
          echo "<td>".$query[0]->Amount."</td>";
          echo "<td><a href=\"".ROOT."/personnel/".$row->uid."/\">View</a></td>";
          echo "</tr>";
        }
      ?>
    </tbody>
  </table>
<?php } elseif(isset($_GET['uid']) && !isset($_GET['action'])) { ?>
  <a href="<?= ROOT ?>/personnel/<?= $_GET['uid'] ?>/add/" class="btn btn-primary">Add</a>

  <table class="table table-striped">
    <thead>
      <th>Type</th>
      <th>Starting date</th>
      <th>Ending date</th>
      <th>Description</th>
      <th>Comments</th>
      <th>Edit</th>
    </thead>
    <tbody>
      <?php
        foreach ($userPortQuery as $row) {
          echo "<tr>";
          echo "<td>".$row->type."</td>";
          echo "<td>".date("l jS F Y", $row->begin_date)."</td>";
          echo "<td>".date("l jS F Y", $row->end_date)."</td>";
          echo "<td>".$row->descr."</td>";
          echo "<td>".$row->comments."</td>";
          echo "<td><a href='".ROOT."/personnel/".$row->uid."/edit/".$row->id."/'>Edit</a></td>";
          echo "</tr>";
        }
      ?>
    </tbody>
  </table>

<?php } elseif(isset($_GET['uid']) && isset($_GET['action']) && $_GET['action'] == "add") { ?>

  <form action="<?= ROOT."/personnel/".$_GET['uid']."/add/" ?>" method="post">
    <div class="form-group col-sm-6">
      <label for="type">Portfolio type</label>
      <input type="text" class="form-control" name="portType" value="<?= isset($_POST['portType']) ? $_POST['portType'] : null ?>" >
    </div>

    <div class="form-group col-sm-6">
      <label for="type">Description</label>
      <textarea class="form-control" name="portDesc"><?= isset($_POST['portDesc']) ? $_POST['portDesc'] : null ?></textarea>
    </div>

    <div class="form-group col-sm-6">
      <label for="type">Begin date</label>
      <input type="date" class="form-control" name="portBegin" value="<?= isset($_POST['portBegin']) ? $_POST['portBegin'] : null ?>" >
    </div>

    <div class="form-group col-sm-6">
      <label for="type">End date</label>
      <input type="date" class="form-control" name="portEnd" value="<?= isset($_POST['portEnd']) ? $_POST['portEnd'] : null ?>" >
    </div>

    <div class="form-group col-sm-6">
      <label for="type">Comments</label>
      <textarea name="portCmnts" class="form-control"><?= isset($_POST['portCmnts']) ? $_POST['portCmnts'] : null ?></textarea>
    </div>

    <div class="form-group col-sm-6">
      <input type="submit" value="Submit" name="portAddSubmit" class="btn btn-primary">
    </div>
  </form>

<?php } elseif(isset($_GET['uid']) && isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['port'])) { ?>
  <form action="<?= ROOT."/personnel/".$_GET['uid']."/edit/".$_GET['port']."/" ?>" method="post">
    <div class="form-group col-sm-6">
      <label for="type">Portfolio type</label>
      <input type="text" class="form-control" name="portType" value="<?= isset($_POST['portType']) ? $_POST['portType'] : $portQuery[0]->type ?>" >
    </div>

    <div class="form-group col-sm-6">
      <label for="type">Description</label>
      <textarea class="form-control" name="portDesc"><?= isset($_POST['portDesc']) ? $_POST['portDesc'] : $portQuery[0]->descr ?></textarea>
    </div>

    <div class="form-group col-sm-6">
      <label for="type">Begin date</label>
      <input type="date" class="form-control" name="portBegin" value="<?= isset($_POST['portBegin']) ? $_POST['portBegin'] : date('Y-m-d', $portQuery[0]->begin_date) ?>" >
    </div>

    <div class="form-group col-sm-6">
      <label for="type">End date</label>
      <input type="date" class="form-control" name="portEnd" value="<?= isset($_POST['portEnd']) ? $_POST['portEnd'] : date('Y-m-d', $portQuery[0]->end_date) ?>" >
    </div>

    <div class="form-group col-sm-6">
      <label for="type">Comments</label>
      <textarea name="portCmnts" class="form-control"><?= isset($_POST['portCmnts']) ? $_POST['portCmnts'] : $portQuery[0]->comments ?></textarea>
    </div>

    <div class="form-group col-sm-6">
      <input type="submit" value="Submit" name="portEditSubmit" class="btn btn-primary">
    </div>
  </form>
<?php } ?>



<?php if (isset($_GET['uid'])) : ?>
<a href="<?= ROOT ?>/personnel/" class="btn btn-primary" style="float:left;">Go back</a>
<?php endif; ?>

<?php if ($_SESSION['role'] == 1): ?>
<a href="<?= ROOT ?>/admin/" class="btn btn-primary" style="float:left;">Back to admin page</a>
<?php endif ?>