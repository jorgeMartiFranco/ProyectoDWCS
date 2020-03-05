<?php
include_once 'db.php';
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
        <style>
            .logo {
                width:150px;
            }
        </style>
    </head>
    <body>
        <?php include "header.php" ?>
        <div class="container-fluid">
            <div class="container border mt-3">
                <ul class="nav nav-tabs mt-2" id="registerTab" role="tablist">
                    <li class="nav-item ">
                        <a class="nav-link active" href="#partner" id="partnerTab" data-toggle="tab" role="tab" aria-controls="partner" aria-selected="true">Partner</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#institution" id="institutionTab" data-toggle="tab" role="tab" aria-controls="institution" aria-selected="false">Institution</a>
                    </li>
                </ul>
                <form method="POST">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="partner" role="tabpanel" aria-labelledby="partner-tab">
                            <script>createFormRegisterPartner();</script>
                            <div class="form-row justify-content-center">
                                <div class="form-col mx-3 my-2 my-md-3"> 
                                    <div class="input-group">
                                    <select class="form-control" name="countryPartner">
                                        <option>Select country...</option>
                                        <?php
                                        getCountries();
                                        ?>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="container text-right">
                            <div class="btn-group"> 
                            <input type="reset" class="btn btn-danger rounded" value="Reset">
                            <button type="button" class="btn btn-primary rounded ml-3" id="next">Next</button>
                            </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="institution" role="tabpanel" aria-labelledby="institution-tab">
                            
                            <script>createFormRegisterInstitution();</script>
                            <div class="form-row justify-content-center">
                                <div class="form-col mx-3 my-2 my-md-3"> 
                            <select class="form-control" name="countryInstitution">
                                <option>Select institution type...</option>
                                <?php 
                                getInstitutionTypes()
                                ?>
                            </select>
                                </div>
                                <div class="form-col mx-3 my-2 my-md-3"> 
                                    <select class="form-control">
                                        <option>Select country...</option>
                                        <?php
                                        getCountries();
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="container text-right">
                            <div class="btn-group"> 
                            <input type="reset" class="btn btn-danger rounded" value="Reset">
                            <button type="submit" class="btn btn-primary rounded ml-3" id="submitRegister">Register</button>
                            </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php include 'footer.html' ?>
    </body>
</html>
