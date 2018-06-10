<div class="topbar">
	<!-- LOGO -->
	<div class="topbar-left">
		<div class="text-center">
			<a href="<?php echo base_url('cable');?>" class="logo"><img src="image1/logo.png" width="50" />
				<!--<img src="image1/lgo.png" class="img-responsive" alt=""><!--<span>Moltran </span>-->
			</a>
		</div>
	</div>
	<!-- Button mobile view to collapse sidebar menu -->
	<div class="navbar navbar-default" role="navigation">
		<div class="container">
			<div class="">
				<div class="pull-left">
					<button class="button-menu-mobile open-left">
					<i class="fa fa-bars"></i>
					</button>
					<span class="clearfix"></span>
				</div>
				
				<ul class="nav navbar-nav navbar-right pull-right">
					
					<li class="dropdown">
						<a href="#" class="dropdown-toggle profile" data-toggle="dropdown" aria-expanded="true"><img src="assets/images/users/avatar-1.jpg" alt="user-img" class="img-circle"> </a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo base_url('internet/');?>"><i class="md md-settings"></i> Dashboard</a></li>
							<li><a href="javascript:void(0)"><i class="md md-settings"></i> Change Password</a></li>
							<li><a href="<?php echo base_url('home/logout');?>"><i class="md md-settings-power"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</div>
</div>