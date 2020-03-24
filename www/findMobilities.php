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
                <div class="container-fluid my-3 my-lg-5 mx-3 mx-lg-5 border-bottom border-dark">
                   <div class='row justify-content-center border-bottom border-dark'><div class='col'><h2>Search mobilities</h2></div></div>
                   <section class="container mb-3 mb-lg-5 ">
                    <form class="col mb-3 mb-lg-5 " method="GET" action="findMobilities.php">
                        
                        <div class="form-row justify-content-center">
                        <div class="col-12 col-sm col-md-5 col-lg-4 mx-md-3 my-2 my-md-3">
                            <h4>Start date</h4>
                            <input class="form-control mt-3" type="date" name="date1" id="date1" required>
                            
                        </div>
                        <div class="col-12 col-sm col-md-5 col-lg-4 mx-md-3 my-2 my-md-3">
                            <h4>Estimated end date</h4>
                            <input class="form-control mt-3" type="date" name="date2" id="date2" required>
                        </div>
                            </div>
               
            
        </section>
        <div class="text-center">
            <button type="submit" class="btn btn-secondary w-25 mb-3 mb-lg-5">Search</button>
        </div>
    </form>
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