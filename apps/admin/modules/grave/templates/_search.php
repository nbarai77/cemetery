
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
						echo select_tag('search'.$amSearch['id'], options_for_select($amSearch['options'], ($sf_user->getAttribute('gr_gstatus') != '') ? $sf_user->getAttribute('gr_gstatus') : ''),array('onkeydown'=>'triggerSerach(event);','class'=>'select'));
						break;
					case 'selectcountry':
						echo select_tag('search'.$amSearch['id'], options_for_select($amSearch['options'], ($sf_user->getAttribute('gr_country') != '') ? $sf_user->getAttribute('gr_country') : '', 'include_custom='.__('Select Country')),array('onkeydown'=>'triggerSerach(event);','onChange' => "callAjaxRequest(this.value,'".url_for('grave/getCustomCementryListAsPerCountry')."','grave_custom_cemetery_list');", 'class'=>'select'));
						break;
					case 'selectajax':
						include_partial($amSearch['ssPartial'], array($amSearch['ssArrayKey'] => $amSearch['options'], $amSearch['ssArrayValue'] => $amExtraParameters['ssSearch'.$amSearch['id']]));
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
                                                'url'      => url_for($url.'&reset=true'),
                                                "before"   => "showAll(".json_encode(explode('-',str_replace(' ','',ucwords(str_replace('_', ' ',implode('- ',array_keys($sf_data->getRaw('amSearchByArray')))))))).")",
                                                'loading'  => jq_visual_effect('fadeIn','#indicator1'),
                                                'complete' => jq_visual_effect('fadeOut','#indicator1').";sortingdiv();",
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
					array('url'		=> url_for('grave/getCustomAreaListAsPerCemetery'),
						  'update'	=> 'grave_custom_area_list',
						  'with'	=> "'cemetery_id='+".$snCemeteryId."+'&country_id='+".$snCountryId." ",
						  'loading' => '$("#IdAjaxLocaderArea").show();',
						  'complete'=> '$("#IdAjaxLocaderArea").hide();'.jq_remote_function(
									array('url'		=> url_for('grave/getCustomSectionListAsPerArea'),
										  'update'	=> 'grave_custom_section_list',
										  'with'	=> "'country_id='+".$snCountryId."+'&cemetery_id='+".$snCemeteryId."",
										  'loading' => '$("#IdAjaxLocaderSection").show();',
										  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
													array('url'		=> url_for('grave/getCustomRowListAsPerSection'),
														  'update'	=> 'grave_custom_row_list',
														  'with'	=> "'country_id='+".$snCountryId."+'&cemetery_id='+".$snCemeteryId."",
														  'loading' => '$("#IdAjaxLocaderRow").show();',
														  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
																		array('url'		=> url_for('grave/getCustomPlotListAsPerRow'),
																			  'update'	=> 'grave_custom_plot_list',
																			  'with'	=> "'country_id='+".$snCountryId."+'&cemetery_id='+".$snCemeteryId."",
																			  'loading' => '$("#IdAjaxLocaderPlot").show();',
																			  'complete'=> '$("#IdAjaxLocaderPlot").hide();'))
													))
									))
					))	
					."
				});
			");
	}

