
<html>
    <title>Mobility&sharp;</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, user-scalable=no" />
                <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="css/custom.css" />
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.bundle.min.js"></script>
		<script src="js/custom.js"></script>
        <body>
<?php
include "controller\db.php";
include "header.php";

if((isset($_GET['enterpriseName']) or !empty($_GET["enterpriseName"]))) {
    ?>
        <?php
    
    \MobilitySharp\controller\searchInstitutionsAdvanced();
    
    ?>


    
   <?php 
} else if(isset($_SESSION)){
?>
<div class="row">
    <form class="col col-md-10 col-lg-8 col-xl-6 mx-auto my-5" method="GET" action="advancedSearch.php">
        <div class="form-group text-center">
            <h1 for="dbSearch">Search institutions advanced</h1>
            <input class="form-control mt-3" type="text" id="dbSearch" placeholder="Institution name" name="enterpriseName">     
                
            
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
include "footer.html";
?>
            
        </body>
</html>