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
        <link rel="stylesheet" type="text/css" href="css/custom.css" />
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
                                <div class="col-12 col-sm-6 col-md-5 col-lg-4 col-xl-3 mx-md-3 my-2 my-md-3"> 
                                    <button type="button" class="btn btn-secondary rounded btn-block" id="next">Next</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="institution" role="tabpanel" aria-labelledby="institution-tab">
                            <script>createFormRegisterInstitution();</script>
                            <div class="form-row justify-content-center">
                                <div class="col-12 col-sm col-md-5 col-lg-4 mx-md-3 my-2 my-md-3"> 
                                    <div class="input-group">
                                        <select class="form-control" name="country">
                                            <option disabled selected>Select country...</option>
                                            <?php
                                            getCountries();
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm col-md-5 col-lg-4 mx-md-3 my-2 my-md-3"> 
                                    <select class="form-control" name="institutionType">
                                        <option disabled selected>Select institution type...</option>
                                        <?php 
                                        getInstitutionTypes()
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row justify-content-center">
                                <div class="col col-sm-6 col-md-5 col-lg-4 btn-group my-2 my-md-3" role="group"> 
                                    <button type="button" class="btn btn-outline-secondary rounded mr-1 mr-md-3">Previous</button>
                                    <button type="submit" class="btn btn-secondary rounded ml-2 ml-md-3 ml-md-4" id="submitRegister">Register</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <?php 
        } else {
           registerPartnerInstitution();
        }
        ?>
        <?php include 'footer.html' ?>
    </body>
</html>
