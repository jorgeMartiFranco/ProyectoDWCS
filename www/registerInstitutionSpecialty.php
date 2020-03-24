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
            <?php
           
            ?>
            <div class='row justify-content-center border-bottom border-dark'><div class='col'><h2>Register new institution specialty</h2></div></div>
            <section class="container mb-3 mb-lg-5">
                
                <form method="POST" id="institutionSpecialty" action="registerInstitutionSpecialty.php">
                   
                    <div class="form-row justify-content-center">
                        
                        <div class="col-12 col-sm col-md-5 col-lg-4 mx-md-3 my-2 my-md-3">
                            <h4>Specialty</h4>
                            
                        </div>
                    </div>
                    <div class="form-row justify-content-center">
                        
                        <div class="col-12 col-sm col-md-5 col-lg-4 mx-md-3 ">
                            <select class="form-control" name="specialty">
                                <option class="disabled">Select specialty...</option>
                                <?php
                                  \MobilitySharp\controller\getAllSpecialties();
                                ?>
                            </select>
                        </div>
                    </div>
                            
                                 
                                 
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
            controller\insertInstitutionSpecialty();
            header("Location:index.php");
        }
        ?>
        <?php include 'footer.html' ?>
    </body>
</html>
