<?php
require 'db.php';

#gets data input by the user
$ec = $db->real_escape_string($_POST["ec"]); #owner
$ecpub = $db->real_escape_string($_POST["ecpub"]); #public ip
$ecpri = $db->real_escape_string($_POST["ecpri"]); #private ip


#query to add to the database
$query   = "INSERT into elastic_cloud (ec_dc, ecpub_ip, ecpri_ip) VALUES('" . $ec. "','" . $ecpub . "','" . $ecpri . "')";

#successful query
$success = $db->query($query);

if (!$success) {
    die("Couldn't enter data: ".$db->error);

}
echo "<br/>Entry Submitted! <br/>";
header("location:elastic.php");

mysqli_close($conn);
?>