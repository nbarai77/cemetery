<?php 
    use_helper('pagination');
    $ssModuleName = $sf_params->get('module'); 
?>
<div id="wapper">    
    <?php include_partial('global/indicator');?>

    <div id="result"></div>
    <h1>
        <?php echo __('Booking/Interment Log list');?> 
        <span id="no_of_items"><?php include_partial('global/total_items',array('snTotalItems'=> $snPageTotalBookingLogPages));?></span>
		<span style="color:#FF0000;"><?php echo __('Warning - Please note that logs automatically expire and are deleted automatically 30 days after login date');?></span>
    </h1>

    <div id="success_msgs">
        <?php echo include_partial('global/notification_msg', array('amSuccessMsg' => $amSuccessMsg,'amErrorMsg' => $amErrorMsg));?>
    </div>
    <?php
        echo jq_form_remote_tag(
                array(
                    'url'       => url_for($ssModuleName.'/bookingLog?request_type=ajax_request'),
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
		echo input_hidden_tag('logtype','booking', array('readonly' => true));

        include_partial(
            'global/listing_top',
            array(
                'form_name'             => $ssFormName,
                'id_checkboxes'         => 'id[]',
                'inactivateIds'         => 'idbookinglog',
                'update_div'            => 'success_msgs',
                'url'                   => url_for($ssModuleName.'/bookingLog?request_type=ajax_request'),
                'admin_act_status'      => 'status',
                'admin_act_module'      => 'delete',
                'bStatusButton'         => 'false',
                'bChangeOrderButton'    => 'false',
                'bDeleteButton'    		=> 'cemAdmin',
                'checkbox'    			=> 'true'
            )
        );

        echo '<div>';
            echo '<div style="width:80%;float:left;">';    

                    echo '<div  id="contentlisting" >';
                        include_partial(
                            'booking_log_list_middle_part',
                            array(
                                'oBookingLogList'   => $oBookingLogList,
                                'amBookingLogList'  => $amBookingLogList,
                                'amExtraParameters' => $amExtraParameters,
                                'amSearch'          => $amSearch,	                                                
                                'ssModuleName'      => $ssModuleName,
                                'sortby'            => $amExtraParameters['ssSortBy'],
                                'sortmode'          => $amExtraParameters['ssSortMode'],
                                'inactivateIds'     => 'idbookinglog',
                            )
                        );
                    echo '</div>';
                            
                    include_partial(
                        'global/listing_bottom',
                        array(
                            'amPagerSearchResults'  => $oBookingLogList, 
                            'amExtraParameters'     => $amExtraParameters
                        )
                    );
                                      
            echo '</div>';
            echo '<div class="searchRightPart">';
                include_partial(
                    'search',
                    array(
                        'url'               => url_for($ssModuleName.'/bookingLog?request_type=ajax_request'),
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
    if(!$sf_user->isSuperAdmin())
	{
		$snCemeteryId = $sf_user->getAttribute('cemeteryid');
		 echo javascript_tag("
			jQuery(document).ready(function() 
				{
					".
					// Ger area, section, row, plot list as per cemetery.
					jq_remote_function(array('url'	=> url_for('gravelog/getStaffListAsPerCemetery'),
										  'update'	=> 'gravelog_users_list',
										  'with'	=> "'&logtype='+$('#logtype').val()+'&cemetery_id='+".$snCemeteryId,
										  'loading' => '$("#IdAjaxLocaderStaff").show();',
										  'complete'=> '$("#IdAjaxLocaderStaff").hide();'))
					."
				});
			");
	}
	//$ssImageName = url_for('images/jquery/calendar.gif').'/calendar.gif';		// LIVE
	$ssImageName = sfConfig::get('app_cal_image_path');							// LATEST
	
	echo javascript_tag('
		jQuery(document).ready(function() 
		{
			sortingdiv();
			var params = {
				changeMonth : true,
				changeYear : true,
				numberOfMonths : 1,
				dateFormat: "dd-mm-yy",
				showButtonPanel : true,
				showOn: "button",
				buttonImage: "'.$ssImageName.'",
				buttonImageOnly: true,
				showSecond: false,
			 };
			$("#searchOperationDate").datepicker(params);                
			
		});
		function sortingdiv()
		{
			showHideSortDiv("sort_div_name","field_div_name");
			showHideSortDiv("sort_div_status","field_div_status");
			showHideSortDiv("chkunchk2","selectopt2");
			showHideSortDiv("chkunchk3","selectopt3");  
		}
		function savePDF()
		{
			var ssURL = " '.url_for('gravelog/saveLogIntoPDF').' ";
			ssURL = ssURL+"?logtype=bookinglog&cemetery_id="+jQuery("#searchCemId").val()+"&user_id="+jQuery("#searchUserId").val()+"&operation_date="+jQuery("#searchOperationDate").val();
			window.location.href = ssURL+"&cemetery_id="+jQuery("#searchCemId").val()+"&user_id="+jQuery("#searchUserId").val()+"&operation_date="+jQuery("#searchOperationDate").val();
		}
		');

?>
