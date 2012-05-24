<div id="stonemason_cementery_list">
<?php echo select_tag('stonemason_cem_cemetery_id', options_for_select($asCementryList , isset($snCementeryId) ? $snCementeryId : '', 'include_custom='.__('--- Select Cementery ----')),
			array('tabindex'=>2,)
			); ?>
</div>
