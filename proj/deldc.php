<?php

include ('db.php');
	
	$id = $_GET['id'];

	$r = $db->query("DELETE FROM dc WHERE dcseg_id like $id");
	
	header("location: datacenter.php");
?>