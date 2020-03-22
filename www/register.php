<?php
session_start();
if(isset($_SESSION['user'])) {
    header('Location: /');
}

include_once 'controller/db.php';
use MobilitySharp\controller;

if(!isset($_POST) or empty($_POST)) {
?>
<!DOCTYPE html>
<html>
    <?php include "head.html"; ?>
    <body>
        <script src="js/register.js"></script>
        <?php include "header.php"; ?>
        <div class="container-fluid">
            <div class="container border my-3">
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
                            <div class="form-row justify-content-center mb-3">
                                <div class="col-12 col-sm-6 col-md-5 col-lg-4 col-xl-3 mx-md-3 my-2 my-md-3 text-center ">
                                    <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="lodgingProvider" name="lodgingProvider">
                                    <label class="custom-control-label" for="lodgingProvider"><b>Lodging provider</b></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row justify-content-center">
                                <div class="col-12 col-sm-6 col-md-5 col-lg-4 col-xl-3 mx-md-3 my-2 my-md-3"> 
                                    <button type="button" class="btn btn-secondary rounded btn-block" id="next">Next</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="institution" role="tabpanel" aria-labelledby="institution-tab">
                            <script>createFormRegisterInstitution();</script>
                            <div class="form-row justify-content-center">
                                <div class="col col-sm-10 col-md-5 col-lg-4 btn-group my-2 my-md-3" role="group"> 
                                    <button type="button" class="btn btn-outline-secondary rounded mr-1 mr-md-3">Previous</button>
                                    <button type="submit" class="btn btn-secondary rounded ml-2 ml-md-3 ml-md-4" id="submitRegister">Register</button>
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
<?php 
} else {
    controller\registerPartnerInstitution();
}
?>