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
			input[type="text"]:readonly {
				background: #dddddd !important;
			}
			@media (min-width: 768px){
				.c_mdl{
					width: 900px;
					margin: 30px auto;
				}
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
										<div class="panel-heading">Search Customer by Name, Mobile etc.<span class="pull-right"><span class="label label-success">Active: <?php echo @$total_due_active['total_due']?$total_due_active['total_due']:0?></span><span class="label label-warning">Inactive: <?php echo @$total_due_inactive['total_due']?$total_due_inactive['total_due']:0?></span><span class="label label-danger">  Deleted: <?php echo @$total_due_delete['total_due']?$total_due_delete['total_due']:0?></span></span></div>
										<div class="panel-body">
										<form method="post" id="search_form" autocomplete="off">
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail keyword_main">
													<input class="form-control" id="autocomplete" type="text" name="keyword" value="<?php echo $this->input->post('keyword');?>" placeholder="Search Keyword">
													<div class="customer_auto"></div>
												</div>
												
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<select name="status" class="form-control">
														<option value="all">All Customer</option>
														<option value="1" <?php if($this->input->post('status')==1 || !$this->input->post('status')){ echo 'selected';}?>>Active</option>
														<option value="2" <?php if($this->input->post('status')==2){ echo 'selected';}?>>Inactive</option>
														<option value="3" <?php if($this->input->post('status')==3){ echo 'selected';}?>>Deleted</option>
														<option value="4" <?php if($this->input->post('status')==4){ echo 'selected';}?>>Paid</option>
														<option value="5" <?php if($this->input->post('status')==5){ echo 'selected';}?>>Unpaid</option>
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
											
											<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12 pull-right">
												<button class="btn btn-success export pull-right"><i class="fa fa-upload"></i> Export to Excel</button>
											</div>
											<div class="clearfix"></div>
											<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
												<div class="dess5">
													<i class="fa fa-pencil-square-o cncl" aria-hidden="true"> <span class="cncl_oopo">Edit</span></i>
													<i class="fa fa-trash-o cncl" aria-hidden="true"> <span class="cncl_oopo">Delete</span></i>
													<i class="fa fa-check cncl" aria-hidden="true"> <span class="cncl_oopo">Active</span></i>
													<i class="fa fa-times cncl" aria-hidden="true"> <span class="cncl_oopo">Inactive</span></i>
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12 pull-right">
												<div class="link_style">
													<?php if($this->uri->segment(3)==='all'){ ?> 
													<a href="<?php echo base_url('cable/customers');?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back </a> | 
													<?php }else{ ?> 
													<a href="<?php echo base_url('cable/customers/all');?>"><i class="fa fa-eye" aria-hidden="true"></i> View All</a> | 
													<?php } ?>
													<a href="<?php echo base_url('cable/customers/add');?>"><i class="md md-add"></i> Add New Customer</a>
												</div>
											</div>
											<div class="clearfix"></div>
											<div class="col-md-12 col-sm-12 col-xs-12">
												
												<div class="table-responsive" data-pattern="priority-columns">
													<table id="datatable1" class="table table-striped table-bordered">
														<thead>
															<tr>
																<th>#</th>
																<th>Customer Code</th>
																<th>Customer Name</th>
																<th>Address</th>
																<th>STB</th>
																<th>Account</th>
																<th>STB Model</th>
																<th>Package</th>
																<th>Due Balance</th>
																<th>Status</th>
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
																	<td><?php echo @$row['cust_code'];?>
																	<br>Other ID: <?php echo @$row['area_name'].'-'.@$row['other_id'];?></td>
																	<td><a href="javascript:;" data-id="<?php echo @$row['customer_id'];?>" class="cust_details_complain"><?php echo @$row['first_name'].' '.@$row['last_name'];?><br>Mobile: <?php echo @$row['mobile1'];?></a></td>
																	<td><?php echo @$row['address1'];?></td>
																	<td>
																	<a href="javascript:;" class="ip_address" data-id="<?php echo @$row['customer_id'];?>">
																		<?php if(@$row['ip']){ foreach($row['ip'] as $row1){
																			echo '<p>'.@$row1['stb_no'].'</p>';
																		}} ?>
																	</a>
																	</td>
																	<td>
																		<?php if(@$row['ip']){ foreach($row['ip'] as $row1){
																			echo '<p>'.@$row1['account'].'</p>';
																		}} ?>
																	</td>
																	<td>
																		<?php if(@$row['ip']){ foreach($row['ip'] as $row1){
																			echo '<p>'.$row1['stb_model_no'].'</p>';
																		}} ?>
																	</td>
																	<td>
																	<a href="javascript:;" class="channel"  data-id="<?php echo @$row['customer_id'];?>"><?php echo @$row['pakname'];?></a>
																	<br>Collector: <?php echo $row['staff_name'];?>
																	</td>
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
																		<a href="javascript:;" data-toggle="tooltip" data-id="<?php echo @$row['customer_id'];?>" title="Pay Now" class="payment"><i class="fa fa-inr" aria-hidden="true"></i></a>
																		<a href="<?php echo base_url('cable/customers/add/'.$row['customer_id']);?>" title="Edit" data-toggle="tooltip">   <i class="fa fa-pencil-square-o delet" aria-hidden="true"></i></a>
																		
																		<?php 
																		if($row['c_status']==1){
																		?>
																		<a onclick="return confirm('Are you sure?')" href="<?php echo base_url('cable/customers/change_status/'.$row['customer_id']);?>" title="Click to Inactive" data-toggle="tooltip"> <i class="fa fa-times" aria-hidden="true"></i></a>
																		<?php
																		}else if($row['c_status']==2){ ?>
																		<a onclick="return confirm('Are you sure?')" href="<?php echo base_url('cable/customers/change_status/'.$row['customer_id']);?>" title="Click to Active" data-toggle="tooltip"> <i class="fa fa-check delet" aria-hidden="true"></i></a>	
																		<?php } ?>
																		
																		<?php if(@$row['status']!=3){ ?>
																			<a href="<?php echo base_url('cable/customers/delete_record/'.$row['customer_id']);?>" onclick="return confirm('Are you sure?')" title="Delete" data-toggle="tooltip"> <i class="fa fa-trash-o delet" aria-hidden="true"></i></a>
																		<?php } ?>
																	</td>
																</tr>
																<?php 
																}
															}else{
															?>
															<tr>
																<td colspan="14" class="text-center">No result(s) found.</td>
															</tr>
															<?php 
															}
															?>
														</tbody>
													</table>
													<?php echo @$paginationLink; ?>
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
			<div class="modal-dialog c_mdl">
			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Customer <span style="float:right"><span class="tot_p"></span> | <span class="tot_b"></span></span></h4>
					</div>
					<div class="modal-body">
						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#billing">Topup</a></li>
							<!--<li><a data-toggle="tab" href="#ledger">Payment</a></li>-->
						</ul>
						<div class="tab-content">
							<div id="billing" class="tab-pane fade in active">
								<div class="billing_respons"></div>
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
				/*
				*@ autocomplete 
				*/
				$('#autocomplete').keyup(function(){
					//alert($('#autocomplete').val());
					var keyword = $('#autocomplete').val();
					$.ajax({
						url:'<?php echo base_url('cable/customers/autocomplete')?>',
						method:'post',
						data:{keyword: keyword},
						dataType:'json',
						success:function(result){
							//console.log(result);
							$('.customer_auto').html(result.html);
							$('.customer_auto').show();
						}
					});
				});
				$('#autocomplete').change(function(){
					//alert($('#autocomplete').val());
					var keyword = $('#autocomplete').val();
					$.ajax({
						url:'<?php echo base_url('cable/customers/autocomplete')?>',
						method:'post',
						data:{keyword: keyword},
						dataType:'json',
						success:function(result){
							//console.log(result);
							$('.customer_auto').html(result.html);
							$('.customer_auto').show();
						}
					});
				});
				$('#autocomplete').blur(function(){
					//alert($('#autocomplete').val());
					var keyword = $('#autocomplete').val();
					$.ajax({
						url:'<?php echo base_url('cable/customers/autocomplete')?>',
						method:'post',
						data:{keyword: keyword},
						dataType:'json',
						success:function(result){
							//console.log(result);
							$('.customer_auto').html(result.html);
							$('.customer_auto').show();
						}
					});
				});
				$('.channel').click(function(){
					var id = $(this).data('id');
					$.ajax({
						url:'<?php echo base_url('cable/customers/channel')?>',
						method:'post',
						data:{customer_id:id},
						dataType:'json',
						success:function(result){
							$('.channel_main').html(result.html);
							$('#channel').modal('show');
							console.log(result);
						},
						error:function(error){
							console.log(error.responseText);
						}
					});
						
				});
			});
		</script>
		<style>
		.sadsad{
			width: 100%;
			height: 500px;
			overflow-y: scroll;
		}
		</style>
		<!--Channel Modal-->
		<div id="channel" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Add Channel</h4>
					</div>
					<div class="modal-body sadsad">
						<div class="channel_main">
							
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!--Channel Modal-->
		
		
		<!-- Payment Modal -->
		<div id="payment" class="modal fade" role="dialog">
			<div class="modal-dialog">
			<!-- Modal content-->
				<div class="modal-content">
					<form id="payment_form" method="post" action="<?php echo base_url('cable/customers/payment')?>">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Bill Payment</h4>
						</div>
						<div class="modal-body" style="float:left">
							<div class="clearfix"></div>
							<div class="col-md-12">
								<div class="panel panel-body customer_main">
									<div class="col-md-12 customer_payment_info">
									</div>
								</div>
								<div class="col-md-6">
									<input type="hidden" name="customer_id" id="customer_id" value="">
									<div class="your-mail">
										<label for="exampleInputEmail1">Month of</label>
										<!--<select class="form-control month_of" name="month_of">
											<option value="">--Select Month--</option>
											<?php for($i=1;$i<=12;$i++){ ?>
											<option value="<?php echo $i;?>"><?php 
												$dateObj   = DateTime::createFromFormat('!m', $i);
												echo $monthName = $dateObj->format('F'); // March?>
											</option>
											<?php } ?>
										</select>-->
										<!--<textarea name="month_of" class="required form-control" placeholder="Enter description of months."></textarea>-->
										<input type="text" name="month_of" class="required form-control" placeholder="Enter description of months.">
										<span class="month_of_error"></span>
									</div>
								</div>
								<div class="col-md-6">
									<div class="your-mail">
										<label for="exampleInputEmail1">Outstanding</label>
										<input class="form-control" id="total_due" type="text" name="outstanding" value="0.00" readonly>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="col-md-6">
									<div class="your-mail">
										<label for="exampleInputEmail1">Payment Date</label>
										<input class="form-control required" id="pack_amount" type="hidden" name="pack_amount" value="0.00" readonly>
										<input class="form-control required datepicker" type="text" name="payment_date" value="" readonly>
										<input class="form-control required" id="package_id" type="hidden" name="package_id" >
									</div>
								</div>
								<div class="col-md-6">
									<div class="your-mail">
										<label for="exampleInputEmail1">Payable Amount</label>
										<input class="form-control required number" id="payment_total" type="text" name="payment_total" value="0.00">
									</div>
								</div>
								
								<div class="clearfix"></div>
								<div class="col-md-6">
									<div class="your-mail">
										<label for="exampleInputEmail1">Discount Amount</label>
										<input class="form-control" id="discount_total" type="text" name="discount_total" value="0.00" readonly>
									</div>
								</div>
								<div class="col-md-6">
									<div class="your-mail">
										<label for="exampleInputEmail1">Discount In</label>
										<input class="form-control required" id="discount_amount" type="text" name="discount_in" value="0.00" style="width:50%">
										<select class="form-control" style="width:50%" name="discount_type" id="discount_type">
											<option value="">Type</option>
											<option value="1">%</option>
											<option value="2">Rs.</option>
										</select>
									</div>
								</div>
								
								
								<div class="clearfix"></div>
								<div class="col-md-6">	
									<div class="your-mail">
										<label for="exampleInputEmail1">Net Due</label>
										<input class="form-control" id="net_due" type="text" name="net_due" value="0.00" readonly>
									</div>
								</div>
								<div class="col-md-6">
									<div class="your-mail">
										<label for="exampleInputEmail1">Paid By</label>
										<select name="staff_id" class="form-control collector required">
											<option value="">--Select Staff--</option>
											<?php foreach($collector as $row){ ?> 
												<option value="<?php echo @$row['staff_id'];?>"><?php echo @$row['staff_name'];?></option>
											<?php } ?>
										</select>
										<span class="collector_error"></span>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
						<div class="modal-footer">
							<div class="col-md-12">
								<button type="submit" id="print_bill" class="btn btn-success payment_btn"><i class="fa fa-print" aria-hidden="true"></i> Payment & Print</button>
								<!--<button type="button" class="btn btn-success payment_btn" id="make_payment"><i class="fa fa-credit-card-alt" aria-hidden="true"></i> Make Payment</button>-->
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="js/jquery.validate.js"></script>
		
		<script>
			$(document).ready(function(){
				$('.datepicker').datepicker({
					dateFormat:'yy-mm-dd'
				});
				$('#payment_form').validate({
					submitHandler: function (form) {
						var customer_id2 = $('#customer_id').val();
						//window.open("<?php echo base_url('cable/customers/bill_print/');?>"+customer_id2);
						form.submit();
					}
				});
				
				/* $('body').on('click','#make_payment',function(){
					var error=true;
					if($('.month_of').val()==''){
						$('.month_of_error').html('This field is required');
						$('.month_of_error').css('color','#f00');
						error=false;
					}else{
						$('.month_of_error').html('');
						error=true;
					}
					if($('.collector').val()==''){
						$('.collector_error').html('This field is required');
						$('.collector_error').css('color','#f00');
						error=false;
					}else{
						$('.collector_error').html('');
						error=true;
					}
					//alert($('.month_of').val());
					if(error==true){
						$('.loader').show();
						$('.loader-inner').show();
						$('#payment_form').submit();
						/* $.ajax({
							url:'<?php echo base_url('cable/customers/payment')?>',
							method:'post',
							data:$('#payment_form').serialize(),
							dataType:'json',
							success:function(result){
								console.log(result);
								setTimeout(function(){
									$('#payment').modal('hide');
									$('.loader').hide();
									$('.loader-inner').hide();
									swal("Success!", "Payment successful!", "success");
								}, 2000);
								
							},error:function(error){
								console.log(error);
							}
						}); 
					}
				}); */
				/* $('body').on('click','#print_bill',function(){
					$('#payment_form').attr('action','<?php echo base_url('cable/customers/bill_print')?>');
					$('#payment_form').attr('target','_blank');
					$('#payment_form').submit();
					$('.loader').show();
					$('.loader-inner').show();
					$.ajax({
						url:'<?php echo base_url('cable/customers/payment')?>',
						method:'post',
						data:$('#payment_form').serialize(),
						dataType:'json',
						success:function(result){
							console.log(result);
							setTimeout(function(){
								$('#payment').modal('hide');
								$('.loader').hide();
								$('.loader-inner').hide();
								swal("Success!", "Payment successful!", "success");
							}, 2000);
						},error:function(error){
							console.log(error);
						}
					});
					return false;
				}); */
				$('body').on('keyup','#discount_amount',function(){
					if($(this).val()!=""){
						$('#discount_type').addClass('required');
					}else{
						$('#discount_type').removeClass('required');
					}
					var payment_total = $('#payment_total').val();
					$('#discount_total').val(0.00);
					var discount_amount = $('#discount_amount').val();
					var discount_type = $('#discount_type').val();
					var discount_total = 0.00;
					var total_due = $('#total_due').val();
					var pack_amount = $('#pack_amount').val();
					//alert(discount_type);
					if(discount_type==1){
						discount_total = ((parseInt(total_due)*parseInt(discount_amount))/100);
					}else if(discount_type==2){
						discount_total = parseInt(discount_amount);
					}
					$('#discount_total').val(discount_total);
					net_due = (parseFloat(total_due)-parseFloat(discount_total))-parseFloat(payment_total);
					$('#net_due').val(net_due);
				});
				
				$('body').on('change','#discount_type',function(){
					if($(this).val()!=""){
						$('#discount_amount').addClass('required');
					}else{
						$('#discount_amount').removeClass('required');
					}
					$('#discount_total').val(0.00);
					var payment_total = $('#payment_total').val();
					var discount_amount = $('#discount_amount').val();
					var discount_type = $('#discount_type').val();
					var discount_total = 0.00;
					var total_due = $('#total_due').val();
					var pack_amount = $('#pack_amount').val();
					//alert(discount_type);
					if(discount_type==1){
						discount_total = ((parseInt(total_due)*parseInt(discount_amount))/100);
					}else if(discount_type==2){
						discount_total = parseInt(discount_amount);
					}
					$('#discount_total').val(discount_total);
					net_due = (parseFloat(total_due)-parseFloat(discount_total))-parseFloat(payment_total);
					$('#net_due').val(net_due);
				});
				
				$('#payment_total').keyup(function(){
					var total_due = $('#total_due').val();
					var pack_amount = $('#pack_amount').val();
					var discount_total = $('#discount_total').val();
					var payment_total = $('#payment_total').val();
					var net_due = 0;
					net_due = (parseFloat(total_due)-parseFloat(discount_total))-parseFloat(payment_total);
					$('#net_due').val(net_due);
				});
				
				$('body').on('click','.payment',function(){
					var customer_id = $(this).data('id');
					$('.loader').show();
					$('.loader-inner').show();
					$.ajax({
						url:'<?php echo base_url('cable/customers/get_customer_data')?>',
						method:'post',
						data:{
							customer_id:customer_id
						},
						dataType:'json',
						success:function(result){
							$('.customer_payment_info').html(result.customer_info);
							$('#total_due').val(result.customer.balance>=0?result.customer.balance:0);
							if(result.customer.payment_status==1){
								$('#pack_amount').val(result.customer.tot_amount);
							}
							$('#package_id').val(result.customer.package_id);
							$('#customer_id').val(result.customer.customer_id);
							setTimeout(function(){
								$('.loader').hide();
								$('.loader-inner').hide();
								$('#payment').modal('show');
							}, 1000);
							
						},
						error:function(error){
							console.log(error.responseText);
						}
					});					
				});
				
			});
		</script>
		<script>
		$(document).ready(function() {
			$('#datatable').DataTable({bFilter: false, bInfo: true,"pageLength": <?php echo PAGE_LIMIT;?>});
			//payment 
			
			$('body').on('click','.ip_address',function(){
				$('.loader').show();
				$('.loader-inner').show();
				var customer_id = $(this).data('id');
				$.ajax({
					url:'<?php echo base_url('cable/customers/get_customer_data')?>',
					method:'post',
					data:{
						customer_id:customer_id
					},
					dataType:'json',
					success:function(result){
						$('.full_name').html(result.customer.first_name+' '+result.customer.last_name);
						$('.mobile1').html(result.customer.mobile1);
						$('.mobile2').html(result.customer.mobile2);
						$('.address1').html(result.customer.address1);
						$('.address2').html(result.customer.address2);
						$('.email').html(result.customer.email);
						$('.dob').html(result.customer.dob);
						$('.pincode').html(result.customer.pincode);
						$('.customer_username').html(result.customer.username);
						$('.customer_other_id').html(result.customer.other_id);
						if(result.customer.gender==1){
							$('.gender').html('Male');
						}else if(result.customer.gender==2){
							$('.gender').html('Female');
						}
						$('.package').html(result.customer.pakname);
						$('.lco').html(result.customer.lconame);
						$('.connection_date').html(result.customer.connection_date);
						$('.isp').html(result.customer.mso);
						$('.balance').html('Rs.'+result.customer.balance);
						$('.installation_amount').html('Rs.'+result.customer.installation_amount);
						$('.deposite_amount').html('Rs.'+result.customer.deposite_amount);
						$('.ip_area').html(result.ip_data);
						setTimeout(function(){
							$('.loader').hide();
							$('.loader-inner').hide();
							$('#customer_details').modal('show');
						}, 3000);
					}
				});
				
				$.ajax({
					url:'<?php echo base_url('cable/customers/billing');?>',
					method:'post',
					data:{ customer_id:customer_id},
					dataType:'json',
					success:function(result){
						console.log(result);
						$('.billing_respons').html(result.table);
						$('.tot_p').html(result.payment_total);
						$('.tot_b').html(result.bill);
					},
					error:function(error){
						console.log(error.responseText);
					}
				});
				$.ajax({
					url:'<?php echo base_url('cable/customers/ledger');?>',
					method:'post',
					data:{ customer_id:customer_id},
					dataType:'json',
					success:function(result){
						console.log(result);
						$('.ledger_respons').html(result.table);
					},
					error:function(error){
						console.log(error.responseText);
					}
				});
			});
		});
		</script>
		<!--customer details and complain modal -->
		<div id="cust_details_complain" class="modal fade" role="dialog">
			<div class="modal-dialog">
			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Customer </h4>
					</div>
					<div class="modal-body">
						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#cust_details">Cust Details</a></li>
							<li><a data-toggle="tab" href="#documents">Documents</a></li>
						</ul>
						<div class="tab-content">
							<div id="cust_details" class="tab-pane fade in active">
								<div class="cust_tab"></div>
							</div>
							<div id="documents" class="tab-pane fade">
								<div class="documents_list">
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!--End customer details and complain modal -->
		<script>
			$(document).ready(function(){
				$('body').on('click','.cust_details_complain', function(){
					$('.loader').show();
					$('.loader-inner').show();
					var customer_id = $(this).data('id');
					$.ajax({
						url:'<?php echo base_url('cable/customers/get_customer_details');?>',
						method:'post',
						data:{ customer_id:customer_id},
						dataType:'json',
						success:function(result){
							console.log(result);
							setTimeout(function(){
								$('.loader').hide();
								$('.loader-inner').hide();
								$('#cust_details_complain').modal('show');
								$('.cust_tab').html(result.html);
								$('.documents_list').html(result.documents);
							}, 3000);
						},
						error:function(error){
							console.log(error.responseText);
						}
					});
					
					
				});
			});
		</script>
		
		<script type="text/javascript" src="cable_assets/js/jquery.fancybox.js"></script>
		<script type="text/javascript">
			$("[data-fancybox='images']").fancybox({
				// Options will go here
				selector : '[data-fancybox="images"]',
				thumbs   : false,
				hash     : false,
			});
		</script>

		
		<script src="cable_assets/js/autocomplete.js"></script>
		<script>
			$(document).ready(function(){
				$('.export').click(function(){
					var action = '<?php echo base_url('cable/customers/export')?>';
					$('#search_form').attr('action',action);
					$('#search_form').submit();
					$('#search_form').attr('action','');
					return false;
				});
				$('#autocomplete').focus();
			});
			/* $('#autocomplete').autocomplete({
				serviceUrl: '<?php echo base_url('cable/customers/autocomplete')?>',
				onSelect: function (suggestion) {
					alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
				}
			}); */
		</script>
		
		<!--customer details and complain modal -->
		<div id="payment_edit" class="modal fade" role="dialog">
			<div class="modal-dialog">
			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Edit Payment Info </h4>
					</div>
					<div class="modal-body">
						<form method="post" class="edit_payment">
							<div class="col-md-6">
								<div class="form-group">
									<input type="text" name="payment_date" class="form-control datepicker required" placeholder="Payment Date">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<input type="text" name="month_of" class="form-control required" placeholder="Month Of">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<select class="form-control required" name="staff_id">
										<option value="">--Select Collector--</option>
										<?php 
										foreach($collector as $row){ ?> 
										<option value="<?php echo $row['staff_id'];?>"><?php echo $row['staff_name'];?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="col-md-6">
								<button type="submit" class="btn btn-primary">SAVE</button>
							</div>
							<div class="clearfix"></div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!--End customer details and complain modal -->
		<script>
			function editPayment(payment_id){
				$.ajax({
					url:'<?php echo base_url('cable/customers/get_payment_info/')?>',
					method:'post',
					data:{
						payment_id:payment_id,
					},
					dataType:'json',
					success:function(result){
						$('#payment_edit').modal('show');
					},
					error:function(e){
						console.log(e.responseText);
					}
				});
			}
			$(document).ready(function(){
				$('.edit_payment').validate();
				$('.edit_payment').submit(function(e){
					$.ajax({
						url:'<?php echo base_url('cable/customers/get_payment_info/')?>',
						method:'post',
						data:{
							payment_id:payment_id,
						},
						dataType:'json',
						success:function(result){
							$('#customer_details').modal('hide');
							$('#payment_edit').modal('show');
						},
						error:function(e){
							console.log(e.responseText);
						}
					});
				});
			});
		</script>
		
		
	</body>
</html>