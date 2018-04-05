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
							<h4 class="pull-left page-title"><?php echo (@$this->uri->segment(4)?'Edit Customer':'Add Customer');?></h4>
							<button class="btn btn-primary pull-right" onclick="location.href='<?php echo base_url('cable/customers');?>'">Back</button>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-body table-rep-plugin">
									<div class="row">
										<form method="post" id="customer_form" enctype="multipart/form-data">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<?php echo $this->utilitylib->showMsg();?>
												<div class="info_ii">
													<P>Basic Information</P>
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Area<span class="text-danger">*</span></label>
													<select name="area_id" class="form-control required area_id">
														<option value="">Select Area</option>
														<?php foreach($area as $row){ ?>
															<option value="<?php echo $row['area_id']?>" <?php if(@$details['area_id']==$row['area_id']){echo "selected";}?>><?php echo $row['area_name']?></option>
														<?php }?>
													</select>
													<span class="area_span"></span>
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Other ID<span class="text-danger">*</span></label>
													<input class="form-control required other_id" type="text" name="other_id" value="<?php echo @$details['other_id'];?>">
													<span class="other_span"></span>
												</div>
											</div>
											
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">CAF No.<span class="text-danger">*</span></label>
													<input class="form-control required" type="text" name="caf_no" value="<?php echo @$details['caf_no'];?>">
													
												</div>
											</div>
											<div class="clearfix"></div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Full Name<span class="text-danger">*</span></label>
													<input class="form-control required" type="text" name="first_name" value="<?php echo @$details['first_name'];?>">
												</div>
											</div>
											
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Mobile 1<span class="text-danger">*</span></label>
													<input class="form-control required" type="text" name="mobile1" value="<?php echo @$details['mobile1'];?>">
												</div>
											</div>
											
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Mobile 2</label>
													<input class="form-control" type="text" name="mobile2" value="<?php echo @$details['mobile2'];?>">
												</div>
											</div>
											
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Email</label>
													<input class="form-control" id="email" type="text" name="email" value="<?php echo @$details['email'];?>">
													<span class="email_error"></span>
												</div>
											</div>
											
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Gender<span class="text-danger">*</span></label>
												</div>
												<label class="radio-inline">
													<input type="radio" id="male" class="required" name="gender" value="1"  <?php if(@$details['gender']==1){echo "checked";}?>>Male 
												</label>
												<label class="radio-inline">
													<input type="radio" id="female" class="required" name="gender" value="2" <?php if(@$details['gender']==2){echo "checked";}?>>Female
												</label>
											</div>
											
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Date of Birth</label>
													<input class="form-control dob" type="text" name="dob" value="<?php echo @$details['dob'];?>">
												</div>
											</div>
											<div class="clearfix"></div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Address1<span class="text-danger">*</span></label>
													<textarea class="form-control required" name="address1"><?php echo @$details['address1'];?></textarea>
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Address2</label>
													<textarea class="form-control" name="address2"><?php echo @$details['address2'];?></textarea>
												</div>
											</div>
											
											<div class="clearfix"></div>
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<div class="info_ii">
													<P>Connection Information</P>
												</div>
											</div>
											
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">MSO<span class="text-danger">*</span></label>
													<select name="mso_id" class="form-control required">
														<option value="">Select MSO</option>
														<?php foreach($isp as $row){ ?>
															<option value="<?php echo $row['isp_id']?>" <?php if(@$details['mso_id']==$row['isp_id']){echo "selected";}?>><?php echo $row['mso'];?></option>
														<?php }?>
													</select>
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">LCO<span class="text-danger">*</span></label>
													<select name="lco_id" class="form-control required">
														<option value="">Select LCO</option>
														<?php foreach($lco as $row){ ?>
															<option value="<?php echo $row['lco_id']?>" <?php if(@$details['lco_id']==$row['lco_id']){echo "selected";}?>><?php echo $row['lconame'];?></option>
														<?php }?>
													</select>
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Collector<span class="text-danger">*</span></label>
													<select name="staff_id" class="form-control required">
														<option value="">Select collector</option>
														<?php foreach($collector as $row){ ?>
															<option value="<?php echo $row['staff_id']?>" <?php if(@$details['staff_id']==$row['staff_id']){echo "selected";}?>><?php echo $row['staff_name'];?></option>
														<?php }?>
													</select>
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Package<span class="text-danger">*</span></label>
													<select name="package_id" class="form-control package_id required">
														<option value="">Select Package</option>
														<?php foreach($package as $row){ ?>
															<option value="<?php echo $row['package_id']?>" <?php if(@$details['package_id']==$row['package_id']){echo "selected";}?>><?php echo $row['pakname'];?></option>
														<?php }?>
													</select>
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Package type<span class="text-danger">*</span></label>
												</div>
												<label class="radio-inline">
													<input type="radio" id="including" class="required package_type" name="package_type" value="1" <?php if(@$details['package_type']==1){echo 'checked';}?>>Including 
												</label>
												<label class="radio-inline">
													<input type="radio" id="excluding" class="required package_type" name="package_type" value="2" <?php if(@$details['package_type']==2){echo 'checked';}?>>Excluding
												</label>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Package Amount<span class="text-danger">*</span></label>
													<input class="form-control required pack_amount" type="text" name="pack_amount" value="<?php echo @$details['pack_amount'];?>">
												</div>
											</div>
											
											<div class="clearfix"></div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Connection Date<span class="text-danger">*</span></label>
													<input class="form-control required dob" type="text" name="connection_date" value="<?php echo @$details['connection_date'];?>" readonly>
												</div>
											</div>
											
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Billing Date<span class="text-danger">*</span></label>
													<input class="form-control required dob" type="text" name="billing_date" value="<?php echo @$details['billing_date'];?>" readonly>
												</div>
											</div>
											
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">STB Amount<span class="text-danger">*</span></label>
													<input class="form-control required" type="text" name="stb_amount" value="<?php echo @$details['stb_amount'];?>">
												</div>
											</div>
											<?php if(!@$details){ ?>
												<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
													<div class="your-mail">
														<label for="exampleInputEmail1">Balance<span class="text-danger">*</span></label>
														<input class="form-control required" type="text" name="balance" value="<?php echo @$details['balance'];?>">
													</div>
												</div>
												
											<?php } ?>
											<div class="clearfix"></div>
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<div class="info_ii">
													<P>Upload Documents</P>
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Upload address proof</label>
													<input class="form-control" type="file" name="address_proof" value="<?php echo @$details['balance'];?>">
												</div>
											</div>	
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Upload CAF Page1</label>
													<input class="form-control" type="file" name="caf_page1" value="<?php echo @$details['balance'];?>">
												</div>
											</div>	
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Upload CAF Page2</label>
													<input class="form-control" type="file" name="caf_page2" value="<?php echo @$details['balance'];?>">
												</div>
											</div>
											<div class="clearfix"></div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="info_ii">
                                                    <P>STB Information</P>
                                                </div>
                                            </div>
											<div class="ip_address">
												<?php $i=1; if(@$details['ip']){ foreach($details['ip'] as $row){ ?>
												<div class="ip_addres">
													<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
														<div class="your-mail">
															<label for="exampleInputEmail1">STB No.<span class="text-danger">*</span></label>
															<input class="form-control required ip_input" type="text" name="stb_no[]" value="<?php echo @$row['stb_no'];?>" data-id="<?php echo $i;?>">
															<span class="ip_input_span_<?php echo $i;?>"></span>
														</div>
													</div>
													
													<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
														<div class="your-mail">
															<label for="exampleInputEmail1">STB Model<span class="text-danger">*</span></label>
															<select class="form-control" name="stb_model[]">
																<option value="">--Select Model--</option>
																<?php if(@$stb){foreach($stb as $row1){ ?>
																	<option value="<?php echo @$row1['stb_model_id'];?>" <?php if($row['stb_model_id']==$row['stb_model_id']){echo 'selected';}?>><?php echo @$row1['stb_model_no'];?></option>
																<?php }} ?>
															</select>
															<span class="username_input_span_<?php echo $i;?>"></span>
														</div>
													</div>
													
													<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
														<div class="your-mail">
															<label for="exampleInputEmail1">Account<span class="text-danger">*</span></label>
															<input class="form-control required username" data-id="<?php echo $i;?>" type="text" name="account[]" value="<?php echo @$row['account'];?>">
															<span class="account_input_span_<?php echo $i;?>"></span>
														</div>
													</div>
													<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
														<?php if($i==1){ ?>
														<div class="your-mail">
															<label for="exampleInputEmail1"> &nbsp; </label>
															<button class="btn add_ip" type="button">+</button>
														</div>
														<?php }else{ ?>
														<div class="your-mail"><label for="exampleInputEmail1"> &nbsp; </label><button class="btn remove_ip" type="button">&times;</button></div>	
														<?php } $i++;?>
													</div>
												</div>
												<div class="clearfix"></div>
												<?php }}else{ ?>
												<div class="ip_addres">
													<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
														<div class="your-mail">
															<label for="exampleInputEmail1">STB No.<span class="text-danger">*</span></label>
															<input class="form-control required ip_input" type="text" name="stb_no[]" value="" data-id="1">
															<span class="ip_input_span_1"></span>
														</div>
													</div>
													<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
														<div class="your-mail">
															<label for="exampleInputEmail1">STB Model<span class="text-danger">*</span></label>
															<select class="form-control" name="stb_model[]">
																<option value="">--Select Model--</option>
																<?php if(@$stb){foreach($stb as $row){ ?>
																	<option value="<?php echo @$row['stb_model_id'];?>"><?php echo @$row['stb_model_no'];?></option>
																<?php }} ?>
															</select>
															<span class="username_input_span_1"></span>
														</div>
													</div>
													<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
														<div class="your-mail">
															<label for="exampleInputEmail1">Account<span class="text-danger">*</span></label>
															<input class="form-control required username" data-id="1" type="text" name="account[]" value="">
															<span class="username_input_span_1"></span>
														</div>
													</div>
													<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
														<div class="your-mail">
															<label for="exampleInputEmail1"> &nbsp; </label>
															<button class="btn add_ip" type="button">+</button>
														</div>
													</div>
												</div>
												<div class="clearfix"></div>
												<?php } ?>
											</div>											
											<div class="clearfix"></div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="add_btnm">
													<input value="Save" type="button" class="btn btn-primary form_submit">
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
	<script>
		$(document).ready(function(){
			$('.area_id').change(function(){
				var area_id = $(this).val();
				$.ajax({
					url:'<?php echo base_url('cable/customers/get_other_id')?>',
					method:'post',
					data:{
						area_id:area_id
					},
					dataType:'json',
					success:function(result){
						console.log(result.result.other_id);
						console.log(result.result);
						if(result.result != null){
							$('.other_id').val(parseInt(result.result.other_id)+1);	
						} else{
							$('.other_id').val('');	
						}
					},
					error:function(err){
						console.log(err);
					}
				});
			});
		});
	</script>
	
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<script>
		$(document).ready(function(){
			$('.package_type').click(function(){
				var pack_type = $(this).val();
				
				var package_id = $('.package_id').val();
				if(package_id!=null){
					$.ajax({
						url:'<?php echo base_url('cable/customers/get_pack_amount')?>',
						method:'post',
						data:{package_id:package_id},
						dataType:'json',
						success:function(result){
							console.log(result);
							if(pack_type==1){
								$('.pack_amount').val(result.including);
							}else if(pack_type==2){
								$('.pack_amount').val(result.excluding);
							}
						}
					});
				}
			});
		});
	</script>
	<script>
		$(document).ready(function(){
			$('.other_id').blur(function(){
				var other_id = $(this).val();
				var area_id = '';
				var area_id = $('.area_id').val();
				var customer_id = '';
				<?php if(@$details['customer_id']){ ?>
					customer_id = <?php echo @$details['customer_id'];?>;
				<?php }?>
				$.ajax({
					url:'<?php echo base_url('cable/customers/check_other_id')?>',
					data:{
						'other_id':other_id,'area_id':area_id,'customer_id':customer_id
					},
					method:'post',
					dataType:'json',
					success:function(result){
						if(result.STATUS=='EXIST'){
							$('.other_span').html('This ID is already exist');
							$('.other_span').css('color','#f00');
							$('.other_id').val('');
							$('.area_span').html('This Area is already exist');
							$('.area_span').css('color','#f00');
							$('.area_id').val('');
						}else{
							$('.other_span').html('');
							$('.area_span').html('');
						}
					}
				});
			});

			$('#customer_form').validate();
			$('.dob').datepicker({
				dateFormat: 'yy-mm-dd',
				changeMonth: true, 
				changeYear: true,
				yearRange: "-90:+00",
				maxDate: '0'
			});
			var email_flag = true;
			$('#email').blur(function(){
				email_flag = false;
				var email = $(this).val();
				if(email!=''){
					var customer_id = '';
					<?php if(@$details['customer_id']){ ?>
						customer_id = <?php echo @$details['customer_id'];?>;
					<?php }?>
					$.ajax({
						method:'post',
						data:{'email':email,'customer_id':customer_id},
						url:'<?php echo base_url('cable/customers/chk_email')?>',
						success:function(result){
							if(result>0){
								$('.email_error').html('Email is already exist');
								$('.email_error').css('color','#f00');
							}else{
								$('.email_error').html('');
								email_flag = true;
							}
						}
					});
				}
			});
			var ip_flag=0;
			$('body').on('blur','.ip_input',function(){
				var ip = $(this).val();
				var id = $(this).data('id');
				$.ajax({
					url:'<?php echo base_url('cable/customers/check_ip'); ?>',
					method:'post',
					data:{
						ip:ip,
						customer_id:'<?php echo @$details['customer_id']?$details['customer_id']:'';?>'
					},
					dataType: 'json',
					success:function(result){
						console.log(result);
						if(result.tot > 0){
							$('.ip_input_span_'+id).html('This STB is already exist');
							$('.ip_input_span_'+id).css('color','#f00');
							ip_flag=ip_flag+1;
						}else{
							$('.ip_input_span_'+id).html('');
							ip_flag=ip_flag-1;
						}
					}
				});
			});
			var username_flag=0;
			$('body').on('blur','.username',function(){
				var username = $(this).val();
				var id = $(this).data('id');
				$.ajax({
					url:'<?php echo base_url('cable/customers/check_username'); ?>',
					method:'post',
					data:{
						username:username,
						customer_id:'<?php echo @$details['customer_id']?$details['customer_id']:'';?>'
					},
					success:function(result){
						console.log(result);
						if(result>0){
							$('.username_input_span_'+id).html('This username is already exist');
							$('.username_input_span_'+id).css('color','#f00');
							username_flag=username_flag+1;
						}else{
							$('.username_input_span_'+id).html('');
							username_flag=username_flag-1;
						}
					}
				});
			});
			
			/*
			* @ This function is used for submit the form if username and stb no is not exist.
			*/
			$('.form_submit').click(function(){
				$('.loader').show();
				$('.loader-inner').show();
				setTimeout(function(){
					if(ip_flag>0 || username_flag>0){
						$('.loader').hide();
						$('.loader-inner').hide();
						console.log(ip_flag, username_flag);
						email_flag=false;
						return false;
					}else{
						email_flag=true;
						console.log(ip_flag, username_flag);
						$('#customer_form').submit();
						$('.loader').hide();
						$('.loader-inner').hide();
					}
				}, 3000);
			});
		});
	</script>
	<script>
		$(document).ready(function(){
			var count=0;
			$('body').on('click','.add_ip',function(){
				<?php if(@$details['ip']){ ?>
				var count=<?php echo count($details['ip'])?>;
				<?php } ?>
				count++;
				var html = '<div class="ip_addres"><div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"><div class="your-mail"><label for="exampleInputEmail1">STB No.<span class="text-danger">*</span></label><input class="form-control required ip_input" data-id="'+count+'" type="text" name="stb_no[]" value=""><span class="ip_input_span_'+count+'"></span></div></div><div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"><div class="your-mail"><label for="exampleInputEmail1">STB Model<span class="text-danger">*</span></label><select class="form-control" name="stb_model[]" data-id="'+count+'"><option value="">--Select Model--</option><?php if(@$stb){foreach($stb as $row){ ?><option value="<?php echo @$row['stb_model_id'];?>"><?php echo @$row['stb_model_no'];?></option><?php }} ?></select></span></div></div><div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"><div class="your-mail"><label for="exampleInputEmail1">Account<span class="text-danger">*</span></label><input class="form-control required username" type="text" name="account[]" data-id="'+count+'" value=""><span class="ip_input_span_'+count+'"></span></div></div><div class="col-lg-3 col-md-3 col-sm-4 col-xs-12"><div class="your-mail"><label for="exampleInputEmail1"> &nbsp; </label><button class="btn remove_ip" type="button">&times;</button></div></div></div><div class="clearfix"></div>';
				$('.ip_address').append(html);
				
			});
			$('body').on('click','.remove_ip',function(){
				$(this).parent().parent().parent().remove();
			});
		});
	</script>
	
	</body>
</html>