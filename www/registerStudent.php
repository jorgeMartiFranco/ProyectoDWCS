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
        <?php
        include "header.php";
        if (!isset($_POST) or empty($_POST)) {
            ?>
            <div class="container-fluid text-center mt-3 mt-lg-5">
                <h1>Insert new student</h1>
                <div class="container border mt-3 pt-3">

                    <form method="POST" id="student" action="registerStudent.php">



                        <script>createFormInsertStudent();</script>
                        <div class="form-row justify-content-center">
                            <div class="radio-inline" checked>
                                <label><input type="radio" name="gender" value="Male" checked>Male</label>
                            </div>
                            <div class="radio-inline">
                                <label><input type="radio" name="gender" value="Female">Female</label>
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
            controller\insertStudent();
        }
        ?>
<?php include 'footer.html' ?>
    </body>
</html>
