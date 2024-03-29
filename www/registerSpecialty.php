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
    <script src="js/register.js"></script>
        <?php include "header.php";
        ?>
        
        
        <?php
        if(!isset($_POST) or empty($_POST)) {
        ?>
        <div class="wrapper">
    <?php
    include "sidenav.php";?>
        <div class="container-fluid my-3 my-lg-5 mx-3 mx-lg-5 border-bottom border-dark">
            <div class="row border-bottom border-dark"><div class="col"><h2>Insert new specialty</h2></div></div>
            
            <section class="container mb-3 mb-lg-5">
                
                <form method="POST" id="specialty" action="registerSpecialty.php">
                   
                           
                            
                                 <script>createFormInsertSpecialty();</script>
                                 
                             <div class="form-row justify-content-center">
                                <div class="col col-sm-6 col-md-5 col-lg-4 btn-group my-2 my-md-3" role="group"> 
                                    <button type="submit" class="btn btn-secondary rounded" id="submitRegister">Insert</button>
                                </div>
                                
                            </div>
            </form>
                        </section>
        </div>
        </div>
        
                    
                
            
       
        
        
        <?php 
        } else {
            controller\insertSpecialty();
            header("Location:index.php");
        }
        ?>
        <?php include 'footer.html' ?>
    </body>
</html>
