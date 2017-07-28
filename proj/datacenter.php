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

 <div class="dc container">
<p>Management IPs</p>

<a href="newrecorddc.php" type="button" class="btn btn-default btn-sm" id="elastic-add">Add Record</a>

<table class="table-bordered table-hover table" id="table" style="margin-top:10px; margin-left:10px; margin-bottom: 10px;">

<tr>
        <th>Data Center</th>
        <th>IP Range</th>
        <th></th>
</tr>

<?php

    $db = new mysqli('localhost', 'root', '', 'ip_segments');
    $query = $db->query("SELECT dcseg_id, dc, ip_range FROM dc");

        if ($query->num_rows) {
            while ($r = $query->fetch_object()) {
                echo "<tr>";
                echo "<td>".$r->dc."</td>";
                echo "<td>".$r->ip_range."</td>";
                echo "<td><a href='deldc.php?id=".$r->dcseg_id."' class='btn btn-danger' id='dc' role='button'>Delete</a></td>";
                echo "</tr>";
            }
        }
    
?>
</table>
</div>


    </body>
</html>