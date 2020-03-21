
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
                <div class="container">
<div class="row">
    <form class="col col-md-10 col-lg-8 col-xl-6 mx-auto my-5 " method="GET" action="findMobilities.php">
        <div class="form-group">
            <div class="row">
                <div class="col border-bottom border-dark"><h2 for="dbSearch">Search mobilities</h2></div></div>
                <div class="row"><div class="col">
                        <input class="form-control mt-3" type="date" id="date1" name="date1"></div>
                        <div class="col"><input class="form-control mt-3" type="date" id="date2" name="date2"></div>    
                </div>
            
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-secondary w-50">Search</button>
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