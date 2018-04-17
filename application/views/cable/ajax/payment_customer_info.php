<div class="customer_info">
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
	<div class="clearfix"></div>
	<div class="col-md-12 noPad">
		<div class="col-md-12">
		<h4>Last Payment Information</h4>
		</div>
		<div class="col-md-4"><label>Pay Date: <?php echo @$last_payment['payment_date']?$last_payment['payment_date']:'N/A';?></label></div>
		<div class="col-md-4"><label>Pay Amount: <?php echo @$last_payment['payment_total']?'Rs.'.$last_payment['payment_total']:'N/A';?></label></div>
		<div class="col-md-4"><label>Month of: <?php @$last_payment['month_of']; ?></label></div>
	</div>
</div>