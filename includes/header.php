<?php
	require "application/config.php";
	require "application/functions.php";
	require "lib/Database.php";
	$db = new Database(HOST, DBNAME, USER, PASS);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title><?= $title." / Barroc IT" ?></title>
		<link rel="stylesheet" type="text/css" href="<?= ASSETS ?>/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?= ASSETS ?>/css/style.css">
		<script type="text/javascript" src="<?= ASSETS ?>/js/jquery-1.11.1.min.js"></script>
	</head>
<body>


<div class="pageheader">		
	<img src="<?= ASSETS ?>/img/banner.png" id="banner" />
	<div class="container">
		<div class="banner">
			<h1>BARROC IT.</h1>
			<h1>SOFTWARE FOR REAL.</h1>
		</div>
	</div>
</div>
<div class="maincontent">
	<div class="container">