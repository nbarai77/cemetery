<?php 
	if(sfContext::getInstance()->getUser()->getAttribute('issuperadmin') == 1):
		echo include_partial("global/menu_super_admin"); // Super admin  
	elseif(sfContext::getInstance()->getUser()->getAttribute('groupid') == 2):
		echo include_partial("global/menu_cem_manager"); // Cem manager  
	elseif(sfContext::getInstance()->getUser()->getAttribute('groupid') == 3):	
		echo include_partial("global/menu_cem_staff"); // cem staff  
	elseif(sfContext::getInstance()->getUser()->getAttribute('groupid') == 4):	
		echo include_partial("global/menu_cem_staff_admin"); // Cem staff admin  
	elseif(sfContext::getInstance()->getUser()->getAttribute('groupid') == 5):	
		echo include_partial("global/menu_cem_fnd"); // cem funeral director  
	elseif(sfContext::getInstance()->getUser()->getAttribute('groupid') == 6):	
		echo include_partial("global/menu_cem_stone"); // Super cem stone mason  
	endif; 
?>	

