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
			<?php echo @$left_menu; ?>
			<!-- Left Sidebar End -->
			<!-- container -->
			<div class="content-page">
			<!-- Start content -->
			<div class="content">
				<div class="container">
					<!-- Page-Title -->
					<div class="row">
						<div class="col-sm-12">
							<h4 class="pull-left page-title"><?php echo (@$this->uri->segment(4)?'Edit Staff':'Add Staff');?></h4>
							<button class="btn btn-primary pull-right" onclick="location.href='<?php echo base_url('internet/staff');?>'">Back</button>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							
							<div class="panel panel-default">
								<div class="panel-body table-rep-plugin">
									<div class="row">
										
										<form method="post" id="form">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<?php echo $this->utilitylib->showMsg();?>
												<div class="info_ii">
													<P>Basic Information</P>
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Staff Name<span class="text-danger">*</span></label>
													<input class="form-control required" type="text" name="staff_name" value="<?php echo @$details['staff_name'];?>">
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Designation<span class="text-danger">*</span></label>
													<div class="form-group">
														<input class="form-control required" type="text" name="designation" value="<?php echo @$details['designation'];?>">
													</div>
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Staff Base<span class="text-danger">*</span></label>
												</div>
												<label class="radio-inline">
													<input type="radio" id="com" class="required" name="staff_base" value="1" <?php if(@$details['staff_base']==1){ echo "checked";}?>>COMISSION 
												</label>
												<label class="radio-inline">
													<input type="radio" id="fixed" class="required" name="staff_base" value="2" <?php if(@$details['staff_base']==2){ echo "checked";}?>>FIXED
												</label>
											</div>
											<div class="clearfix"></div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Commission Rate<span class="text-danger">*</span></label>
													<div class="form-group">
														<input class="form-control required" type="text" name="commission" value="<?php echo @$details['commission'];?>">
													</div>
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Address<span class="text-danger">*</span></label>
													<textarea class="form-control required" name="address"><?php echo @$details['address'];?></textarea>
												</div>
											</div>
											
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="">Mobile<span class="text-danger">*</span></label>
													<!--<input class="form-control number required" type="text" name="mobile" value="<?php echo @$details['mobile'];?>">-->
													<textarea class="form-control required" name="mobile"><?php echo str_replace('<br />','&#13;',@$details['mobile']);?></textarea>
												</div>
											</div>
											<div class="clearfix"></div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="">Joining Date<span class="text-danger">*</span></label>
													<input class="form-control required joining_date" type="text" name="join_date" value="<?php echo @$details['join_date'];?>" readonly>
												</div>
											</div>
											
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="">Staff Type<span class="text-danger">*</span></label>
													<input class="form-control required" type="text" name="staff_type" value="<?php echo @$details['staff_type'];?>">
												</div>
											</div>
											
											
											<div class="clearfix"></div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="add_btnm">
													<input value="Save" type="submit" class="btn btn-primary">
												</div>
											</div>
										</form>
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
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<script>
		$(document).ready(function(){
			$('#form').validate();
			$('.joining_date').datepicker({
				dateFormat: "yy-mm-dd"
			});
		});
	</script>
	</body>
</html>