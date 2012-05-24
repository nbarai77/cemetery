<?php use_helper('JavascriptBase', 'jQuery', 'Text');?> 

<div class="main_search">
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
    	<tr>
        	<th><label><?php echo __('Filter')?></label></th>
        </tr>
        <tr><td></td></tr>
        <?php
        	foreach($amSearchByArray as $ssKey => $amSearch):
        		echo '<tr>';
        		echo '<td><label>'.$amSearch['caption'].'</label></td>';
        		echo '</tr>';
    			echo '<tr>';
    			echo '<td>';
    			switch($amSearch['type'])
    			{
    				case 'text':	
        				echo input_tag('search'.$amSearch['id'],trim($amExtraParameters['ssSearch'.$amSearch['id']]),array('onkeydown'=>'triggerSerach(event);','class'=>'text'));
                    break;
					case 'select':
						echo select_tag('search'.$amSearch['id'], options_for_select($amSearch['options'], $amExtraParameters['ssSearch'.$amSearch['id']]),array('onkeydown'=>'triggerSerach(event);','class'=>'select'));
						break;
					case 'date':	
        				echo input_tag('search'.$amSearch['id'],trim($amExtraParameters['ssSearch'.$amSearch['id']]),array('onkeydown'=>'triggerSerach(event);','class'=>'date'));
	                    break;
					case 'selectcountry':
						echo select_tag('search'.$amSearch['id'], options_for_select($amSearch['options'], isset($amExtraParameters['ssSearch'.$amSearch['id']]) ? $amExtraParameters['ssSearch'.$amSearch['id']] : sfConfig::get('app_default_country_id'), 'include_custom='.__('Select Country')),array('onkeydown'=>'triggerSerach(event);','onChange' => "callAjaxRequest(this.value,'".url_for('gravelog/getCustomCementryListAsPerCountry')."','gravelog_cemetery_list');", 'class'=>'select'));
						break;
					case 'selectajax':
						include_partial('gravelog/'.$amSearch['ssPartial'], array($amSearch['ssArrayKey'] => $amSearch['options'], $amSearch['ssArrayValue'] => $amExtraParameters['ssSearch'.$amSearch['id']]));
						break;
    			}
    			echo '</td>';
        		echo '</tr>';
        	endforeach; 
        ?>
    	<tr>
        	<td>
            	<div class="actions zindex_up">
                	<ul class="fleft">
                    	<li class="list1">
                        	<span>
								<?php
                                    // Go button
                                    echo jq_submit_to_remote(
                                            'bGo', 
                                            __('Filter'), 
                                            array(
                                                'update'   => $update_div,
                                                'url'      => $url,
                                                "before"   => 'jQuery("#page").val("1");',
                                                'loading'  => jq_visual_effect('fadeIn','#indicator1'),
                                                'complete' => jq_visual_effect('fadeOut','#indicator1').";sortingdiv();",
                                            ),
                                            array('title'=>__('Filter'),'class'=>'button', 'id' => 'bGo')
                                        );
                                ?>
                        	</span>
                        </li>
                        <li class="list1">
                        	<span>
                                <?php
                                    // Show all button
                                    $asSearchValues = array_keys($sf_data->getRaw('amSearchByArray'));
                                    echo jq_submit_to_remote(
                                            'bShowAll',
                                            __('Reset'), 
                                            array(
                                                'update'   => $update_div,
                                                'url'      => url_for($url),
                                                "before"   => "showAll(".json_encode(explode('-',str_replace(' ','',ucwords(str_replace('_', ' ',implode('- ',array_keys($sf_data->getRaw('amSearchByArray')))))))).")",
                                                'loading'  => jq_visual_effect('fadeIn','#indicator1'),
                                                'complete' => jq_visual_effect('fadeOut','#indicator1').";",
                                            ),
                                            array('title'=>__('Reset'),'class'=>'button', 'id' => 'bShowAll')
                                        ); 
                                ?>
                            </span>
                       </li>
                   </ul>
                </div>
            </td>
        </tr>
    </table>
