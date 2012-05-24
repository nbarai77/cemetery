<p><?php echo __('Please click on below link regarding letter attachment confirmation');?></p>
<p>
<?php 
	$ssUrl = sfConfig::get('app_static_site_url').'/letterconfimation/index?id='.$snBookingFiveId.'&content_type='.$ssContentType.'&token='.$ssToken;
	echo link_to($ssUrl,$ssUrl);?>
</p>
