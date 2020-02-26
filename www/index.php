<?php
session_start();
$user = $_SESSION['user'] ?? NULL;
$breakpoint = $user ? 'lg' : 'md'; 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Movility&sharp;</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, user-scalable=no" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<style>
		.logo {
			width:150px;
		}
	</style>
</head>
	<body>
		<header class="navbar navbar-expand-<?=$breakpoint?> navbar-custom bg-main">
			<a class="navbar-brand">
				<img class="logo" src="img/logo.png" alt="Movility&sharp;">
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
				<form class="form-inline ml-auto mt-3 mt-<?=$breakpoint?>-0">
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
					<a role="button" class="btn btn-main" href="register">Register</a>
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
		<div class="container-fluid">
			<div class="container row mx-auto">
				<section class="container border rounded my-5 mx-auto col-12 col-md">
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus, ante sed tempor congue, arcu erat pellentesque arcu, a consequat augue eros non urna. In hendrerit euismod tellus eu semper. Donec congue diam a ipsum finibus cursus. Nulla sit amet nibh neque. Vestibulum non mollis turpis. Curabitur non hendrerit nunc, quis ultricies leo. Aenean est diam, suscipit sed arcu a, mollis eleifend nisi. Nullam nec efficitur risus, eu mollis erat. Cras dapibus est gravida est finibus, at tempor lorem iaculis. Praesent blandit at mauris ut tempus. Sed elementum tortor orci, at congue dui elementum a. Integer laoreet auctor venenatis. Cras a elit arcu. Praesent bibendum urna vel nunc molestie cursus. Sed lacinia felis vitae elit sagittis hendrerit. Etiam tortor erat, pellentesque vel sapien non, finibus venenatis mauris.</p>
					<p>Donec enim sapien, fringilla eget feugiat vel, tincidunt nec nisl. Cras risus diam, venenatis ut felis eu, posuere mollis quam. Etiam imperdiet laoreet blandit. Sed sem massa, lacinia id interdum malesuada, porta aliquet nibh. Cras at mi dapibus, pretium eros non, tempor neque. Integer non aliquet nibh. Aliquam in lacinia tellus, et rhoncus nunc. Morbi sodales, arcu a laoreet bibendum, sem velit auctor mi, sit amet tincidunt nibh arcu sed erat. Donec consequat massa blandit lectus dignissim vestibulum. Aenean placerat fermentum mauris, non ultricies ante imperdiet eget. Etiam a dui libero.</p>
					<p>Integer placerat ipsum lorem, non efficitur elit bibendum faucibus. Integer molestie molestie tellus vel posuere. Donec neque nulla, viverra vel diam nec, vehicula dapibus purus. Duis non ultricies ipsum. Suspendisse potenti. Mauris semper suscipit eros, eget consectetur enim suscipit in. Integer augue nibh, viverra in feugiat vel, bibendum at leo. Suspendisse convallis diam vitae bibendum elementum.</p>
				</section>
				<section class="container border rounded my-5 mx-auto col-12 col-md">
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus, ante sed tempor congue, arcu erat pellentesque arcu, a consequat augue eros non urna. In hendrerit euismod tellus eu semper. Donec congue diam a ipsum finibus cursus. Nulla sit amet nibh neque. Vestibulum non mollis turpis. Curabitur non hendrerit nunc, quis ultricies leo. Aenean est diam, suscipit sed arcu a, mollis eleifend nisi. Nullam nec efficitur risus, eu mollis erat. Cras dapibus est gravida est finibus, at tempor lorem iaculis. Praesent blandit at mauris ut tempus. Sed elementum tortor orci, at congue dui elementum a. Integer laoreet auctor venenatis. Cras a elit arcu. Praesent bibendum urna vel nunc molestie cursus. Sed lacinia felis vitae elit sagittis hendrerit. Etiam tortor erat, pellentesque vel sapien non, finibus venenatis mauris.</p>
					<p>Donec enim sapien, fringilla eget feugiat vel, tincidunt nec nisl. Cras risus diam, venenatis ut felis eu, posuere mollis quam. Etiam imperdiet laoreet blandit. Sed sem massa, lacinia id interdum malesuada, porta aliquet nibh. Cras at mi dapibus, pretium eros non, tempor neque. Integer non aliquet nibh. Aliquam in lacinia tellus, et rhoncus nunc. Morbi sodales, arcu a laoreet bibendum, sem velit auctor mi, sit amet tincidunt nibh arcu sed erat. Donec consequat massa blandit lectus dignissim vestibulum. Aenean placerat fermentum mauris, non ultricies ante imperdiet eget. Etiam a dui libero.</p>
					<p>Integer placerat ipsum lorem, non efficitur elit bibendum faucibus. Integer molestie molestie tellus vel posuere. Donec neque nulla, viverra vel diam nec, vehicula dapibus purus. Duis non ultricies ipsum. Suspendisse potenti. Mauris semper suscipit eros, eget consectetur enim suscipit in. Integer augue nibh, viverra in feugiat vel, bibendum at leo. Suspendisse convallis diam vitae bibendum elementum.</p>
				</section>
				<section class="container border rounded my-5 mx-auto col-12 col-md">
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus, ante sed tempor congue, arcu erat pellentesque arcu, a consequat augue eros non urna. In hendrerit euismod tellus eu semper. Donec congue diam a ipsum finibus cursus. Nulla sit amet nibh neque. Vestibulum non mollis turpis. Curabitur non hendrerit nunc, quis ultricies leo. Aenean est diam, suscipit sed arcu a, mollis eleifend nisi. Nullam nec efficitur risus, eu mollis erat. Cras dapibus est gravida est finibus, at tempor lorem iaculis. Praesent blandit at mauris ut tempus. Sed elementum tortor orci, at congue dui elementum a. Integer laoreet auctor venenatis. Cras a elit arcu. Praesent bibendum urna vel nunc molestie cursus. Sed lacinia felis vitae elit sagittis hendrerit. Etiam tortor erat, pellentesque vel sapien non, finibus venenatis mauris.</p>
					<p>Donec enim sapien, fringilla eget feugiat vel, tincidunt nec nisl. Cras risus diam, venenatis ut felis eu, posuere mollis quam. Etiam imperdiet laoreet blandit. Sed sem massa, lacinia id interdum malesuada, porta aliquet nibh. Cras at mi dapibus, pretium eros non, tempor neque. Integer non aliquet nibh. Aliquam in lacinia tellus, et rhoncus nunc. Morbi sodales, arcu a laoreet bibendum, sem velit auctor mi, sit amet tincidunt nibh arcu sed erat. Donec consequat massa blandit lectus dignissim vestibulum. Aenean placerat fermentum mauris, non ultricies ante imperdiet eget. Etiam a dui libero.</p>
					<p>Integer placerat ipsum lorem, non efficitur elit bibendum faucibus. Integer molestie molestie tellus vel posuere. Donec neque nulla, viverra vel diam nec, vehicula dapibus purus. Duis non ultricies ipsum. Suspendisse potenti. Mauris semper suscipit eros, eget consectetur enim suscipit in. Integer augue nibh, viverra in feugiat vel, bibendum at leo. Suspendisse convallis diam vitae bibendum elementum.</p>
				</section>
			</div>
		</div>
	</body>
</html>