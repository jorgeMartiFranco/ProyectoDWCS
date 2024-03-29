<?php
require_once 'controller/sessions.php';
include_once 'controller/db.php';
use MobilitySharp\controller;
use MobilitySharp\controller\sessions;

sessions\startSession();
sessions\checkLogin();
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
        <div class="container-fluid my-3 my-lg-5 mx-3 mx-lg-5 border-bottom border-dark"> 
            <?php
            if(controller\partnerMobilities()){
            ?>
            <div class="row border-bottom border-dark"><div class="col"><h2>Your mobilities</h2></div></div>
            
       
            <?php
                    controller\listPartnerMobilities();
                    
            }
            else {
        ?>
            <section class="container mt-3 pt-3 mb-3 mb-lg-5">
                <div class="row border-bottom border-dark"><div class="col"><h4>You have to register at least one mobility.</h4></div></div>
                <ul>
                    <li><div class="row text-left m-3"><div class="col"><h5><a href="registerEnterpriseMobility.php">Register enterprise mobility</a></h5></div></div></li>
                    <li><div class="row text-left m-3"><div class="col"><h5><a href="registerInstitutionMobility.php">Register institution mobility</a></h5></div></div></li>

                </ul>
            </section>
            <?php
            }
            ?>
            </div>
        </div>
        <?php include "footer.html";?>
    </body>
</html>