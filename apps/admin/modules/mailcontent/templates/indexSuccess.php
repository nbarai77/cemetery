<?php 
    use_helper('pagination');
    $ssModuleName = $sf_params->get('module'); 
?>
<div id="wapper">    
    <?php include_partial('global/indicator');?>

	<div id="result"></div>
	<?php if($sf_params->get('type') == 'common_letter'):?>
	<h1>
        <?php echo __('Daily Services');?> 
        <span id="no_of_items"><?php include_partial('global/total_items',array('snTotalItems'=> $snPageTotalMailContentPages));?></span>
    </h1>
	<?php else: ?>
    <h1>
        <?php echo __('Mail Content list');?> 
        <span id="no_of_items"><?php include_partial('global/total_items',array('snTotalItems'=> $snPageTotalMailContentPages));?></span>
    </h1>
 	<?php endif;?>
    <div id="success_msgs">
        <?php echo include_partial('global/notification_msg', array('amSuccessMsg' => $amSuccessMsg,'amErrorMsg' => $amErrorMsg));?>
    </div>
    <?php echo jq_form_remote_tag(
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
        echo input_hidden_tag('form_name',$ssFormName, array('readonly' => true));
        echo input_hidden_tag('type',$ssType, array('readonly' => true));
			
		if($sf_user->isSuperAdmin()):
			include_partial(
				'global/listing_top',
				array(
					'form_name'             => $ssFormName,
					'id_checkboxes'         => 'id[]',
					'inactivateIds'         => 'idcountry',
					'update_div'            => 'success_msgs',
					'url'                   => url_for($ssModuleName.'/index?request_type=ajax_request'),
					'admin_act_status'      => 'status',
					'admin_act_module'      => 'delete',
					'bStatusButton'         => 'false',
					'bChangeOrderButton'    => 'false',
					'bDeleteButton'    		=> 'cemAdmin',
					'checkbox'    			=> 'true',
					'back_url'				=> url_for($ssModuleName.'/customCemetery?back=true&type='.$ssType),
					'asCustomButton'		=> array('name' => __('Show list of static { } variables'), 'url' => url_for($ssModuleName.'/listStaticVariables?'.html_entity_decode($amExtraParameters['ssQuerystr']) ))
				)
			);
		else:			
			include_partial(
				'global/listing_top',
				array(
					'form_name'             => $ssFormName,
					'id_checkboxes'         => 'id[]',
					'inactivateIds'         => 'idcountry',
					'update_div'            => 'success_msgs',
					'url'                   => url_for($ssModuleName.'/index?request_type=ajax_request'),
					'admin_act_status'      => 'status',
					'admin_act_module'      => 'delete',
					'bStatusButton'         => 'false',
					'bChangeOrderButton'    => 'false',
					'bDeleteButton'    		=> 'cemAdmin',
					'checkbox'    			=> 'true',
					'asCustomButton'		=> array('name' => __('Show list of static { } variables'), 'url' => url_for($ssModuleName.'/listStaticVariables?'.html_entity_decode($amExtraParameters['ssQuerystr']) ))
				)
			);			
		endif;
		
        echo '<div>';
            echo '<div style="width:100%;float:left;">';    
                if($snPageTotalMailContentPages == 0): 
                    echo '<div class="warning-msg"><span>'.__('Record(s) not found').'</span></div>';
                else:
                    echo '<div  id="contentlisting" >';
                        include_partial(
                            'list_middle_part',
                            array(
                                'oMailContentList'   => $oMailContentList,
                                'amMailContentList'  => $amMailContentList,
                                'amExtraParameters' => $amExtraParameters,
                                'amSearch'          => $amSearch,	                                                
                                'ssModuleName'      => $ssModuleName,
                                'sortby'            => $amExtraParameters['ssSortBy'],
                                'sortmode'          => $amExtraParameters['ssSortMode'],
                                'inactivateIds'     => 'idcountry',
                            )
                        );
                    echo '</div>';
                            
                    include_partial(
                        'global/listing_bottom',
                        array(
                            'amPagerSearchResults'  => $oMailContentList, 
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
			jQuery(function() {         
					jQuery(".nyroModal").nyroModal();     
			});
		});
		function sortingdiv()
		{
			showHideSortDiv("sort_div_subject","field_div_subject");
			showHideSortDiv("chkunchk2","selectopt2");
			showHideSortDiv("chkunchk3","selectopt3");  
		};
		
		function letterAction(ssUrl)
		{
			ssUrl = ssUrl;
			window.open(ssUrl,"sendletterwindow","width=1200,height=1000,scrollbars=yes");
		}
		
		
		');
?>
