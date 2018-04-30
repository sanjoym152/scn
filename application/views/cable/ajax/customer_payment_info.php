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
		<th>DUE</th>
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
		@$i = date('m', strtotime($payment_info[0]['billing_date']));
		foreach($payment_info as $row){ ?>
		<tr>
			<td>
			<?php 
				$dateObj = DateTime::createFromFormat('!m',  $i);
				echo $monthName = $dateObj->format('M'); $i++;?>
			<?php //echo date('M', strtotime($row['billing_date'])); ?></td>
			<td><?php echo date('d/m/Y', strtotime($row['billing_date'])); ?></td>
			<td><?php echo @$row['pack_amount']; ?></td>
			<td>ALA CA</td>
			<td><?php echo @$row['outstanding']; ?></td>
			<td><?php echo @$row['billing_total']; ?></td>
			<td><?php echo @$row['payment_date']?$row['payment_date']:'N/A'; ?></td>
			<td><?php echo @$row['staff_name']; ?></td>
			<td><?php echo @$row['discount_total']; ?></td>
			<td><?php echo @$row['other_fees']; ?></td>
			<td><?php echo @$row['payment_total']; ?></td>
			<td width="10%">
				<a href="javascript:;" data-id="<?php echo @$row['customer_id']; ?>" data-payment_id="<?php echo @$row['payment_id']; ?>" class="add_payment" data-toggle="tooltip" title="Add payment"><i class="fa fa-plus" aria-hidden="true"></i></a>
				<a href="javascript:;" data-toggle="tooltip" title="Edit" onclick="editPayment(5913)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
				<a href="http://localhost/scn/cable/customers/delete_billing/5913" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure?')"><i class="fa fa-trash" aria-hidden="true"></i></a>
				<a target="_blank" href="http://localhost/scn/cable/customers/bill_print/5913" data-toggle="tooltip" title="Print bill"><i class="fa fa-print" aria-hidden="true"></i></a>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
