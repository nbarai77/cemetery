<?php 

    use_helper('pagination');
    $ssModuleName = $sf_params->get('module'); 
?>
<div id="wapper">    
    <?php include_partial('global/indicator');?>

    <div id="result"></div>
    <h1>
        <?php echo __('Annual Care Results');?> 
        <span id="no_of_items"><?php include_partial('global/total_items',array('snTotalItems'=> $snPageTotalAnnualSearchPages));?></span>
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
		
		echo input_hidden_tag('country_id',$ssSearchCountryId);
        echo input_hidden_tag('annualsearch_cem_cemetery_id',$ssSearchCemCemeteryId);
        echo input_hidden_tag('annualsearch_ar_area_id',$ssSearchArAreaId);
        echo input_hidden_tag('annualsearch_ar_section_id',$ssSearchArSectionId);
        echo input_hidden_tag('annualsearch_ar_row_id',$ssSearchArRowId);
        echo input_hidden_tag('annualsearch_ar_plot_id',$ssSearchArPlotId);
        echo input_hidden_tag('annualsearch_ar_grave_id',$ssSearchArGraveId);

        echo input_hidden_tag('annualsearch_first_name',$ssAnnualSearchFirstName);        
        echo input_hidden_tag('annualsearch_surname',$ssAnnualSearchSurname);        
        echo input_hidden_tag('annualsearch_renewal_date',$ssAnnualSearchRenewalDate);        
		  
        echo input_hidden_tag('form_name',$ssFormName, array('readonly' => true));
        
        include_partial(
            'global/listing_top',
            array(
                'form_name'             => $ssFormName,
                'id_checkboxes'         => 'id[]',
                'inactivateIds'         => 'idannualsearch',
                'update_div'            => 'success_msgs',
                'url'                   => $ssModuleName.'/index?request_type=ajax_request',
                'admin_act_status'      => 'status',
                'admin_act_module'      => 'delete',
                'bStatusButton'         => 'false',
                'bChangeOrderButton'    => 'false',
                'back_url'				=> $ssModuleName.'/report?back=true',
                'bDeleteButton'    => 'cemAdmin',
                'checkbox'    => 'true',
            )
        );


        echo '<div>';
            echo '<div style="width:100%;float:left;">';    
                if($snPageTotalAnnualSearchPages == 0): 
                    echo '<div class="warning-msg"><span>'.__('Record(s) not found').'</span></div>';
                else:
                    echo '<div  id="contentlisting" >';
                        include_partial(
                            'list_middle_part',
                            array(
                                'oAnnualSearchList'  	=> $oAnnualSearchList,
                                'amAnnualSearchList'  	=> $amAnnualSearchList,
                                'amExtraParameters' => $amExtraParameters,
                                'amSearch'          => $amSearch,	                                                
                                'ssModuleName'      => $ssModuleName,
                                'sortby'            => $amExtraParameters['ssSortBy'],
                                'sortmode'          => $amExtraParameters['ssSortMode'],
                                'inactivateIds'     => 'idannualsearch',
                            )
                        );
                    echo '</div>';
                            
                    include_partial(
                        'global/listing_bottom',
                        array(
                            'amPagerSearchResults'  => $oAnnualSearchList, 
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
    if($snPageTotalAnnualSearchPages > 0):
        echo javascript_tag('
            jQuery(document).ready(function() 
            {
                sortingdiv();
            });
            function sortingdiv()
            {
                showHideSortDiv("sort_div_first_name","field_div_first_name");
                showHideSortDiv("sort_div_surname","field_div_surname");
                showHideSortDiv("chkunchk2","selectopt2");
                showHideSortDiv("chkunchk3","selectopt3");  
            }');
    endif;
?>
