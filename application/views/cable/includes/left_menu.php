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
						<li><a href="<?php echo base_url('cable/');?>"><i class="md md-settings"></i> Dashboard</a></li>
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
					<a href="#" class="waves-effect <?php if($this->uri->segment(2)=='mso' || $this->uri->segment(2)=='lco' || $this->uri->segment(2)=='package' || $this->uri->segment(2)=='tax' || $this->uri->segment(2)=='area' || $this->uri->segment(2)=='sub_area' || $this->uri->segment(2)=='staff' || $this->uri->segment(2)=='channel' || $this->uri->segment(2)=='stb'){echo 'subdrop active-menu';}?>"><i class="md ion-android-settings "></i>
					<span> Master Panel </span> <span class="pull-right"><?php if($this->uri->segment(2)=='mso' || $this->uri->segment(2)=='lco' || $this->uri->segment(2)=='package' || $this->uri->segment(2)=='tax' || $this->uri->segment(2)=='area' || $this->uri->segment(2)=='sub_area' || $this->uri->segment(2)=='staff' || $this->uri->segment(2)=='channel' || $this->uri->segment(2)=='stb'){echo '<i class="md md-remove"></i>';}else{echo '<i class="md md-add"></i>';}?></span></a>
					<ul class="list-unstyled" <?php if($this->uri->segment(2)=='mso' || $this->uri->segment(2)=='lco' || $this->uri->segment(2)=='package' || $this->uri->segment(2)=='tax'  || $this->uri->segment(2)=='area' || $this->uri->segment(2)=='sub_area' || $this->uri->segment(2)=='staff' || $this->uri->segment(2)=='channel' || $this->uri->segment(2)=='stb'){echo 'style="display:block"';}?>>
						<li><a href="<?php echo base_url('cable/mso');?>">MSO Master</a></li>
						<li><a href="<?php echo base_url('cable/lco');?>">LCO Master</a></li>
						
						<li><a href="<?php echo base_url('cable/stb');?>">STB Model</a></li>
						<li><a href="<?php echo base_url('cable/package');?>">Package Master</a></li>
						<li><a href="<?php echo base_url('cable/channel');?>">Channel Master</a></li>
						<!--<li><a href="<?php echo base_url('cable/area');?>">Area Master</a></li>
						<li><a href="<?php echo base_url('cable/sub_area');?>">Sub-Area Master</a></li>-->
						<li><a href="<?php echo base_url('cable/staff');?>">Staff Master</a></li>
						<li><a href="<?php echo base_url('cable/customers/import');?>">Import Customers</a></li>
					</ul>
				</li>
				<li class="has_sub">
					<a href="#" class="waves-effect"<?php if($this->uri->segment(2)=='customers'){echo 'subdrop active-menu';}?>><i class="md ion-person"></i>
					<span> Customers </span> <span class="pull-right"><?php if($this->uri->segment(2)=='customers'){echo '<i class="md md-remove"></i>';}else{echo '<i class="md md-add"></i>';}?></span></a>
					<ul class="list-unstyled" <?php if($this->uri->segment(2)=='customers'){echo 'style="display:block"';}?>>
						<li><a href="<?php echo base_url('cable/customers/add');?>">Add Customer</a></li>
						<li><a href="<?php echo base_url('cable/customers');?>">Customer List</a></li>
						<li><a href="<?php echo base_url('cable/customers/top_up');?>">Multi Topup</a></li>
					</ul>
				</li>
				<li class="has_sub">
					<a href="#" class="waves-effect"<?php if($this->uri->segment(2)=='reports'){echo 'subdrop active-menu';}?>><i class="md ion-person"></i>
					<span> Reports </span> <span class="pull-right"><?php if($this->uri->segment(2)=='reports'){echo '<i class="md md-remove"></i>';}else{echo '<i class="md md-add"></i>';}?></span></a>
					<ul class="list-unstyled" <?php if($this->uri->segment(2)=='reports'){echo 'style="display:block"';}?>>
						<li><a href="<?php echo base_url('cable/reports');?>">Active Customers Reports</a></li>
						<li><a href="<?php echo base_url('cable/reports/get_all_customers_details');?>">All Customers List</a></li>
						<li><a href="<?php echo base_url('cable/reports/collector_due');?>">Collector Wise Due</a></li>
						<li><a href="<?php echo base_url('cable/reports/collector_payment');?>">Collector Wise Payment</a></li>
						<li><a href="<?php echo base_url('cable/reports/daily_collection');?>">Daily Collection</a></li>
						<li><a href="<?php echo base_url('cable/reports/package_wise_customer');?>">Package Wise Customer</a></li>
						<!--<li><a href="<?php echo base_url('cable/reports/deactive_customer');?>">Deactive Customers Reports</a></li>
						<li><a href="<?php echo base_url('cable/reports/date_wise_payment');?>">Date Wise Payment</a></li>
						<li><a href="<?php echo base_url('cable/reports/month_wise_payment');?>">Month Wise Payment</a></li>
						<li><a href="<?php echo base_url('cable/reports/monthly_billing_report');?>">Monthly Billing Report</a></li>
						<li><a href="<?php echo base_url('cable/reports/month_wise_payment');?>">Total Payment Report</a></li>
						<li><a href="<?php echo base_url('cable/reports/yearly_payment_report');?>">Yearly Payment Report</a></li>-->
					</ul>
				</li>
				
			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<!-- Left Sidebar End -->