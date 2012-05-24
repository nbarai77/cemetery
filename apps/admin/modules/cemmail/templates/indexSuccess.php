<?php 
    use_helper('pagination');
    $ssModuleName = $sf_params->get('module'); 
?>
<div id="wapper">    
    <?php include_partial('global/indicator');?>

    <div id="result"></div>
    <h1>
        <?php echo __('Cemetery Mail');?> 
        <span id="no_of_items"><?php include_partial('global/total_items',array('snTotalItems'=> $snPageTotalCemMails));?></span>
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
        echo input_hidden_tag('mail_type',$ssMailType, array('readonly' => true));
        echo input_hidden_tag('form_name',$ssFormName, array('readonly' => true));

        include_partial(
            'global/listing_top',
            array(
                'form_name'             => $ssFormName,
                'id_checkboxes'         => 'id[]',
                'inactivateIds'         => 'idmails',
                'update_div'            => 'success_msgs',
                'url'                   => $ssModuleName.'/index?request_type=ajax_request',
                'admin_act_status'      => 'status',
                'admin_act_module'      => 'delete',
				'inbox_url'				=> url_for($ssModuleName.'/index?mail_type=inbox'),
				'sent_url'				=> url_for($ssModuleName.'/index?mail_type=sent'),
				'trash_url'				=> url_for($ssModuleName.'/index?mail_type=trash'),
				'compose_url'			=> url_for($ssModuleName.'/sendMail'),
                'bStatusButton'         => 'false',
                'bChangeOrderButton'    => 'false',
            )
        );

        echo '<div>';
            echo '<div style="width:80%;float:left;">';    
                if($snPageTotalCemMails == 0): 
                    echo '<div class="warning-msg"><span>'.__('Record(s) not found').'</span></div>';
                else:
                    echo '<div  id="contentlisting" >';
                        include_partial(
                            'list_middle_part',
                            array(
                                'oCemMailsList'  	=> $oCemMailsList,
                                'amCemMailsList'  	=> $amCemMailsList,
                                'amExtraParameters' => $amExtraParameters,
                                'amSearch'          => $amSearch,
                                'ssModuleName'      => $ssModuleName,
                                'sortby'            => $amExtraParameters['ssSortBy'],
                                'sortmode'          => $amExtraParameters['ssSortMode'],
                                'inactivateIds'     => 'idmails',
								'ssMailType'		=> $ssMailType
                            )
                        );
                    echo '</div>';
                            
                    include_partial(
                        'global/listing_bottom',
                        array(
                            'amPagerSearchResults'  => $oCemMailsList, 
                            'amExtraParameters'     => $amExtraParameters
                        )
                    );
                endif;                            
            echo '</div>';
            echo '<div class="searchRightPart">';
                include_partial(
                    'global/search',
                    array(
                        'url'               => $ssModuleName.'/index?request_type=ajax_request',
                        'update_div'        => 'contentlisting',
                        'amSearchByArray'   => $amSearch,
                        'amExtraParameters' => $amExtraParameters,
                    )
                );
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
    if($snPageTotalCemMails > 0):
        echo javascript_tag('
            jQuery(document).ready(function() 
            {
                sortingdiv();
            });
            function sortingdiv()
            {
                showHideSortDiv("chkunchk2","selectopt2");
                showHideSortDiv("chkunchk3","selectopt3");  
            }');
    endif;

	echo javascript_tag('
	function showMailDetails(ssURL,ssUpdateId,ssMailType,ssShowMailId,snFromUserId)
	{
		'.jq_remote_function(
			array('url'		=> url_for($ssModuleName.'/showDetails?'.html_entity_decode($amExtraParameters['ssQuerystr'])),
				  'update'	=> 'contentlisting',
				  'with'	=> "'request_type=ajax_request&id='+ssShowMailId+'&cmu_id='+ssUpdateId+'&from_user_id='+snFromUserId",
				  'complete'=> '$("#indicatormedia").hide();')).'

		//window.location = ssURL;
	}
	');
?>
