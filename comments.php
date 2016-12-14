<?php
	session_start();
	$title = "Login";
	require "includes/header.php";

	# LOGIC
	$cmntsQuery = $db->select("SELECT * FROM comments ORDER BY id DESC");

	if (!empty($_POST['subject']) && !empty($_POST['descr']) && isset($_POST['cmntSubmit'])) {
		$bind = [
			"sub" => htmlspecialchars($_POST['subject']),
			"des" => htmlspecialchars($_POST['descr']),
			"dat" => strtotime("now")
		];
		$cmntInsertQuery = $db->insert("INSERT INTO comments (Subject, Description, `Date`) VALUES (:sub, :des, :dat)", $bind);

		if ($cmntInsertQuery) {
			setMsg("Successfully added your comment!", 1);
			header("location:".ROOT."/comments/");
			die();
		}
	}

	require "views/comments.view.php";
	require "includes/footer.php";

	unset($_SESSION['msg']);
	unset($_SESSION['msglvl']);
?>