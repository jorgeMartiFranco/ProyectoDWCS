<?php
require_once 'controller/sessions.php';
include_once 'controller/db.php';
use MobilitySharp\controller;
use MobilitySharp\controller\sessions;

sessions\startSession();
sessions\checkLogin();

if(isset($_GET) && isset($_GET['id'])) {
    $enterprise = controller\findEntity("Enterprise", filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT));
    if(!is_null($enterprise)) {
        controller\deleteEnterprise($enterprise->getId());
    }
}
?>
<!DOCTYPE html>
<html>
    <?php include "head.html"; ?>
    <body>
        <?php include "header.php"; ?>
        <div class="wrapper">
            <?php include "sidenav.php"; ?>
            <div class="container-fluid my-3 my-lg-5 mx-3 mx-lg-5 border-bottom border-dark">
                <?php if(controller\getPartnerEnterprises()){ ?>
                <div class="row border-bottom border-dark"><div class="col"><h2>Your enterprises</h2></div></div>
                <?php controller\listPartnerEnterprises();
                } else {
                ?>
                    <section class="container mt-3 pt-3 mb-3 mb-lg-5">
                        <div class="row">
                            <div class="col">
                                <h4>You have to register at least one enterprise.</h4>
                            </div>
                        </div>
                        <ul>
                            <li>
                                <div class="row text-left m-3">
                                    <div class="col">
                                        <h5><a href="registerEnterprise.php">Register enterprise</a></h5>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </section>
                <?php } ?>
                </div>
            </div>
        <?php include "footer.html";?>
    </body>
</html>