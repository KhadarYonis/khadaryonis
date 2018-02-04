<?php 
	include('functions/database.php'); 

	function get_descriptions() {
		global $db;

		$sql2 = "SELECT *			
			FROM description
			order by posts.date DESC
			";
		$req = $db->query($sql2);

		$results = array();

		while ($rows = $req->fetchObject()) {
			# code...
			$results[] = $rows;
		}
		return $results;
	}
?>