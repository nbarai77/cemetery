<?php  
if($pager_search_result) 
{
	if(isset($IsPlugin) && $IsPlugin)
	{
		echo pager_plugin_navigation($pager_search_result, $snPaging, (isset($ssForm)) ? $ssForm : '', (isset($snPaggingDropDown)) ? $snPaggingDropDown : '', (isset($IsPlugin)) ? $IsPlugin : false); 
	}
	else
	{
		echo pager_navigation($pager_search_result, $snPaging, (isset($ssForm)) ? $ssForm : '', (isset($snPaggingDropDown)) ? $snPaggingDropDown : '', (isset($IsPlugin)) ? $IsPlugin : false); 
	}
}
?>
