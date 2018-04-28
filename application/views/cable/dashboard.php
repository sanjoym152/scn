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
													for($i=2018;$i<=date('Y');$i++){ ?>
												<option value="<?php echo @$i;?>"><?php echo @$i;?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="card-body">
										<div class="row table-responsive account_info">
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
		<?php echo @$footer;?>
		<?php echo @$footer_scripts;?>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script>
			$( function() {
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
								$('.basic_info').html(result.template);
								$('.payment_div').slideDown();
								console.log(result);
							}, 
							error: function(err){
								console.log(err.responseText);
							}
						});
					}
				});
			});
		</script>
	</body>
</html>