</div>
<?php 
	if(!$sf_user->isSuperAdmin() && !$sf_params->get('back') && $sf_params->get('flag'))
	{
		 echo javascript_tag("
			jQuery(document).ready(function() 
				{
					".
					// Ger area, section, row, plot list as per cemetery.
					jq_remote_function(
					array('url'		=> url_for('granteesearch/getCustomAreaListAsPerCemetery'),
						  'update'	=> 'grantee_custom_area_list',
						  'with'	=> "'cemetery_id='+".$snCemeteryId."+'&country_id='+".$snCountryId." ",
						  'loading' => '$("#IdAjaxLocaderArea").show();',
						  'complete'=> '$("#IdAjaxLocaderArea").hide();'.jq_remote_function(
									array('url'		=> url_for('granteesearch/getCustomSectionListAsPerArea'),
										  'update'	=> 'grantee_custom_section_list',
										  'with'	=> "'country_id='+".$snCountryId."+'&cemetery_id='+$('#searchCemCemeteryId').val()",
										  'loading' => '$("#IdAjaxLocaderSection").show();',
										  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
													array('url'		=> url_for('granteesearch/getCustomRowListAsPerSection'),
														  'update'	=> 'grantee_custom_row_list',
														  'with'	=> "'country_id='+".$snCountryId."+'&cemetery_id='+$('#searchCemCemeteryId').val()",
														  'loading' => '$("#IdAjaxLocaderRow").show();',
														  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
																		array('url'		=> url_for('granteesearch/getCustomPlotListAsPerRow'),
																			  'update'	=> 'grantee_custom_plot_list',
																			  'with'	=> "'country_id='+".$snCountryId."+'&cemetery_id='+$('#searchCemCemeteryId').val()",
																			  'loading' => '$("#IdAjaxLocaderPlot").show();',
																			  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
																							array('url'	=> url_for('granteesearch/getCustomGraveListAsPerPlot'),
																								  'update'	=> 'grantee_custom_grave_list',
																								  'with'	=> "'country_id='+".$snCemeteryId."+'&cemetery_id='+".$snCemeteryId."",
																								  'loading' => '$("#IdAjaxLocaderGrave").show();',
																								  'complete'=> '$("#IdAjaxLocaderGrave").hide();'))
																				))
													))
									))
					))	
					."
				});
			");
	}

