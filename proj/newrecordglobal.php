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

    <div class="container col-xs-3">
        
    <form action="addglobal.php" method="post">
    Regional: <input type="text" name="global" class="form-control input-sm">
    Site: <input type="text" name="globalsite" class="form-control input-sm">
    Users: <input type="text" name="globaluser" class="form-control input-sm">
    Device IP: <input type="text" name="globalip" class="form-control input-sm">
    Network: <input type="text" name="globalnet" class="form-control input-sm">

    <button class='btn btn-default' id='sbmt-ec' role='button'>Add</button>
    </form>

    </div>

    </body>
</html>