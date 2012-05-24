<?php 
    use_helper('pagination');
    $ssModuleName = $sf_params->get('module'); 
?>
<div id="wapper">    
    <?php include_partial('global/indicator');?>

    <div id="result"></div>
    <h1>
        <?php 
			$ssCompany = $sf_params->get('company','');
			$ssCompany = ($ssCompany != '') ? ' '.__('for').' "'.$ssCompany.'"' : '';
			echo __('List of documents').$ssCompany;
		?> 
        <span id="no_of_items"><?php include_partial('global/total_items',array('snTotalItems'=> $snPageTotalStonemasonDocsPages));?></span>
    </h1>

    <div id="success_msgs">
        <?php echo include_partial('global/notification_msg', array('amSuccessMsg' => $amSuccessMsg,'amErrorMsg' => $amErrorMsg));?>
    </div>
    <?php
        echo jq_form_remote_tag(
                array(
                    'url'       => $ssModuleName.'/listDocuments?request_type=ajax_request',
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

		$ssBackURL = $sf_params->get('id_stonemason') ? $ssModuleName.'/index' : 'user/welcome';
		
if($sf_user->getAttribute('groupid') == 6):

        include_partial(
            'global/listing_top',
            array(
                'form_name'             => $ssFormName,
                'id_checkboxes'         => 'id[]',
                'inactivateIds'         => 'idstonemasondocs',
                'update_div'            => 'success_msgs',
                'url'                   => $ssModuleName.'/listDocuments?request_type=ajax_request',
                'admin_act_status'      => 'status',
                'admin_act_module'      => 'delete',
                'add_new_url'           => $ssModuleName.'/upload',
                'bStatusButton'         => 'false',
                'bChangeOrderButton'    => 'false',
				'back_url'				=> $ssBackURL,
            )
        );
else:

        include_partial(
            'global/listing_top',
            array(
                'form_name'             => $ssFormName,
                'id_checkboxes'         => 'id[]',
                'inactivateIds'         => 'idstonemasondocs',
                'update_div'            => 'success_msgs',
                'url'                   => $ssModuleName.'/listDocuments?request_type=ajax_request',
                'admin_act_status'      => 'status',
                'admin_act_module'      => 'delete',
                'bStatusButton'         => 'false',
                'bChangeOrderButton'    => 'false',
				'back_url'				=> $ssBackURL,
				'bDeleteButton'         => 'cemAdmin',
				'checkbox'              => 'true', 				
            )
        );

endif;                
        

        echo '<div>';
            echo '<div style="width:100%;float:left;">';    
                if($snPageTotalStonemasonDocsPages == 0): 
                    echo '<div class="warning-msg"><span>'.__('Record(s) not found').'</span></div>';
                else:
                    echo '<div  id="contentlisting" >';
                        include_partial(
                            'list_docs_middle_part',
                            array(
                                'oStonemasonDocsList'  	=> $oStonemasonDocsList,
                                'amStonemasonDocsList'  	=> $amStonemasonDocsList,
                                'amExtraParameters' => $amExtraParameters,
                                'amSearch'          => $amSearch,	                                                
                                'ssModuleName'      => $ssModuleName,
                                'sortby'            => $amExtraParameters['ssSortBy'],
                                'sortmode'          => $amExtraParameters['ssSortMode'],
                                'inactivateIds'     => 'idstonemasondocs',
								'snStoneMasonId'	=> $snStoneMasonId
                            )
                        );
                    echo '</div>';
                            
                    include_partial(
                        'global/listing_bottom',
                        array(
                            'amPagerSearchResults'  => $oStonemasonDocsList, 
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
    if($snPageTotalStonemasonDocsPages > 0):
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
                showHideSortDiv("sort_div_doc_name","field_div_doc_name");
                showHideSortDiv("chkunchk2","selectopt2");
                showHideSortDiv("chkunchk3","selectopt3");  
            }');
    endif;
?>
