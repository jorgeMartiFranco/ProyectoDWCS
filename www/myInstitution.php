<?php
include_once 'controller/db.php';

use MobilitySharp\controller;
?>
<!DOCTYPE html>
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
            <div class="row border-bottom border-dark"><div class="col"><h2>Your institution</h2></div></div>
            
       
            <?php
        controller\listPartnerInstitution();
        ?>
            </div>
        </div>
        <?php include "footer.html";?>
    </body>
</html>