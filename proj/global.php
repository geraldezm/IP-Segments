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
            <li><a href="ipseg.php">IP Segments</a></li>
        </ul>
    </nav>

    <div class="oz container">

<div class="global container">
<p>Global IP List</p>

<a href="newrecordglobal.php" type="button" class="btn btn-default btn-sm" id="elastic-add">Add Record</a>

<table class="table-bordered table-hover table" id="table" style="margin-top:10px; margin-left:10px; margin-bottom: 10px;">
    <tr>
        <th>Regional</th>
        <th>Site</th>
        <th>User</th>
        <th>Device IP</th>
        <th>Network</th>
        <th></th>
    </tr>

<?php
    $db = new mysqli('localhost', 'root', '', 'ip_segments');
    $query = $db->query("SELECT globalseg_id, regional, site, users, device_ip, network FROM global_ip");

        if ($query->num_rows) {
            while ($r = $query->fetch_object()) {

                echo "<tr>";
                echo "<td>".$r->regional."</td>";
                echo "<td>".$r->site."</td>";
                echo "<td>".$r->users."</td>";
                echo "<td>".$r->device_ip."</td>";
                echo "<td>".$r->network."</td>";
                echo "<td><a href='delglobal.php?id=".$r->globalseg_id."' class='btn btn-danger' id='dc' role='button'>Delete</a></td>";
                echo "</tr>";
            }
        }
?>
</table>
</div>
  
    </body>
</html>
