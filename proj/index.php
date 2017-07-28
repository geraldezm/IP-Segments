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


    <body class="trend">
    <!---HOME PAGE-->

    <nav class="navbar navbar-inverse" id="nav">
        <ul class="nav navbar-nav" id="navb">
            <li><a href="index.php">Search</a></li>
            <li><a href="ipseg.php">IP Segments</a></li>
        </ul>
    </nav>

        <form action="search5.php" method="get">
            <div class="col-xs-12 col-sm-3 input-group" id="frm">
                <input type="text" name="keywords" autocomplete="off" class="form-control" id="search" placeholder="Search"> 
                <div class="input-group-btn">
                <button type="submit" value="search" class="btn btn-default" id="btn"><i class="glyphicon glyphicon-search"></i></button>
                </div>
            </div>  
        </form>

        <div class="container">
        <button type="button" class="btn btn-success button" id="elastic" onclick="location.href = 'elastic.php';">Elastic</button>
        <button type="button" class="btn btn-success button" id="dc" onclick="location.href = 'datacenter.php';">Data Center</button>
        <button type="button" class="btn btn-success button" id="ocaz" onclick="location.href = 'ocaz.php';">Opencloud Availability Zone</button>
        <button type="button" class="btn btn-success button" id="global" onclick="location.href = 'global.php';">Global IP</button>
        </div>
        

    </body>
</html>