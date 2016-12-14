<?php
	class Database {
		// Properties:
		private $host;
		private $dbname;
		private $user;
		private $pass;

		private $error;
		private $stmt;
		private $con;

		// Methods:

		public function __construct($host, $dbname, $user, $pass) {
			$this->host = $host;
			$this->dbname = $dbname;
			$this->user = $user;
			$this->pass = $pass;

			try {
				$this->con = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname, $this->user, $this->pass);
				$this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				$this->error = $e->getMessage();
				return $this->error;
			}
		}

		public function insert($query, $bind) {
			$this->stmt = $this->con->prepare($query);
			if($this->stmt->execute($bind)) {
				return true;
			}
		}


		public function update($query, $bind) {
			$this->stmt = $this->con->prepare($query);
			if ($this->stmt->execute($bind)) {
				return true;
			} else {
				return false;
			}
		}

		public function select($query, $bind = null) {
			$this->stmt = $this->con->prepare($query);
			
			if ($bind) {
				$this->stmt->execute($bind);
			} else {
				$this->stmt->execute();
			}

			return $this->stmt->fetchAll(PDO::FETCH_OBJ);
		}

		public function getRows() {
			return $this->stmt->rowCount();
		}
	}
?>