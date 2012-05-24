<div id="user_cementery_list">
<?php echo select_tag('user_award_id', options_for_select($asAwards , isset($snCementeryId) ? $snCementeryId : '', 'include_custom='.__('Select Award')),
			array('tabindex'=>9)
			); ?>
</div>