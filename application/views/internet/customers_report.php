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
								<h4 class="pull-left page-title">ALL CUSTOMERS</h4>
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
													<input class="form-control from_date" type="text" name="f_date" value="<?php echo $this->input->post('f_date');?>" placeholder="From Date">
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<input class="form-control to_date" type="text" name="t_date" value="<?php echo $this->input->post('t_date');?>" placeholder="To Date">
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<select name="staff_id" class="form-control">
														<option value="all">Select Collector</option>
														<?php if(@$collecter){ foreach($collecter as $row){?> 
														<option value="<?php echo @$row['staff_id'];?>" <?php if(@$row['staff_id']==$this->input->post('staff_id')){echo 'selected';}?>><?php echo @$row['staff_name'];?></option>
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
												<button class="btn btn-success export pull-right">Export to Excel</button>
											</div>
											<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 pull-right">
												<div class="link_style">
													<a href="<?php echo base_url('internet/customers/add');?>"><i class="md md-add"></i> Add New Customer</a>
												</div>
											</div>
											<div class="clearfix"></div>
											<div class="col-md-12 col-sm-12 col-xs-12">
												
												<div class="table-responsive" data-pattern="priority-columns">
													<table id="datatable" class="table table-striped table-bordered">
														<thead>
															<tr>
																<th>#</th>
																<th>Customer Code</th>
																<th>Other ID</th>
																<th>Customer Name</th>
																<th>Ip Address</th>
																<th>Username</th>
																<th>Package</th>
																<th>Address</th>
																<th>Mobile</th>
																<th>Due Balance</th>
																<th>Status</th>
																<th>Payment Status</th>
																<th>Action</th>
															</tr>
														</thead>
														<tbody>
															<?php 
															$i=1;
															if(@$customers){
																foreach($customers as $row){
																?>
																<tr>
																	<td><?php echo @$i++;?></td>
																	<td><?php echo @$row['cust_code'];?></td>
																	<td><?php echo @$row['other_id'];?></td>
																	<td><a href="javascript:;" data-id="<?php echo @$row['customer_id'];?>" class="cust_details_complain"><?php echo @$row['first_name'].' '.@$row['last_name'];?></a></td>
																	<td>
																	<a href="javascript:;" class="ip_address" data-id="<?php echo @$row['customer_id'];?>">
																		<?php if(@$row['ip']){ foreach($row['ip'] as $row1){
																			echo '<p>'.@$row1['ip_address'].'</p>';
																		}} ?>
																	</a>
																	</td>
																	<td>
																		<?php if(@$row['ip']){ foreach($row['ip'] as $row1){
																			echo '<p>'.@$row1['username'].'</p>';
																		}} ?>
																	</td>
																	<td><?php echo @$row['pakname'];?></td>
																	<td><?php echo @$row['address1'];?></td>
																	<td><?php echo @$row['mobile1'];?></td>
																	<td>Rs.<?php echo @$row['balance'];?></td>
																	<td>
																	<?php 
																	if($row['c_status']==1){
																		echo '<label class="label label-success">Active</label>';
																	}else if($row['c_status']==2){
																		echo '<label class="label label-warning">Inactive</label>';
																	}else if($row['c_status']==3){
																		echo '<label class="label label-danger">Deleted</label>';
																	}
																	?></td>
																	<td>
																	<?php 
																	if($row['last_payment_month']==date('m')){
																		echo '<label class="label label-success">Paid</label>';
																	}else{
																		echo '<label class="label label-danger">Not Paid</label>';
																	}
																	?></td>
																	<td>
																		<a href="javascript:;" data-id="<?php echo @$row['customer_id'];?>" class="topup" data-toggle="tooltip" title="Add Topup"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
																		<a href="javascript:;" data-toggle="tooltip" data-id="<?php echo @$row['customer_id'];?>" title="Pay Now" class="payment"><i class="fa fa-inr" aria-hidden="true"></i></a>
																		<a href="<?php echo base_url('internet/customers/add/'.$row['customer_id']);?>" title="Edit" data-toggle="tooltip">   <i class="fa fa-pencil-square-o delet" aria-hidden="true"></i></a>
																		
																		<?php 
																		if($row['c_status']==1){
																		?>
																		<a onclick="return confirm('Are you sure?')" href="<?php echo base_url('internet/customers/change_status/'.$row['customer_id']);?>" title="Click to Inactive" data-toggle="tooltip"> <i class="fa fa-times" aria-hidden="true"></i></a>
																		<?php
																		}else if($row['c_status']==2){ ?>
																		<a onclick="return confirm('Are you sure?')" href="<?php echo base_url('internet/customers/change_status/'.$row['customer_id']);?>" title="Click to Active" data-toggle="tooltip"> <i class="fa fa-check delet" aria-hidden="true"></i></a>	
																		<?php } ?>
																		
																		<?php if(@$row['status']!=3){ ?>
																			<a href="<?php echo base_url('internet/customers/delete_record/'.$row['customer_id']);?>" onclick="return confirm('Are you sure?')" title="Delete" data-toggle="tooltip"> <i class="fa fa-trash-o delet" aria-hidden="true"></i></a>
																		<?php } ?>
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