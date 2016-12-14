<?php
  if (getMsg()) {
    echo getMsg();
  }
?>

<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="<?= ROOT ?>/sales/">Sales</a></li>
        <li><a href="<?= ROOT ?>/finance/">Finance</a></li>
        <li><a href="<?= ROOT ?>/development/">Dev</a></li>
        <li><a href="<?= ROOT ?>/personnel/">P&amp;O</a></li>
      </ul>

      <ul class="nav navbar-right navbar-nav">
      	<li><a href="<?= ROOT ?>/logout/">Logout</a></li>
      	<li><a href="<?= ROOT ?>/comments/">Comments</a></li>
      </ul>
    </div>
  </div>
</nav>
