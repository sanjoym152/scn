<div class="col-md-12">
	<div class="info_ii">
		<p>Basic Information</p>
	</div>
	<div class="col-md-6">
		<span class="">Name: <?php echo @$customer_preview['first_name'];?></span>
	</div>
	<div class="col-md-6">
		<span class="">Mobile1: <?php echo @$customer_preview['mobile1'];?></span>
	</div>
	<div class="clearfix"></div>
	<div class="col-md-6">
		<span class="">Address1: <?php echo @$customer_preview['address1'];?></span>
	</div>
	<div class="col-md-6">
		<span class="">Mobile2: <?php echo @$customer_preview['mobile2'];?></span>
	</div>
	<div class="clearfix"></div>
	<div class="col-md-6">
		<span class="">Address2: <?php echo @$customer_preview['address2'];?></span>
	</div>
	<div class="col-md-6">
		<span class="">Email: <?php echo @$customer_preview['email'];?></span>
	</div>
	<div class="clearfix"></div>
	<div class="col-md-6">
		<span class="">DOB: <?php echo (@$customer_preview['dob'])?(date('d/m/Y',strtotime($customer_preview['dob']))):'';?></span>
	</div>
	<div class="col-md-6">
		<span class="">Gender: <?php echo @$customer_preview['gender']==1?'Male':'Female';?></span>
	</div>
	<div class="clearfix"></div>
	<div class="col-md-6">
		<span class="">Pincode: <?php echo @$customer_preview['pincode'];?></span>
	</div>
	<div class="col-md-6">
		<span class="">Other ID: <?php echo @$customer_preview['other_id'];?></span>
	</div>
	
	<div class="clearfix"></div>
	<div class="info_ii">
		<p>Connection Information</p>
	</div>
	<div class="col-md-6">
		<span class="">Package: <?php echo @$customer_preview['pakname'];?><strong>(<?php echo @$customer_preview['pkg_mode'];?> month)</strong></span>
	</div>
	<!--<div class="col-md-6">
		<span class="">LCO: <?php echo @$customer_preview['lconame'];?></span>
	</div>-->
	<div class="col-md-6">
		<span class="">Connection Date: <?php echo @date('d/m/Y',strtotime($customer_preview['connection_date']));?></span>
	</div>
	<div class="col-md-6">
		<span class="">Balance: Rs.<?php echo @$customer_preview['balance'];?></span>
	</div>
	<div class="info_ii">
		<p>IP Information</p>
	</div>
	<div class="ip_area">
		<table class="table table-striped">
			<tr>
				<th>IP</th>
				<th>Username</th>
			</tr>
			<?php if(@$customer_preview_ip){ foreach($customer_preview_ip as $row){ ?>
				<tr>
					<td><?php echo @$row['ip_address'];?></td>
					<td><?php echo @$row['username'];?></td>
				</tr>
			<?php }} ?>
			
		</table>
	</div>
</div>