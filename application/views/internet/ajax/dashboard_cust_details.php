<div class="col-md-12 noPad">
	<!-- <div class="col-md-1 noPad docs_section">
		<div class="col-md-12 doc_image_area">
			<img width="80" height="80" src="<?php echo @$customer_details['caf_page1']?'uploads/'.@$customer_details['caf_page1']:'uploads/no_img.png';?>">
		</div>
		<div class="col-md-12 doc_image_area">
			<img width="80" height="80" src="<?php echo @$customer_details['caf_page2']?'uploads/'.@$customer_details['caf_page2']:'uploads/no_img.png';?>">
		</div>
		<div class="col-md-12 doc_image_area">
			<img width="80" height="80" src="<?php echo @$customer_details['address_attachment']?'uploads/'.@$customer_details['address_attachment']:'uploads/no_img.png';?>">
		</div> -->
	</div>
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="basic_info">
					<div class="col-md-12">
						<div class="col-md-6">
							<span class="">Full Name: </span>
							<span class="pull-right"><strong><?php echo @$customer_details['first_name'];?></strong></span>
						</div>
						<div class="col-md-6">
							<span class="">CUST CODE: </span>
							<span class="pull-right"><?php echo @$customer_details['cust_code'];?></span>
						</div>
						<div class="col-md-6">
							<span class="">OTHER ID: </span>
							<span class="pull-right"><?php echo @$customer_details['other_id'];?></span>
						</div>
						<div class="col-md-6">
							<span class="">CAF No:</span>
							<span class="pull-right"><?php echo @$customer_details['caf_no'];?></span>
						</div>
						
						<div class="col-md-6">
							<span class="">MOBILE:</span>
							<span class="pull-right"><?php echo @$customer_details['mobile1'];?></span>
						</div>
						
						<div class="col-md-6">
							<span class="">Address1:</span>
							<span class="pull-right"><?php echo @$customer_details['address1'];?></span>
						</div>
						
						<div class="col-md-6">
							<span class="">Mobile2: </span>
							<span class="pull-right"><?php echo @$customer_details['mobile2']?$customer_details['mobile2']:'N/A';?></span>
						</div>
						
						<div class="col-md-6">
							<span class="">Address2: </span>
							<span class="pull-right"><?php echo @$customer_details['address2'];?></span>
						</div>
						<div class="col-md-6">
							<span class="">Email:</span>
							<span class="pull-right"><?php echo @$customer_details['email'];?></span>
						</div>
						<div class="col-md-6">
							<span class="">DOB: </span>
							<span class="pull-right"><?php echo date('d/m/Y',strtotime(@$customer_details['dob']));?></span>
						</div>
						<div class="col-md-6">
							<span class="">Gender: </span>
							<span class="pull-right"><?php echo @$customer_details['gender']==1?'Male':'Female';?></span>
						</div>
						<div class="col-md-6">
							<span class="">Pincode: </span>
							<span class="pull-right"><?php echo @$customer_details['pincode'];?></span>
						</div>
						
						<div class="col-md-6">
							<span class="">Package:</span>
							<span class="pull-right"><?php echo @$customer_details['pakname'].'('.@$customer_details['pkg_mode'].' Month(s))';?></span>
						</div>
						<div class="col-md-6">
							<span class="">LCO:</span>
							<span class="pull-right"><?php echo @$customer_details['shtname'];?><small>(<?php echo @$customer_details['lconame'];?>)</small></span>
						</div>
						<div class="col-md-6">
							<span class="">Connection Date:</span>
							<span class="pull-right"><?php echo date('d/m/Y',strtotime(@$customer_details['connection_date']));?></span>
						</div>
						<div class="col-md-6">
							<span class="">ISP:</span>
							<span class="pull-right"><?php echo @$customer_details['mso'];?></span>
						</div>
						<div class="col-md-6">
							<span class="">Balance:</span>
							<span class="pull-right">Rs. <?php echo @$customer_details['balance'];?></span>
						</div>
						<div class="col-md-6">
							<span class="">STB Amount:</span>
							<span class="pull-right"><?php echo @$customer_details['stb_amount'];?></span>
						</div>
						<div class="ip_area">
							<table class="table table-striped">
								<tbody>
								<?php 
								foreach($customer_details['stb'] as $row){ ?>
									<tr>
										<td><strong><?php echo @$row['ip_address']?></strong></td>
										<td><?php echo @$row['username']?></td>
									</tr>
								<?php } ?>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3 edit_section">
		<button data-id="<?php echo $customer_details['customer_id'];?>" class="btn btn-success dashboard_btn edit_cust" onclick="location.href='<?php echo base_url('cable/customers/add/'.$customer_details['customer_id']);?>'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> EDIT CUSTOMER</button>
		<button class="btn btn-warning dashboard_btn" onclick="location.href='<?php echo base_url('cable/customers/change_status/'.$customer_details['customer_id']);?>'"><i class="fa fa-ban" aria-hidden="true"></i> INACTIVE CUSTOMER</button>
		<button class="btn btn-danger dashboard_btn" onclick="location.href='<?php echo base_url('cable/customers/delete_record/'.$customer_details['customer_id']);?>'"><i class="fa fa-trash" aria-hidden="true"></i> DELETE CUSTOMER</button>
	</div>
</div>



