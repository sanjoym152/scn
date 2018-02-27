<style>
	.sadas{
		border-bottom: #d2d2d2 solid 1px;
		padding: 10px;
	}
	.small{
		    margin-left: 18px;
    color: #525151;
	}
</style>
<?php 
/* echo "<pre>";
print_r($all_channel);die; */
?>
<div class="col-md-12">
	<form method="post" action="<?php echo base_url('cable/customers/add_channel')?>" id="add_chnl_frm">
		<?php foreach($all_channel as $row){ if (!in_array($row['channel_id'], $c_chnl_id)){ ?>
		<div class="col-md-6">
			<div class="form-group sadas">
				<label for="chnl_<?php echo @$row['channel_id'];?>">
				<input type="checkbox" name="channel[]" value="<?php echo @$row['channel_id'];?>" id="chnl_<?php echo @$row['channel_id'];?>" data-id="<?php echo @$row['channel_id'];?>" <?php if (in_array($row['channel_id'], $c_chnl_id)){echo 'checked';}?> class="chnl_chk"> <?php echo @$row['channel_name'];?>
				</label>
				<div class="clearfix"></div>
				<small class="small">Rs.<?php echo @$row['tot_amount']?></small>
				<div class="clearfix"></div>
				<span class="chnl_text_error_<?php echo @$row['channel_id'];?>"></span>
				<input type="hidden" name="customer_id" value="<?php echo $customer_id;?>">
			</div>				
		</div>
		<?php } } ?>
		<div class="col-md-12 text-center">
			<input type="submit" value="Save" class="btn btn-success">
		</div>
	</form>
</div>
