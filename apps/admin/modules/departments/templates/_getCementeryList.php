<div id="cementery_list">
<?php echo select_tag('department_cem_cemetery_id', options_for_select($asCementryList , isset($snCementeryId) ? $snCementeryId : '', 'include_custom='.__('Select Cementery')),array('tabindex'=>2)); ?>
</div>
