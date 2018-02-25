<!DOCTYPE html>
<html>
	<head>
		<!--header links-->
		<?php echo @$header_links;?>
		<!--header links-->
		<style>
			.customer_info div div{
				margin:0 !important;
			}
			.customer_main{
				    background: #d2d2d2;
			}
		</style>
	</head>
	<body class="fixed-left">
		<!-- Begin page -->
		<div id="wrapper">
			<!-- Top Bar Start -->
			<?php echo @$topbar; ?>
			<!-- Top Bar End -->
			<!-- Left Sidebar Start -->
			<?php echo @$left_menu?>
			<!-- Left Sidebar End -->
			<!-- container -->
			<div class="content-page">
				<!-- Start content -->
				<div class="content">
					<div class="container">
						<!-- Page-Title -->
						<div class="row">
							<div class="col-sm-12">
								<h4 class="pull-left page-title"><?php echo $pageTitle;?></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<?php echo $this->utilitylib->showMsg();?>
								<div class="panel panel-default">
									<div class="panel-body table-rep-plugin">
										<div class="panel panel-default">
										<div class="panel-heading">Search from date and to date and collecter etc.</div>
										<div class="panel-body">
										<form method="post" id="search_form">
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<input class="form-control from_date" type="text" name="f_date" value="<?php echo $this->input->post('f_date');?>" placeholder="From Date" required>
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<input class="form-control to_date" type="text" name="t_date" value="<?php echo $this->input->post('t_date');?>" placeholder="To Date" required>
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<select name="mso_id" class="form-control" required>
														<option value="">Select MSO</option>
														<?php if(@$mso){ foreach($mso as $row){?> 
														<option value="<?php echo @$row['isp_id'];?>" <?php if(@$row['isp_id']==$this->input->post('mso_id')){echo 'selected';}?>><?php echo @$row['mso'];?></option>
														<?php } }?>
													</select>
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<select name="lco_id" class="form-control" required>
														<option value="">Select LCO</option>
														<?php if(@$lco){ foreach($lco as $row){?> 
														<option value="<?php echo @$row['lco_id'];?>" <?php if(@$row['lco_id']==$this->input->post('lco_id')){echo 'selected';}?>><?php echo @$row['lconame'];?></option>
														<?php } }?>
													</select>
												</div>
											</div>
											<div class="col-md-4 col-sm-4 col-xs-12 col-lg-4">
												<div class="submit-login mrgnT5">
													<button type="submit" class="btn btn-default">Search</button>
												</div>
											</div>
										</form>
										
										</div>
										</div>
										<div class="row">
											<div class="clearfix"></div>
											<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
												<div class="dess5">
													<i class="fa fa-pencil-square-o cncl" aria-hidden="true"> <span class="cncl_oopo">Edit</span></i>
													<i class="fa fa-trash-o cncl" aria-hidden="true"> <span class="cncl_oopo">Delete</span></i>
													<i class="fa fa-check cncl" aria-hidden="true"> <span class="cncl_oopo">Active</span></i>
													<i class="fa fa-times cncl" aria-hidden="true"> <span class="cncl_oopo">Inactive</span></i>
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12">
												<a href="<?php echo base_url('cable/reports/export');?>"><button class="btn btn-success export pull-right">Export to Excel</button></a>
												<!--<button class="btn btn-success export pull-right">Export to PDF</button>-->
											</div>
											
											<!--<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 pull-right">
												<div class="link_style">
													<a href="<?php echo base_url('internet/customers/add');?>"><i class="md md-add"></i> Add New Customer</a>
												</div>
											</div>-->
											<div class="clearfix"></div>
											<div class="col-md-12 col-sm-12 col-xs-12">
												
												<div class="table-responsive" data-pattern="priority-columns">
													<table id="datatable" class="table table-striped table-bordered">
														<thead>
															<tr>
																<th>Payment Date</th>
																<th>Customer</th>
																
															</tr>
														</thead>
														<tbody>
															<?php 
															$i=1;
															if(@$payment_details){
																foreach($payment_details as $row){
																?>
																<tr>
																	<td><strong class="text-primary">Payment Date : </strong><?php echo $row['payment_date']?>
																	<br><strong class="text-primary">Total Payment : </strong><?php echo @$row['tot_payment'];?></td>
																	<td>
																		<table class="table table-bordered">
																		<?php foreach($row['customers'] as $row1){?>
																			<tr>
																				<td><strong class="text-primary">Customer Name :</strong><?php echo @$row1['first_name'].' '.@$row1['last_name'];?>
																				<br><strong class="text-primary">Customer Code :</strong><?php echo @$row1['cust_code'];?>
																				<br><strong class="text-primary">Other Id :</strong><?php echo @$row1['other_id'];?></td>
																				<td><strong class="text-primary">Balance :</strong><?php echo @$row1['balance'];?>
																				<br><strong class="text-primary">Payment :</strong><?php echo @$row1['payment_total'];?></td>
																			</tr>
																		<?php } ?>
																		
																		</table>
																	</td>
																	
																</tr>
																<?php 
																}
															}else{
															?>
															<tr>
																<td colspan="13" class="text-center">No result(s) found.</td>
															<tr/>
															<?php 
															}
															?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- End Row -->
					</div>
					<!-- container -->
				</div>
				<!-- content -->
			</div>
		</div> 
		<!-- content -->
		
		
		<style>
			.nav > li > a {
				line-height: 40px;
				padding: 0px 15px;
				position: relative;
				color:#000 !important;
			}
			#cust_details span{
				line-height:35px;
			}
		</style>
		
		
		<!-- Customer Modal -->
		<div id="customer_details" class="modal fade" role="dialog">
			<div class="modal-dialog">
			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Customer</h4>
					</div>
					<div class="modal-body">
						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#billing">Billing</a></li>
							<li><a data-toggle="tab" href="#ledger">Ledger</a></li>
						</ul>
						<div class="tab-content">
							<div id="billing" class="tab-pane fade in active">
								<div class="billing_respons"></div>
							</div>
							<div id="ledger" class="tab-pane fade">
								<div class="ledger_respons"></div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		
		<?php echo @$footer;?>
		<?php echo @$footer_scripts;?>
		<script>
			$(document).ready(function(){
				var startDate = new Date('01/01/2012');
				var FromEndDate = new Date();
				var ToEndDate = new Date();
				ToEndDate.setDate(ToEndDate.getDate() + 365);

				$('.from_date').datepicker({
				weekStart: 1,
				startDate: '01/01/2012',
				endDate: FromEndDate,
				autoclose: true
				})
				.on('changeDate', function (selected) {
						startDate = new Date(selected.date.valueOf());
						startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
						$('.to_date').datepicker('setStartDate', startDate);
					});
				$('.to_date')
					.datepicker({
						weekStart: 1,
						startDate: startDate,
						endDate: ToEndDate,
						autoclose: true
					})
					.on('changeDate', function (selected) {
						FromEndDate = new Date(selected.date.valueOf());
						FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
						$('.from_date').datepicker('setEndDate', FromEndDate);
					});
			})
		</script>
	</body>
</html>