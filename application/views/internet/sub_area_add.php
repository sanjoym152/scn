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
							<h4 class="pull-left page-title"><?php echo (@$this->uri->segment(4)?'Edit Sub Area':'Add Sub Area');?></h4>
							<button class="btn btn-primary pull-right" onclick="location.href='<?php echo base_url('internet/sub_area');?>'">Back</button>
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
													<label for="exampleInputEmail1">Area Name<span class="text-danger">*</span></label>
													<select name="area_id" class="form-control required">
														<option value="">Select Area</option>
														<?php 
														foreach($area as $row){
														?>
														<option value="<?php echo @$row['area_id'];?>" <?php if(@$details['area_id']==$row['area_id']){ echo "selected";}?>><?php echo $row['area_name'];?></option>
														<?php 
														}
														?>
													</select>
													
												</div>
											</div>
											
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Sub Area Name<span class="text-danger">*</span></label>
													<input class="form-control required" type="text" name="sub_area_name" value="<?php echo @$details['sub_area_name'];?>">
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