<div class="col-md-12 mt-3">
	<div class="col-md-3">
		<a data-fancybox="images" class="" href="uploads/<?php echo @$customer['address_attachment'];?>">
		<?php if(@$customer['address_attachment']){?>
			<img src="uploads/<?php echo @$customer['address_attachment'];?>" class="img-responsive"/>
		<?php }else{?>
			<img src="cable_assets/images/no_image.png" class="img-responsive"/>
		<?php }?>
			<div class="mask">
				<p>Address Proof</p>
			</div>
		</a>
		
	</div>
	<div class="col-md-3">
		<a data-fancybox="images" class="" href="uploads/<?php echo @$customer['caf_page1'];?>">
			<img src="uploads/<?php echo @$customer['caf_page1'];?>" class="img-responsive"/>
			<div class="mask">
				<p>CAF Page1</p>
			</div>
		</a>
	</div>
	<div class="col-md-3">
		<a data-fancybox="images" class="" href="uploads/<?php echo @$customer['caf_page2'];?>">
			<img src="uploads/<?php echo @$customer['caf_page2'];?>" class="img-responsive"/>
			<div class="mask">
				<p>CAF Page2</p>
			</div>
		</a>
	</div>
</div>