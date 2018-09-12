<?php

require_once 'Providers/ConnectionProvider.php';

class ImpactRepository {

	private $dbConnection;

	public function __construct() {
		$connectionProvider = new ConnectionProvider;
		$connectionProvider->getMySQLConnection();
		$this->dbConnection = $connectionProvider->connection;
	}

	public function getUsersByDuration($long, $lat) {
		
		$mysqli = $this->dbConnection;

		$select_query = "SELECT impacts.duration_hours, COUNT(user_id) FROM impacts WHERE impacts.user_id IN (SELECT user_id FROM users WHERE FLOOR(users.latitude) = FLOOR(?) AND FLOOR(users.longitude) = FLOOR(?)) GROUP BY impacts.duration_hours LIMIT 50";
		
		if ( $select_stmt = $mysqli->prepare($select_query)) {

            $select_stmt->bind_param("dd", $lat,$long);
            $select_stmt->execute();
            $result = $select_stmt->get_result();
            $select_stmt->close();
        }
        
        $finalResult = [];
        while ($row = $result->fetch_assoc()) {
        	$usersByDuration = [];
        	$usersByDuration["Duration"] = intval($row["duration_hours"]*60);
        	$usersByDuration["NumberOfUsers"] = $row["COUNT(user_id)"];
        	$finalResult[] = $usersByDuration;
		}

		return json_encode($finalResult);
    }
}
