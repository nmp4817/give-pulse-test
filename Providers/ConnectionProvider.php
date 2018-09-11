<?php

class ConnectionProvider {

	public $connection;

	public function getMySQLConnection() {
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

		$servername = "127.0.0.1:3306";
		$username = "root";
		$password = "";
		$database = "givepulse_test";

		try {
			if ($mysqli = new mysqli($servername,$username,$password,$database)) {
				$this->connection = $mysqli;
			} else {
				throw new Exception('Unable to connect');
			}
		} catch(Exception $e) {
			echo '<h1>'.$e->getMessage().'</h1>';
		}

	}
}