<?php
require 'db.php';

#gets the data input by the user
$ocaz = $db->real_escape_string($_POST["ocaz"]); #owner
$ocazpub = $db->real_escape_string($_POST["ocazpub"]); #public ip
$ocazpri = $db->real_escape_string($_POST["ocazpri"]); #private ip


#add into database
$query   = "INSERT into opencloud_az (oc_az, ocazpub_ip, ocazpri_ip) VALUES('" . $ocaz. "','" . $ocazpub . "','" . $ocazpri . "')";
$success = $db->query($query); #if query was a success

if (!$success) {
    die("Couldn't enter data: ".$db->error);

}
echo "<br/>Entry Submitted! <br/>";

#redirect back to ocaz.php
header("location:ocaz.php");

mysqli_close($conn);
?>