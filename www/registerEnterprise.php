<?php
include_once 'controller/db.php';
use MobilitySharp\controller;
?>
<html>
    <head>
        <title>Mobility&sharp;</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no" />
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/custom.js"></script>
        <script src="js/register.js"></script>
    </head>
    <body>
        <?php include "header.php";
        if(!isset($_POST) or empty($_POST)) {
        ?>
        <div class="container-fluid">
            <div class="container border mt-3 text-center pt-3">
                <h1>Insert new enterprise</h1>
                <form method="POST" id="enterprise" action="registerEnterprise.php">
                   
                           
                            
                                 <script>createFormInsertEnterprise();</script>
                                 <div class="form-row justify-content-center">
                                 <div class="col-12 col-sm col-md-5 col-lg-4 mx-md-3 my-2 my-md-3"> 
                                        <select class="form-control" name="ceo">
                                            <option disabled selected>Select ceo...</option>
                                            <?php
                                            controller\getCeos();
                                            ?>
                                        </select>
                                    </div>
                                 <div class="col-12 col-sm col-md-5 col-lg-4 mx-md-3 my-2 my-md-3"> 
                                    <select class="form-control" name="enterpriseType">
                                        <option disabled selected>Select enterprise type...</option>
                                        <?php 
                                        controller\getEnterpriseType();
                                        ?>
                                    </select>
                                </div>
                                     <div class="col-12 col-sm col-md-5 col-lg-4 mx-md-3 my-2 my-md-3"> 
                                    <select class="form-control" name="country">
                                        <option disabled selected>Select country...</option>
                                        <?php 
                                        controller\getCountries();
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
        </div>
        
                    
                
            
       
        
        
        <?php 
        } else {
            controller\insertEnterprise();
        }
        ?>
        <?php include 'footer.html' ?>
    </body>
</html>
