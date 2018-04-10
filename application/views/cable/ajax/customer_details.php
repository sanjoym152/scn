<div class="col-md-12">
	<div class="info_ii">
		<p>Basic Information</p>
	</div>
	<div class="col-md-6">
		<span class="">Other ID: <?php echo @$customer['other_id'];?></span>
	</div>
	<div class="col-md-6">
		<span class="">CAF No.: <?php echo @$customer['caf_no'];?></span>
	</div>
	
	<div class="col-md-6">
		<span class="">Mobile1: <?php echo @$customer['mobile1'];?></span>
	</div>
	
	<div class="col-md-6">
		<span class="">Address1: <?php echo @$customer['address1'];?></span>
	</div>
	
	<div class="col-md-6">
		<span class="">Mobile2: <?php echo @$customer['mobile2'];?></span>
	</div>
	
	<div class="col-md-6">
		<span class="">Address2: <?php echo @$customer['address2'];?></span>
	</div>
	<div class="col-md-6">
		<span class="">Email: <?php echo @$customer['email'];?></span>
	</div>
	
	<div class="col-md-6">
		<span class="">DOB: <?php echo (@$customer['dob'])?(date('d/m/Y',strtotime($customer['dob']))):'';?></span>
	</div>
	<div class="col-md-6">
		<span class="">Gender: <?php echo @$customer['gender']==1?'Male':'Female';?></span>
	</div>
	
	<div class="col-md-6">
		<span class="">Pincode: <?php echo @$customer['pincode'];?></span>
	</div>
	
	
	<div class="clearfix"></div>
	<div class="info_ii">
		<p>Connection Information</p>
	</div>
	<div class="col-md-6">
		<span class="">Package: <?php echo @$customer['pakname'];?><strong>(<?php echo @$customer['pkg_mode'];?> month)</strong></span>
	</div>
	<div class="col-md-6">
		<span class="">LCO: <?php echo @$customer['lconame'];?></span>
	</div>
	<div class="col-md-6">
		<span class="">Connection Date: <?php echo @date('d/m/Y',strtotime($customer['connection_date']));?></span>
	</div>
	<div class="col-md-6">
		<span class="">ISP: <?php echo @$customer['mso'];?></span>
	</div>
	<div class="col-md-6">
		<span class="">Balance: Rs.<?php echo @$customer['balance'];?></span>
	</div>
	<div class="col-md-6">
		<span class="">STB Amount: Rs.<?php echo @$customer['stb_amount'];?></span>
	</div>
	<div class="info_ii">
		<p>STB Information</p>
	</div>
	<div class="ip_area">
		<table class="table table-striped">
			<tr>
				<th>STB No.</th>
				<th>STB Model</th>
				<th>Account</th>
			</tr>
			<?php if(@$customer_ip){ foreach($customer_ip as $row){ ?>
			<tr>
				<td><?php echo @$row['stb_no'];?></td>
				<td><?php echo @$row['stb_model_no'];?></td>
				<td><?php echo @$row['account'];?></td>
			</tr>
			<?php }} ?>
			
		</table>
	</div>
</div>