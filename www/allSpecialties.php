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
            <div class="row border-bottom border-dark"><div class="col"><h2>Specialties</h2></div></div>
            
       
            <?php
                    controller\listAllSpecialties();
        ?>
            </div>
        </div>
        <?php include "footer.html";?>
    </body>
</html>

