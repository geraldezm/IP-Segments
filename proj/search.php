<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="all" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="all" href="css/style.css">
    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body>

    <nav class="navbar navbar-inverse" id="nav">
        <ul class="nav navbar-nav" id="navb">
            <li><a href="index.php">Search</a></li>
            <li><a href="search.php">IP Segments</a></li>
        </ul>
    </nav>


<?php

require_once 'db.php';

	$db = new mysqli('localhost', 'root', '', 'ip_segments');

	if (isset($_GET['keywords'])) {

		$keywords = $db->escape_string($_GET['keywords']);

		$query = $db->query("SELECT ec_dc, ecpub_ip, ecpri_ip FROM elastic_cloud WHERE ec_dc like '%".$keywords."%' OR ecpub_ip like '%".$keywords."%' OR ecpri_ip like '%".$keywords."%' ");

		if ($query->num_rows) {
 
			while ($r = $query->fetch_object()) {

				echo "Owner:".$r->ec_dc."<br>";
				echo "Public Range:".$r->ecpub_ip."<br>";
				echo "Private Range:".$r->ecpri_ip."<br>";
				echo "Description:";
				echo "<br><br>";
			}
		}
	}

	if (isset($query)) {

		$keywords = $db->escape_string($_GET['keywords']);

		$query = $db->query("SELECT sdi_sp, sdisppub_ip, sdisppri_ip FROM sdi_sp WHERE sdi_sp like '%".$keywords."%' OR sdisppub_ip like '%".$keywords."%' OR sdisppri_ip like '%".$keywords."%' ");

		if ($query->num_rows) {
			while ($r = $query->fetch_object()) {

				echo "Owner:".$r->sdi_sp."<br>";
				echo "Public Range:".$r->sdisppub_ip."<br>";
				echo "Private Range:".$r->sdisppri_ip."<br>";
				echo "Description:";
				echo "<br><br>";
			}
		}
	}

	if (isset($query)) {

		$keywords = $db->escape_string($_GET['keywords']);

		$query = $db->query("SELECT dc, ip_range FROM dc WHERE dc like '%".$keywords."%' OR ip_range like '%".$keywords."%'");

		if ($query->num_rows) {
			while ($r = $query->fetch_object()) {

				echo "Data Center:".$r->dc."<br>";
				echo "IP Range:".$r->ip_range."<br>";
				echo "<br><br>";
			}
		}
	}

	if (isset($query)) {

		$keywords = $db->escape_string($_GET['keywords']);

		$query = $db->query("SELECT regional, site, users, device_ip, network FROM global_ip WHERE regional like '%".$keywords."%' OR site like '%".$keywords."%' OR users like '%".$keywords."%' OR device_ip like '%".$keywords."%' OR network like '%".$keywords."%'");

		if ($query) {
		if ($query->num_rows) {

			while ($r = $query->fetch_object()) {
				echo "Regional:".$r->regional."<br>";
				echo "Site:".$r->site."<br>";
				echo "User:".$r->users."<br>";
				echo "Device IP:".$r->device_ip."<br>";
				echo "Network:".$r->network."<br>";
				echo "<br><br>";
			}
		}
	}
}

?>

</body>
</html>