if(!$sf_params->get('flag')):
	if($sf_user->getAttribute('gr_country') != '' && $sf_user->isSuperAdmin()): 
		echo javascript_tag(
				jq_remote_function(array(
					'update'  => 'grave_custom_cemetery_list',
					'url'     => url_for('grave/getCustomCementryListAsPerCountry?id='.$sf_user->getAttribute('gr_country').'&cemetery_id='.$sf_user->getAttribute('gr_cemetery')),
					'loading' => '$("#IdAjaxLocaderCemetery").show();',
  					'complete'=> '$("#IdAjaxLocaderCemetery").hide();'
				))); 
	endif; 
	
	if($sf_user->getAttribute('gr_cemetery') != ''):
		echo javascript_tag(
			jq_remote_function(array(
				'update'  => 'grave_custom_area_list',
				'url'     => url_for('grave/getCustomAreaListAsPerCemetery?country_id='.$sf_user->getAttribute('gr_country').'&cemetery_id='.$sf_user->getAttribute('gr_cemetery').'&area_id='.$sf_user->getAttribute('gr_area')),
				'loading' => '$("#IdAjaxLocaderArea").show();',
				'complete'=> '$("#IdAjaxLocaderArea").hide();'
			)));
		if($sf_user->getAttribute('gr_area') == ''):
			 echo javascript_tag(
			  jq_remote_function(array(
				'update'  => 'grave_custom_section_list',
				'url'     => url_for('grave/getCustomSectionListAsPerArea?country_id='.$sf_user->getAttribute('gr_country').'&cemetery_id='.$sf_user->getAttribute('gr_cemetery').'&section_id='.$sf_user->getAttribute('gr_section')),
				'loading' => '$("#IdAjaxLocaderSection").show();',
				'complete'=> '$("#IdAjaxLocaderSection").hide();'
			  ))); 		
		endif; 
		if($sf_user->getAttribute('gr_section') == '' && $sf_user->getAttribute('gr_area') == ''): 
			echo javascript_tag(
				jq_remote_function(array(
					'update'  => 'grave_custom_row_list',
					'url'     => url_for('grave/getCustomRowListAsPerSection?country_id='.$sf_user->getAttribute('gr_country').'&cemetery_id='.$sf_user->getAttribute('gr_cemetery').'&row_id='.$sf_user->getAttribute('gr_row')),
					'loading' => '$("#IdAjaxLocaderRow").show();',
  					'complete'=> '$("#IdAjaxLocaderRow").hide();'
				))); 
		endif;
		if($sf_user->getAttribute('gr_row') == '' && $sf_user->getAttribute('gr_section') == '' && $sf_user->getAttribute('gr_area') == ''): 
		 echo javascript_tag(
			jq_remote_function(array(
				'update'  => 'grave_custom_plot_list',
				'url'     => url_for('grave/getCustomPlotListAsPerRow?country_id='.$sf_user->getAttribute('gr_country').'&cemetery_id='.$sf_user->getAttribute('gr_cemetery').'&plot_id='.$sf_user->getAttribute('gr_plot')),
				'loading' => '$("#IdAjaxLocaderPlot").show();',
				'complete'=> '$("#IdAjaxLocaderPlot").hide();'
			))); 
		 endif;	 	
	endif; 
	
	if($sf_user->getAttribute('gr_area') != ''): 
		 echo javascript_tag(
		  jq_remote_function(array(
			'update'  => 'grave_custom_section_list',
			'url'     => url_for('grave/getCustomSectionListAsPerArea?country_id='.$sf_user->getAttribute('gr_country').'&cemetery_id='.$sf_user->getAttribute('gr_cemetery').'&area_id='.$sf_user->getAttribute('gr_area').'&section_id='.$sf_user->getAttribute('gr_section')),
			'loading' => '$("#IdAjaxLocaderSection").show();',
			'complete'=> '$("#IdAjaxLocaderSection").hide();'
		  ))); 
	
		 if($sf_user->getAttribute('gr_section') == ''): 
			 echo javascript_tag(				
			  jq_remote_function(array(
				'update'  => 'grave_custom_row_list',
				'url'     => url_for('grave/getCustomRowListAsPerSection?country_id='.$sf_user->getAttribute('gr_country').'&cemetery_id='.$sf_user->getAttribute('gr_cemetery').'&area_id='.$sf_user->getAttribute('gr_area').'&row_id='.$sf_user->getAttribute('gr_row')),
				'loading' => '$("#IdAjaxLocaderRow").show();',
				'complete'=> '$("#IdAjaxLocaderRow").hide();'
			  ))); 
		 endif; 
	
		 if($sf_user->getAttribute('gr_row') == '' && $sf_user->getAttribute('gr_section') == ''): 
			 echo javascript_tag(
			  jq_remote_function(array(
				'update'  => 'grave_custom_plot_list',
				'url'     => url_for('grave/getCustomPlotListAsPerRow?country_id='.$sf_user->getAttribute('gr_country').'&cemetery_id='.$sf_user->getAttribute('gr_cemetery').'&area_id='.$sf_user->getAttribute('gr_area').'&plot_id='.$sf_user->getAttribute('gr_plot')),
				'loading' => '$("#IdAjaxLocaderPlot").show();',
				'complete'=> '$("#IdAjaxLocaderPlot").hide();'
			  ))); 
		 endif;  
	 endif; 
	
	if($sf_user->getAttribute('gr_section') != ''): 
		 echo javascript_tag(
		  jq_remote_function(array(
			'update'  => 'grave_custom_row_list',
			'url'     => url_for('grave/getCustomRowListAsPerSection?country_id='.$sf_user->getAttribute('gr_country').'&cemetery_id='.$sf_user->getAttribute('gr_cemetery').'&area_id='.$sf_user->getAttribute('gr_area').'&section_id='.$sf_user->getAttribute('gr_section').'&row_id='.$sf_user->getAttribute('gr_row')),
			'loading' => '$("#IdAjaxLocaderRow").show();',
			'complete'=> '$("#IdAjaxLocaderRow").hide();'
		  ))); 
		  
		 if($sf_user->getAttribute('gr_row') == ''): 
		 echo javascript_tag(
		  jq_remote_function(array(
			'update'  => 'grave_custom_plot_list',
			'url'     => url_for('grave/getCustomPlotListAsPerRow?country_id='.$sf_user->getAttribute('gr_country').'&cemetery_id='.$sf_user->getAttribute('gr_cemetery').'&area_id='.$sf_user->getAttribute('gr_area').'&section_id='.$sf_user->getAttribute('gr_section').'&plot_id='.$sf_user->getAttribute('gr_plot')),
			'loading' => '$("#IdAjaxLocaderPlot").show();',
			'complete'=> '$("#IdAjaxLocaderPlot").hide();'
		  ))); 
		 endif;  
	 endif; 
	
	 if($sf_user->getAttribute('gr_row') != ''): 
	 echo javascript_tag(
	  jq_remote_function(array(
		'update'  => 'grave_custom_plot_list',
		'url'     => url_for('grave/getCustomPlotListAsPerRow?country_id='.$sf_user->getAttribute('gr_country').'&cemetery_id='.$sf_user->getAttribute('gr_cemetery').'&area_id='.$sf_user->getAttribute('gr_area').'&section_id='.$sf_user->getAttribute('gr_section').'&row_id='.$sf_user->getAttribute('gr_row').'&plot_id='.$sf_user->getAttribute('gr_plot')),
		'loading' => '$("#IdAjaxLocaderPlot").show();',
		'complete'=> '$("#IdAjaxLocaderPlot").hide();'
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
?>
