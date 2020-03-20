<!DOCTYPE html>
<html>
	
	<body>
		<?php include 'header.php'; ?>
		<div class="wrapper">
                    <?php include 'head.html' ?>
		<?php include 'sidenav.php'; ?>
			<div class="container-fluid">
				<?php if(is_null($user)) { ?>
				<section class="container my-2 my-lg-5">
					<?php include 'search.php'; ?>
				</section>
				<section class="info-block row bg-secondary">
					<img class="img-fluid" src="img/new_york_skyline.jpg" alt="New York City"/>
					<div class="text-block row no-gutters flex-column">
						<div class="col d-none d-lg-flex flex-grow-0">
							<h1 class="display-1 ml-5">Register</h1>
						</div>
						<div class="col col-md-8 col-lg-6 mx-auto my-auto align-self-center">
							<div class="row no-gutters h-100 align-items-center">
								<div class="col px-3">
									<p>Register now to be able to take advantage of the full capabilities of <strong>Mobility&sharp;</strong></p>
									<div class="d-none d-sm-block">
										<p>As a registered partner you can:</p>
										<ul>
											<li>Perform complex and specific queries to find enterprises or institutions.</li>
											<li>Manage your students mobilities.</li>
											<li>Contact with other partners registered in the platform to coordinate the lodgment of your students.</li>
											<li>Contribute on the platform by adding new enterprises around you.</li>
										</ul>
									</div>
									<div class="text-center">
										<a class="btn btn-accent" role="button" href="register.php">Register now</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
				<?php } else { ?>
				<section class="container">
					<!-- Aquí van los elementos del panel de control -->
				</section>
				<section class="container">
					<?php 
                                        include 'score.php';
                                        include 'search.php';
                                        include 'topInstitutions.php'?>
				</section>
				<?php } ?>
			</div>
		</div>
		<?php include 'footer.html' ?>
	</body>
</html>