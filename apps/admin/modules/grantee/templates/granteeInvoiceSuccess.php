<?php 
    use_helper('pagination');
    $ssModuleName = $sf_params->get('module'); 

?>
<div id="wapper">    
    <?php include_partial('global/indicator');?>

    <div id="result"></div>
    <h1>
        <?php         
        echo __('Grave Purchase Invoice list');
        ?> 
        <span id="no_of_items"><?php include_partial('global/total_items',array('snTotalItems'=> $snPageTotalGranteePages));?></span>
    </h1>

    <div id="success_msgs">
        <?php echo include_partial('global/notification_msg', array('amSuccessMsg' => $amSuccessMsg,'amErrorMsg' => $amErrorMsg));?>
    </div>
    <?php
    echo '<div id="main">';
            echo '<div style="width:100%;float:left;">';
                include_partial('export_datewise',array('oGravePlotReportForm' => $oGravePlotReportForm,'ssFromDate'=>(isset($ssFromDate)?$ssFromDate:''),'ssToDate'=>(isset($ssToDate)?$ssToDate:'')));
    echo '</div></div>';
    
    echo jq_form_remote_tag(
                array(
                    'url'       => $ssModuleName.'/granteeInvoice?request_type=ajax_request',
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
        
        include_partial(
            'global/listing_top',
            array(
                'form_name'             => $ssFormName,
                'id_checkboxes'         => 'id[]',
				'checkbox'              => 'true',
                'inactivateIds'         => 'idgrantee',
                'update_div'            => 'success_msgs',
                'url'                   => $ssModuleName.'/index?request_type=ajax_request',
                'admin_act_status'      => 'status',
                'admin_act_module'      => 'delete',
                'bStatusButton'         => 'false',
                'bDeleteButton'         => 'cemAdmin',
                'bChangeOrderButton'    => 'false',
				//'back_url'				=> url_for('granteedetails/index?'.html_entity_decode($amExtraParameters['ssQuerystr']))
            )
        );

        echo '<div>';
            echo '<div style="width:100%;float:left;">';    
                if($snPageTotalGranteePages == 0): 
                    echo '<div class="warning-msg"><span>'.__('Record(s) not found').'</span></div>';
                else:
                    echo '<div  id="contentlisting" >';
                        include_partial(
                            'list_middle_part_invoice',
                            array(
                                'oGranteeList'  	=> $oGranteeList,
                                'amGranteeList'  	=> $amGranteeList,
                                'amExtraParameters' => $amExtraParameters,
                                'amSearch'          => $amSearch,	                                                
                                'ssModuleName'      => $ssModuleName,
                                'sortby'            => $amExtraParameters['ssSortBy'],
                                'sortmode'          => $amExtraParameters['ssSortMode'],
                                'inactivateIds'     => 'idgrantee',
								'snCementeryId'		=> $snCementeryId
                            )
                        );
                    echo '</div>';
                            
                    include_partial(
                        'global/listing_bottom',
                        array(
                            'amPagerSearchResults'  => $oGranteeList, 
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
    if($snPageTotalGranteePages > 0):
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
                showHideSortDiv("sort_div_date_of_purchase","field_div_date_of_purchase");
				showHideSortDiv("sort_div_tenure_expiry_date","field_div_tenure_expiry_date");
                showHideSortDiv("sort_div_grantee_first_name","field_div_grantee_first_name");
                showHideSortDiv("sort_div_grave_number","field_div_grave_number");
                showHideSortDiv("sort_div_grantee_surname","field_div_grantee_surname");
                showHideSortDiv("chkunchk2","selectopt2");
                showHideSortDiv("chkunchk3","selectopt3");  
            }');
    endif;
?>
