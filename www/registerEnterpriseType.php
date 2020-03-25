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
            
            <div class="row border-bottom border-dark">
                <div class="col"><h2>Insert new enterprise type</h2></div></div>
            
            
                <section class="container">
                <form class="col mb-3 mb-lg-5" method="POST" id="enterpriseType" action="registerEnterpriseType.php">
                   
                           
                            
                                 <script>createFormRegisterEnterpriseType();</script>
                                 
                             <div class="form-row justify-content-center mt-3">
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
            controller\insertEnterpriseType();
            header("Location:index.php");
        }
        ?>
        <?php include 'footer.html' ?>
    </body>
</html>

