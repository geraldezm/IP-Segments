<?php

include ('db.php');
	
	#identify the row with the same ID
	$id = $_GET['id'];

	#delete row with the same ID
	$r = $db->query("DELETE FROM elastic_cloud WHERE ecseg_id like $id");
	
	#redirect back to elastic.php
	header("location: elastic.php");
?>