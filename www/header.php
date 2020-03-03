<?php
session_start();
$user = $_SESSION['user'] ?? NULL;
$breakpoint = $user ? 'lg' : 'md'; 
?>
<header class="navbar navbar-expand-<?=$breakpoint?> navbar-custom bg-main">
    <a class="navbar-brand" href="">
        <img class="logo" src="img/logoNuevo.png" alt="Movility&sharp;">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse text-right mt-<?=$breakpoint?>-auto" id="navbarText">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link active" href="">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="">Contact</a>
            </li>
        </ul>
        <form class="form-inline ml-auto mb-0 mt-3 mt-<?=$breakpoint?>-0 " method="GET" action="/search">
            <div class="input-group ml-auto" role="search">
                <input class="form-control" type="search" placeholder="Search&hellip;" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                </div>
            </div>
        </form>
        <?php
        if(is_null($user)) {?>
        <div class="btn-group ml-md-4 my-3 my-md-0" role="group">
            <button type="button" class="btn btn-main" data-toggle="modal" data-target="#modalLogin">Login</button>
            <a role="button" class="btn btn-main" href="register.php">Register</a>
        </div>
        <?php
        } else {
        ?>
        <div class="ml-lg-5 my-3 my-lg-0">
            <span class="align-middle">Welcome, <?=$user['usuario'];?></span>
            <div class="btn-group" role="group">
                <a role="button" class="btn btn-main" href="/profile">Profile</a>
                <a role="button" class="btn btn-main" href="logout.php">Logout</a>
            </div>
        </div>
        <?php
        }?>
    </div>
</header>
<?php
if(is_null($user)) {?>
<div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="grid">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title ml-auto">Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="login.php" method="POST">
                    <input class="form-control mb-2" placeholder="Username / Email" type="text" name="username">
                    <input class="form-control my-2" placeholder="Password" type="password" name="password">
                    <button class="btn btn-primary btn-block mt-3" type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php }?>