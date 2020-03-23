<?php
include_once 'controller/db.php';

use MobilitySharp\controller;
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
        <script src="js/register.js"></script>
        
            <?php
        if (!isset($_POST) or empty($_POST)) {
            ?>
        <div class="wrapper">
    <?php
    include "sidenav.php";?>
            <div class="container-fluid my-3 my-lg-5 mx-3 mx-lg-5 border-bottom border-dark">
                <div class="row border-bottom border-dark"><div class="col"><h2>Contact with an administrator</h2></div></div>
                
                <div class="container pt-3 mb-3 mb-lg-5">

                    <form method="POST" id="student" action="contact.php">


                        <div class="form-row justify-content-center">
                            
                            <div class="col-12 col-sm col-md-5 col-lg-4 mx-md-3 my-2 my-md-3">
                                <input type="text" class="form-control" placeholder="Subject" name="subject" id="subject" required>
                            </div>
                            
                        </div>
                        <div class="form-row justify-content-center">
                            
                            <div class="col-12 col-sm col-md-5 col-lg-4 mx-md-3 my-2 my-md-3">
                                <textarea type="text" class="form-control" placeholder="Description" name="description" id="description" maxlength="255" rows="5" required></textarea>
                            </div>
                        </div>
                        
                        
                        <div class="form-row justify-content-center">
                            <div class="col col-sm-6 col-md-5 col-lg-4 btn-group my-2 my-md-3" role="group"> 
                                <button type="submit" class="btn btn-secondary rounded ml-2 ml-md-3 ml-md-4" id="submitRegister">Send</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>






            <?php
        } else {
            controller\sendPetition();
            //header("Location:index.php");
        }
        ?>
<?php include 'footer.html' ?>
    </body>
</html>
