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
       
    </head>
    <body>
        <?php include "header.php";
        if(!isset($_POST) or empty($_POST)) {
        ?>
        <div class="container-fluid text-center mt-3 mt-lg-5">
            <h1>Register new institution mobility</h1>
            <div class="container border mt-3 pt-3">
                
                <form method="POST" id="institutionMobility" action="registerInstitutionMobility.php">
                   
                    <div class="form-row justify-content-center">
                        <div class="col-12 col-sm col-md-5 col-lg-4 mx-md-3 my-2 my-md-3">
                            <h2>Start date</h2>
                            <input class="form-control mt-3" type="date" name="startDate" id="startDate" required>
                            
                        </div>
                        <div class="col-12 col-sm col-md-5 col-lg-4 mx-md-3 my-2 my-md-3">
                            <h2>Estimated end date</h2>
                            <input class="form-control mt-3" type="date" name="estimatedEndDate" id="estimatedEndDate" required>
                        </div>
                    </div>
                    <div class="form-row justify-content-center">
                        <div class="col-12 col-sm col-md-5 col-lg-4 mx-md-3 my-2 my-md-3">
                            <select class="form-control" name="institution">
                                <option class="disabled">Select institution...</option>
                                <?php
                                        \MobilitySharp\controller\getAllInstitutions();
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
                        </div>
        </div>
         <?php 
        } else {
            controller\insertInstitutionMobility();
            header("Location:index.php");
        }
        ?>
        <?php include 'footer.html' ?>
    </body>
</html>
