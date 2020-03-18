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
		<link rel="stylesheet" type="text/css" href="css/custom.css" />
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.bundle.min.js"></script>
		<script src="js/custom.js"></script>
    </head>
    <body>
        <?php
        include "header.php";
        ?>
        <div class="container-fluid text-center mt-3 mt-lg-5"> <h1>Your enterprises</h1>
       
            <?php
        controller\listPartnerEnterprises();
        ?>
            </div>
        <?php include "footer.html";?>
    </body>
</html>