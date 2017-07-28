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
        
    <form action="addelastic.php" method="post">
    Data Center: <input type="text" name="ec" class="form-control input-sm">
    Public IP Range:<input type="text" name="ecpub" class="form-control input-sm">
    Private IP Range: <input type="text" name="ecpri" class="form-control input-sm">

    <button class='btn btn-default' id='sbmt-ec' role='button'>Add</button>
    </form>

    </div>

    </body>
</html>