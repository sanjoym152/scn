<!DOCTYPE html>
<html>
	<head>
		<!--header links-->
		<?php echo @$header_links;?>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<!--header links-->
	</head>
	<body class="fixed-left">
		<!-- Begin page -->
		<div id="wrapper">
			<!-- Top Bar Start -->
			<?php echo @$topbar;?>
			<!-- Top Bar End -->
			<!-- Left Sidebar Start -->
			<?php echo @$left_menu?>
			<!-- Left Sidebar End -->
			<!-- container -->
			<div class="content-page">
				<!-- Start content -->
				<div class="content">
					<div class="container-fluid">
					  
					  <!-- Icon Cards-->
					  
					  <!-- Area Chart Example-->
					  <div class="card mb-3">
						<div class="card-header">
						  <i class="fa fa-user" aria-hidden="true"></i> Customer Profile <div class="pull-right ui-widget keyword_main"><input autocomplete="off" type="text" class="form-control search_textbox" id="autocomplete" placeholder="Search Customer"><i class="fa fa-search customer_search_icon" aria-hidden="true" style="font-size: 17px !important;"></i>
						  <div class="customer_auto"></div>
						  </div></div>
						<div class="card-body">
							<div class="col-md-12 noPad">
								<div class="col-md-2 noPad">
									<div class="col-md-12 doc_image_area">
										<img width="80" height="80" src="uploads/1515304194saf213431.jpg">
									</div>
									<div class="col-md-12 doc_image_area">
										<img width="80" height="80" src="uploads/1515304194saf213431.jpg">
									</div><div class="col-md-12 doc_image_area">
										<img width="80" height="80" src="uploads/1515304194saf213431.jpg">
									</div>
								</div>
								<div class="col-md-10">
									<div class="panel panel-default">
										<div class="panel-body">
											<div class="basic_info">
												<div class="col-md-12">
													<div class="col-md-6">
														<span class="">Other ID: 1</span>
													</div>
													<div class="col-md-6">
														<span class="">CAF No.: P</span>
													</div>
													
													<div class="col-md-6">
														<span class="">Mobile1: 9339835656</span>
													</div>
													
													<div class="col-md-6">
														<span class="">Address1: R.K ROAD</span>
													</div>
													
													<div class="col-md-6">
														<span class="">Mobile2: </span>
													</div>
													
													<div class="col-md-6">
														<span class="">Address2: </span>
													</div>
													<div class="col-md-6">
														<span class="">Email: gtplkcbpl@gmail.com</span>
													</div>
													
													<div class="col-md-6">
														<span class="">DOB: 01/01/1970</span>
													</div>
													<div class="col-md-6">
														<span class="">Gender: Male</span>
													</div>
													
													<div class="col-md-6">
														<span class="">Pincode: </span>
													</div>
													
													<div class="clearfix"></div>
													
													<div class="col-md-6">
														<span class="">Package: REGULAR PLUS<strong>(1 month)</strong></span>
													</div>
													<div class="col-md-6">
														<span class="">LCO: SATELLITE CHANNEL NETWORK</span>
													</div>
													<div class="col-md-6">
														<span class="">Connection Date: 14/02/2018</span>
													</div>
													<div class="col-md-6">
														<span class="">ISP: GTPL KCBPL</span>
													</div>
													<div class="col-md-6">
														<span class="">Balance: Rs.650.00</span>
													</div>
													<div class="col-md-6">
														<span class="">STB Amount: Rs.0.00 dfg dfg dfg df</span>
													</div>
													
													<div class="ip_area">
														<table class="table table-striped">
															<tbody>
															<tr>
																<td>2920447852</td>
																<td>SKYWORTH 7640</td>
																<td>229958</td>
															</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-8 pull-right">
									<button class="btn btn-success dashboard_btn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> EDIT CUSTOMER</button>
									<button class="btn btn-warning dashboard_btn"><i class="fa fa-ban" aria-hidden="true"></i> INACTIVE CUSTOMER</button>
									<button class="btn btn-danger dashboard_btn"><i class="fa fa-trash" aria-hidden="true"></i> DELETE CUSTOMER</button>
								</div>
							</div>
						</div>
						<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
					  </div>
					  <div class="row">
						<div class="col-lg-12">
						  <!-- Example Bar Chart Card-->
						  <div class="card mb-3">
							<div class="card-header">
							  <i class="fa fa-list" aria-hidden="true"></i> Account Information <div class="pull-right">
							  <select class="form-control search_textbox">
								<option value="">--Select Year--</option>
								<?php 
								for($i=2018;$i<=date('Y');$i++){ ?>
								<option value="<?php echo @$i;?>"><?php echo @$i;?></option>
								<?php } ?>
							  </select></div></div>
							<div class="card-body">
							  <div class="row table-responsive">
								<table class="table table-striped">
									<thead>
										<th>MONTH</th>
										<th>BILL DATE</th>
										<th>PACKAGE AMOUNT</th>
										<th>ALA CA</th>
										<th>DUE AMOUNT</th>
										<th>OTHER</th>
										<th>TOTAL</th>
										<th>PAY DATE</th>
										<th>COLLECTOR</th>
										<th>DISCOUNT</th>
										<th>PAY AMOUNT</th>
										<th>ACTION</th>
									</thead>
									<tbody>
										<tr>
											<td>MONTH</td>
											<td>MONTH</td>
											<td>MONTH</td>
											<td>MONTH</td>
											<td>MONTH</td>
											<td>MONTH</td>
											<td>MONTH</td>
											<td>MONTH</td>
											<td>MONTH</td>
											<td>MONTH</td>
											<td>MONTH</td>
											<td width="10%">
												<a href="#" data-toggle="tooltip" title="Add payment"><i class="fa fa-plus" aria-hidden="true"></i></a>
												<a href="javascript:;" data-toggle="tooltip" title="Edit" onclick="editPayment(5913)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
												<a href="http://localhost/scn/cable/customers/delete_billing/5913" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure?')"><i class="fa fa-trash" aria-hidden="true"></i></a>
												<a target="_blank" href="http://localhost/scn/cable/customers/bill_print/5913" data-toggle="tooltip" title="Print bill"><i class="fa fa-print" aria-hidden="true"></i></a>
											</td>
										</tr>
										
									</tbody>
								</table>
							  </div>
							</div>
							<div class="card-footer small text-muted">Updated yesterday at 11:59 PM <div class="pull-right"><button class="btn btn-primary"> <i class="fa fa-print" aria-hidden="true"></i> Print all</button></div></div>
						  </div>
						</div>
					  </div>
					  <!-- Example DataTables Card-->
					  
					</div>
					
				</div>
			</div>
		</div> 
		<?php echo @$footer;?>
		<?php echo @$footer_scripts;?>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		
		<script>
			$( function() {
				$( "#autocomplete" ).autocomplete({
					source: function( request, response ) {
						$.ajax({
							url:'<?php echo base_url('cable/home/autocomplete')?>',
							method:'post',
							dataType: "json",
							data: {
								keyword: request.term
							},
							success: function( data ) {
								response( data );
							}
						});
					},
					minLength: 2,
					select: function( event, ui ) {
						console.log(ui.item.value);
					}
				});
			});
		</script>
		
	</body>
</html>