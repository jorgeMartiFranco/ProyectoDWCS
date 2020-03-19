<?php
if((isset($_GET['enterpriseName']) or !empty($_GET["enterpriseName"]))) {
    include_once "controller\db.php";
?>
<html>
    <head>
        <title>Mobility&sharp;</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no" />
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
        <link rel="stylesheet" type="text/css" href="css/custom.css" />
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/custom.js"></script>
    </head>
    <body>
    <?php
        include "header.php";
        \MobilitySharp\controller\searchInstitutionsBasic();
        include "footer.html";
        ?>
    </body>
</html>
<?php 
} else if(isset($_SESSION)){
?>
<div class="row">
    <form class="col col-md-10 col-lg-8 col-xl-6 mx-auto my-5" method="GET" action="search.php">
        <div class="form-group">
            <label for="dbSearch">Search institutions</label>
            <input class="form-control" type="text" id="dbSearch" placeholder="Institution name" name="enterpriseName">
            <?php if(is_null($user)) { ?>
                <small id="dbSearchHelp" class="form-text text-muted">To perform more specific queries, registration is required</small>
            <?php } else { ?>
                <small class="form-text"><a  href="advancedSearch.php">Advanced search</a></small>
            <?php } ?>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-secondary w-50">Search</button>
        </div>
    </form>
</div>
<?php
} else {
    header('Location: /');
}
?>