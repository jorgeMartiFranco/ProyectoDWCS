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
            if(controller\listAllEnterprises() and controller\partnerStudents()){
            ?>
            <div class='row justify-content-center border-bottom border-dark'><div class='col'><h2>Register new enterprise mobility</h2></div></div>
            <section class="container mb-3 mb-lg-5 ">
                
                <form method="POST" id="enterpriseMobility" action="registerEnterpriseMobility.php">
                   
                    <div class="form-row justify-content-center">
                        <div class="col-12 col-sm col-md-5 col-lg-4 mx-md-3 my-2 my-md-3">
                            <h4>Start date</h4>
                            <input class="form-control mt-3" type="date" name="startDate" id="startDate" required>
                            
                        </div>
                        <div class="col-12 col-sm col-md-5 col-lg-4 mx-md-3 my-2 my-md-3">
                            <h4>Estimated end date</h4>
                            <input class="form-control mt-3" type="date" name="estimatedEndDate" id="estimatedEndDate" required>
                        </div>
                    </div>
                    <div class="form-row justify-content-center">
                        <div class="col-12 col-sm col-md-5 col-lg-4 mx-md-3 my-2 my-md-3">
                            <select class="form-control" name="enterprise">
                                <option class="disabled">Select enterprise...</option>
                                <?php
                                        \MobilitySharp\controller\getAllEnterprises();
                                ?>
                            </select>
                        </div>
                        <div class="col-12 col-sm col-md-5 col-lg-4 mx-md-3 my-2 my-md-3">
                            <select class="form-control" name="student">
                                <option class="disabled">Select student...</option>
                                <?php
                                  \MobilitySharp\controller\getPartnerStudents();
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
            <?php
            }
            else {
                ?>
            <section class="container border mt-3 pt-3">
                <div class="row"><div class="col"><h4>You have to register at least one student and one enterprise to perform mobilities</h4></div></div>
                <ul>
                    <li><div class="row text-left m-3"><div class="col"><h5><a href="registerStudent.php">Register student</a></h5></div></div></li>
                    <li><div class="row text-left m-3"><div class="col"><h5><a href="registerEnterprise.php">Register enterprise</a></h5></div></div></li>
                </ul>
                </section>
            <?php
            }
            ?>
        </div>
        </div>
        
                    
                
            
       
        
        
        <?php 
        } else {
            controller\insertEnterpriseMobility();
            header("Location:index.php");
        }
        ?>
        <?php include 'footer.html' ?>
    </body>
</html>
