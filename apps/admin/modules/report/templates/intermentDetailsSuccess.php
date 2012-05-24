<?php 
    use_helper('pagination');
    $ssModuleName = $sf_params->get('module'); 
?>
<div id="wapper">    
    <?php include_partial('global/indicator');?>

    <div id="result"></div>
    <h1>
        <?php echo __('Interments Details as per Report');?> 
        <span id="no_of_items"><?php include_partial('global/total_items',array('snTotalItems'=> $snPageTotalIntermentDetailsPages));?></span>
    </h1>

    <div id="success_msgs">
        <?php echo include_partial('global/notification_msg', array('amSuccessMsg' => $amSuccessMsg,'amErrorMsg' => $amErrorMsg));?>
    </div>
    <?php
        echo jq_form_remote_tag(
                array(
                    'url'       => $ssModuleName.'/intermentDetails?request_type=ajax_request',
                    'update'    => 'contentlisting',
                    'script'    => true,
                    'loading'   => jq_visual_effect('fadeIn','#indicator1'),
                    'complete'  => jq_visual_effect('fadeOut','#indicator1').";sortingdiv();",
                ),
                array('name' => $ssFormName, 'id' => $ssFormName)
            );

        echo input_hidden_tag('page',$snPage, array('readonly' => true));
        echo input_hidden_tag('paging',$snPaging, array('readonly' => true));
        echo input_hidden_tag('ssRequestIds',$ssRequestIds, array('readonly' => true));
        echo input_hidden_tag('ssSearchFor',$ssSearchFor, array('readonly' => true));
        echo input_hidden_tag('form_name',$ssFormName, array('readonly' => true));

        include_partial(
            'global/listing_top',
            array(
                'form_name'             => $ssFormName,
                'id_checkboxes'         => 'id[]',
                'inactivateIds'         => 'idinterment',
                'update_div'            => 'success_msgs',
                'url'                   => $ssModuleName.'/intermentDetails?request_type=ajax_request',
                'admin_act_status'      => 'status',
                'admin_act_module'      => 'delete',
                'bStatusButton'         => 'false',
                'bChangeOrderButton'    => 'false',
				'bDeleteButton'			=> 'cemAdmin',
				'checkbox'				=> 'true',
				'back_url'				=> url_for($ssModuleName.'/index?back=true'),
            )
        );

        echo '<div>';
            echo '<div style="width:100%;float:left;">';    
                if($snPageTotalIntermentDetailsPages == 0): 
                    echo '<div class="warning-msg"><span>'.__('Record(s) not found').'</span></div>';
                else:
                    echo '<div  id="contentlisting" >';
                        include_partial(
                            'list_intermentdetails_middle_part',
                            array(
                                'oIntermentDetailsList'  	=> $oIntermentDetailsList,
                                'amIntermentDetailsList'  	=> $amIntermentDetailsList,
                                'amExtraParameters' => $amExtraParameters,
                                'amSearch'          => $amSearch,              
                                'ssModuleName'      => $ssModuleName,
                                'sortby'            => $amExtraParameters['ssSortBy'],
                                'sortmode'          => $amExtraParameters['ssSortMode'],
                                'inactivateIds'     => 'idinterment',
                            )
                        );
                    echo '</div>';

                    include_partial(
                        'global/listing_bottom',
                        array(
                            'amPagerSearchResults'  => $oIntermentDetailsList, 
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
    if($snPageTotalIntermentDetailsPages > 0):
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
                showHideSortDiv("sort_div_deceased_first_name","field_div_deceased_first_name");
                showHideSortDiv("sort_div_deceased_surname","field_div_deceased_surname");
                showHideSortDiv("sort_div_service_type_name","field_div_service_type_name");
                showHideSortDiv("sort_div_interment_date","field_div_interment_date");				
                showHideSortDiv("sort_div_service_booking_date","field_div_service_booking_date");
                showHideSortDiv("sort_div_service_booking_time_from","field_div_service_booking_time_from");
                showHideSortDiv("sort_div_service_booking_time_to","field_div_service_booking_time_to");
                showHideSortDiv("sort_div_consultant","field_div_consultant");
                showHideSortDiv("sort_div_taken_by_name","field_div_taken_by_name");
                showHideSortDiv("sort_div_control_number","field_div_control_number");
                showHideSortDiv("chkunchk2","selectopt2");
                showHideSortDiv("chkunchk3","selectopt3");  
            }');
    endif;
?>
