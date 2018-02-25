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
							<h4 class="pull-left page-title"><?php echo (@$this->uri->segment(4)?'Edit IPS':'Add IPS');?></h4>
							<button class="btn btn-primary pull-right" onclick="location.href='<?php echo base_url('internet/isp');?>'">Back</button>
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
													<label for="exampleInputEmail1">ISP Name<span class="text-danger">*</span></label>
													<input class="form-control required" id="mso" type="text" name="mso" value="<?php echo @$details['mso'];?>">
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Short Name<span class="text-danger">*</span></label>
													<input class="form-control required" id="shtname" type="text" name="shtname" value="<?php echo @$details['shtname'];?>">
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Email ID</label>
													<input class="form-control email" id="email" type="text" name="email" value="<?php echo @$details['email'];?>">
												</div>
											</div>
											<div class="clearfix"></div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Fax No</label>
													<input class="form-control number" id="fax" type="text" name="fax" value="<?php echo (@$details['fax']!=0)?$details['fax']:'';?>">
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Phone No</label>
													<input class="form-control number" id="phone" type="text" name="phone" value="<?php echo (@$details['phone']!=0)?$details['phone']:'';?>">
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Mobile No<span class="text-danger">*</span></label>
													<input class="form-control required number" id="mob" type="text" name="mob" value="<?php echo @$details['mob'];?>">
												</div>
											</div>
											<div class="clearfix"></div>
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<div class="your-mail">
													<label for="">Address<span class="text-danger">*</span></label>
													<textarea name="address" class="form-control required"><?php echo @$details['address'];?></textarea>
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
		});
	</script>
	</body>
</html>