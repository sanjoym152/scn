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
								<h4 class="pull-left page-title">ALL STAFF DETAILS</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<?php echo $this->utilitylib->showMsg();?>
								<div class="panel panel-default">
									
									<div class="panel-body table-rep-plugin">
										<div class="panel panel-default">
										<div class="panel-heading">Search Staff by Name, Designation, Staff Type etc.</div>
										<div class="panel-body">
										<form method="post">
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													
													<input class="form-control" id="keyword" type="text" name="keyword" value="<?php echo $this->input->post('keyword');?>" placeholder="Search Keyword">
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
													<a href="<?php echo base_url('internet/staff/add');?>"><i class="md md-add"></i> Add New Staff</a>
												</div>
											</div>
											<div class="clearfix"></div>
											<div class="col-md-12 col-sm-12 col-xs-12">
												
												<div class="table-responsive" data-pattern="priority-columns">
													<table id="datatable" class="table table-striped table-bordered">
														<thead>
															<tr>
																<th>#</th>
																<th>STAFF NAME</th>
																<th>STAFF ID</th>
																<th>DESIGNATION</th>
																<th>STAFF BASE</th>
																<th>COMMISSION</th>
																<th>ADDRESS</th>
																<th>MOBILE</th>
																<th>JOINING DATE</th>
																<th>STAFF TYPE</th>
																<th>STATUS</th>
																<th>Action</th>
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
																	<td><?php echo @$row['staff_name'];?></td>
																	<td><?php echo @$row['staff_code'];?></td>
																	<td><?php echo @$row['designation'];?></td>
																	<td><?php 
																	if(@$row['staff_base']==1){
																		echo "COMMISSION";
																	}elseif(@$row['staff_base']==2){
																		echo "FIXED";
																	}?></td>
																	<td><?php echo @$row['commission'];?></td>
																	<td><?php echo @$row['address'];?></td>
																	<td><?php echo @$row['mobile'];?></td>
																	<td><?php echo @$row['join_date'];?></td>
																	<td><?php echo @$row['staff_type'];?></td>
																	<td><?php echo ($row['status']==1)?'<label class="label label-success">Active</label>':'<label class="label label-danger">Inactive</label>';?></td>
																	<td>
																		<a href="<?php echo base_url('internet/staff/add/'.$row['staff_id']);?>" title="Edit" data-toggle="tooltip">   <i class="fa fa-pencil-square-o delet" aria-hidden="true"></i></a>
																		<a href="<?php echo base_url('internet/staff/delete_record/'.$row['staff_id']);?>" onclick="return confirm('Are you sure?')" title="Delete" data-toggle="tooltip"> <i class="fa fa-trash-o delet" aria-hidden="true"></i></a>
																		<?php 
																		if($row['status']==1){
																		?>
																		<a onclick="return confirm('Are you sure?')" href="<?php echo base_url('internet/staff/change_status/'.$row['staff_id']);?>" title="Click to Inactive" data-toggle="tooltip"> <i class="fa fa-times" aria-hidden="true"></i></a>
																		<?php
																		}else if($row['status']==2){ ?>
																		<a onclick="return confirm('Are you sure?')" href="<?php echo base_url('internet/staff/change_status/'.$row['staff_id']);?>" title="Click to Active" data-toggle="tooltip"> <i class="fa fa-check delet" aria-hidden="true"></i></a>	
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
			$('#datatable').DataTable({bFilter: false, bInfo: true,"pageLength": <?php echo PAGE_LIMIT;?>});
		} );
		</script>
	</body>
</html>