<?php
    tcpdf();
    $custom_size="A4";
    $obj_pdf = new TCPDF('P', PDF_UNIT, $custom_size , true, 'UTF-8', false);
    $obj_pdf->SetCreator(PDF_CREATOR);
    $obj_pdf->SetTitle('SCN | CUSTOMER - CABLE - DAILY cOLLECTION');
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
		<!--<table width="100%" border="0">
			<tr>
				<td width="30%">
					<table>
						<tr>
							<td align="center" border="1" height="80px">
								<h3 style="line-height:20px; font-size:10px">SATALLITE CHANNEL NETWORK</h3><span style="font-size:7px; line-height:10px;">OFFICE COPY</span>
							</td>
						</tr>
						<tr>
							<td align="left" border="1" height="150px">
								<table>
									<tr>
										<td style="font-size:7px; line-height:15px; padding-left:20px;">&nbsp;&nbsp;CUST ID: <?php echo @$userdata['cust_code'];?></td>
										<td style="font-size:7px; line-height:15px; padding-left:20px;">&nbsp;&nbsp;BILL NO: <?php echo @$userdata['payment_id'];?></td>
									</tr>
								</table>
								<table>
									<tr>
										<td style="font-size:7px; line-height:15px; padding-left:20px;">&nbsp;&nbsp;NAME: <strong style="font-size:10px"><?php echo @$userdata['first_name'];?></strong></td>
									</tr>
									<tr>
										<td style="font-size:7px; line-height:15px; padding-left:20px;">&nbsp;&nbsp;ADDRESS: <?php echo @$userdata['address1'];?></td>
									</tr>
									<tr>
										<td style="font-size:7px; line-height:15px; padding-left:20px;">&nbsp;&nbsp;MOBILE: <?php echo @$userdata['mobile1'];?></td>
									</tr>
									<tr>
										<td style="font-size:7px; line-height:15px; padding-left:20px;">&nbsp;&nbsp;COLLECTOR: <?php echo @$userdata['staff_name'];?></td>
									</tr>
									<tr>
										<td style="font-size:7px; line-height:15px; padding-left:20px;">&nbsp;&nbsp;PAYMENT DATE: <?php echo date('d/m/Y',strtotime(@$userdata['payment_date']));?></td>
									</tr>
									<tr>
										<td style="font-size:7px; line-height:15px; padding-left:20px;">&nbsp;&nbsp;PREVIOUS DUE: <?php echo @$userdata['outstanding'];?></td>
									</tr>
									<!--<tr>
										<td style="font-size:7px; line-height:15px; padding-left:20px;">&nbsp;&nbsp;PACKAGE AMOUNT: <?php echo @$userdata['pack_amount'];?></td>
									</tr>
									<tr>
										<td style="font-size:7px; line-height:10px; padding-left:20px;">&nbsp;&nbsp;PAYMENT TYPE: <?php echo @$userdata['payment_id'];?></td>
									</tr>-->
									<!--<tr>
										<td style="font-size:7px; line-height:15px; padding-left:20px;">&nbsp;&nbsp;PAYMENT TOTAL: Rs. <?php echo @$userdata['payment_total'];?></td>
									</tr><tr>
										<td style="font-size:7px; line-height:15px; padding-left:20px;">&nbsp;&nbsp;NET DUE: Rs. <?php echo @$userdata['net_due'];?></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			
				<td width="70%">
					<table>
						<tr>
							<td align="center" border="1" height="80px">
								<h3 style="line-height:20px;"><img src="image1/print_logo.png" width="30" height="30"> SATALLITE CHANNEL NETWORK</h3><center><span style="font-size:7px; line-height:10px;">G B ROAD, NIMTA, 42 PALLY, KOLKATA-700049<br><small>(Bill Payment)</small></span></center>
							</td>
						</tr>
						<tr>
							<td align="left" border="1" height="150px">
								<table class="aaa">
									<tr>
										<td style="font-size:7px; line-height:10px; padding-left:20px;">&nbsp;&nbsp; CUSTOMER ID: <?php echo @$userdata['cust_code'];?></td>
										<td style="font-size:7px; line-height:10px; padding-left:20px;">&nbsp;&nbsp; BILL NO: <?php echo @$userdata['payment_id'];?></td>
									</tr>
									<tr>
										<td style="font-size:7px; line-height:10px; padding-left:20px;">&nbsp;&nbsp; CUSTOMER NAME: <strong style="font-size:10px"><?php echo @$userdata['first_name'];?></strong></td>
										<td style="font-size:7px; line-height:12px; padding-left:20px;">&nbsp;&nbsp; DATE: <?php echo date('d/m/Y',strtotime(@$userdata['payment_date']));?></td>
									</tr>
									<tr>
										<td style="font-size:7px; line-height:10px; padding-left:20px;">&nbsp;&nbsp; ADDRESS: <?php echo @$userdata['address1'];?></td>
										
									</tr>
									<tr>
										<td style="font-size:7px; line-height:10px; padding-left:20px;">&nbsp;&nbsp; MOBILE: <?php echo @$userdata['mobile1'];?></td>
										<!--<td style="font-size:7px; line-height:10px; padding-left:20px;">&nbsp;&nbsp; IP: <?php echo @$userdata['payment_id'];?></td>-->
										<!--<td style="font-size:7px; line-height:10px; padding-left:20px;">&nbsp;&nbsp; STB NO: <?php echo @$userdata['stb_no'];?></td>
									</tr>
									<tr>
										<td style="font-size:7px; line-height:10px; padding-left:20px;">&nbsp;&nbsp; COLLECTOR NAME: <?php echo @$userdata['staff_name'];?></td>
										<td style="font-size:7px; line-height:12px; padding-left:20px;">&nbsp;&nbsp; ACCOUNT: <?php echo @$userdata['account'];?></td>
									</tr>
									<tr>
										<td style="font-size:7px; line-height:10px; padding-left:20px;">&nbsp;&nbsp; PACKAGE: <?php echo @$userdata['pakname'];?></td>
									</tr>
									
								</table>
								<br>
								<br>
								<table border="1" style="margin-left:10px;" align="center">
									<tr>
										<td height="15px" style="font-size:7px; line-height:10px">PREVIOUS DUE</td>
										<!--<td height="15px" style="font-size:7px; line-height:10px">PACKAGE AMOUNT</td>-->
										<!--<td height="15px" style="font-size:7px; line-height:10px">DISCOUNT</td>
										<td height="15px" style="font-size:7px; line-height:10px">PAID AMOUNT</td>
										<td height="15px" style="font-size:7px; line-height:10px">NET DUE</td>
									</tr>
									<tr>
										<td height="15px" style="font-size:7px; line-height:10px">Rs. <?php echo @$userdata['outstanding'];?></td>
										<!--<td height="15px" style="font-size:7px; line-height:10px">Rs. <?php echo @$userdata['pack_amount'];?></td>-->
										<!--<td height="15px" style="font-size:7px; line-height:10px">Rs. <?php echo @$userdata['p_discount'];?></td>
										<td height="15px" style="font-size:7px; line-height:10px">Rs. <?php echo @$userdata['payment_total'];?></td>
										<td height="15px" style="font-size:7px; line-height:10px">Rs. <?php echo @$userdata['net_due'];?></td>
									</tr>
								</table>
								<br /><br />
								<table>
									<tr>
										<td align="right"><strong>Total: Rs. <?php echo @$userdata['payment_total'];?> &nbsp;</strong></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
				
			</tr>
		</table>-->
												<div class="col-md-12 col-sm-12 col-xs-12">
												<div class="table-responsive" data-pattern="priority-columns">
													<table id="datatable" class="table table-striped table-bordered">
														<thead>
														<tr>
							<td align="center" border="1" height="80px">
								<h3 style="line-height:20px; font-size:10px">SATALLITE CHANNEL NETWORK</h3><span style="font-size:7px; line-height:10px;">OFFICE COPY</span>
							</td>
						</tr>
															<tr>
																<th>#</th>
																<th>CUSTOMER CODE</th>
																<th>CUSTOMER NAME</th>
																<th>ADDRESS</th>
																<th>STB</th>
																<th>ACCOUNT</th>
																<th>MOBILE</th>
																<th>START DATE</th>
																<th>END DATE</th>
																<th>STATUS</th>
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
																	<td><?php echo @$row['first_name'].' '.@$row['last_name'];?></td>
																	<td><?php echo @$row['address1'];?></td>
																	<td><?php echo @$row['stb_no'];?></td>
																	<td><?php echo @$row['account'];?></td>
																	<td><?php echo @$row['mobile1'];?></td>
																	<td><?php echo @$row['billing_date'];?></td>
																	<td><?php echo date('Y-m-d', strtotime($row['billing_date']. '+'. '30 days'));?></td>
																	<td>
																	<?php 
																	if($row['status']==1){
																		echo '<label class="label label-success">Active</label>';
																	}else if($row['status']==2){
																		echo '<label class="label label-warning">Inactive</label>';
																	}else if($row['status']==3){
																		echo '<label class="label label-danger">Deleted</label>';
																	}
																	?></td>
																</tr>
																<?php 
																}
															}else{
															?>
															<tr>
																<td colspan="15" class="text-center">No result(s) found.</td>
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