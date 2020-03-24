<!DOCTYPE html>
<html>
    <?php
    include "head.html";
    ?>
        <body>
<?php
include "controller\db.php";
include "header.php";
?>
           
<div class="wrapper">
    <?php
    include "sidenav.php";?>
<?php if((isset($_GET['enterpriseName']) or !empty($_GET["enterpriseName"]))) {
    ?>
             
        <?php
    
    \MobilitySharp\controller\searchInstitutionsAdvanced();
    
    ?>


    
   <?php 
} else if(isset($_SESSION)){
?>
<div class="container-fluid my-3 my-lg-5 mx-3 mx-lg-5 border-bottom border-dark">
    <div class="row border-bottom border-dark"><div class="col"><h2 for="dbSearch">Search institutions advanced</h2></div></div>
<section class="container">
<div class="row">
    <form class="col col-md-10 col-lg-8 col-xl-6 mx-auto my-5" method="GET" action="advancedSearch.php">
        <div class="form-group">
            
            <input class="form-control mt-3" type="text" id="dbSearch" placeholder="Institution name" name="enterpriseName">     
                
            
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-secondary w-50">Search</button>
        </div>
    </form>
</div>
                </section>
            </div>
</div>
<?php

} else {
    header('Location: /');
}
include "footer.html";
?>
            
        </body>
</html>