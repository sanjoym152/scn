<span class="pull-right">Balance : Rs. <?php echo @$billing[0]['balance']; ?></span>
<table class="table table-striped">
	<thead>
		<!--<th>Bill MonthOf</th>-->
		<th>Payment Date</th>
		<th>Bill No.</th>
		<th>Sub Total</th>
		<th>Other Fees</th>
		<th>Discount</th>
		<th>Final Amount</th>
		<!--<th>Status</th>-->
		<th>Collector</th>
		<th>Action</th>
	</thead>
	<tbody>
		<?php 
		/* echo "<pre>";
		print_r($billing);die; */
		if(@$billing){ foreach($billing as $row){ ?>
			<tr>
				<!--<td>
				<?php 
				$dateObj = DateTime::createFromFormat('!m',  @$row['month_of']);
				echo $monthName = $dateObj->format('F');?>
				</td>-->
				<td><?php echo @date('d/m/Y',strtotime($row['payment_date']));?></td>
				<td><?php echo @$row['payment_id'];?></td>
				<td><?php echo @$row['pack_amount'];?></td>
				<td><?php echo @$row['other_fees'];?></td>
				<td><?php echo @$row['dis'];?></td>
				<td width="30%"><?php echo @$row['p_tot'];?></td>
				<!--<td>Paid</td>-->
				<td><?php echo @$row['staff_name']?$row['staff_name']:'N/A';?></td>
				<td>
					<a href="<?php echo base_url('internet/customers/delete_billing/'.$row['payment_id']);?>" data-toggle="tooltip" title="Delete"  onclick="return confirm('Are you sure?')"><i class="fa fa-trash" aria-hidden="true"></i></a>
					<a target="_blank" href="<?php echo base_url('internet/customers/topup_bill_print/'.$row['payment_id']);?>" data-toggle="tooltip" title="Delete"><i class="fa fa-print" aria-hidden="true"></i></a>
				</td>
			</tr>
		<?php }} ?>
	</tbody>
</table>