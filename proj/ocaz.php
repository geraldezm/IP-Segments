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

<a href="newrecordocaz.php" type="button" class="btn btn-default btn-sm" id="elastic-add">Add Record</a>

<table class="table-bordered table-hover table-sm table" id="table" style="margin-top:10px; margin-left:10px; margin-bottom: 10px;">

    <tr>
        <thead>
        <th>Opencloud Availability Zone</th>
        <th>Public Range</th>
        <th>Private Range</th>
        <th></th>
        </thead>
    </tr>

<?php
        
        #connect to database
        $db = new mysqli('localhost', 'root', '', 'ip_segments');

        #database query
        $query = $db->query("SELECT ocazseg_id, oc_az, ocazpub_ip, ocazpri_ip FROM opencloud_az");

        #if query has results
        if ($query->num_rows) {
            #queried object will be placed in $r
            while ($r = $query->fetch_object()) {

                echo "<tr>";
                echo "<td>".$r->oc_az."</td>";
                echo "<td>".$r->ocazpub_ip."</td>";
                echo "<td>".$r->ocazpri_ip."</td>";
                echo "<td><a href='delocaz.php?id=".$r->ocazseg_id."' class='btn btn-danger' id='dc' role='button'>Delete</a></td>";
                echo "</tr>";
            }
        }


?>
</table>
</div>
  
    </body>
</html>