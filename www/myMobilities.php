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
            <?php
            if(controller\partnerMobilities()){
            ?>
            <div class="row border-bottom border-dark"><div class="col"><h2>Your mobilities</h2></div></div>
            
       
            <?php
                    controller\listPartnerMobilities();
                    
            }
            else {
        ?>
            <div class="container mt-3 pt-3 mb-3 mb-lg-5">
                <div class="row border-bottom border-dark"><div class="col"><h4>You have to register at least one mobility.</h4></div></div>
                <ul>
                    <li><div class="row text-left m-3"><div class="col"><h5><a href="registerEnterpriseMobility.php">Register enterprise mobility</a></h5></div></div></li>
                    <li><div class="row text-left m-3"><div class="col"><h5><a href="registerInstitutionMobility.php">Register institution mobility</a></h5></div></div></li>

                </ul>
                </div>
            <?php
            }
            ?>
            </div>
        </div>
        <?php include "footer.html";?>
    </body>
</html>