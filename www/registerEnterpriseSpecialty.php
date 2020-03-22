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
        <div class="container-fluid mt-3 mt-lg-5 mx-3 mx-lg-5 mb-3 mb-lg-5">
            <?php
            if(controller\getPartnerEnterprises()){
            ?>
            <div class='row justify-content-center border-bottom border-dark'><div class='col'><h2>Register new enterprise specialty</h2></div></div>
            <div class="container border-bottom border-dark mb-3 mb-lg-5">
                
                <form method="POST" id="studentSpecialty" action="registerEnterpriseSpecialty.php">
                   
                    <div class="form-row justify-content-center">
                        <div class="col-12 col-sm col-md-5 col-lg-4 mx-md-3 my-2 my-md-3">
                            <h4>Enterprise</h4>
                            
                            
                        </div>
                        <div class="col-12 col-sm col-md-5 col-lg-4 mx-md-3 my-2 my-md-3">
                            <h4>Specialty</h4>
                            
                        </div>
                    </div>
                    <div class="form-row justify-content-center">
                        <div class="col-12 col-sm col-md-5 col-lg-4 mx-md-3">
                            <select class="form-control" name="enterprise">
                                <option class="disabled">Select enterprise...</option>
                                <?php
                                            \MobilitySharp\controller\partnerEnterprises();
                                ?>
                            </select>
                        </div>
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
                        </div>
            <?php
            }
            else {
                ?>
            <div class="container mt-3 pt-3">
                <div class="row border-bottom border-dark"><div class="col"><h4>You have to register at least one enterprise.</h4></div></div>
                <ul>
                    <li><div class="row text-left m-3 "><div class="col"><h5><a href="registerEnterprise.php">Register enterprise</a></h5></div></div></li>
                </ul>
                </div>
            <?php
            }
            ?>
        </div>
        </div>
        
        <?php 
        } else {
            controller\insertEnterpriseSpecialty();
            header("Location:index.php");
        }
        ?>
        <?php include 'footer.html' ?>
    </body>
</html>
