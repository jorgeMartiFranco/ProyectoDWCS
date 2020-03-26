<?php
require_once 'controller/sessions.php';
include_once 'controller/db.php';
use MobilitySharp\controller;
use MobilitySharp\controller\sessions;

sessions\startSession();
sessions\checkLogin();

if (isset($_POST) && isset($_POST['id']) && !empty($_POST['id'])) {
    controller\modifyStudent(filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT));
    

} else if (isset($_POST) && !empty($_POST)) {
    controller\insertStudent();

} else if (isset($_GET) && isset($_GET['id']) && !empty($_GET['id'])) {
    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    $student = controller\findEntity("Student", $id);

?>
<!DOCTYPE html>
<html>
    <?php include "head.html"; ?>
    <body>
        <script src="js/register.js"></script>
        <?php include "header.php"; ?>
        <div class="wrapper">
            <?php include "sidenav.php"; ?>
            <div class="container-fluid my-3 my-lg-5 mx-3 mx-lg-5 border-bottom border-dark">
                <div class="row border-bottom border-dark">
                    <div class="col">
                        <h2>Edit Student</h2>
                    </div>
                </div>
                <section class="container pt-3 mb-3 mb-lg-5">
                    <?php
                    if($student) {
                    ?>
                    <form method="POST" id="student">
                        <input type="hidden" name="id" value="<?=$id?>">
                        <script>createFormEditStudent(<?=$id?>);</script>
                        <div class="form-row justify-content-center">
                            <div class="radio-inline mx-2">
                                <h6><label><input type="radio" name="gender" value="Male">Male</label></h6>
                            </div>
                            <div class="radio-inline mx-2">
                                <h6><label><input type="radio" name="gender" value="Female">Female</label></h6>
                            </div>
                        </div>
                        <div class="form-row justify-content-center">
                            <div class="col col-sm-6 col-md-5 col-lg-4 btn-group my-2 my-md-3" role="group"> 
                                <button type="submit" class="btn btn-secondary rounded" id="submitRegister">Insert</button>
                            </div>
                        </div>
                    </form>
                    <?php
                    } else {
                    ?>
                    <div>
                        <p class="text-danger">Student with ID <?=$id?> doesn't exist</p>
                    </div>
                    <?php
                    }
                    ?>
                </section>
            </div>
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
            <div class="container-fluid my-3 my-lg-5 mx-3 mx-lg-5 border-bottom border-dark">
                <div class="row border-bottom border-dark">
                    <div class="col">
                        <h2>Insert new student</h2>
                    </div>
                </div>
                <section class="container pt-3 mb-3 mb-lg-5">
                    <form method="POST" id="student">
                        <script>createFormInsertStudent();</script>
                        <div class="form-row justify-content-center">
                            <div class="radio-inline mx-2">
                                <h6><label><input type="radio" name="gender" value="Male" checked>Male</label></h6>
                            </div>
                            <div class="radio-inline mx-2">
                                <h6><label><input type="radio" name="gender" value="Female">Female</label></h6>
                            </div>
                        </div>
                        <div class="form-row justify-content-center">
                            <div class="col col-sm-6 col-md-5 col-lg-4 btn-group my-2 my-md-3" role="group"> 
                                <button type="submit" class="btn btn-secondary rounded" id="submitRegister">Insert</button>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
        <?php include 'footer.html' ?>
    </body>
</html>
<?php
}
?>