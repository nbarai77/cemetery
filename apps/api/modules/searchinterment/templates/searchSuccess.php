<?php 
    use_helper('pagination','JavascriptBase','jQuery','Form');
    $ssModuleName = $sf_params->get('module'); 
?>
<div id="wapper1">    
    <div id="result"></div>
    <h1>
        <?php echo __('Interment Info');?> 
        <span id="no_of_items"><?php include_partial('global/total_items',array('snTotalItems'=> $snPageTotalSearchInterment));?></span>
    </h1>

    <?php
        echo jq_form_remote_tag(
                array(
                    'url'       => $ssModuleName.'/search?request_type=ajax_request',
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
                'inactivateIds'         => 'idarea',
                'update_div'            => 'success_msgs',
                'url'                   => $ssModuleName.'/search?request_type=ajax_request',
                'admin_act_module'      => 'delete',
                'bStatusButton'         => 'false',
                'bChangeOrderButton'    => 'false',
				'bDeleteButton'			=> 'cemAdmin'
            )
        );

        echo '<div>';
            echo '<div style="width:50%;float:left;">';    
                if($snPageTotalSearchInterment == 0): 
                    echo '<div class="warning-msg"><span>'.__('Record(s) not found').'</span></div>';
                else:
                    echo '<div id="contentlisting" >';
                        include_partial(
                            'list_middle_part',
                            array(
                                'oSearchIntermentList'  => $oSearchIntermentList,
                                'amSearchIntermentList' => $amSearchIntermentList,
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
                            'amPagerSearchResults'  => $oSearchIntermentList, 
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
<?php
	echo javascript_tag('	
		function showHideDiv(snId, ssType)
		{
			if(ssType == "show")
				$("#moreDetails_"+snId).show();
			else
				$("#moreDetails_"+snId).hide();
			
		}
	');
?>