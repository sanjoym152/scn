<!DOCTYPE html>
<html>
	<head>
		<!--header links-->
		<?php echo @$header_links;?>
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
								<i class="fa fa-user" aria-hidden="true"></i> Customer Profile 
								<div class="pull-right ui-widget keyword_main">
									<input autocomplete="off" type="text" class="form-control search_textbox" id="autocomplete" placeholder="Search Customer"><i class="fa fa-search customer_search_icon" aria-hidden="true" style="font-size: 17px !important;"></i>
									<div class="customer_auto"></div>
								</div>
							</div>
							<div class="card-body">
								<div class="col-md-12 noPad">
									<div class="col-md-12">
										<div class="basic_info">
											<h1 class="text-center">Search to view customer details</h1>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
						</div>
						<div class="row payment_div" style="display:none">
							<div class="col-lg-12">
								<!-- Example Bar Chart Card-->
								<div class="card mb-3">
									<div class="card-header">
										<i class="fa fa-list" aria-hidden="true"></i> Account Information 
										<div class="pull-right">
											<select class="form-control search_textbox year">
												<option value="">--Select Year--</option>
												<?php 
													for($i=2017;$i<=date('Y');$i++){ ?>
												<option value="<?php echo @$i;?>"><?php echo @$i;?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="card-body">
										<div class="row table-responsive account_info">
											
										</div>
										<div class="row table-responsive before_select">
											<h5 class="text-center">Select a year to view customer payment details</h1>
										</div>
									</div>
									<div class="card-footer small text-muted">
										Updated yesterday at 11:59 PM 
										<div class="pull-right"><button class="btn btn-primary"> <i class="fa fa-print" aria-hidden="true"></i> Print all</button></div>
									</div>
								</div>
							</div>
						</div>
						<!-- Example DataTables Card-->
					</div>
				</div>
			</div>
		</div>
		
		
		<!-- Payment Modal -->
		<div id="payment" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
				<!-- Modal content-->
				<div class="modal-content">
					<form id="payment_form" method="post" action="<?php echo base_url('cable/payment/add_payment')?>">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Bill Payment</h4>
						</div>
						<div class="modal-body" style="float:left">
							<div class="clearfix"></div>
							<div class="col-md-12">
								<div class="col-md-3">
									<input type="hidden" name="customer_id" id="customer_id" value="">
									<input type="hidden" name="payment_id" id="payment_id" value="">
									<div class="your-mail">
										<label for="exampleInputEmail1">Description</label>
										<input type="text" name="month_of" class="required form-control" placeholder="Enter description of month.">
										<span class="month_of_error"></span>
									</div>
								</div>
								<div class="col-md-3">
									<div class="your-mail">
										<label for="exampleInputEmail1">Outstanding</label>
										<input class="form-control" id="total_due" type="text" name="outstanding" value="0.00" readonly>
									</div>
								</div>
								
								<div class="col-md-3">
									<div class="your-mail">
										<label for="exampleInputEmail1">Payment Date</label>
										<input class="form-control required" id="pack_amount" type="hidden" name="pack_amount" value="0.00" readonly>
										<input class="form-control required datepicker" type="text" name="payment_date" value="" readonly>
										<input class="form-control required" id="package_id" type="hidden" name="package_id">
									</div>
								</div>
								<div class="col-md-3">
									<div class="your-mail">
										<label for="exampleInputEmail1">Payable Amount</label>
										<input class="form-control required number" id="payment_total" type="text" name="payment_total" value="0.00">
									</div>
								</div>
								
								<div class="col-md-3">
									<div class="your-mail">
										<label for="exampleInputEmail1">Discount Amount</label>
										<input class="form-control" id="discount_total" type="text" name="discount_total" value="0.00" readonly>
									</div>
								</div>
								
								<div class="col-md-3">
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
								
								<div class="col-md-3">	
									<div class="your-mail">
										<label for="exampleInputEmail1">Net Due</label>
										<input class="form-control" id="net_due" type="text" name="net_due" value="0.00" readonly>
									</div>
								</div>
								<div class="col-md-3">
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
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		
		
		
		<?php echo @$footer;?>
		<?php echo @$footer_scripts;?>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script type="text/javascript" src="js/jquery.validate.js"></script>
		
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
					$('.payment_div').hide();
					$('.before_select').show();
					$('.account_info').hide();
					$('.year').val('');
					$('.loader').show();
					$('.loader-inner').show();
					event.preventDefault(); // <--- Prevent the value from being inserted.
					$('#autocomplete').val(ui.item.label);
					$.ajax({
						url:'<?php echo base_url('cable/home/get_customer_details')?>',
						method:'post',
						dataType: "json",
						data: {
							customer_id: ui.item.value
						},
						success: function( result ) {
							$('.loader').hide();
							$('.loader-inner').hide();
							//$('.before_select').hide();
							$('.basic_info').html(result.template);
							$('.payment_div').slideDown();
						}, 
						error: function(err){
							console.log(err.responseText);
						}
					});
				}
			});
			
			$('.year').change(function(){
				//console.log($(this).val());
				var year = $(this).val();
				var cust_id = $('.edit_cust').data('id');
				console.log(cust_id);
				$.ajax({
					url:'<?php echo base_url('cable/home/get_payment_info');?>',
					method:'post',
					data:{
						customer_id:cust_id,
						year:year
					},
					dataType:'json',
					success:function(result){
						$('.before_select').hide();
						$('.account_info').show();
						if(result.error){
							console.log(result.error);
						} else{
							$('.account_info').html(result.template);
						}
					},
					error:function(err){
						console.log(err);
					}
				});
			});
			
			/*
			* @ This function is used for add payment.
			*/
			$('body').on('click','.add_payment',function(){
				var customer_id = $(this).data('id');
				var payment_id = $(this).data('payment_id');
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
						$('#payment_id').val(payment_id);
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
			
			
			// Payment calculation for add payment topup
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
			
			$('.datepicker').datepicker({
				dateFormat:'yy-mm-dd'
			});
			$('#payment_form').validate({
				submitHandler: function (form) {
					form.submit();
				}
			});
			
			/* Delete payment */
			$('body').on('click', '.delete_payment', function(){
				if(confirm('Are you sure?')){
					var payment_id = $(this).data('id');
					var customer_id = $(this).data('customer_id');
					var year = $('.year').val();
					$.ajax({
						method:'post',
						url: '<?php echo base_url('cable/payment/delete_payment')?>',
						data:{ payment_id: payment_id, customer_id: customer_id, year: year},
						dataType:'json',
						success:function(result){
							$('.account_info').html(result.template);
						},
						error: function(err){
							console.log(err.responseText);
						}
					});
				}
			});
			/* Delete payment */
			
			// Edit payment
			$('body').on('click', '.edit_payment', function(){
				var payment_id = $(this).data('id');
				var customer_id = $(this).data('customer_id');
				$.ajax({
					url:'<?php echo base_url('cable/home/get_payment_data')?>',
					method:'post',
					data:{
						payment_id:payment_id,
						customer_id:customer_id
					},
					dataType:'json',
					success:function(result){
						$('#edit_payment').modal('show');
						$('.payment_id').val(payment_id);
						$('.customer_id').val(customer_id);
						$('.month_of').val(result.payment_data.month_of);
						$('.payment_date').val(result.payment_data.payment_date);
						$('.payment_total').val(result.payment_data.payment_total);
						$('.discount_total').val(result.payment_data.discount_total);
						$('.discount_amount').val(result.payment_data.discount_in);
						$('.discount_type').val(result.payment_data.discount_type);
						$('.collector').val(result.payment_data.staff_id);
					},
					error:function(error){
						console.log(error.responseText);
					}
				});
			});
			
			// Discount calculation for edit popup
			$('body').on('keyup','.discount_amount',function(){
				if($(this).val()!=""){
					$('.discount_type').addClass('required');
				}else{
					$('.discount_type').removeClass('required');
				}
				var payment_total_edit = $('.payment_total').val();
				$('.discount_total').val(0.00);
				var discount_amount_edit = $('.discount_amount').val();
				var discount_type_edit = $('.discount_type').val();
				var discount_total_edit = 0.00;
				var total_due_edit = $('.total_due').val();
				var pack_amount_edit = $('.pack_amount').val();

				if(discount_type_edit == 1){
					discount_total_edit = ((parseInt(total_due_edit)*parseInt(discount_amount_edit))/100);
				}else if(discount_type_edit==2){
					discount_total_edit = parseInt(discount_amount_edit);
				}
				$('.discount_total').val(discount_total_edit);
				net_due_edit = (parseFloat(total_due_edit)-parseFloat(discount_total_edit))-parseFloat(payment_total_edit);
				$('.net_due').val(net_due_edit);
			});
			
			$('body').on('change','.discount_type',function(){
				if($(this).val()!=""){
					$('.discount_amount').addClass('required');
				}else{
					$('.discount_amount').removeClass('required');
				}
				$('.discount_total').val(0.00);
				var payment_total_edit = $('.payment_total').val();
				var discount_amount_edit = $('.discount_amount').val();
				var discount_type_edit = $('.discount_type').val();
				var discount_total_edit = 0.00;
				var total_due_edit = $('.total_due').val();
				var pack_amount_edit = $('.pack_amount').val();
				
				if(discount_type_edit==1){
					discount_total_edit = ((parseInt(total_due_edit)*parseInt(discount_amount_edit))/100);
				}else if(discount_type_edit==2){
					discount_total_edit = parseInt(discount_amount_edit);
				}
				$('.discount_total').val(discount_total_edit);
				net_due_edit = (parseFloat(total_due_edit)-parseFloat(discount_total_edit))-parseFloat(payment_total_edit);
				$('.net_due').val(net_due_edit);
			});
			
			$('.payment_total').keyup(function(){
				var total_due_edit = $('.total_due').val();
				var pack_amount_edit = $('.pack_amount').val();
				var discount_total_edit = $('.discount_total').val();
				var payment_total_edit = $('.payment_total').val();
				var net_due_edit = 0;
				net_due_edit = (parseFloat(total_due_edit)-parseFloat(discount_total_edit))-parseFloat(payment_total_edit);
				$('.net_due').val(net_due_edit);
			});
		});
		</script>
		
		<!-- Edit Payment Modal -->
		<div id="edit_payment" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
			<!-- Modal content-->
				<div class="modal-content">
					<form id="payment_form" autocomplete="off" method="post" action="<?php echo base_url('cable/payment/edit_payment')?>">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Edit Payment</h4>
						</div>
						<div class="modal-body" style="float:left">
							<div class="clearfix"></div>
							<div class="col-md-12">
								<div class="col-md-4">
									<input type="hidden" name="customer_id" class="customer_id" value="">
									<input type="hidden" name="payment_id" class="payment_id" value="">
									<div class="your-mail">
										<label for="exampleInputEmail1">Description</label>
										<input type="text" name="month_of" class="month_of required form-control" placeholder="Enter description of month.">
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="your-mail">
										<label for="exampleInputEmail1">Payment Date</label>
										<input class="form-control required datepicker payment_date" type="text" name="payment_date" value="" readonly>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="your-mail">
										<label for="exampleInputEmail1">Payable Amount</label>
										<input class="form-control required number payment_total" autocomplete="off" type="text" name="payment_total" value="0.00">
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="your-mail">
										<label for="exampleInputEmail1">Discount Amount</label>
										<input class="form-control discount_total" type="text" name="discount_total" value="0.00" readonly>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="your-mail">
										<label for="exampleInputEmail1">Discount In</label>
										<input class="form-control required discount_amount" id="" type="text" name="discount_in" value="0.00" style="width:50%">
										<select class="form-control discount_type" style="width:50%" name="discount_type">
											<option value="">Type</option>
											<option value="1">%</option>
											<option value="2">Rs.</option>
										</select>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="your-mail">
										<label for="exampleInputEmail1">Paid By</label>
										<select name="staff_id" class="form-control collector required">
											<option value="">--Select Staff--</option>
											<?php foreach($collector as $row){ ?> 
											<option value="<?php echo @$row['staff_id'];?>"><?php echo @$row['staff_name'];?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
						<div class="modal-footer">
							<div class="col-md-12">
								<button type="submit" id="print_bill" class="btn btn-success payment_btn"><i class="fa fa-print" aria-hidden="true"></i> Payment & Print</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		
	</body>
</html>