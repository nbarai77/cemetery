<?php 

    use_helper('pagination');
    $ssModuleName = $sf_params->get('module'); 
?>
<div id="wapper">    
    <?php include_partial('global/indicator');?>

    <div id="result"></div>
    <h1>
        <?php echo __('Grave Results');?> 
        <span id="no_of_items"><?php include_partial('global/total_items',array('snTotalItems'=> $snPageTotalArGravePages));?></span>
    </h1>
			

    <div id="success_msgs">
        <?php echo include_partial('global/notification_msg', array('amSuccessMsg' => $amSuccessMsg,'amErrorMsg' => $amErrorMsg));?>
    </div>
    <?php
        echo jq_form_remote_tag(
                array(
                    'url'       => $ssModuleName.'/index?request_type=ajax_request',
                    'update'    => 'contentlisting',
                    'script'    => true,
                    'loading'   => jq_visual_effect('fadeIn','#indicator1'),
                    'complete'  => jq_visual_effect('fadeOut','#indicator1').";sortingdiv();",
                ),
                array('name' => $ssFormName, 'id' => $ssFormName)
            );

        echo input_hidden_tag('page',$snPage, array('readonly' => true));
        echo input_hidden_tag('paging',$snPaging, array('readonly' => true));
        
        
        echo input_hidden_tag('grave_number',$ssSearchName);
        echo input_hidden_tag('country_id',$ssSearchCountryId);
        echo input_hidden_tag('grave_cem_cemetery_id',$ssSearchCemCemeteryId);
        echo input_hidden_tag('grave_ar_area_id',$ssSearchArAreaId);
        echo input_hidden_tag('grave_ar_section_id',$ssSearchArSectionId);
        echo input_hidden_tag('grave_ar_row_id',$ssSearchArRowId);
        echo input_hidden_tag('grave_ar_plot_id',$ssSearchArPlotId);
		echo input_hidden_tag('ar_grave_status_id',$ssSearchArGraveStatusId);
        
        echo input_hidden_tag('form_name',$ssFormName, array('readonly' => true));
        
        include_partial(
            'global/listing_top',
            array(
                'form_name'             => $ssFormName,
                'id_checkboxes'         => 'id[]',
                'inactivateIds'         => 'idgrave',
                'update_div'            => 'success_msgs',
                'url'                   => $ssModuleName.'/index?request_type=ajax_request',
                'admin_act_status'      => 'status',
                'admin_act_module'      => 'delete',
                //'add_new_url'           => $ssModuleName.'/addedit',
                'bStatusButton'         => 'false',
                'bChangeOrderButton'    => 'false',
                'back_url'				=> 'gravesearch/addedit?back=true',
                'bDeleteButton'    => 'cemAdmin',
                'checkbox'    => 'true',
            )
        );


        echo '<div>';
            echo '<div style="width:100%;float:left;">';    
                if($snPageTotalArGravePages == 0): 
                    echo '<div class="warning-msg"><span>'.__('Record(s) not found').'</span></div>';
                else:
                    echo '<div  id="contentlisting" >';
                        include_partial(
                            'list_middle_part',
                            array(
                                'oArGraveList'  	=> $oArGraveList,
                                'amArGraveList'  	=> $amArGraveList,
                                'amExtraParameters' => $amExtraParameters,
                                'amSearch'          => $amSearch,	                                                
                                'ssModuleName'      => $ssModuleName,
                                'sortby'            => $amExtraParameters['ssSortBy'],
                                'sortmode'          => $amExtraParameters['ssSortMode'],
                                'inactivateIds'     => 'idgrave',
                            )
                        );
                    echo '</div>';
                       

                            
                    include_partial(
                        'global/listing_bottom',
                        array(
                            'amPagerSearchResults'  => $oArGraveList, 
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
    if($snPageTotalArGravePages > 0):
        echo javascript_tag('
            jQuery(document).ready(function() 
            {
                sortingdiv();
            });
            function sortingdiv()
            {
                showHideSortDiv("sort_div_grave_number","field_div_grave_number");
                showHideSortDiv("sort_div_status","field_div_status");
                showHideSortDiv("chkunchk2","selectopt2");
                showHideSortDiv("chkunchk3","selectopt3");  
            }');
    endif;
?>
