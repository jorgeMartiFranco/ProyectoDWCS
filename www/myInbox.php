<html>
    
    <?php
    include "head.html";
    ?>
    <body>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
        <?php
        include "header.php";
        
        ?>
        <div class="wrapper">
    <?php
    include "sidenav.php";?>
            

<div class="container mt-3 mt-lg-5">
<div class="row inbox">
	<div class="col-md-3">
	    <div class="panel panel-default">
			<div class="panel-body inbox-menu">
				<a href="page-inbox-compose.html" class="btn btn-danger btn-block">New Email</a>
				<ul>
					<li>
						<a href="#"><i class="fa fa-inbox"></i> Inbox <span class="label label-danger">4</span></a>
					</li>
					<li>
						<a href="#"><i class="fa fa-star"></i> Stared</a>
					</li>
					<li>
						<a href="#"><i class="fa fa-rocket"></i> Sent</a>
					</li>
					<li>
						<a href="#"><i class="fa fa-trash-o"></i> Trash</a>
					</li>
					<li>
						<a href="#"><i class="fa fa-bookmark"></i> Important<span class="label label-info">5</span></a>
					</li>
					<li class="title">
						Labels
					</li>
					<li>
						<a href="#">Home <span class="label label-danger"></span></a>
					</li>
					<li>
						<a href="#">Job <span class="label label-info"></span></a>
					</li>
					<li>
						<a href="#">Clients <span class="label label-success"></span></a>
					</li>
					<li>
						<a href="#">News <span class="label label-warning"></span></a>
					</li>
				</ul>
				
			</div>	
			
		</div>
		
			
		
	</div><!--/.col-->
	
	<div class="col-md-9">
		<div class="panel panel-default">
			<div class="panel-body">
				<span class="btn-group">
				  	<button class="btn btn-default"><span class="fa fa-envelope"></span></button>
				  	<button class="btn btn-default"><span class="fa fa-star"></span></button>
				  	<button class="btn btn-default"><span class="fa fa-star-o"></span></button>
					<button class="btn btn-default"><span class="fa fa-bookmark-o"></span></button>
				</span>

				<span class="btn-group">
				  	<button class="btn btn-default"><span class="fa fa-mail-reply"></span></button>
				  	<button class="btn btn-default"><span class="fa fa-mail-reply-all"></span></button>
				  	<button class="btn btn-default"><span class="fa fa-mail-forward"></span></button>
				</span>

				<button class="btn btn-default"><span class="fa fa-trash-o"></span></button>

				

				<span class="btn-group pull-right">
				  	<button class="btn btn-default"><span class="fa fa-chevron-left"></span></button>
				  	<button class="btn btn-default"><span class="fa fa-chevron-right"></span></button>
				</span>

				<ul class="messages-list">

					<li class="unread">
						<a href="page-inbox-message.html">
							<div class="header">
								<span class="action"><i class="fa fa-square-o"></i><i class="fa fa-square"></i></span> 
								<span class="from">Lukasz Holeczek</span>
								<span class="date"><span class="fa fa-paper-clip"></span> Today, 3:47 PM</span>
							</div>
							<div class="title">
								<span class="action"><i class="fa fa-star-o"></i><i class="fa fa-star bg"></i></span>
								Lorem ipsum dolor sit amet, consectetur adipisicing elit.
							</div>	
							<div class="description">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
							</div>
						</a>		
					</li>

					<li>
						<a href="page-inbox-message.html">
							<div class="header">
								<span class="action"><i class="fa fa-square-o"></i><i class="fa fa-square"></i></span> 
								<span class="from">Lukasz Holeczek</span>
								<span class="date"><span class="fa fa-paper-clip"></span> Today, 3:47 PM</span>
							</div>
							<div class="title">
								<span class="action"><i class="fa fa-star-o"></i><i class="fa fa-star bg"></i></span>
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
							</div>	
							<div class="description">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
							</div>
						</a>		
					</li>

					<li>
						<a href="page-inbox-message.html">
							<div class="header">
								<span class="action"><i class="fa fa-square-o"></i><i class="fa fa-square"></i></span> 
								<span class="from">Lukasz Holeczek</span>
								<span class="date">Today, 3:47 PM</span>
							</div>
							<div class="title">
								<span class="action"><i class="fa fa-star-o"></i><i class="fa fa-star bg"></i></span>
								Lorem ipsum dolor sit amet.
							</div>	
							<div class="description">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
							</div>
						</a>	
					</li>

					<li class="unread">
						<a href="page-inbox-message.html">
							<div class="header">
								<span class="action"><i class="fa fa-square-o"></i><i class="fa fa-square"></i></span> 
								<span class="from">Lukasz Holeczek</span>
								<span class="date">Today, 3:47 PM</span>
							</div>
							<div class="title">
								<span class="action"><i class="fa fa-star-o"></i><i class="fa fa-star bg"></i></span>
								Lorem ipsum dolor sit amet, consectetur adipisicing elit.
							</div>	
							<div class="description">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
							</div>
						</a>
					</li>

					<li class="unread">
						<a href="page-inbox-message.html">
							<div class="header">
								<span class="action"><i class="fa fa-square-o"></i><i class="fa fa-square"></i></span> 
								<span class="from">Lukasz Holeczek</span>
								<span class="date">Today, 3:47 PM</span>
							</div>
							<div class="title">
								<span class="action"><i class="fa fa-star-o"></i><i class="fa fa-star bg"></i></span>
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
							</div>	
							<div class="description">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
							</div>		
							
						</a>
					</li>

					<li>
						<a href="page-inbox-message.html">
							<div class="header">
								<span class="action"><i class="fa fa-square-o"></i><i class="fa fa-square"></i></span> 
								<span class="from">Lukasz Holeczek</span>
								<span class="date">Today, 3:47 PM</span>
							</div>
							<div class="title">
								<span class="action"><i class="fa fa-star-o"></i><i class="fa fa-star bg"></i></span>
								Lorem ipsum dolor sit amet.
							</div>	
							<div class="description">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
							</div>
						</a>		
					</li>

					<li class="unread">
						<a href="page-inbox-message.html">
							<div class="header">
								<span class="action"><i class="fa fa-square-o"></i><i class="fa fa-square"></i></span> 
								<span class="from">Lukasz Holeczek</span>
								<span class="date">Today, 3:47 PM</span>
							</div>
							<div class="title">
								<span class="action"><i class="fa fa-star-o"></i><i class="fa fa-star bg"></i></span>
								Lorem ipsum dolor sit amet, consectetur adipisicing elit.
							</div>	
							<div class="description">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
							</div>
						</a>											
					</li>

					<li>
						<a href="page-inbox-message.html">
							<div class="header">
								<span class="action"><i class="fa fa-square-o"></i><i class="fa fa-square"></i></span> 
								<span class="from">Lukasz Holeczek</span>
								<span class="date">Today, 3:47 PM</span>
							</div>
							<div class="title">
								<span class="action"><i class="fa fa-star-o"></i><i class="fa fa-star bg"></i></span>
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
							</div>	
							<div class="description">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
							</div>
						</a>		
					</li>

					<li>
						<a href="page-inbox-message.html">
							<div class="header">
								<span class="action"><i class="fa fa-square-o"></i><i class="fa fa-square"></i></span> 
								<span class="from">Lukasz Holeczek</span>
								<span class="date">Today, 3:47 PM</span>
							</div>
							<div class="title">
								<span class="action"><i class="fa fa-star-o"></i><i class="fa fa-star bg"></i></span>
								Lorem ipsum dolor sit amet.
							</div>	
							<div class="description">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
							</div>
						</a>
					</li>

				</ul>
				
			</div>	
			
		</div>	
		
	</div><!--/.col-->	
			
</div>
</div>
        </div>
</html>