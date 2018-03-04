<style>
.customer_auto{
	position: absolute;
    top: 40px;
    background: #fff;
    width: 308px;
    z-index: 99;
    border: solid 1px #eee;
    overflow-y: scroll;
    height: 134px;
    box-shadow: 2px 0px 5px 0px #949393;
}
.customer_auto ul li{
        border-bottom: solid 1px #eee;
    list-style: none;
    padding: 6px 0 6px 10px;
    cursor: pointer;
}
.customer_auto ul li:hover{
    background: #0e7977;
    color: #fff;
}
.customer_auto ul{
	    padding: 0;
}
</style>
<ul>
	<?php if($customers){ foreach($customers as $row){ ?>
	<li class="customer"><?php echo @$row['first_name']?></li>
	<?php }} ?>
</ul>
<script>
	$(document).ready(function(){
		$('.customer').click(function(){
			var data = $(this).html();
			$('#autocomplete').val(data);
			$('.customer_auto').hide();
		});
		$(document).on('click','body',function(){
			$('.customer_auto').hide();
		});
	});
</script>