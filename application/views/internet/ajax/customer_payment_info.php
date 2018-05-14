<table class="table table-striped">
	<thead>
		<th>NO</th>
		<th>START DATE</th>
		<th>END DATE</th>
		<th>PACKAGE</th>
		<th>OTHER</th>
		<th>BILLING TOTAL</th>
		<th>PAYMENT DATE</th>
		<th>PAYMENT TOTAL</th>
		<th>DISCOUNT</th>
		<th>COLLECTOR</th>
		<th>ACTION</th>
	</thead>
	<tbody>
		<?php 
		if(@$payment_info){ foreach($payment_info as $row){ ?>
		<tr>
			<!--<td>
			<?php 
			$dateObj = DateTime::createFromFormat('!m',  @$row['month_of']);
			echo $monthName = $dateObj->format('F');?>
			</td>-->
			<td><?php echo @$row['payment_id'];?></td>
			<td><?php echo @date('d/m/Y',strtotime(@$row['pack_start_date']));?></td>
			<td><?php echo @date('d/m/Y',strtotime(@$row['pack_end_date']));?></td>
			<td><?php echo @$row['pack_amount'];?></td>
			<td><?php echo @$row['other_fees'];?></td>
			<td><?php echo @$row['billing_total'];?></td>
			<td><?php echo @$row['payment_date']?date('d/m/Y',strtotime($row['payment_date'])):'N/A';?></td>
			<td><?php echo @$row['payment_total'];?></td>
			<td><?php echo @$row['dis'];?></td>
			<td><?php echo @$row['staff_name']?$row['staff_name']:'N/A';?></td>
			<td width="10%">
				<?php if(!@$row['status']){ ?>
					<a href="javascript:;" data-id="<?php echo @$row['customer_id']; ?>" data-payment_id="<?php echo @$row['payment_id']; ?>" class="add_payment" data-toggle="tooltip" title="Add payment"><i class="fa fa-plus" aria-hidden="true"></i></a>
				<?php } ?>
				
				<a href="javascript:;" class="edit_payment" data-customer_id="<?php echo @$row['customer_id']; ?>" data-id="<?php echo @$row['payment_id']; ?>" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
				
				<a target="_blank" href="<?php echo base_url('internet/customers/bill_print/'.@$row['payment_id'])?>" data-toggle="tooltip" title="Print bill"><i class="fa fa-print" aria-hidden="true"></i></a>
				
				<a href="javascript:;" class="delete_payment" data-id="<?php echo @$row['payment_id'];?>" data-customer_id="<?php echo @$row['customer_id']; ?>" data-toggle="tooltip" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
			</td>
		</tr>
		<?php }} ?>
	</tbody>
</table>
<div class="due_area col-md-12">
	<div class="col-md-3">Billing Total: <?php echo @$payment_total_info['billing_tot'];?></div>
	<div class="col-md-3">Due: <?php echo @$customer_info['balance'];?></div>
	<div class="col-md-3">Discount: <?php echo @$payment_total_info['discount_tot'];?></div>
	<div class="col-md-3">Payment Total: <?php echo @$payment_total_info['payment_tot'];?></div>
</div>
