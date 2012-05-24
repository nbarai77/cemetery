<?php
/**
 * PaginationHelper.
 *
 * @package    Cemetery
 * @subpackage helper
 * @author     Prakash Panchal
 *
 */
function pager_plugin_navigation($pager, $snPaging, $ssForm, $snPaggingDropDown, $IsPlugin)
{  
    if ($pager->getNbResults() > 0)
    {
		$snFirstOpt = ($snPaggingDropDown != '') ? $snPaggingDropDown : 2;
		$snSectionOpt = $snFirstOpt + 1;
		
        $ssNavigation = '';
        if ($pager->haveToPaginate())
        {  
            // Previous page
            if ($pager->getPage() != 1)
            {
                $ssNavigation .= '<li>'.link_to_function('<img src="/images/first.png" title="First" name="right"/>','setFirstPage('.$pager->getFirstPage().',\''.$ssForm.'\')', array('id' => 'first')).'</li>';            
                $ssNavigation .= '<li>'.link_to_function('<img src="/images/prev.png" title="Previous" name="right"/>','setPreviousPage(\''.$ssForm.'\')', array('id' => 'previous')).'</li>';
            }
            else
            {
                $ssNavigation .= '<li><img src="/images/first-disable.png" title="First" name="right"/></li>';				
                $ssNavigation .= '<li><img src="/images/prev-disable.png" title="Previous" name="right"/></li>';
            }
            
            $anPage = array(); 
            for($i=1;$i<=$pager->getLastPage();$i++)
            {
                $anPage[$i] = $i;
            }
			
			if(!$IsPlugin)
			{
				// showing current page
				$ssNavigation .= '<li class="">';
				$ssNavigation .= '<ul>';
				$ssNavigation .= '<li><input type="text" value="'.$pager->getPage().'" id="jump_to" name="jump_to" onkeydown="jumpTo(\''.$pager->getLastPage().'\',event,\''.$ssForm.'\');" style="height:20px;" size="5"/></li>';
				$ssNavigation .= '</ul>';
				$ssNavigation .= '</li>';
			}
            // Next page
            if ($pager->getPage() != $pager->getLastPage())
            {
                $ssNavigation .= '<li>'.link_to_function('<img src="/images/next.png" title="Next" name="right"/>','setNextPage(\''.$ssForm.'\')', array('id' => 'next')).'</li>';
                $ssNavigation .= '<li>'.link_to_function('<img src="/images/last.png" title="Last" name="right"/>','setLastPage('.$pager->getLastPage().',\''.$ssForm.'\')', array('id' => 'last')).'</li>';            
                echo input_hidden_tag('searchfilter','searchfilter');
            }
            else
            {
                $ssNavigation .= '<li>'.image_tag('next-disable.png',array('title'=>__('Next'))).'</li>';
                $ssNavigation .= '<li>'.image_tag('last-disable.png',array('title'=>__('Last'))).'</li>';            
            }
        } 
	
	    // showing record per page
	    $anRecordPerPage = sfConfig::get('app_record_per_page');
	    $ssNavigation .= '<li class="list1 '.(($pager->haveToPaginate()) ? "MLeft20" : "").'">';
	    $ssNavigation .= '<span style="padding:6px 15px 7px 10px">';
	    $ssNavigation .= '<span class="arrow" id="selectopt'.$snSectionOpt.'" style = "font-weight:normal; cursor:pointer;" title="'.$snPaging.'">'.$snPaging;
	    $ssNavigation .= '<div class="assanding1" style="display:block;">';
	    $ssDropDownClass = "inn_drupdown1";
	    $ssNavigation .= '<div class="'.$ssDropDownClass.'" id="chkunchk'.$snSectionOpt.'" style="display:none;">';
	    $ssNavigation .= '<ul>';
	    for($i=1;$i<=count($anRecordPerPage);$i++)
		    $ssNavigation .= '<li title="'.$anRecordPerPage[$i].'" onclick="recordPerPage(\''.$anRecordPerPage[$i].'\',\''.$ssForm.'\');">'.link_to_function($anRecordPerPage[$i], "", array('title' => $anRecordPerPage[$i])).'</li>';
	    $ssNavigation .= '</ul>';
		$ssNavigation .= '<div class="inn_drupdown1Bottom">';
        $ssNavigation .= '</div>';
	    $ssNavigation .= '</div>';
	    $ssNavigation .= '</div>';
	    $ssNavigation .= '</span>';
	    $ssNavigation .= '</span>';
	    $ssNavigation .= '</li>';         
	    $ssNavigation .= '<li><span class="RPP">'.__('records per page').'</span></li>';
	
        return $ssNavigation;
    }        
}
