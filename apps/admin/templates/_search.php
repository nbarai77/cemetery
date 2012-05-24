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
					case 'checkbox':	
        				echo '<span class="fleft">'.checkbox_tag('search'.$amSearch['id'], '1', false).'<span>';
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
                                                'url'      => $url,
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
