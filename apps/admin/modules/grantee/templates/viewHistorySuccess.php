<?php 
    use_helper('pagination');
    $ssModuleName = $sf_params->get('module'); 
?>
<div id="wapper">    
    <?php include_partial('global/indicator');?>

    <div id="result"></div>
    <h1>
        <?php echo __('Grave History');?> 
        <span id="no_of_items"><?php include_partial('global/total_items',array('snTotalItems'=> $snPageTotalGranteeGraveHistoryPages));?></span>
    </h1>

    <div id="success_msgs">
        <?php echo include_partial('global/notification_msg', array('amSuccessMsg' => $amSuccessMsg,'amErrorMsg' => $amErrorMsg));?>
    </div>
    <?php
        echo jq_form_remote_tag(
                array(
                    'url'       => $ssModuleName.'/viewHistory?request_type=ajax_request',
                    'update'    => 'contentlisting',
                    'script'    => true,
                    'loading'   => jq_visual_effect('fadeIn','#indicator1'),
                    'complete'  => jq_visual_effect('fadeOut','#indicator1').";sortingdiv();",
                ),
                array('name' => $ssFormName, 'id' => $ssFormName)
            );

        echo input_hidden_tag('page',$snPage, array('readonly' => true));
        echo input_hidden_tag('paging',$snPaging, array('readonly' => true));    
        echo input_hidden_tag('form_name',$ssFormName, array('readonly' => true));
	
		$ssBackURL = ($sf_params->get('back') == 'grave') ? 'grave/index?'.html_entity_decode($amExtraParameters['ssQuerystr']) : $ssModuleName.'/index?grantee_id='.$snGranteeId.'&'.html_entity_decode($amExtraParameters['ssQuerystr']); 

        include_partial(
            'global/listing_top',
            array(
                'form_name'             => $ssFormName,
                'id_checkboxes'         => 'id[]',
                'inactivateIds'         => 'idsurrendergrave',
                'update_div'            => 'success_msgs',
                'url'                   => $ssModuleName.'/viewHistory?request_type=ajax_request',
                'admin_act_status'      => 'status',
                'admin_act_module'      => 'delete',
                'bStatusButton'         => 'false',
                'bChangeOrderButton'    => 'false',
				'back_url'				=> url_for($ssBackURL),
            )
        );

        echo '<div>';
            echo '<div style="width:100%;float:left;">';    
                if($snPageTotalGranteeGraveHistoryPages == 0): 
                    echo '<div class="warning-msg"><span>'.__('Record(s) not found').'</span></div>';
                else:
                    echo '<div  id="contentlisting" >';
                        include_partial(
                            'history_list_middle_part',
                            array(
                                'oGranteeGraveHistoryList'  	=> $oGranteeGraveHistoryList,
                                'amGranteeGraveHistoryList'  	=> $amGranteeGraveHistoryList,
                                'amExtraParameters' => $amExtraParameters,
                                'amSearch'          => $amSearch,	                                                
                                'ssModuleName'      => $ssModuleName,
                                'sortby'            => $amExtraParameters['ssSortBy'],
                                'sortmode'          => $amExtraParameters['ssSortMode'],
                                'inactivateIds'     => 'idsurrendergrave',
								'snIdGrave'			=> $snIdGrave,
								'snGranteeId'		=> $snGranteeId
                            )
                        );
                    echo '</div>';
                            
                    include_partial(
                        'global/listing_bottom',
                        array(
                            'amPagerSearchResults'  => $oGranteeGraveHistoryList, 
                            'amExtraParameters'     => $amExtraParameters
                        )
                    );
                endif;                            
            echo '</div>';
            echo '<div class="clearb">&nbsp;</div>';
        echo '</div>';    	
    ?>
    <div class="clearb">&nbsp;</div>
    <div class="clearb">&nbsp;</div>
    </form>
</div>
<!--Sorting for selected field-->
<?php 
    if($snPageTotalGranteeGraveHistoryPages > 0):
        echo javascript_tag('
            jQuery(document).ready(function() 
            {
                sortingdiv();
			 	jQuery(function() {         
					jQuery(".nyroModal").nyroModal();     
				});
            });
            function sortingdiv()
            {
                showHideSortDiv("sort_div_old_grantee_first_name","field_div_old_grantee_first_name");
                showHideSortDiv("sort_div_new_grantee_first_name","field_div_new_grantee_first_name");
                showHideSortDiv("sort_div_grave_number","field_div_grave_number");
                showHideSortDiv("sort_div_surrender_date","field_div_surrender_date");
                showHideSortDiv("chkunchk2","selectopt2");
                showHideSortDiv("chkunchk3","selectopt3");  
            }');
    endif;
?>
