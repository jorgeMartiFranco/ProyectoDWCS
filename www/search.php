<?php
if((isset($_GET['enterpriseName']) or !empty($_GET["enterpriseName"]))) {
    include_once "controller\db.php";
?>
<html>
    <?php
    include "head.html";
    ?>
    <body>
    <?php
        include "header.php";
        \MobilitySharp\controller\searchInstitutionsBasic();
        include "footer.html";
        ?>
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
        <div class="text-center">
            <button type="submit" class="btn btn-secondary w-50">Search</button>
        </div>
    </form>
</div>
<?php
} else {
    header('Location: /');
}
?>