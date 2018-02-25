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
								<h4 class="pull-left page-title">ALL PACKAGE DETAILS</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<?php echo $this->utilitylib->showMsg();?>
								<div class="panel panel-default">
									
									<div class="panel-body table-rep-plugin">
										<div class="panel panel-default">
										<div class="panel-heading">Search Package by Name, Package Mode etc.</div>
										<div class="panel-body">
										<form method="post">
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													
													<input class="form-control" id="keyword" type="text" name="keyword" value="<?php echo $this->input->post('keyword');?>" placeholder="Search Keyword">
												</div>
											</div>
											
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="form-group your-mail">
													<select name="pkg_mode" class="form-control required">
														<option value="">Select Pakage Mode</option>
														<option value="1" <?php if($this->input->post('pkg_mode')==1){ echo "selected";}?>>One Month</option>
														<option value="3" <?php if($this->input->post('pkg_mode')==3){ echo "selected";}?>>Three Month</option>
														<option value="6" <?php if($this->input->post('pkg_mode')==6){ echo "selected";}?>>Six Month</option>
														<option value="12" <?php if($this->input->post('pkg_mode')==12){ echo "selected";}?>>One Year</option>
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
											<div class="col-lg-8 col-md-8 col-sm-9 col-xs-12">
												<div class="dess5">
													<i class="fa fa-pencil-square-o cncl" aria-hidden="true">  <span class="cncl_oopo">Edit</span></i>
													<i class="fa fa-trash-o cncl" aria-hidden="true"> <span class="cncl_oopo">Delete</span></i>
													<i class="fa fa-check cncl" aria-hidden="true"> <span class="cncl_oopo">Active</span></i>
													<i class="fa fa-times cncl" aria-hidden="true"> <span class="cncl_oopo">Inactive</span></i>
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12">
												<div class="link_style">
													<a href="<?php echo base_url('cable/package/add');?>"><i class="md md-add"></i> Add New Package</a>
												</div>
											</div>
											<div class="clearfix"></div>
											<div class="col-md-12 col-sm-12 col-xs-12">
												
												<div class="table-responsive" data-pattern="priority-columns">
													<table id="datatable" class="table table-striped table-bordered">
														<thead>
															<tr>
																<th>#</th>
																<th>PACKAGE NAME</th>
																<th>PACKAGE MODE</th>
																<th>BASIC PRICE</th>
																<th>INCLUDING TAX RENTAL</th>
																<th>EXCLUDING TAX RENTAL</th>
																<th>PACKAGE DISCOUNT</th>
																<th>PACKAGE TOTAL</th>
																<th>STATUS</th>
																<th>Action</th>
															</tr>
														</thead>
														<tbody>
															<?php 
															$i=1;
															if(@$package){
																foreach($package as $row){
																?>
																<tr>
																	<td><?php echo @$i++;?></td>
																	<td><?php echo @$row['pakname'];?></td>
																	
																	<td><?php 
																	if(@$row['pkg_mode']>=12){
																		echo @$row['pkg_mode']/12 ." Year(s)";
																	}else{
																		echo @$row['pkg_mode'] .' Month(s)';
																	}?></td>
																	<td>Rs. <?php echo @$row['pakren'];?></td>
																	<td>Rs. <?php echo @$row['including_amount'];?></td>
																	<td style="position:relative"><?php echo @$row[''];?>
																		<div class="excluding_tax"><div class="inner_tax">
																			<table class="table table-striped">
																				<tr>
																					<th>Tax Name</th>
																					<th>Tax No.</th>
																					<th>Tax Amount</th>
																				</tr>
																				<?php if(@$row['ex_tax']){ foreach($row['ex_tax'] as $row1){ ?>
																				<tr>
																					<td><?php echo @$row1['tax_name'];?></td>
																					<td><?php echo @$row1['tax_no'];?></td>
																					<td><?php if(@$row1['tax_type']==1){ echo @$row1['tax_price'].' %'; }else if(@$row1['tax_type']==2){ echo 'Rs. '.@$row1['tax_price']; }?></td>
																				</tr>	
																				<?php }}?>
																			</table>
																		</div>
																		</div>
																	</td>
																	<td>Rs. <?php echo @$row['dis_amount'];?></td>
																	<td>Rs. <?php echo @$row['tot_amount'];?></td>
																	<td><?php echo ($row['status']==1)?'<label class="label label-success">Active</label>':'<label class="label label-danger">Inactive</label>';?></td>
																	<td>
																		<a href="<?php echo base_url('cable/package/add/'.$row['package_id']);?>" title="Edit" data-toggle="tooltip">   <i class="fa fa-pencil-square-o delet" aria-hidden="true"></i></a>
																		<a href="<?php echo base_url('cable/package/delete_record/'.$row['package_id']);?>" onclick="return confirm('Are you sure?')" title="Delete" data-toggle="tooltip"> <i class="fa fa-trash-o delet" aria-hidden="true"></i></a>
																		<?php 
																		if($row['status']==1){
																		?>
																		<a onclick="return confirm('Are you sure?')" href="<?php echo base_url('cable/package/change_status/'.$row['package_id']);?>" title="Click to Inactive" data-toggle="tooltip"> <i class="fa fa-times" aria-hidden="true"></i></a>
																		<?php
																		}else if($row['status']==2){ ?>
																		<a onclick="return confirm('Are you sure?')" href="<?php echo base_url('cable/package/change_status/'.$row['package_id']);?>" title="Click to Active" data-toggle="tooltip"> <i class="fa fa-check delet" aria-hidden="true"></i></a>	
																		<?php } ?>
																	</td>
																</tr>
																<?php 
																}
															}else{
															?>
															<tr>
																<td colspan="10" class="text-center">No result(s) found.</td>
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
			$('#datatable').DataTable({bFilter: false, bInfo: true,"pageLength": <?php echo PAGE_LIMIT?>});
		} );
		</script>
	</body>
</html>