if(!$sf_params->get('flag')):
	if($sf_user->getAttribute('gt_country') != '' && $sf_user->isSuperAdmin()):
		echo javascript_tag(
		  jq_remote_function(array(
			'update'  => 'grantee_custom_cemetery_list ',
			'url'     => url_for('granteesearch/getCustomCementryListAsPerCountry?id='.$sf_user->getAttribute('gt_country').'&cnval='.$sf_user->getAttribute('gt_cemetery')),
			'loading' => '$("#IdAjaxLocaderCemetery").show();',
			'complete'=> '$("#IdAjaxLocaderCemetery").hide();'
		  )));
	endif;
	
	if($sf_user->getAttribute('gt_cemetery') != ''):
		echo javascript_tag(
			jq_remote_function(array(
				'update'  => 'grantee_custom_area_list',
				'url'     => url_for('granteesearch/getCustomAreaListAsPerCemetery?country_id='.$sf_user->getAttribute('gt_country').'&cemetery_id='.$sf_user->getAttribute('gt_cemetery').'&arval='.$sf_user->getAttribute('gt_area')),
				'loading' => '$("#IdAjaxLocaderArea").show();',
				'complete'=> '$("#IdAjaxLocaderArea").hide();'
			)));
		if($sf_user->getAttribute('gt_area') == ''):
			 echo javascript_tag(
			  jq_remote_function(array(
				'update'  => 'grantee_custom_section_list',
				'url'     => url_for('granteesearch/getCustomSectionListAsPerArea?country_id='.$sf_user->getAttribute('gt_country').'&cemetery_id='.$sf_user->getAttribute('gt_cemetery').'&secval='.$sf_user->getAttribute('gt_section')),
				'loading' => '$("#IdAjaxLocaderSection").show();',
				'complete'=> '$("#IdAjaxLocaderSection").hide();'
			  ))); 		
		endif; 
		if($sf_user->getAttribute('gt_section') == '' && $sf_user->getAttribute('gt_area') == ''): 
			echo javascript_tag(
				jq_remote_function(array(
					'update'  => 'grantee_custom_row_list',
					'url'     => url_for('granteesearch/getCustomRowListAsPerSection?country_id='.$sf_user->getAttribute('gt_country').'&cemetery_id='.$sf_user->getAttribute('gt_cemetery').'&rwval='.$sf_user->getAttribute('gt_row')),
					'loading' => '$("#IdAjaxLocaderRow").show();',
					'complete'=> '$("#IdAjaxLocaderRow").hide();'
				))); 
		endif;
		if($sf_user->getAttribute('gt_row') == '' && $sf_user->getAttribute('gt_section') == '' && $sf_user->getAttribute('gt_area') == ''): 
		 echo javascript_tag(
			jq_remote_function(array(
				'update'  => 'grantee_custom_plot_list',
				'url'     => url_for('granteesearch/getCustomPlotListAsPerRow?country_id='.$sf_user->getAttribute('gt_country').'&cemetery_id='.$sf_user->getAttribute('gt_cemetery').'&plval='.$sf_user->getAttribute('gt_plot')),
				'loading' => '$("#IdAjaxLocaderPlot").show();',
				'complete'=> '$("#IdAjaxLocaderPlot").hide();'
			))); 
		 endif;	
		if($sf_user->getAttribute('gt_plot') == '' && $sf_user->getAttribute('gt_row') == '' && $sf_user->getAttribute('gt_section') == '' && $sf_user->getAttribute('gt_area') == ''):
			echo javascript_tag(
			  jq_remote_function(array(
				'update'  => 'grantee_custom_grave_list',
				'url'     => url_for('granteesearch/getCustomGraveListAsPerPlot?country_id='.$sf_user->getAttribute('gt_country').'&cemetery_id='.$sf_user->getAttribute('gt_cemetery').'&gnval='.$sf_user->getAttribute('gt_grave')),
				'loading' => '$("#IdAjaxLocaderGrave").show();',
				'complete'=> '$("#IdAjaxLocaderGrave").hide();'
			  )));
		endif;	  	
	endif; 
	
	if($sf_user->getAttribute('gt_area') != ''): 
		 echo javascript_tag(
		  jq_remote_function(array(
			'update'  => 'grantee_custom_section_list',
			'url'     => url_for('granteesearch/getCustomSectionListAsPerArea?country_id='.$sf_user->getAttribute('gt_country').'&cemetery_id='.$sf_user->getAttribute('gt_cemetery').'&area_id='.$sf_user->getAttribute('gt_area').'&secval='.$sf_user->getAttribute('gt_section')),
			'loading' => '$("#IdAjaxLocaderSection").show();',
			'complete'=> '$("#IdAjaxLocaderSection").hide();'
		  ))); 
	
		 if($sf_user->getAttribute('gt_section') == ''): 
		 echo javascript_tag(
			
		  jq_remote_function(array(
			'update'  => 'grantee_custom_row_list',
			'url'     => url_for('granteesearch/getCustomRowListAsPerSection?country_id='.$sf_user->getAttribute('gt_country').'&cemetery_id='.$sf_user->getAttribute('gt_cemetery').'&area_id='.$sf_user->getAttribute('gt_area').'&rwval='.$sf_user->getAttribute('gt_row')),
			'loading' => '$("#IdAjaxLocaderRow").show();',
			'complete'=> '$("#IdAjaxLocaderRow").hide();'
		  ))); 
		 endif; 
	
		 if($sf_user->getAttribute('gt_row') == '' && $sf_user->getAttribute('gt_section') == ''): 
		 echo javascript_tag(
		  jq_remote_function(array(
			'update'  => 'grantee_custom_plot_list',
			'url'     => url_for('granteesearch/getCustomPlotListAsPerRow?country_id='.$sf_user->getAttribute('gt_country').'&cemetery_id='.$sf_user->getAttribute('gt_cemetery').'&area_id='.$sf_user->getAttribute('gt_area').'&plval='.$sf_user->getAttribute('gt_plot')),
			'loading' => '$("#IdAjaxLocaderPlot").show();',
			'complete'=> '$("#IdAjaxLocaderPlot").hide();'
		  ))); 
		 endif;  
		if($sf_user->getAttribute('gt_row') == '' && $sf_user->getAttribute('gt_section') == '' && $sf_user->getAttribute('gt_plot') == ''):
		echo javascript_tag(
		  jq_remote_function(array(
			'update'  => 'grantee_custom_grave_list',
			'url'     => url_for('granteesearch/getCustomGraveListAsPerPlot?country_id='.$sf_user->getAttribute('gt_country').'&cemetery_id='.$sf_user->getAttribute('gt_cemetery').'&area_id='.$sf_user->getAttribute('gt_area').'&gnval='.$sf_user->getAttribute('gt_grave')),
			'loading' => '$("#IdAjaxLocaderGrave").show();',
			'complete'=> '$("#IdAjaxLocaderGrave").hide();'
		  )));
		endif;	 
	 endif; 
	
	
	 if($sf_user->getAttribute('gt_section') != ''): 
		 echo javascript_tag(
		  jq_remote_function(array(
			'update'  => 'grantee_custom_row_list',
			'url'     => url_for('granteesearch/getCustomRowListAsPerSection?country_id='.$sf_user->getAttribute('gt_country').'&cemetery_id='.$sf_user->getAttribute('gt_cemetery').'&area_id='.$sf_user->getAttribute('gt_area').'&section_id='.$sf_user->getAttribute('gt_section').'&rwval='.$sf_user->getAttribute('gt_row')),
			'loading' => '$("#IdAjaxLocaderRow").show();',
			'complete'=> '$("#IdAjaxLocaderRow").hide();'
		  ))); 
		  
		 if($sf_user->getAttribute('gt_row') == ''): 
		 echo javascript_tag(
		  jq_remote_function(array(
			'update'  => 'grantee_custom_plot_list',
			'url'     => url_for('granteesearch/getCustomPlotListAsPerRow?country_id='.$sf_user->getAttribute('gt_country').'&cemetery_id='.$sf_user->getAttribute('gt_cemetery').'&area_id='.$sf_user->getAttribute('gt_area').'&section_id='.$sf_user->getAttribute('gt_section').'&plval='.$sf_user->getAttribute('gt_plot')),
			'loading' => '$("#IdAjaxLocaderPlot").show();',
			'complete'=> '$("#IdAjaxLocaderPlot").hide();'
		  ))); 
		 endif;
		if($sf_user->getAttribute('gt_row') == '' && $sf_user->getAttribute('gt_plot') == ''):
		echo javascript_tag(
		  jq_remote_function(array(
			'update'  => 'grantee_custom_grave_list',
			'url'     => url_for('granteesearch/getCustomGraveListAsPerPlot?country_id='.$sf_user->getAttribute('gt_country').'&cemetery_id='.$sf_user->getAttribute('gt_cemetery').'&area_id='.$sf_user->getAttribute('gt_area').'&section_id='.$sf_user->getAttribute('gt_section').'&gnval='.$sf_user->getAttribute('gt_grave')),
			'loading' => '$("#IdAjaxLocaderGrave").show();',
			'complete'=> '$("#IdAjaxLocaderGrave").hide();'
		  )));
		endif;	 
		   
	 endif; 
	
	 if($sf_user->getAttribute('gt_row') != ''): 
		 echo javascript_tag(
		  jq_remote_function(array(
			'update'  => 'grantee_custom_plot_list',
			'url'     => url_for('granteesearch/getCustomPlotListAsPerRow?country_id='.$sf_user->getAttribute('gt_country').'&cemetery_id='.$sf_user->getAttribute('gt_cemetery').'&area_id='.$sf_user->getAttribute('gt_area').'&section_id='.$sf_user->getAttribute('gt_section').'&row_id='.$sf_user->getAttribute('gt_row').'&plval='.$sf_user->getAttribute('gt_plot')),
			'loading' => '$("#IdAjaxLocaderPlot").show();',
			'complete'=> '$("#IdAjaxLocaderPlot").hide();'
		  )));
		if($sf_user->getAttribute('gt_plot') == ''):
		echo javascript_tag(
		  jq_remote_function(array(
			'update'  => 'grantee_custom_grave_list',
			'url'     => url_for('granteesearch/getCustomGraveListAsPerPlot?country_id='.$sf_user->getAttribute('gt_country').'&cemetery_id='.$sf_user->getAttribute('gt_cemetery').'&area_id='.$sf_user->getAttribute('gt_area').'&section_id='.$sf_user->getAttribute('gt_section').'&row_id='.$sf_user->getAttribute('gt_row').'&gnval='.$sf_user->getAttribute('gt_grave')),
			'loading' => '$("#IdAjaxLocaderGrave").show();',
			'complete'=> '$("#IdAjaxLocaderGrave").hide();'
		  )));
		endif;   
	 endif;
	
	if($sf_user->getAttribute('gt_plot') != ''):
	echo javascript_tag(
	  jq_remote_function(array(
		'update'  => 'grantee_custom_grave_list',
		'url'     => url_for('granteesearch/getCustomGraveListAsPerPlot?country_id='.$sf_user->getAttribute('gt_country').'&cemetery_id='.$sf_user->getAttribute('gt_cemetery').'&area_id='.$sf_user->getAttribute('gt_area').'&section_id='.$sf_user->getAttribute('gt_section').'&row_id='.$sf_user->getAttribute('gt_row').'&plot_id='.$sf_user->getAttribute('gt_plot').'&gnval='.$sf_user->getAttribute('gt_grave')),
		'loading' => '$("#IdAjaxLocaderGrave").show();',
		'complete'=> '$("#IdAjaxLocaderGrave").hide();'
	  )));
	endif;

endif;

    $ssFocusField = str_replace(' ', '', ucwords(str_replace('_', ' ', $asSearchValues[0])));
    echo javascript_tag('jQuery("#search'.$ssFocusField.'").focus();');
    echo javascript_tag('
        function triggerSerach(e)
        {
            if(e.keyCode == 13)
            {
                jQuery("#bGo").click();
            }
        }
    ');  

echo javascript_tag("
	jQuery(document).ready(function() 
	{
		var snCountryId = jQuery('#searchCountryId').val();
		var snCemeteryId = $('#searchCemId option').length;

		if(snCountryId > 0 && snCemeteryId == 1)
			callAjaxRequest(snCountryId,'".url_for('gravelog/getCustomCementryListAsPerCountry')."','gravelog_cemetery_list');
	});
");
?>
