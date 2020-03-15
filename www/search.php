<?php
if(isset($_GET['institutionName'])) {

} else if(isset($_SESSION)){
?>
<div class="row">
    <form class="col col-md-10 col-lg-8 col-xl-6 mx-auto my-5" method="GET" action="/search">
        <div class="form-group">
            <label for="dbSearch">Search institutions</label>
            <input class="form-control" type="text" id="dbSearch" placeholder="Institution name" name="institutionName">
            <?php if(is_null($user)) { ?>
                <small id="dbSearchHelp" class="form-text text-muted">To perform more specific queries, registration is required</small>
            <?php } else { ?>
                <small class="form-text"><a  href="">Advanced search</a></small>
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