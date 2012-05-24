<div id="upd_chapel_type_div">
	<div class="fleft ChapelTime">
		<?php echo __('Select Chapel');?>
	</div>
	<div class="fleft pad_10">
	<?php 
		echo select_tag('chapel_grouplist', options_for_select($amChapelUnAssociated, array_keys( $sf_data->getRaw('amChapelAssociated') ) ), 'multiple=multiple',array('tabindex' => 18))
	?>
	</div>
</div>