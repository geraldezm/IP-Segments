<!DOCTYPE html>

<html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="all" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="all" href="css/style.css">
    <script src="https://code.jquery.com/jquery.js"></script>
    </head>


    <body>
    <nav class="navbar navbar-inverse" id="nav">
        <ul class="nav navbar-nav" id="navb">
            <li><a href="index.php">Search</a></li>
            <li><a href="ipseg.php">IP Segments</a></li>
        </ul>
    </nav>

        <form action="search.php" method="get">
            <div class="col-xs-12 col-sm-3 input-group" id="frm">
                <input type="text" name="keywords" autocomplete="off" class="form-control" id="search" placeholder="Search"> 
                <div class="input-group-btn">
                <button type="submit" value="search" class="btn btn-default" id="btn"><i class="glyphicon glyphicon-search"></i></button>
                </div>
            </div>  
        </form>
    </body>
</html>