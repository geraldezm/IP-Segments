<?php
require 'db.php';

#gets the data input by the user
$regional = $db->real_escape_string($_POST["global"]); #owner
$site = $db->real_escape_string($_POST["globalsite"]); #site
$users = $db->real_escape_string($_POST["users"]); #user
$deviceip = $db->real_escape_string($_POST["globalip"]); #ip
$network = $db->real_escape_string($_POST["globalnet"]); #network


#query to add the data to the database
$query   = "INSERT into global_ip (regional, site, users, device_ip, network) VALUES('" . $regional. "','" . $site . "','" . $users . "', '".$deviceip."', '".$network."')";

#if query is a success
$success = $db->query($query);

if (!$success) {
    die("Couldn't enter data: ".$db->error);

}
echo "<br/>Entry Submitted! <br/>";
header("location:global.php");

mysqli_close($conn);
?>