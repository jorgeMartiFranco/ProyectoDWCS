<?php
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
        <div class="wrapper">
            <?php include "sidenav.php"; ?>
            <div class="container-fluid mt-3 mt-lg-5 mx-3 mx-lg-5">
                <div class="row border-bottom border-dark">
                    <div class="col">
                        <h2>Insert new enterprise</h2>
                    </div>
                </div>
                <div class="container border my-3">
                    <ul class="nav nav-tabs mt-2" id="registerTab" role="tablist">
                        <li class="nav-item ">
                            <a class="nav-link active" href="#enterprise" id="enterpriseTab" data-toggle="tab" role="tab" aria-controls="enterprise" aria-selected="true">Enterprise</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#ceo" id="ceoTab" data-toggle="tab" role="tab" aria-controls="ceo" aria-selected="false">CEO</a>
                        </li>
                    </ul>
                    <form method="POST">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="enterprise" role="tabpanel" aria-labelledby="enterprise-tab">
                                <script>createFormRegisterEnterprise();</script>
                                <div class="form-row justify-content-center">
                                    <div class="col-12 col-sm-6 col-md-5 col-lg-4 col-xl-3 mx-md-3 my-2 my-md-3"> 
                                        <button type="button" class="btn btn-secondary rounded btn-block" id="next">Next</button>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="ceo" role="tabpanel" aria-labelledby="ceo-tab">
                                <script>createFormRegisterCEO();</script>   <!-- Modificar -->
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
                <!--<div class="container">
                    <form method="POST" id="enterprise" action="registerEnterprise.php">
                        <script>createFormInsertEnterprise();</script>
                        <div class="form-row justify-content-center">
                            <div class="col col-sm-6 col-md-5 col-lg-4 btn-group my-2 my-md-3" role="group"> 
                                <button type="submit" class="btn btn-secondary rounded ml-2 ml-md-3 ml-md-4" id="submitRegister">Insert</button>
                            </div>
                        </div>
                    </form>
                </div>-->
            </div>
        </div>
        <?php include 'footer.html' ?>
    </body>
</html>
<?php 
} else {
    controller\insertEnterprise();
}
?>