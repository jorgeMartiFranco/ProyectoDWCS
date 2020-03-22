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
<div class="container mt-3 mt-lg-5">
    <div class='row border-bottom border-dark mb-3 mx-3 mx-lg-5'><div class='col col-12 col-lg-10 col-xl-8'><h3>Search institutions</h3></div></div>
    <form class="col col-md-11 col-lg-9 col-xl-7 mx-auto my-5 border p-5" method="GET" action="search.php">
        <div class="form-group">
            
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