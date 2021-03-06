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
								<h4 class="pull-left page-title">STAFF COMMSSION</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<?php echo $this->utilitylib->showMsg();?>
								<div class="panel panel-default">
									<div class="panel-body table-rep-plugin">
										<!--<div class="panel panel-default">
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
										</div>-->
										<div class="row">
											
											<div class="col-md-12 col-sm-12 col-xs-12">
												<?php 
												/* echo "<pre>";
												print_r($staff); */
												?>
												<div class="table-responsive" data-pattern="priority-columns">
													<table id="datatable" class="table table-striped table-bordered">
														<thead>
															<tr>
																<th>#</th>
																<th>Staff Code</th>
																<th>Staff Name</th>
																<th>Total Commission</th>
															</tr>
														</thead>
														<tbody>
															<?php 
															$i=1;
															if(@$staff){
																foreach($staff as $row){
																?>
																<tr>
																	<td><?php echo @$i++;?></td>
																	<td><?php echo @$row['staff_code'];?></td>
																	<td><?php echo @$row['staff_name'];?></td>
																	<td><?php echo @$row['total_commission'];?></td>
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