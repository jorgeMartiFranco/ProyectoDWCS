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
        <div class="container-fluid my-3 my-lg-5 mx-3 mx-lg-5 border-bottom border-dark">
            <?php
            if(controller\partnerStudents()){
                
            
            ?>
            <div class="row border-bottom border-dark"><div class="col"><h2>Your students</h2></div></div>
            
       
            <?php
                    controller\listPartnerStudents();
            }
            else {
        ?>
            <section class="container mt-3 pt-3 mb-3 mb-lg-5">
                <div class="row"><div class="col"><h4>You have to register at least one student.</h4></div></div>
                <ul>
                    <li><div class="row text-left m-3"><div class="col"><h5><a href="registerStudent.php">Register student</a></h5></div></div></li>
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