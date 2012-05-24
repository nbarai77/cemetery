<?php 
	echo select_tag('langauge_culture', options_for_select($oGuardGroupPageListQuery , isset($culture) ? $culture : ''),
			array('onChange' => jq_remote_function(
								array('url'		=> '/language/changelanguage',
									  'with'	=> "'culture='+this.value",
									  'complete' => "window.location.reload()"
									  
			))
	 )); 
?>

