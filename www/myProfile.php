<?php
require_once 'controller/sessions.php';
include_once 'controller/db.php';
use MobilitySharp\controller;
use MobilitySharp\controller\sessions;

sessions\startSession();
sessions\checkLogin();

//Deactivates the account if the user wants to
if(isset($_GET) && isset($_GET['account_deactivate'])) {
    controller\deleteUser();
}

?>
<!DOCTYPE html>
<html>
    <?php
    include "head.html";
    ?>
    <body>
        <?php
        include "header.php";
        
        ?>
        <div class="wrapper">
    <?php
    include "sidenav.php";?>
        <div class="container-fluid mt-3 mt-lg-5 mx-3 mx-lg-5">
            
            
       
            <?php
        controller\partnerProfile();
        
        ?>
            </div>
        </div>
        <?php include "footer.html";?>
    </body>
</html>

