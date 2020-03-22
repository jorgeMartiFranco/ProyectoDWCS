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
           

<?php if((isset($_GET['date1']) and isset($_GET["date2"]))) {
    ?>
            
             
        <?php
    
        \MobilitySharp\controller\findMobilitiesBetweenDates();
    
    ?>

             </div>
    
   <?php 
} else if(isset($_SESSION)){
?>
                <div class="container-fluid my-3 my-lg-5 mx-3 mx-lg-5">
<div class="row border-bottom border-dark">
    <form class="col mb-3 mb-lg-5 " method="GET" action="findMobilities.php">
        <div class="form-group ">
            <div class="row border-bottom border-dark ">
                <div class="col "><h2 for="dbSearch">Search mobilities</h2></div></div>
                <div class="row justify-content-center mt-3"><div class="col col-12 col-lg-5 col-xl-3"><h4>Start date</h4></div><div class="col col-12 col-lg-5 col-xl-3"><h4>Estimated end date</h4></div></div>
                <div class="row justify-content-center mt-3"><div class="col col-12 col-lg-5 col-xl-3">
                        <input class="form-control" type="date" id="date1" name="date1"></div>
                        <div class="col col-12 col-lg-5 col-xl-3"><input class="form-control" type="date" id="date2" name="date2"></div>    
                </div>
            
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-secondary w-25">Search</button>
        </div>
    </form>
</div>
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