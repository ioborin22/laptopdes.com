	<?php if(get_option('business_ads-6')!=""){?>
	<div class="ads-6">
	<?php if (get_option('business_ads-6') <> "") { 
		echo stripslashes(stripslashes(get_option('business_ads-6'))); 
} ?>
	</div>
	<?php }?>