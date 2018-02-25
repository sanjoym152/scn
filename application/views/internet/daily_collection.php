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
								<h4 class="pull-left page-title">DAILY COLLECTION</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<?php echo $this->utilitylib->showMsg();?>
								<div class="panel panel-default">
									
									<div class="panel-body table-rep-plugin">
										
										<div class="row">
											
											<div class="clearfix"></div>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<div class="table-responsive" data-pattern="priority-columns">
													<table id="datatable" class="table table-striped table-bordered">
														<thead>
															<tr>
																<th>#</th>
																<th>DATE</th>
																<th>AMOUNT(Rs.)</th>
															</tr>
														</thead>
														<tbody>
															<?php 
															$i=1;
															if(@$daily_collection){
																foreach($daily_collection as $row){
																?>
																<tr>
																	<td><?php echo @$i++;?></td>
																	<td><?php echo date('d/m/Y',strtotime(@$row['payment_date']));?></td>
																	<td><?php echo @$row['daily_total'];?></td>
																</tr>
																<?php 
																}
															}else{
															?>
															<tr>
																<td colspan="3" class="text-center">No result(s) found.</td>
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
		<?php echo @$footer;?>
		<?php echo @$footer_scripts;?>
		<script>
		$(document).ready(function() {
			$('#datatable').DataTable({bFilter: false, bInfo: true,"pageLength": <?php echo PAGE_LIMIT;?>});
		} );
		</script>
	</body>
</html>