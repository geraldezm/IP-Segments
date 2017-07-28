<?php
require 'db.php';

$dc = $db->real_escape_string($_POST["dc"]);
$iprange = $db->real_escape_string($_POST["iprange"]);


$query   = "INSERT into dc (dc, ip_range) VALUES('" . $dc. "','" . $iprange . "')";
$success = $db->query($query);

if (!$success) {
    die("Couldn't enter data: ".$db->error);

}
echo "<br/>Entry Submitted! <br/>";
header("location:datacenter.php");

mysqli_close($conn);
?>