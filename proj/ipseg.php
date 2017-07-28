<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="all" href="css/style.css">
    <link rel="stylesheet" type="text/css" media="all" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" media="all" href="css/bootstrap.min.css">
    <script src="boostrap.min.js"></script>
</head>

<body>

    <nav class="navbar navbar-inverse" id="nav">
        <ul class="nav navbar-nav" id="navb">
            <li><a href="index.php">Search</a></li>
            <li><a href="search.php">IP Segments</a></li>
        </ul>
    </nav>


<div class="elastic container">

<p>Elastic Cloud(SJC1,IAD1, MUC1, LHR1)</p>

<table class="table-bordered table-hover table" id="table" style="margin-top:10px; margin-left:10px; margin-bottom: 10px;">
	<tr>
		<thead>
		<th>Elastic Cloud DC</th>
		<th>Public Range</th>
		<th>Private Range</th>
		</thead>
	</tr>

<?php
require_once 'db.php';

	$db = new mysqli('localhost', 'root', '', 'ip_segments');

		$query = $db->query("SELECT ec_dc, ecpub_ip, ecpri_ip FROM elastic_cloud");

		if ($query->num_rows) {
 
			while ($r = $query->fetch_object()) {

				echo "<tr>";
				echo "<td>".$r->ec_dc."</td>";
				echo "<td>".$r->ecpub_ip."</td>";
				echo "<td>".$r->ecpri_ip."</td>";
				echo "</tr>";
			}
		}

?>
</table>
</div>



<div class="oz container">

<table class="table-bordered table-hover table-sm table" id="table" style="margin-top:10px; margin-left:10px; margin-bottom: 10px;">

	<tr>
		<thead>
		<th>Opencloud Availability Zone</th>
		<th>Public Range</th>
		<th>Private Range</th>
		</thead>
	</tr>

<?php
		$query = $db->query("SELECT oc_az, ocazpub_ip, ocazpri_ip FROM opencloud_az");

		if ($query->num_rows) {
			while ($r = $query->fetch_object()) {

				echo "<tr>";
				echo "<td>".$r->oc_az."</td>";
				echo "<td>".$r->ocazpub_ip."</td>";
				echo "<td>".$r->ocazpri_ip."</td>";
				echo "</tr>";
			}
		}


?>
</table>
</div>


<div class="dc container">
<p>Management IPs</p>
<table class="table-bordered table-hover table" id="table" style="margin-top:10px; margin-left:10px; margin-bottom: 10px;">

<tr>
		<th>Data Center</th>
		<th>IP Range</th>
</tr>

<?php
$query = $db->query("SELECT dc, ip_range FROM dc");

		if ($query->num_rows) {
			while ($r = $query->fetch_object()) {

				echo "<tr>";
				echo "<td>".$r->dc."</td>";
				echo "<td>".$r->ip_range."</td>";
				echo "</tr>";
			}
		}
	
?>
</table>
</div>


<div class="global container">
<p>Global IP List</p>

<table class="table-bordered table-hover table" id="table" style="margin-top:10px; margin-left:10px; margin-bottom: 10px;">
	<tr>
		<th>Regional</th>
		<th>Site</th>
		<th>User</th>
		<th>Device IP</th>
		<th>Network</th>
	</tr>

<?php
	$query = $db->query("SELECT regional, site, users, device_ip, network FROM global_ip");

		if ($query->num_rows) {
			while ($r = $query->fetch_object()) {

				echo "<tr>";
				echo "<td>".$r->regional."</td>";
				echo "<td>".$r->site."</td>";
				echo "<td>".$r->users."</td>";
				echo "<td>".$r->device_ip."</td>";
				echo "<td>".$r->network."</td>";
				echo "</tr>";
			}
		}
?>
</table>
</div>

</body>
</html>

