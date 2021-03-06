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

<div class="elastic container">

<h1>Elastic Cloud(SJC1,IAD1, MUC1, LHR1)</h1>

<a href="newrecordec.php" type="button" class="btn btn-default btn-sm" id="elastic-add">Add Record</a>

<table class="table table-bordered table-hover" id="table" style="margin-top:10px; margin-left:10px; margin-bottom: 10px;">
    <tr>
        <thead>
        <th>Elastic Cloud DC</th>
        <th>Public Range</th>
        <th>Private Range</th>
        <th> </th>
        </thead>
    </tr>

    

<?php

require_once 'db.php';

    $db = new mysqli('localhost', 'root', '', 'ip_segments');

        

        $query = $db->query("SELECT ecseg_id, ec_dc, ecpub_ip, ecpri_ip FROM elastic_cloud");

        if ($query->num_rows) {
 
            while ($r = $query->fetch_object()) {

                echo "<tr>";
                echo "<td>".$r->ec_dc."</td>";
                echo "<td>".$r->ecpub_ip."</td>";
                echo "<td>".$r->ecpri_ip."</td>";
                echo "<td><a href='delelastic.php?id=".$r->ecseg_id."' class='btn btn-danger' id='elastic' role='button'>Delete</a></td>";
                echo "</tr>";
            }
        }



?>

</table>

</div>
    </body>
</html>