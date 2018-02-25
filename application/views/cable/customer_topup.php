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
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.css" />
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
								<h4 class="pull-left page-title">MULTI TOPUP</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<?php echo $this->utilitylib->showMsg();?>
								<div class="panel panel-default">
									<div class="panel-body table-rep-plugin">
										<div class="panel panel-default">
										<div class="panel-heading">Search Customer by LCO.</div>
											<div class="panel-body">
												<form method="post" id="topup_form" autocomplete="off">
													<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
														<div class="your-mail keyword_main">
															<select name="lco" id="lco" class="form-control">
																<option value="all">--SELECT LCO--</option>
																<?php if(@$lco){
																foreach($lco as $row){ ?>
																<option value="<?php echo @$row['lco_id'];?>" <?php if($this->input->post('lco') == $row['lco_id']){echo 'selected';}?>><?php echo @$row['lconame'];?></option>
																<?php }
																} ?>
															</select>
														</div>
													</div>
												</form>
											</div>
										</div>
										<?php if($this->input->post()){ ?>
										<div class="row">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<div class="panel panel-default">
													<div class="panel-heading">CUSTOMER PACKAGE SUMMARY</div>
													<form method="post" action="<?php echo base_url('cable/customers/add_topup')?>">
													<div class="panel-body">
														<div class="table-responsive" data-pattern="priority-columns">
															<table id="datatable" class="table table-striped table-bordered">
																<tbody>
																	<?php 
																	$i=1;
																	if(@$customers){
																		/* echo "<pre>";
																		print_r($customers);die; */
																		foreach($customers as $key=>$row){
																		?>
																		<tr>
																			<td>
																			<label><input type="checkbox" name="customer_id[]" value="<?php echo @$row['customer_id'];?>">
																			<span><?php foreach($row['accounts'] as $row1){echo @$row1['account'].'<br>';}?></span></label>
																			</td>
																			
																			<td>
																			<label><strong style="color:#276395;">Name: </strong><?php echo @$row['first_name'];?></label>
																			<br>
																			<label><strong style="color:#276395;">Start date: </strong><?php echo date('d/m/Y',strtotime(@$row['billing_date']));?>
																			<strong style="color:#276395;">End  date: </strong><?php echo date('d/m/Y',strtotime(@$row['billing_date']. ' + 30 days'));?>
																			</label>
																			</td>
																			
																			<td><strong style="color:#276395;">ACCOUNT: </strong><?php echo @$row['accounts'][0]['account'];?>
																			<br>
																			<strong style="color:#276395;">STB No: </strong><?php echo @$row['accounts'][0]['stb_no'];?>
																			</td>
																			
																			<td><strong style="color:#276395;">PACKAGE: </strong><?php echo @$row['pakname'];?><br><strong style="color:#276395;">PACKAGE PRICE: </strong>Rs. <?php echo @$row['pack_amount'];?>
																			<br><strong style="color:#276395;">TOTAL DUE: </strong>Rs. <?php echo @$row['balance'];?>
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
															
														</div>
														<button class="btn btn-success" type="submit" name="add_topup">Add Topup</button>
														</form>
													</div>
												</div>
											</div>
										</div>
										<?php }?> 
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
		<?php echo @$footer;?>
		<?php echo @$footer_scripts;?>
		<script>
			$(document).ready(function(){
				$('#lco').change(function(){
					$('.loader').show();
					$('.loader-inner').show();
					$('#topup_form').submit();
				});
			});
		</script>
	</body>
</html>