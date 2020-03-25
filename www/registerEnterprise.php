<?php
require_once 'controller/sessions.php';
include_once 'controller/db.php';
use MobilitySharp\controller;
use MobilitySharp\controller\sessions;

sessions\startSession();
sessions\checkLogin();

if (isset($_POST) && isset($_POST['id']) && !empty($_POST['id'])) {     //Se ha recibido una petición para procesar la modificación de la empresa
    controller\modifyEnterprise(filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT));
    header("Location:myEnterprises.php");
} else if (isset($_POST) && !empty($_POST)) {   //Se ha recibido una petición para insertar una nueva empresa
    controller\insertEnterprise();
} else if (isset($_GET) && isset($_GET['id']) && !empty($_GET['id'])) {     //Se ha recibido una petición para modificar la empresa y mostraremos el formulario con sus datos
    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    $enterprise = controller\findEntity("Enterprise", $id);
?>
<!DOCTYPE html>
<html>
    <?php include "head.html"; ?>
    <body>
        <script src="js/register.js"></script>
        <?php include "header.php"; ?>
        <div class="wrapper">
            <?php include "sidenav.php"; ?>
            <section class="container-fluid my-3 my-lg-5 mx-3 mx-lg-5 border-bottom border-dark">
                <div class="row border-bottom border-dark">
                    <div class="col">
                        <h2>Edit enterprise</h2>
                    </div>
                </div>
                <div class="container">
                    <?php
                    if($enterprise){
                    ?>
                    <form method="POST" id="enterprise" action="registerEnterprise.php">
                        <input type="hidden" name="id" value="<?=$id?>">
                        <script>createFormEditEnterprise(<?=$id?>);</script>
                        <div class="form-row justify-content-center">
                            <div class="col col-sm-6 col-md-5 col-lg-4 btn-group my-2 my-md-3" role="group"> 
                                <button type="submit" class="btn btn-secondary rounded" id="submitRegister">Edit</button>
                            </div>
                        </div>
                    </form>
                    <?php } else { ?>
                        <div>
                            <p class="text-danger">Enterprise with ID <?=$id?> doesn't exist</p>
                        </div>
                    <?php } ?>
                </div>
            </section>
        </div>
        <?php include 'footer.html' ?>
    </body>
</html>
<?php
} else {
?>
<!DOCTYPE html>
<html>
    <?php include "head.html"; ?>
    <body>
        <script src="js/register.js"></script>
        <?php include "header.php"; ?>
        <div class="wrapper">
            <?php include "sidenav.php"; ?>
            <section class="container-fluid my-3 my-lg-5 mx-3 mx-lg-5 border-bottom border-dark">
                <div class="row border-bottom border-dark">
                    <div class="col">
                        <h2>Insert new enterprise</h2>
                    </div>
                </div>
                <div class="container mb-3 mb-lg-5">
                    <ul class="nav nav-tabs mt-2" id="registerTab" role="tablist">
                        <li class="nav-item ">
                            <a class="nav-link active" href="#enterprise" id="enterpriseTab" data-toggle="tab" role="tab" aria-controls="enterprise" aria-selected="true">Enterprise</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#ceo" id="ceoTab" data-toggle="tab" role="tab" aria-controls="ceo" aria-selected="false">CEO</a>
                        </li>
                    </ul>
                    <form method="POST" action="registerEnterprise.php">
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
            </section>
        </div>
        <?php include 'footer.html' ?>
    </body>
</html>
<?php 
}
?>