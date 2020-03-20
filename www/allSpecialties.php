<?php
include_once 'controller/db.php';

use MobilitySharp\controller;
?>

<html>
    <?php
    include "head.html";
    ?>
    <body>
        <?php
        include "header.php";
        
        ?>
        <div class="wrapper">
    <?php
    include "sidenav.php";?>
        <div class="container-fluid mt-3 mt-lg-5 mx-3 mx-lg-5"> 
            <div class="row"><div class="col"><h2>Specialties</h2></div></div>
            
       
            <?php
                    controller\listAllSpecialties();
        ?>
            </div>
        </div>
        <?php include "footer.html";?>
    </body>
</html>

