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
        <?php include "header.php";
        ?>
        <script src="js/register.js"></script>
        
            <?php
        if(!isset($_POST) or empty($_POST)) {
        ?>
        <div class="wrapper">
    <?php
    include "sidenav.php";?>
        <div class="container-fluid my-3 my-lg-5 mx-3 mx-lg-5 border-bottom border-dark">
            <div class="row border-bottom border-dark"><div class="col"><h2>Insert new institution type</h2></div></div>
            
            <section class="container mb-3 mb-lg-5">
                
                <form method="POST" id="institutionType" action="registerInstitutionType.php">
                   
                           
                            
                    <script>createFormRegisterInstitutionType()</script>
                                 
                             <div class="form-row justify-content-center">
                                <div class="col col-sm-6 col-md-5 col-lg-4 btn-group my-2 my-md-3" role="group"> 
                                    <button type="submit" class="btn btn-secondary rounded ml-2 ml-md-3 ml-md-4" id="submitRegister">Insert</button>
                                </div>
                                
                            </div>
            </form>
                        </section>
        </div>
        </div>
        
                    
                
            
       
        
        
        <?php 
        } else {
            controller\insertInstitutionType();
            header("Location:index.php");
        }
        ?>
        <?php include 'footer.html' ?>
    </body>
</html>

