<?php
    tcpdf();
    $custom_size=array(230,297);
    $obj_pdf = new TCPDF('P', PDF_UNIT, $custom_size , true, 'UTF-8', false);
    $obj_pdf->SetCreator(PDF_CREATOR);
    $obj_pdf->SetTitle('SCN | CUSTOMER -  TOP UP BILL PRINT');
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
		<table width="100%" border="0">
			<tr>
				<td width="30%">
					<table>
						<tr>
							<td align="center" border="1" height="80px">
								<h3 style="line-height:20px; font-size:10px">SATALLITE CHANNEL NETWORK</h3><span style="font-size:7px; line-height:12px;">OFFICE COPY</span>
							</td>
						</tr>
						<tr>
							<td align="left" border="1" height="150px">
								<table>
									<tr>
										<td style="font-size:7px; line-height:12px; padding-left:20px;">&nbsp;&nbsp;CUST ID: <?php echo @$userdata['cust_code'];?></td>
										<td style="font-size:7px; line-height:12px; padding-left:20px;">&nbsp;&nbsp;BILL NO: <?php echo @$userdata['payment_id'];?></td>
									</tr>
								</table>
								<table>
									<tr>
										<td style="font-size:7px; line-height:12px; padding-left:20px;">&nbsp;&nbsp;NAME: <strong style="font-size:10px"><?php echo @$userdata['first_name'];?></strong></td>
									</tr>
									<tr>
										<td style="font-size:7px; line-height:12px; padding-left:20px;">&nbsp;&nbsp;ADDRESS: <?php echo @$userdata['address1'];?></td>
									</tr>
									<tr>
										<td style="font-size:7px; line-height:12px; padding-left:20px;">&nbsp;&nbsp;MOBILE: <?php echo @$userdata['mobile1'];?></td>
									</tr>
									<tr>
										<td style="font-size:7px; line-height:12px; padding-left:20px;">&nbsp;&nbsp;COLLECTOR: <?php echo @$userdata['staff_name'];?></td>
									</tr>
									<tr>
										<td style="font-size:7px; line-height:12px; padding-left:20px;">&nbsp;&nbsp;ADDED DATE: <?php echo date('d/m/Y',strtotime(@$userdata['payment_date']));?></td>
									</tr>
									<tr>
										<td style="font-size:7px; line-height:12px; padding-left:20px;">&nbsp;&nbsp;PACKAGE CHARGE: Rs. <?php echo (@$userdata['package_tax_type']==1)?@$userdata['including_amount']:@$userdata['pakren'];?></td>
									</tr>
									<tr>
										<td style="font-size:7px;">&nbsp;&nbsp;OTHERS FEES: Rs. <?php echo @$userdata['other_fees']+@$userdata['installation_charge'];;?></td>
										
									</tr>
									<!--<tr>
										<td style="font-size:7px; line-height:12px; padding-left:20px;">&nbsp;&nbsp;DISCOUNT TOTAL: Rs. <?php echo @$userdata['p_discount'];?></td>
									</tr>-->
									<tr>
										<td style="font-size:7px;">&nbsp;&nbsp;PREVIOUS DUE: Rs. <?php echo @$userdata['outstanding'];?></td>
									</tr>
									<tr>
										
										<td style="font-size:7px; line-height:12px; padding-left:20px;">
											<?php if(@$userdata['package_tax_type']==2){ ?> 
												<table border="1">
													<tr>
														<th> &nbsp;TAX</th>
														<th> &nbsp;No.</th>
														<th> &nbsp;PRICE</th>
													</tr>
													<?php if(@$tax){ foreach($tax as $row){ ?>
														<tr>
															<td>&nbsp;&nbsp;<?php echo @$row['tax_name'];?></td>
															<td>&nbsp;&nbsp;<?php echo @$row['tax_no'];?></td>
															<td>&nbsp;&nbsp;<?php echo @$row['tax_price'];?></td>
														</tr>
													<?php } } ?>
												</table>
											<?php }?>
										</td>
									</tr>
									<tr>
										<hr />
										<td align="right" style="font-size:7px; line-height:12px;">&nbsp;&nbsp;TOTAL: Rs. <?php echo @$userdata['payment_total'];?> &nbsp;&nbsp;&nbsp;</td>
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
								<h3 style="line-height:20px;"><img src="image1/print_logo.png" width="30" height="30"> SATALLITE CHANNEL NETWORK</h3><center><span style="font-size:7px; line-height:12px;">G B ROAD, NIMTA, 42 PALLY, KOLKATA-700049<br><small>(Topup Bill)</small></span></center>
							</td>
						</tr>
						<tr>
							<td align="left" border="1" height="150px">
								<table class="aaa">
									<tr>
										<td style="font-size:7px; line-height:12px; padding-left:20px;">&nbsp;&nbsp; CUSTOMER ID: <?php echo @$userdata['cust_code'];?></td>
										<td style="font-size:7px; line-height:12px; padding-left:20px;">&nbsp;&nbsp; BILL NO: <?php echo @$userdata['payment_id'];?></td>
									</tr>
									<tr>
										<td style="font-size:7px; line-height:12px; padding-left:20px;">&nbsp;&nbsp; CUSTOMER NAME: <strong style="font-size:10px"><?php echo @$userdata['first_name'];?></strong></td>
										<td style="font-size:7px; line-height:12px; padding-left:20px;">&nbsp;&nbsp; DATE: <?php echo date('d/m/Y',strtotime($userdata['payment_date']));?></td>
									</tr>
									<tr>
										<td style="font-size:7px; line-height:12px; padding-left:20px;">&nbsp;&nbsp; ADDRESS: <?php echo @$userdata['address1'];?></td>
										<!--<td style="font-size:7px; line-height:12px; padding-left:20px;">&nbsp;&nbsp; MONTH OF: <?php echo @$userdata['month_of']?date('"F Y"', strtotime(@$userdata['month_of'])):'';?></td>-->
									</tr>
									<tr>
										<td style="font-size:7px; line-height:12px; padding-left:20px;">&nbsp;&nbsp; MOBILE: <?php echo @$userdata['mobile1'];?></td>
										<td style="font-size:7px; line-height:12px; padding-left:20px;">&nbsp;&nbsp; IP: <?php echo @$userdata['ip_address'];?></td>
									</tr>
									<tr>
										<td style="font-size:7px; line-height:12px; padding-left:20px;">&nbsp;&nbsp; COLLECTOR NAME: <?php echo @$userdata['staff_name'];?></td>
										<td style="font-size:7px; line-height:12px; padding-left:20px;">&nbsp;&nbsp; USERNAME: <?php echo @$userdata['username'];?></td>
									</tr>
									<tr>
										<td style="font-size:7px; line-height:12px; padding-left:20px;">&nbsp;&nbsp; PACKAGE: <?php echo @$userdata['pakname'];?></td>
									</tr>
									
								</table>
								<br>
								<br>
								<table border="1" style="margin-left:10px;" align="center">
									<tr>
										<td height="15px" style="font-size:7px; line-height:10px">PREVIOUS DUE</td>
										<td height="15px" style="font-size:7px; line-height:10px">PACKAGE AMOUNT</td>
										<td height="15px" style="font-size:7px; line-height:10px">OTHERS FEES</td>
										<?php if(@$userdata['package_tax_type']==2){ ?><td height="15px" style="font-size:7px; line-height:10px">TAX</td> <?php } ?>
										<!--<td height="15px" style="font-size:7px; line-height:10px">DISCOUNT</td>-->
										<td height="15px" style="font-size:7px; line-height:10px">TOTAL</td>
									</tr>
									<tr>
										<td height="15px" style="font-size:7px; line-height:10px">Rs. <?php echo @$userdata['outstanding'];?></td>
										<td height="15px" style="font-size:7px; line-height:10px">Rs. <?php echo (@$userdata['package_tax_type']==1)?@$userdata['including_amount']:@$userdata['pakren'];?></td>
										<td height="15px" style="font-size:7px; line-height:10px">Rs. <?php echo @$userdata['other_fees']+@$userdata['installation_charge'];?></td>
										<?php if(@$userdata['package_tax_type']==2){ ?>
										<td height="15px" style="font-size:7px; line-height:10px">
											<?php if(@$userdata['package_tax_type']==1){ ?> Rs. <?php echo @$userdata['including_amount'];?><?php }else{ ?> 
												<table border="1">
													<tr>
														<th>TAX</th>
														<th>No.</th>
														<th>PRICE</th>
													</tr>
													<?php if(@$tax){ foreach($tax as $row){ ?>
														<tr>
															<td><?php echo @$row['tax_name'];?></td>
															<td><?php echo @$row['tax_no'];?></td>
															<td><?php echo @$row['tax_price'];?></td>
														</tr>
													<?php } } ?>
												</table>
											<?php }?>
										</td>
										<?php } ?>
										<!--<td height="15px" style="font-size:7px; line-height:10px">Rs. <?php echo @$userdata['p_discount'];?></td>-->
										<td height="15px" style="font-size:7px; line-height:10px">Rs. <?php echo @$userdata['payment_total'];?></td>
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
		</table>
		
		
	</body>
</html>
<?php
	$name='INTERNET-PAYMENT-'.date('Y-m-d H:i:s');
    $content = ob_get_contents();
    ob_end_clean();
    $obj_pdf->writeHTML($content, true, false, true, false, '');
    $obj_pdf->Output($name.'.pdf', 'I');
?>