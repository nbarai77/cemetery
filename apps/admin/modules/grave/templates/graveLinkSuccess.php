<?php 
    use_helper('pagination');
    $ssModuleName = $sf_params->get('module'); 
?>
<div id="wapper">    
    <?php include_partial('global/indicator');?>

    <div id="result"></div>
    <h1>
        <?php echo __('Linked Grave list');?> 
        <span id="no_of_items"><?php include_partial('global/total_items',array('snTotalItems'=> $snPageTotalGraveLinkPages));?></span>
    </h1>

    <div id="success_msgs">
        <?php echo include_partial('global/notification_msg', array('amSuccessMsg' => $amSuccessMsg,'amErrorMsg' => $amErrorMsg));?>
    </div>
    <?php
        echo jq_form_remote_tag(
                array(
                    'url'       => $ssModuleName.'/graveLink?request_type=ajax_request',
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

        $ssBackURL = $ssModuleName.'/index?'.html_entity_decode($amExtraParameters['ssQuerystr']); 
        
        include_partial(
            'global/listing_top',
            array(
                'form_name'             => $ssFormName,
                'id_checkboxes'         => 'id[]',
                'inactivateIds'         => 'idlinkgrave',
                'update_div'            => 'success_msgs',
                'url'                   => $ssModuleName.'/graveLink?request_type=ajax_request',
                'admin_act_status'      => 'status',
                'admin_act_module'      => 'delete',
                'add_new_url'           => url_for($ssModuleName.'/addEditGraveLink?'.html_entity_decode($amExtraParameters['ssQuerystr'])),
                'bStatusButton'         => 'false',
                'bChangeOrderButton'    => 'false',
                'back_url'				=> url_for($ssBackURL),
            )
        );

        echo '<div>';
            echo '<div style="width:100%;float:left;">';    
                if($snPageTotalGraveLinkPages == 0): 
                    echo '<div class="warning-msg"><span>'.__('Record(s) not found').'</span></div>';
                else:
                    echo '<div  id="contentlisting" >';
                        include_partial(
                            'list_grave_link_middle_part',
                            array(
                                'oArGraveList'  	=> $oGraveLinkList,
                                'amArGraveList'  	=> $amGraveLinkList,
                                'amExtraParameters' => $amExtraParameters,
                                'ssModuleName'      => $ssModuleName,
                                'sortby'            => $amExtraParameters['ssSortBy'],
                                'sortmode'          => $amExtraParameters['ssSortMode'],
                                'inactivateIds'     => 'idlinkgrave',
                            )
                        );
                    echo '</div>';
                            
                    include_partial(
                        'global/listing_bottom',
                        array(
                            'amPagerSearchResults'  => $oGraveLinkList, 
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

	echo javascript_tag('
		jQuery(document).ready(function() 
		{
			sortingdiv();
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
?>
