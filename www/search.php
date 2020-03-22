<?php
if((isset($_GET['enterpriseName']))) {
    include_once "controller\db.php";
?>
<!DOCTYPE html>
<html>
    <?php include "head.html"; ?>
    <body>
        <?php include "header.php"; ?>
        <div class="wrapper">
            <?php include "sidenav.php"; ?>
            <?php        
            \MobilitySharp\controller\searchInstitutionsBasic();
            ?>
        </div>
        <?php include "footer.html"; ?>
    </body>
</html>
<?php 
} else if(isset($_SESSION)){
?>
<div class="row">
    <form class="col col-md-12 col-lg-10 col-xl-8 mx-auto my-5 border p-5" method="GET" action="search.php">
        <div class="form-group">
            <h6 for="dbSearch">Search institutions</h6>
            <input class="form-control" type="text" id="dbSearch" placeholder="Institution name" name="enterpriseName">
            <?php if(is_null($user)) { ?>
                <small id="dbSearchHelp" class="form-text text-muted">To perform more specific queries, registration is required</small>
            <?php } else { ?>
                <small class="form-text"><a  href="advancedSearch.php">Advanced search</a></small>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col col-md-6 col-lg-4 mx-auto">
                <button type="submit" class="btn btn-secondary btn-block">Search</button>
            </div>
        </div>
    </form>
</div>

<?php
} else {
    header('Location: /');
}
?>