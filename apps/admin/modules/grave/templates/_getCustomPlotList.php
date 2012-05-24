<div id="grave_custom_plot_list">
	<?php 
	echo select_tag('searchArPlotId', options_for_select($asPlotList , ($sf_user->getAttribute('gr_plot') != '') ? $sf_user->getAttribute('gr_plot') : '', 'include_custom='.__('Select Plot')),array('tabindex'=> 6)); 
	echo '<span id="IdAjaxLocaderPlot" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';	
	?>
</div>
