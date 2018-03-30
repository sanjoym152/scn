<?php
	tcpdf();
	$custom_size="A4";
	$obj_pdf = new TCPDF('P', PDF_UNIT, $custom_size , true, 'UTF-8', false);
	$obj_pdf->SetCreator(PDF_CREATOR);
	$obj_pdf->SetTitle('SCN | CUSTOMER - CABLE - CUSTOMER PAYMENT');
	$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	$obj_pdf->SetDefaultMonospacedFont('helvetica');
	$obj_pdf->SetHeaderMargin(0);
	$obj_pdf->SetFooterMargin(0);
	$obj_pdf->SetMargins(3, 6, PDF_MARGIN_RIGHT);
	$obj_pdf->SetAutoPageBreak(TRUE, 0);
	$obj_pdf->SetFont('helvetica', '', 9);
	$obj_pdf->setFontSubsetting(false);
	$obj_pdf->AddPage();
	ob_start();
	?>
<!DOCTYPE html>
<html>
	<head>
		<style>
			body{
			background:#fff;
			}
			.header_area{
			text-align: center;
			border: solid 1px #000;
			margin: 10px 0 0;
			}
			.body_area{
			border-bottom: solid 1px #000;
			height: 290px;
			border-left: solid 1px #000;
			border-right: solid 1px #000;
			padding: 18px;
			}
			.office_area{
			height: 121px;
			border-bottom: solid 1px #000;
			border-left: solid 1px #000;
			border-right: solid 1px #000;
			}
		</style>
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<style>
			.inner_table tr td{
			font-family:Arial, Helvetica, sans-serif;
			font-size:10px;
			padding:10px 10px;
			vertical-align:middle;
			line-height:20px; 
			}
			.font-bold{
			font-weight:bold;
			}
			.inner_table tr td h4{
			font-size:10px;
			margin:0;
			padding:10px;
			}
			.border{
			border:1px solid #ddd;
			}
			.innertable{
			padding-top:20px;
			}
			.bg_ash{
			background:#ccc;
			padding:10px 10px;
			font-family:Arial, Helvetica, sans-serif;
			}
			.bg_ash_1{
			background:#fefefe;
			padding:10px 10px;
			font-family:Arial, Helvetica, sans-serif;
			}
			.aaa>tr>td{
			font-size:8px;
			}
		</style>
	</head>
	<body>
		<h3 align="center" style="line-height:20px; font-size:10px">CUSTOMER PAYMENT REPORT</h3>
		<span align="center" style="font-size:7px; line-height:10px;">OFFICE COPY</span>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" data-pattern="priority-columns">
				<table id="datatable" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>#</th>
							<th>CUSTOMER CODE</th>
							<th>OTHER ID</th>
							<th>STAFF NAME</th>
							<th>CUSTOMER NAME</th>
							<th>ADDRESS</th>
							<th>STB</th>
							<th>ACCOUNT</th>
							<th>MOBILE</th>
							<th>PAY DATE</th>
							<th>PAY FOR MONTH</th>
							<th>PAY AMOUNT</th>
							<th>DUE AMOUNT</th>
							<!--<th>COLLECTOR</th>-->
							
						</tr>
					</thead>
					<tbody>
						<?php 
						$i=1;
						if(@$customer_details){
							foreach($customer_details as $row){
							?>
							<tr>
								<td><?php echo @$i++;?></td>
								<td><?php echo @$row['cust_code'];?></td>
								<td><?php echo @$row['area_name'].'-'.@$row['other_id'];?></td>
								<td><?php echo @$row['staff_name'];?></td>
								<td><?php echo @$row['first_name'].' '.@$row['last_name'];?></td>
								<td><?php echo @$row['address1'];?></td>
								<td><?php echo @$row['stb_no'];?></td>
								<td><?php echo @$row['account'];?></td>
								<td><?php echo @$row['mobile1'];?></td>
								<td><?php echo @$row['payment_date'];?></td>
								<td>
								<?php $dateObj   = DateTime::createFromFormat('!m', $row['month_of']);
								$monthName = $dateObj->format('F');
								echo @$row['month_of']?$monthName.' '.date('Y'):'N/A';?></td>
								<td><?php echo @$row['payment_total'];?></td>
								<td><?php echo @$row['balance']?></td>
								<!--<td><?php echo @$row['staff_name']?></td>-->
							</tr>
							<?php 
							}
						}else{
						?>
						<tr>
							<td colspan="14" class="text-center">No result(s) found.</td>
						<tr/>
						<?php 
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>
<?php
	$name='DAILY-COLLECTION-'.date('Y-m-d H:i:s');
	   $content = ob_get_contents();
	   ob_end_clean();
	   $obj_pdf->writeHTML($content, true, false, true, false, '');
	   $obj_pdf->Output($name.'.pdf', 'I');
	?>