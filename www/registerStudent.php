<?php
include_once 'controller/db.php';

use MobilitySharp\controller;
?>
<html>
    <?php
    include "head.html";
    ?>
    <body>
        <?php
        include "header.php";
        ?>
        <script src="js/register.js"></script>
        
            <?php
        if (!isset($_POST) or empty($_POST)) {
            ?>
        <div class="wrapper">
    <?php
    include "sidenav.php";?>
            <div class="container-fluid mt-3 mt-lg-5 mx-3 mx-lg-5">
                <div class="row border-bottom border-dark"><div class="col"><h2>Insert new student</h2></div></div>
                
                <div class="container border-bottom border-dark pt-3 mb-3 mb-lg-5">

                    <form method="POST" id="student" action="registerStudent.php">



                        <script>createFormInsertStudent();</script>
                        <div class="form-row justify-content-center">
                            <div class="radio-inline mx-2" checked>
                                <h6><label><input type="radio" name="gender" value="Male" checked>Male</label></h6>
                            </div>
                            <div class="radio-inline mx-2">
                                <h6><label><input type="radio" name="gender" value="Female">Female</label></h6>
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
        </div>






            <?php
        } else {
            controller\insertStudent();
        }
        ?>
<?php include 'footer.html' ?>
    </body>
</html>
