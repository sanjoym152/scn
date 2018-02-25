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
							<h4 class="pull-left page-title"><?php echo (@$this->uri->segment(4)?'Edit Package':'Add Package');?></h4>
							<button class="btn btn-primary pull-right" onclick="location.href='<?php echo base_url('internet/package');?>'">Back</button>
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
													<label for="exampleInputEmail1">Package Name<span class="text-danger">*</span></label>
													<input class="form-control required" id="pakname" type="text" name="pakname" value="<?php echo @$details['pakname'];?>">
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Package Mode<span class="text-danger">*</span></label>

													<div class="form-group">
														<select name="pkg_mode" class="form-control required">
															<option value="">Select Package Mode</option>
															<option value="1" <?php if(@$details['pkg_mode']==1){ echo "selected";}?>>One Month</option>
															<option value="3" <?php if(@$details['pkg_mode']==3){ echo "selected";}?>>Three Month</option>
															<option value="6" <?php if(@$details['pkg_mode']==6){ echo "selected";}?>>Six Month</option>
															<option value="12" <?php if(@$details['pkg_mode']==12){ echo "selected";}?>>One Year</option>
														</select>
													</div>
												</div>
											</div>
											
											<div class="clearfix"></div>
											<div class="tax_type_div" style="padding-bottom:100px">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<div class="info_ii">
														<P>Tax Information</P>
													</div>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
													
													<label class="radio-inline">
														<input type="radio" class="required tax_type1" name="tax_type1" value="1" <?php if(@$details['staff_base']==1){echo "checked";}?>> Including All Tax 
													</label>
													<label class="radio-inline">
														<input type="radio" class="required  tax_type1" name="tax_type1" value="2" <?php if(@$details['staff_base']==2){echo "checked";}?>> Excluding All Tax 
													</label>
												</div>
											</div>
											
											<div class="clearfix"></div>
											<div class="including_tax" <?php if(@$details['staff_base']==1){ ?>style="display:block;"<?php }else{ ?> style="display:none;"<?php }?>>
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<div class="info_ii">
														<P>Including Tax Information</P>
													</div>
												</div>											
												<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
													<div class="your-mail">
														<label for="">Final Amount</label>
														<input class="form-control number final_amount" type="text" name="including_amount" value="<?php echo @$details['including_amount'];?>">
													</div>
												</div>
											</div>
											
											<div class="clearfix"></div>
											<div class="tax_row excluding_tax"  <?php if(@$details['staff_base']==2){ ?>style="display:block;"<?php }else{ ?> style="display:none;"<?php }?>>
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<div class="info_ii">
														<P>Excluding Tax Information</P>
													</div>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
													<div class="your-mail">
														<label for="exampleInputEmail1">Basic Amount</label>
														<input class="form-control basic_amount" type="text" name="pakren" value="<?php echo @$details['pakren'];?>">
													</div>
												</div>
												<div class="clearfix"></div>
												<div class="tax_row_inner">
													<div class="append">
														<?php $i=1; if(@$package_tax){ foreach($package_tax as $k=>$v){?>
														<div class="append_1" data-id="<?php echo @$i;?>">
															<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
																<div class="your-mail">
																	<label for="exampleInputEmail1">Tax Name</label>
																	<input class="form-control required tax_name" type="text" name="tax_name[]" value="<?php echo @$v['tax_name'];?>" data-id="<?php echo @$i;?>">
																</div>
															</div>
															<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
																<div class="your-mail">
																	<label for="exampleInputEmail1">Tax No</label>
																	<input class="form-control number required tax_no" type="text" name="tax_no[]" value="<?php echo @$v['tax_no'];?>" data-id="<?php echo @$i;?>">
																</div>
															</div>
															<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
																<div class="your-mail">
																	<label for="exampleInputEmail1">Tax Type</label>
																	<select name="tax_type[]" class="form-control required tax_type tax_type_1" data-id="<?php echo @$i;?>" id="tax_type_<?php echo @$i;?>">
																		<option value="">Select Tax Type</option>
																		<option value="1" <?php if($v['tax_type']==1){echo 'selected';}?>>Percentage</option>
																		<option value="2" <?php if($v['tax_type']==2){echo 'selected';}?>>Fixed</option>
																	</select>
																</div>
															</div>
															<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
																<div class="your-mail">
																	<label for="exampleInputEmail1">Amount</label>
																	<input class="form-control number required tax_price" type="number" id="tax_price_<?php echo @$i;?>" name="tax_price[]" value="<?php echo @$v['tax_price'];?>" min="0" data-id="<?php echo @$i;?>">
																</div>
															</div>
															<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
																<div class="your-mail">
																	<label for="exampleInputEmail1"> &nbsp; </label>
																	<?php if($i==1){?> 
																	<button class="btn add_tax" type="button">+</button>
																	<?php } $i++;?>
																	<button class="btn remove_tax" type="button">&times;</button>
																</div>
															</div>
														</div>
														<?php }}else{ ?>
														<div class="append_1" data-id="1">
															<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
																<div class="your-mail">
																	<label for="exampleInputEmail1">Tax Name</label>
																	<input class="form-control tax_name" type="text" name="tax_name[]" value="" data-id="1">
																</div>
															</div>
															<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
																<div class="your-mail">
																	<label for="exampleInputEmail1">Tax No</label>
																	<input class="form-control number required tax_no" type="text" name="tax_no[]" value="" data-id="1">
																</div>
															</div>
															<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
																<div class="your-mail">
																	<label for="exampleInputEmail1">Tax Type</label>
																	<select name="tax_type[]" class="form-control required tax_type tax_type_1" data-id="1" id="tax_type_1">
																		<option value="">Select Tax Type</option>
																		<option value="1">Percentage</option>
																		<option value="2">Fixed</option>
																	</select>
																</div>
															</div>
															<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
																<div class="your-mail">
																	<label for="exampleInputEmail1">Amount</label>
																	<input class="form-control number required tax_price" type="number" id="tax_price_1" name="tax_price[]" value="0" min="0" data-id="1">
																</div>
															</div>
															<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
																<div class="your-mail">
																	<label for="exampleInputEmail1"> &nbsp; </label>
																	<button class="btn add_tax" type="button">+</button>
																	<!--<button class="btn remove_tax" type="button">&times;</button>-->
																</div>
															</div>
														</div>
														<?php }?>
																
													</div>	
												</div>
											</div>
											
											<div class="clearfix"></div>
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<div class="info_ii">
													<P>Discount Information</P>
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Amount</label>
													<input class="form-control number dis_amount" type="text" name="dis_amount" value="<?php echo @$details['dis_amount']?$details['dis_amount']:0;?>">
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Type</label>
													<select name="dis_type" class="form-control dis_type">
														<option value="1" <?php if(@$details['dis_type']==1){echo "selected";}?>>In %</option>
														<option value="2" <?php if(@$details['dis_type']==2){echo "selected";}?>>Fixed</option>
													</select>
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Discount Total Amount</label>
													<input class="form-control number discount_total" type="text" name="discount_total" value="<?php echo @$details['discount_total']?$details['discount_total']:0;?>" readonly>
												</div>
											</div>
											<div class="clearfix"></div>
											<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1">Total Amount</label>
													<input class="form-control number tot_amount" type="text" name="tot_amount" readonly value="<?php echo @$details['tot_amount'];?>">
													
												</div>
											</div>
											<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
												<div class="your-mail">
													<label for="exampleInputEmail1"> &nbsp; </label>
													<button class="btn calculate" type="button">Calculate</button>
												</div>
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
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<script>
		$(document).ready(function(){
			$('.tax_type1').click(function(){
				//alert($(this).val());
				var value = $(this).val();
				if(value==1){
					$('.including_tax').fadeIn();
					$('.excluding_tax').fadeOut();
				}if(value==2){
					$('.including_tax').fadeOut();
					$('.excluding_tax').fadeIn();
				}
			});
			$('#form').validate({
				
				rules: {
					'tax_name[]': {
						required: true
					}
				}
			});
			var count=1;
			$('.add_tax').click(function(){
				count+=1;
				$('.append').append('<div class="clearfix"></div><div class="append_1" data-id="'+count+'"><div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><div class="your-mail"><label for="exampleInputEmail1">Tax Name</label><input class="form-control required tax_name" data-id="'+count+'" type="text" name="tax_name[]" value=""></div></div><div class="col-lg-2 col-md-2 col-sm-4 col-xs-12"><div class="your-mail"><label for="exampleInputEmail1">Tax No</label><input class="form-control number tax_no" type="text" data-id="'+count+'" name="tax_no[]" value=""></div></div><div class="col-lg-2 col-md-2 col-sm-4 col-xs-12"><div class="your-mail"><label for="exampleInputEmail1">Tax Type</label><select id="tax_type_'+count+'"  name="tax_type[]" class="form-control required tax_type tax_type_'+count+'" data-id="'+count+'"><option value="">Select Tax Type</option><option value="1">Percentage</option><option value="2">Fixed</option></select></div></div><div class="col-lg-2 col-md-2 col-sm-4 col-xs-12"><div class="your-mail"><label for="exampleInputEmail1">Amount</label><input class="form-control number tax_price tax_price_'+count+'" data-id="'+count+'" type="number" id="tax_price_'+count+'" name="tax_price[]" value="0" min="0"></div></div><div class="col-lg-2 col-md-2 col-sm-4 col-xs-12"><div class="your-mail"><label for="exampleInputEmail1"> &nbsp; </label><button class="btn remove_tax" type="button">&times;</button></div></div></div>');
			});
			$('body').on('click','.remove_tax', function(){
				$(this).parent().parent().parent().remove();
			});
			
			$('.calculate').click(function(){
				var tax_type1 = $('input[name=tax_type1]:checked').val();
				var tot_amount=0;
				var basic_amount=0;
				var percent_amount=0;
				var fixed_amount = 0;
				var tax_amm = 0;
				var discount_total=0;
				var final_amount = 0;
				final_amount = $('.final_amount').val();
				if(tax_type1==1){
					if($('.dis_amount').val()!=''){
						var dis_amount = $('.dis_amount').val();
						if($('.dis_type').val()==1){
							discount_total=((final_amount*dis_amount)/100);
							tot_amount = final_amount-((final_amount*dis_amount)/100);
						}
						else if($('.dis_type').val()==2){
							discount_total=(final_amount - (final_amount-dis_amount));
							tot_amount = parseInt(final_amount)-parseInt(dis_amount);
						}
					}
					//alert(tot_amount);
					$('.tot_amount').val(tot_amount);
					$('.discount_total').val(discount_total);
				}else{
					basic_amount = $('.basic_amount').val();
					$(".append_1").each(function(){
						var id = $(this).data('id');
						if($('#tax_type_'+id).val()==1){
							tax_amm = $('#tax_price_'+id).val(); 
							percent_amount = parseInt(percent_amount)+parseInt(tax_amm);
						}
						if($('#tax_type_'+id).val()==2){
							tax_amm = $('#tax_price_'+id).val(); 
							fixed_amount = parseInt(fixed_amount)+parseInt(tax_amm);
						}
					});
					tot_amount = parseInt(basic_amount)+(basic_amount*percent_amount)/100;
					tot_amount = parseInt(tot_amount)+parseInt(fixed_amount);
					//alert(basic_amount);
					if($('.dis_amount').val()!=''){
						var dis_amount = $('.dis_amount').val();
						if($('.dis_type').val()==1){
							discount_total=((tot_amount*dis_amount)/100);
							tot_amount = tot_amount-((tot_amount*dis_amount)/100);
						}
						else if($('.dis_type').val()==2){
							discount_total=tot_amount - (tot_amount-dis_amount);
							tot_amount = parseInt(tot_amount)-parseInt(dis_amount);
						}
					}
					//alert(tot_amount);
					$('.tot_amount').val(tot_amount);
					$('.discount_total').val(discount_total);
				}
				
				//alert(fixed_amount);
			});
			$('.form_submit').click(function(){
				var tax_type1 = $('input[name=tax_type1]:checked').val();
				var tot_amount=0;
				var basic_amount=0;
				var percent_amount=0;
				var fixed_amount = 0;
				var tax_amm = 0;
				var discount_total=0;
				var final_amount = 0;
				final_amount = $('.final_amount').val();
				if(tax_type1==1){
					if($('.dis_amount').val()!=''){
						var dis_amount = $('.dis_amount').val();
						if($('.dis_type').val()==1){
							discount_total=((final_amount*dis_amount)/100);
							tot_amount = final_amount-((final_amount*dis_amount)/100);
						}
						else if($('.dis_type').val()==2){
							discount_total=(final_amount - (final_amount-dis_amount));
							tot_amount = parseInt(final_amount)-parseInt(dis_amount);
						}
					}
					//alert(tot_amount);
					$('.tot_amount').val(tot_amount);
					$('.discount_total').val(discount_total);
				}else{
					basic_amount = $('.basic_amount').val();
					$(".append_1").each(function(){
						var id = $(this).data('id');
						if($('#tax_type_'+id).val()==1){
							tax_amm = $('#tax_price_'+id).val(); 
							percent_amount = parseInt(percent_amount)+parseInt(tax_amm);
						}
						if($('#tax_type_'+id).val()==2){
							tax_amm = $('#tax_price_'+id).val(); 
							fixed_amount = parseInt(fixed_amount)+parseInt(tax_amm);
						}
					});
					tot_amount = parseInt(basic_amount)+(basic_amount*percent_amount)/100;
					tot_amount = parseInt(tot_amount)+parseInt(fixed_amount);
					//alert(basic_amount);
					if($('.dis_amount').val()!=''){
						var dis_amount = $('.dis_amount').val();
						if($('.dis_type').val()==1){
							discount_total=((tot_amount*dis_amount)/100);
							tot_amount = tot_amount-((tot_amount*dis_amount)/100);
						}
						else if($('.dis_type').val()==2){
							discount_total=tot_amount - (tot_amount-dis_amount);
							tot_amount = parseInt(tot_amount)-parseInt(dis_amount);
						}
					}
					//alert(tot_amount);
					$('.tot_amount').val(tot_amount);
					$('.discount_total').val(discount_total);
				}
				$('#form').submit();
				//alert(fixed_amount);
			});
		});
	</script>
	</body>
</html>