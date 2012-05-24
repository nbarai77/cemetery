<?php 
    use_helper('pagination');
    $ssModuleName = $sf_params->get('module'); 
	use_javascript('nyroModal/jquery.nyroModal.custom.js');
	use_stylesheet('nyroModal/nyroModal');
?>
<div id="wapper">    
    <?php include_partial('global/indicator');?>

    <div id="result"></div>
    <h1>
        <?php echo __('Grave Owners');?> 
        <span id="no_of_items"><?php include_partial('global/total_items',array('snTotalItems'=> $snPageTotalGrantee));?></span>
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
		echo input_hidden_tag('grave_id',$snIdGrave, array('readonly' => true));    		
        echo input_hidden_tag('form_name',$ssFormName, array('readonly' => true));

		$ssBackUrl = ($sf_params->get('back2gsearch')) ? url_for('gravesearch/index?back2search=true&'.base64_decode($sf_params->get('back2gsearch')) ) : url_for('grave/index?back=true&'.html_entity_decode($amExtraParameters['ssQuerystr']));

        include_partial(
            'global/listing_top',
            array(
                'form_name'             => $ssFormName,
                'id_checkboxes'         => 'id[]',
                'inactivateIds'         => 'idgrantees',
                'update_div'            => 'success_msgs',
                'url'                   => url_for($ssModuleName.'/showGrantees?request_type=ajax_request'),
                'admin_act_status'      => 'status',
                'admin_act_module'      => 'delete',
				'back_url'				=> $ssBackUrl,
                'add_assign_grantee_url' => url_for($ssModuleName.'/purchaseGrave?id='.$snIdGrave),
				'add_new_grantee_url'   => url_for('granteedetails/addedit?grave_id='.$snIdGrave),
                'bStatusButton'         => 'false',
                'bChangeOrderButton'    => 'false',
            )
        );

        echo '<div>';
            echo '<div style="width:100%;float:left;">';    
                if($snPageTotalGrantee == 0): 
                    echo '<div class="warning-msg"><span>'.__('Record(s) not found').'</span></div>';
                else:
                    echo '<div  id="contentlisting" >';
                        include_partial(
                            'list_grantee_middle_part',
                            array(
                                'amGranteesList'  	=> $amGranteesList,
                                'amExtraParameters' => $amExtraParameters,
                                'amSearch'          => $amSearch,	                                                
                                'ssModuleName'      => $ssModuleName,
                                'sortby'            => $amExtraParameters['ssSortBy'],
                                'sortmode'          => $amExtraParameters['ssSortMode'],
                                'inactivateIds'     => 'idgrantees',
								'snIdGrave'			=> $snIdGrave
                            )
                        );
                    echo '</div>';
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

    if($snPageTotalGrantee > 0):
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
                showHideSortDiv("sort_div_plot_grave_number","field_div_plot_grave_number");
                showHideSortDiv("sort_div_area_name","field_div_area_name");
                showHideSortDiv("sort_div_section_name","field_div_section_name");
                showHideSortDiv("sort_div_row_name","field_div_row_name");				
                showHideSortDiv("sort_div_plot_name","field_div_plot_name");
                showHideSortDiv("sort_div_status","field_div_status");
                showHideSortDiv("chkunchk2","selectopt2");
                showHideSortDiv("chkunchk3","selectopt3");  
            }');
    endif;
?>
