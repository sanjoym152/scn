<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
	<div class="sidebar-inner slimscrollleft">
		<div class="user-details">
			<div class="pull-left">
				<img src="assets/images/users/avatar-1.jpg" alt="" class="thumb-md img-circle">
			</div>
			<div class="user-info">
				<div class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo $this->session->userdata('name');?> <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url('internet/');?>"><i class="md md-settings"></i> Dashboard</a></li>
						<li><a href="javascript:void(0)"><i class="md md-settings"></i> Change Password</a></li>
						<li><a href="<?php echo base_url('home/logout');?>"><i class="md md-settings-power"></i> Logout</a></li>
					</ul>
				</div>
				<?php 
				if($this->session->userdata('user_type')==1){
				?>
				<p class="text-muted m-0">Administrator</p>
				<?php 
				}else if($this->session->userdata('user_type')==2){
				?>
				<p class="text-muted m-0">Sub-Admin</p>
				<?php 
				}
				?>
			</div>
		</div>
		<!--- Divider -->
		<div id="sidebar-menu">
			<ul>
				<li class="has_sub">
					<a href="#" class="waves-effect <?php if($this->uri->segment(2)=='isp' || $this->uri->segment(2)=='lco' || $this->uri->segment(2)=='package' || $this->uri->segment(2)=='tax' || $this->uri->segment(2)=='area' || $this->uri->segment(2)=='sub_area' || $this->uri->segment(2)=='staff'){echo 'subdrop active-menu';}?>"><i class="md ion-android-settings "></i>
					<span> Master Panel </span> <span class="pull-right"><?php if($this->uri->segment(2)=='isp' || $this->uri->segment(2)=='lco' || $this->uri->segment(2)=='package' || $this->uri->segment(2)=='tax' || $this->uri->segment(2)=='area' || $this->uri->segment(2)=='sub_area' || $this->uri->segment(2)=='staff'){echo '<i class="md md-remove"></i>';}else{echo '<i class="md md-add"></i>';}?></span></a>
					<ul class="list-unstyled" <?php if($this->uri->segment(2)=='isp' || $this->uri->segment(2)=='lco' || $this->uri->segment(2)=='package' || $this->uri->segment(2)=='tax'  || $this->uri->segment(2)=='area' || $this->uri->segment(2)=='sub_area' || $this->uri->segment(2)=='staff'){echo 'style="display:block"';}?>>
						<li><a href="<?php echo base_url('internet/isp');?>">ISP Master</a></li>
						<li><a href="<?php echo base_url('internet/lco');?>">LCO Master</a></li>
						<li><a href="<?php echo base_url('internet/tax');?>">TAX Master</a></li>
						<li><a href="<?php echo base_url('internet/package');?>">Package Master</a></li>
						<!--<li><a href="<?php echo base_url('internet/area');?>">Area Master</a></li>
						<li><a href="<?php echo base_url('internet/sub_area');?>">Sub-Area Master</a></li>-->
						<li><a href="<?php echo base_url('internet/staff');?>">Staff Master</a></li>
					</ul>
				</li>
				<li class="has_sub">
					<a href="#" class="waves-effect"<?php if($this->uri->segment(2)=='customers'){echo 'subdrop active-menu';}?>><i class="md ion-person"></i>
					<span> Customers </span> <span class="pull-right"><?php if($this->uri->segment(2)=='customers'){echo '<i class="md md-remove"></i>';}else{echo '<i class="md md-add"></i>';}?></span></a>
					<ul class="list-unstyled" <?php if($this->uri->segment(2)=='customers'){echo 'style="display:block"';}?>>
						<li><a href="<?php echo base_url('internet/customers/add');?>">Add Customer</a></li>
						<li><a href="<?php echo base_url('internet/customers');?>">Customer List</a></li>
					</ul>
				</li>
				<li class="has_sub">
					<a href="#" class="waves-effect"<?php if($this->uri->segment(2)=='reports'){echo 'subdrop active-menu';}?>><i class="md ion-person"></i>
					<span> Reports </span> <span class="pull-right"><?php if($this->uri->segment(2)=='reports'){echo '<i class="md md-remove"></i>';}else{echo '<i class="md md-add"></i>';}?></span></a>
					<ul class="list-unstyled" <?php if($this->uri->segment(2)=='reports'){echo 'style="display:block"';}?>>
						<!--<li><a href="<?php echo base_url('internet/reports/');?>">Customers Reports</a></li>-->
						<li><a href="<?php echo base_url('internet/reports/daily_collection');?>">Daily Collection</a></li>
						<li><a href="<?php echo base_url('internet/reports/collector_due');?>">Collector wise Due</a></li>
						<!--<li><a href="<?php echo base_url('internet/reports/staff_commission');?>">Staff Commission</a></li>-->
					</ul>
				</li>
				
			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="col-md-12 text-danger text-center show_bal" style="cursor:pointer"><strong><u>Click here.</u></strong></div>
		<div class="col-md-12 text-center bal_area" style="display:none">
			<?php $customers = get_total_cust_internet(); ?>
			<span class="text-center btn" style="color:#fff">Amount: Rs.<?php echo $customers['tot_balance'];?></span><br><br>
			<span class="text-center btn" style="color:#fff">Total Customer: <?php echo $customers['tot_customers'];?></span>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<!-- Left Sidebar End -->