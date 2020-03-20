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
        <div class="container-fluid text-center mt-3 mt-lg-5"> <h1>Your mobilities</h1>
       
            <?php
                    controller\listPartnerMobilities();
        ?>
            </div>
        </div>
        <?php include "footer.html";?>
    </body>
</html>