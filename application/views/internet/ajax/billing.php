<span class="pull-right">Balance : Rs. <?php echo @$billing[0]['balance']; ?></span>
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
		<!--<th>PAYMENT</th>
		<th>TOTAL</th>
		<!--<th>Status</th>-->
		<th>COLLECTOR</th>
		<th>ACTION</th>
	</thead>
	<tbody>
		<?php 
		if(@$billing){ foreach($billing as $row){ ?>
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
				<td><?php echo @date('d/m/Y',strtotime($row['payment_date']));?></td>
				<td><?php echo @$row['payment_total'];?></td>
				<td><?php echo @$row['dis'];?></td>
				<!--<td><?php echo @$row['type']==1?@$row['payment_total']:'N/A';?></td>
				<td><?php echo @$row['type']==1?@$row['outstanding']-@$row['payment_total']:@$row['payment_total'];?></td>
				<td><?php echo @$row['payment_total'];?></td>-->
				<!--<td>Paid</td>-->
				<td><?php echo @$row['staff_name']?$row['staff_name']:'Office';?></td>
				<td>
					<a href="<?php echo base_url('internet/customers/delete_billing/'.$row['payment_id']);?>" data-toggle="tooltip" title="Delete"  onclick="return confirm('Are you sure?')"><i class="fa fa-trash" aria-hidden="true"></i></a>
					<a href="javascript:;" data-toggle="tooltip" data-id="<?php echo @$row['payment_id'];?>" title="Pay Now" class="payment"><i class="fa fa-inr" aria-hidden="true"></i></a>
					<?php if(@$row['type']==1){
					?>
					<a target="_blank" href="<?php echo base_url('internet/customers/bill_print/'.$row['payment_id']);?>" data-toggle="tooltip" title="Delete"><i class="fa fa-print" aria-hidden="true"></i></a>
					<?php 
					}else{ ?>
					<a target="_blank" href="<?php echo base_url('internet/customers/topup_bill_print/'.$row['payment_id']);?>" data-toggle="tooltip" title="Delete"><i class="fa fa-print" aria-hidden="true"></i></a>	
					<?php } ?>
				</td>
			</tr>
		<?php }} ?>
	</tbody>
</table>