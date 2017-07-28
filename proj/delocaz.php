<?php

include ('db.php');
	
	#get the id of the row user wants to delete
	$id = $_GET['id'];

	#query to delete the row with the same id
	$r = $db->query("DELETE FROM opencloud_az WHERE ocazseg_id like $id");
	
	#redirect back to ocaz.php
	header("location: ocaz.php");
?>