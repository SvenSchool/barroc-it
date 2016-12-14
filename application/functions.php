<?php
	function setMsg($msg, $msglvl) {
		$_SESSION['msg'] = $msg;
		$_SESSION['msglvl'] = $msglvl;
	}

	function getMsg() {
		if (isset($_SESSION['msg']) && isset($_SESSION['msglvl'])) {
			$lvl = $_SESSION['msglvl'];
			$msg = $_SESSION['msg'];

			switch ($lvl) {
				case 1:
					return "<div class='alert alert-success' style='margin-top:10px;' role='alert'>".$msg."</div>";
					break;

				case 2:
					return "<div class='alert alert-warning' style='margin-top:10px;' role='alert'>".$msg."</div>";
					break;

				case 3:
					return "<div class='alert alert-danger' style='margin-top:10px;' role='alert'>".$msg."</div>";
					break;
				
				default:
					return false;
			}
		} else {
			return false;
		}
	}

?>