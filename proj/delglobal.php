<?php

include ('db.php');
	
	#identify the row with the same id
	$id = $_GET['id'];

	#query to delete the row with the same ID
	$r = $db->query("DELETE FROM global_ip WHERE globalseg_id like $id");
	
	#redirect back to global.php
	header("location: global.php");
?>