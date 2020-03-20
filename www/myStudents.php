<?php
include_once 'controller/db.php';

use MobilitySharp\controller;
?>

<html>
    <head>
        <?php
        include "head.html";
        ?>
    </head>
    <body>
        <?php
        include "header.php";
        
        ?>
        <div class="wrapper">
    <?php
    include "sidenav.php";?>
        <div class="container-fluid mt-3 mt-lg-5 mx-3 mx-lg-5">
            <div class="row"><div class="col"><h2>Your students</h2></div></div>
            
       
            <?php
                    controller\listPartnerStudents();
        ?>
            </div>
        </div>
        <?php include "footer.html";?>
    </body>
</html>