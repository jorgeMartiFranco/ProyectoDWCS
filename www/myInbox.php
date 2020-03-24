<html>
    
    <?php
    include_once 'controller/db.php';
    include "head.html";
    ?>
    <body>
        
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
                            <a href="contact.php" class="btn btn-danger btn-block">New Petition</a>
				<ul>
                                    <?php
                                    if($_SESSION["user"]["role"]=="REGISTERED"){
                                    ?>
					<li>
						<a href="#requested"><i class="fa fa-inbox"></i>Requested <span class="label"><?php 
                                                                \MobilitySharp\controller\countMessages("REQUESTED");
                                                ?></span></a>
					</li>
					<li>
						<a href="#inProccess"><i class="fa fa-star"></i>In Proccess<span class="label"><?php 
                                                                \MobilitySharp\controller\countMessages("IN PROCCESS");
                                                ?></span></a>
					</li>
					<li>
						<a href="#solved"><i class="fa fa-rocket"></i>Solved
                                                <span class="label"><?php 
                                                                \MobilitySharp\controller\countMessages("SOLVED");
                                                ?></span>
                                                </a>
					</li>
					<li>
						<a href="#cancelled"><i class="fa fa-trash"></i>Cancelled
                                                <span class="label"><?php 
                                                                \MobilitySharp\controller\countMessages("CANCELLED");
                                                ?></span></a>
					</li>
					<li>
						<a href="#declined"><i class="fas fa-times-circle"></i>Declined<span class="label"><?php 
                                                                \MobilitySharp\controller\countMessages("DECLINED");
                                                ?></span></a>
					</li>
					<?php
                                    }
                                    else if($_SESSION["user"]["role"]=="ADMIN"){
                                        ?>
                                        <li>
						<a href="#requested"><i class="fa fa-inbox"></i>Requested<span class="label"><?php 
                                                                \MobilitySharp\controller\countMessagesAdmin("REQUESTED");
                                                ?></span></a>
					</li>
					<li>
						<a href="#inProccess"><i class="fas fa-lightbulb"></i>In Proccess<span class="label"><?php 
                                                                \MobilitySharp\controller\countMessagesAdmin("IN PROCCESS");
                                                ?></span></a>
					</li>
					<li>
						<a href="#solved"><i class="fas fa-check-circle"></i>Solved<span class="label"><?php 
                                                                \MobilitySharp\controller\countMessagesAdmin("SOLVED");
                                                ?></span>
                                                </a>
					</li>
					
					<li>
						<a href="#declined"><i class="fas fa-times-circle"></i>Declined<span class="label"><?php 
                                                                \MobilitySharp\controller\countMessagesAdmin("DECLINED");
                                                ?></span></a>
					</li>
                                        
                                        <?php
                                    }
                                        ?>
				</ul>
				
			</div>	
			
		</div>
		
			
		
	</div><!--/.col-->
	
	<div class="col-md-9">
		<div class="panel panel-default">
			<div class="panel-body">
				<span class="btn-group">
                                    <?php
                                    if($_SESSION["user"]["role"]=="ADMIN"){
                                    ?>
				  	<button class="btn btn-primary" data-toggle="tooltip" title="Set petition requested"><span class="fa fa-inbox"></span></button>
				  	<button class="btn btn-primary" data-toggle="tooltip" title="Set petition in proccess"><span class="fas fa-lightbulb"></span></button>
				  	<button class="btn btn-primary" data-toggle="tooltip" title="Set petition solved"><span class="fas fa-check-circle"></span></button>
					<button class="btn btn-primary" data-toggle="tooltip" title="Set petition declined"><span class="fas fa-times-circle"></span></button>
                                    <?php
                                    }
                                    else if($_SESSION["user"]["role"]=="REGISTERED"){
                                        ?>
                                            
                                            <?php
                                    }
                                    ?>
				</span>

				

				

				<span class="btn-group pull-right">
				  	<button class="btn btn-default"><span class="fa fa-chevron-left"></span></button>
				  	<button class="btn btn-default"><span class="fa fa-chevron-right"></span></button>
				</span>
                                <?php
                                if($_SESSION["user"]["role"]=="REGISTERED"){
                                ?>
                                
                                        <?php 
                                                MobilitySharp\controller\listPartnerMessages("REQUESTED");
                                        ?>
					
					

				
                                
                                
                                        <?php 
                                                MobilitySharp\controller\listPartnerMessages("IN PROCCESS");
                                        ?>
					
					

				
                                
                                
                                        <?php 
                                                MobilitySharp\controller\listPartnerMessages("SOLVED");
                                        ?>
					
					

				
                                        <?php 
                                                MobilitySharp\controller\listPartnerMessages("CANCELLED");
                                        ?>
					
					

				
                                        <?php 
                                                MobilitySharp\controller\listPartnerMessages("DECLINED");
                                        ?>
					
					
                                    <?php
                                }
                                else if($_SESSION["user"]["role"]=="ADMIN"){
                                    
                                    ?>
                                        
                                        <?php 
                                                MobilitySharp\controller\listPartnerMessagesAdmin("REQUESTED");
                                        ?>
					
					

				
                                        <?php 
                                                MobilitySharp\controller\listPartnerMessagesAdmin("IN PROCCESS");
                                        ?>
					
					

				
                                        <?php 
                                                MobilitySharp\controller\listPartnerMessagesAdmin("SOLVED");
                                        ?>
					
					

				
                                        <?php 
                                                MobilitySharp\controller\listPartnerMessagesAdmin("CANCELLED");
                                        ?>
					
					

				
                                        <?php 
                                                MobilitySharp\controller\listPartnerMessagesAdmin("DECLINED");
                                        ?>
					
					
                                        
                                        <?php
                                }
                                    ?>
				
                                
                                
				
			</div>	
			
		</div>	
		
	</div><!--/.col-->	
			
</div>
</div>
        </div>
        <?php
        include "footer.html";
        ?>
</html>