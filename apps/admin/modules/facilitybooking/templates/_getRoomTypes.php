<div id="upd_room_type_div">
	<div class="fleft ChapelTime">
		<?php echo __('Select Rooms');?>
	</div>
	<div class="fleft pad_10">
	<?php 
		echo select_tag('room_grouplist', options_for_select($amRoomUnAssociated, array_keys( $sf_data->getRaw('amRoomAssociated') ) ), 'multiple=multiple',array('tabindex' => 18))
	?>
	</div>
</div>