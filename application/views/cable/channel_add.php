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
							<h4 class="pull-left page-title"><?php echo (@$this->uri->segment(4)?'Edit Channel':'Add Channel');?></h4>
							<button class="btn btn-primary pull-right" onclick="location.href='<?php echo base_url('cable/channel');?>'">Back</button>
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
													<label for="exampleInputEmail1">Channel Name<span class="text-danger">*</span></label>
													<input class="form-control required" id="channel_name" type="text" name="channel_name" value="<?php echo @$details['channel_name'];?>">
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Channel Mode<span class="text-danger">*</span></label>
													<div class="form-group">
														<select name="channel_mode" class="form-control required">
															<option value="">Select Channel Mode</option>
															<option value="1" <?php if(@$details['channel_mode']==1){ echo "selected";}?>>One Month</option>
															<option value="3" <?php if(@$details['channel_mode']==3){ echo "selected";}?>>Three Month</option>
															<option value="6" <?php if(@$details['channel_mode']==6){ echo "selected";}?>>Six Month</option>
															<option value="12" <?php if(@$details['channel_mode']==12){ echo "selected";}?>>One Year</option>
														</select>
													</div>
												</div>
											</div>
											
											<div class="clearfix"></div>
											<div class="including_tax">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<div class="info_ii">
														<P>Channel Price Information</P>
													</div>
												</div>											
												<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
													<div class="your-mail">
														<label for="">Channel Price<span class="text-danger">*</span></label>
														<input class="form-control required number final_amount" type="text" name="tot_amount" value="<?php echo @$details['tot_amount'];?>">
													</div>
												</div>
											</div>
											
											<div class="clearfix"></div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="add_btnm">
													<input value="Save" type="submit" class="btn btn-primary form_submit">
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
		});
	</script>
	</body>
</html>