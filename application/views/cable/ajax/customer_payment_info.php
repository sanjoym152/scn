<?php 
/* echo "<pre>";
print_r($payment_info); *///die;
?>
<table class="table table-striped">
	<thead>
		<th>MONTH</th>
		<th>BILL DATE</th>
		<th>PACK AMOUNT</th>
		<th>ALA CA</th>
		<!--<th>DUE</th>-->
		<th>TOTAL</th>
		<th>PAY DATE</th>
		<th>COLLECTOR</th>
		<th>DISCOUNT</th>
		<th>OTHER</th>
		<th>PAY AMOUNT</th>
		<th>ACTION</th>
	</thead>
	<tbody>
		<?php 
		if(@$payment_info){ 
			@$i = date('m', strtotime($payment_info[0]['billing_date']));
			foreach($payment_info as $row){ ?>
			<tr>
				<td>
					<?php $dateObj = DateTime::createFromFormat('!m',  $i);
					echo $monthName = $dateObj->format('M'); $i++; ?>
				</td>
				<td><?php echo date('d/m/Y', strtotime($row['billing_date'])); ?></td>
				<td><?php echo @$row['pack_amount']; ?></td>
				<td>ALA CA</td>
				<!--<td><?php echo @$row['outstanding']; ?></td>-->
				<td><?php echo @$row['billing_total']; ?></td>
				<td><?php echo @$row['payment_date']?$row['payment_date']:'N/A'; ?></td>
				<td><?php echo @$row['staff_name']; ?></td>
				<td><?php echo @$row['discount_total']; ?></td>
				<td><?php echo @$row['other_fees']; ?></td>
				<td><?php echo @$row['payment_total']; ?></td>
				<td width="10%">
					<?php if(!@$row['status']){ ?>
					<a href="javascript:;" data-id="<?php echo @$row['customer_id']; ?>" data-payment_id="<?php echo @$row['payment_id']; ?>" class="add_payment" data-toggle="tooltip" title="Add payment"><i class="fa fa-plus" aria-hidden="true"></i></a>	
					<?php } ?>
					
					<a href="javascript:;" class="edit_payment" data-customer_id="<?php echo @$row['customer_id']; ?>" data-id="<?php echo @$row['payment_id']; ?>" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
					
					<a target="_blank" href="<?php echo base_url('cable/customers/bill_print/'.@$row['payment_id'])?>" data-toggle="tooltip" title="Print bill"><i class="fa fa-print" aria-hidden="true"></i></a>
					
					<a href="javascript:;" class="delete_payment" data-id="<?php echo @$row['payment_id'];?>" data-customer_id="<?php echo @$row['customer_id']; ?>" data-toggle="tooltip" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
				</td>
			</tr>
		<?php } } else{ ?>
			<tr>
				<td colspan="12" align="center">
					<h5>No bill generated in this year.<br> Click <a target="_blank" href="<?php echo base_url('cable/customers/top_up')?>">here</a> to generate a bill.</h5>
				</td>
			</tr>
		<?php }  ?>
	</tbody>
</table>
<div class="due_area col-md-12">
	<div class="col-md-3">Billing Total: <?php echo @$payment_total_info['billing_tot'];?></div>
	<div class="col-md-3">Due: <?php echo @$customer_info['balance'];?></div>
	<div class="col-md-3">Discount: <?php echo @$payment_total_info['discount_tot'];?></div>
	<div class="col-md-3">Payment Total: <?php echo @$payment_total_info['payment_tot'];?></div>
</div>
