<span class="pull-right">Balance : Rs. <?php echo @$billing[0]['balance']; ?></span>
<table class="table table-striped">
	<thead>
		<th>TYPE</th>
		<th>DATE</th>
		<th>No.</th>
		<th>DUES</th>
		<th>PACKAGE</th>
		<th>OTHER</th>
		<th>DISCOUNT</th>
		<th>PAYMENT</th>
		<th>MONTH OF</th>
		<th>TOTAL</th>
		<!--<th>Status</th>-->
		<th>COLLECTOR</th>
		<th>ACTION</th>
	</thead>
	<tbody>
		<?php 
		if(@$billing){ foreach($billing as $row){ ?>
			<tr>
				
				<td>
				<?php if(@$row['type']==2){ echo "BILL"; }else if(@$row['type']==1){ echo "PAY"; } ?>
				</td>
				<td><?php echo @date('d/m/Y',strtotime($row['payment_date']));?></td>
				<td><?php echo @$row['payment_id'];?></td>
				<td><?php echo @$row['outstanding'];?></td>
				<td><?php echo @$row['pack_amount'];?></td>
				<td><?php echo @$row['other_fees'];?></td>
				<td><?php echo @$row['dis'];?></td>
				<td><?php echo @$row['type']==1?@$row['payment_total']:'N/A';?></td>
				<td>
				<?php $dateObj   = DateTime::createFromFormat('!m', $row['month_of']);
				$monthName = $dateObj->format('F');
				echo @$row['month_of']?$monthName.' '.date('Y'):'N/A';?></td>
				<td><?php echo @$row['payment_total'];?></td>
				
				<!--<td>Paid</td>-->
				<td><?php echo @$row['staff_name']?$row['staff_name']:'Office';?></td>
				<td>
					<a href="<?php echo base_url('cable/customers/delete_billing/'.$row['payment_id']);?>" data-toggle="tooltip" title="Delete"  onclick="return confirm('Are you sure?')"><i class="fa fa-trash" aria-hidden="true"></i></a>
					<?php if(@$row['type']==1){
					?>
					<a target="_blank" href="<?php echo base_url('cable/customers/bill_print/'.$row['payment_id']);?>" data-toggle="tooltip" title="Delete"><i class="fa fa-print" aria-hidden="true"></i></a>
					<?php 
					}else{ ?>
					<a target="_blank" href="<?php echo base_url('cable/customers/topup_bill_print/'.$row['payment_id']);?>" data-toggle="tooltip" title="Print"><i class="fa fa-print" aria-hidden="true"></i></a>	
					<?php } ?>
				</td>
			</tr>
		<?php }} ?>
	</tbody>
</table>