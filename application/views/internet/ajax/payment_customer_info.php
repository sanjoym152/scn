<div class="customer_info">
	<?php 
	/* echo '<pre>';
	print_r($customer); */
	?>
	<div class="col-md-6">
		<div class="form-group">
			<label><?php echo @$customer['first_name'].' '.@$customer['last_name'];?></label>
		</div>
		<div class="form-group">
			<label><?php echo @$customer['mobile1'];?></label>
		</div>
		<div class="form-group">
			<label><?php echo @$customer['address1'];?></label>
		</div>
		<div class="form-group">
			<label><?php echo @$customer['pincode'];?></label>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label>Package: <?php echo $customer['pakname'];?></label>
		</div>
		<div class="form-group">
			<label>Package Fees: Rs.<?php echo @$customer['tot_amount'];?></label>
		</div>
		<div class="form-group">
			<label>Total outstanding: Rs.<?php echo @$customer['balance'];?><br><small>(including package charge)</small></label>
		</div>
	</div>
</div>