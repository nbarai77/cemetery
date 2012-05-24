<?php use_javascript('/sfFormExtraPlugin/js/double_list.js');
    use_helper('pagination');
    $ssModuleName = $sf_params->get('module'); 
?>
<div id="wapper">  
	<?php 
		echo $oSummaryForm->renderFormTag(
			url_for($sf_params->get('module').'/'.'index'.(!$oSummaryForm->getObject()->isNew() ? '?id='.$oSummaryForm->getObject()->getId().'&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '')), 
			array("name" => $oSummaryForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
		);
	include_partial('global/indicator');?>
    <div id="result"></div>
	<table width="100%" border="0" cellspacing="5" cellpadding="5">
		<tr>
			<td valign="middle" align="left" width="6%">
				<?php echo $oSummaryForm['service_date']->renderLabel($oSummaryForm['service_date']->renderLabelName());?> : 
			</td>				
			<td valign="middle" width="4%">
				<?php 
					if($oSummaryForm['service_date']->hasError()):
						echo $oSummaryForm['service_date']->renderError();
					endif;
					echo $oSummaryForm['service_date']->render(); 
				?>
			</td>
			<td valign="middle" width="37%">
				<div class="actions">
					<ul class="fleft">
						<li class="list1">
							<span>
								<?php 
									echo submit_tag(
										__('Show'), 
										array(
											'class'     => 'delete',
											'name'      => 'submit_button',
											'title'     => __('Show'), 
											'tabindex'  => 2,
											'onclick'   => "jQuery('#tab').val('');"
										)
									);
								?>
							</span>
						</li>
						<li class="list1">
							<span>
								<?php  
								    $ssCancelUrl    = $sf_params->get('module').'/index?'.html_entity_decode($amExtraParameters['ssQuerystr']);
									echo button_to(__('Reset'),$ssCancelUrl,array('class'=>'delete','title'=>__('Reset'),'alt'=>__('Cancel'),'tabindex'=>1));
								?>
							</span>
						</li>
					</ul>
				</div>
			</td>
		</tr>
	</table>
	</form>
	<!------------------------------- Burials Listing Part ---------------------------------->
    <?php
        echo jq_form_remote_tag(
                array(
                    'url'       => $ssModuleName.'/index?request_type=ajax_request_burials',
                    'update'    => 'buriallisting',
                    'script'    => true,
                    'loading'   => jq_visual_effect('fadeIn','#indicator1'),
                    'complete'  => jq_visual_effect('fadeOut','#indicator1').";sortingdiv1();",
                ),
                array('method' => 'post', 'name' => 'frm_list_burials', 'id' => 'frm_list_burials')
            );
		echo input_hidden_tag('page',$snPage, array('readonly' => true));
		echo input_hidden_tag('paging',$snPaging, array('readonly' => true));
        echo input_hidden_tag('form_name','frm_list_burials', array('readonly' => true));
		echo input_hidden_tag('service_type',1, array('readonly' => true));
        echo input_hidden_tag('service_date',$ssServiceDate, array('readonly' => true));

        echo '<div>';
            echo '<div style="width:100%;float:left;">';    
				echo '<div  id="buriallisting" >';
					include_partial(
						'burials_list_middle_part',
						array(
							'oBurialSummaryList'  	=> $oBurialSummaryList,
							'amBurialSummaryList'  	=> $amBurialSummaryList,
							'amExtraParameters' => $amExtraParameters,
							'amSearch'          => $amSearch,	                                                
							'ssModuleName'      => $ssModuleName,
							'sortby'            => $amExtraParameters['ssSortBy'],
							'sortmode'          => $amExtraParameters['ssSortMode'],
							'inactivateIds'     => 'idservicebooking',
							'snPageTotalBurialRecords' => $snPageTotalBurialRecords
						)
					);
				echo '</div>';
						
				include_partial(
					'global/listing_bottom',
					array(
						'amPagerSearchResults'  => $oBurialSummaryList, 
						'amExtraParameters'     => $amExtraParameters,
						'ssForm'				=> 'frm_list_burials'
					)
				);
            echo '</div>';            
            echo '<div class="clearb">&nbsp;</div>';
        echo '</div>';    	
    ?>
    </form>
	<!------------------------------- Ashes Listing Part ---------------------------------->
	<?php
        echo jq_form_remote_tag(
                array(
                    'url'       => $ssModuleName.'/index?request_type=ajax_request_ashes',
                    'update'    => 'asheslisting',
                    'script'    => true,
                    'loading'   => jq_visual_effect('fadeIn','#indicator1'),
                    'complete'  => jq_visual_effect('fadeOut','#indicator1').";sortingdiv2();",
                ),
                array('method' => 'post', 'name' => 'frm_list_ashes', 'id' => 'frm_list_ashes')
            );
		echo input_hidden_tag('page',$snPage, array('readonly' => true));
		echo input_hidden_tag('paging',$snPaging, array('readonly' => true));
        echo input_hidden_tag('form_name','frm_list_ashes', array('readonly' => true));		
		echo input_hidden_tag('service_type',3, array('readonly' => true));
		echo input_hidden_tag('service_date',$ssServiceDate, array('readonly' => true));
		
        echo '<div>';
            echo '<div style="width:100%;float:left;">';    
				echo '<div  id="asheslisting" >';
					include_partial(
						'ashes_list_middle_part',
						array(
							'oAshesSummaryList'  	=> $oAshesSummaryList,
							'amAshesSummaryList'  	=> $amAshesSummaryList,
							'amExtraParameters' 	=> $amExtraParameters,
							'amSearch'          	=> $amSearch,	                                                
							'ssModuleName'      	=> $ssModuleName,
							'sortby'            	=> $amExtraParameters['ssSortBy'],
							'sortmode'          	=> $amExtraParameters['ssSortMode'],
							'inactivateIds'     	=> 'idservicebooking',
							'snPageTotalAshesRecords' => $snPageTotalAshesRecords
						)
					);
				echo '</div>';
						
				include_partial(
					'global/listing_bottom',
					array(
						'amPagerSearchResults'  => $oAshesSummaryList, 
						'amExtraParameters'     => $amExtraParameters,
						'ssForm'				=> 'frm_list_ashes',
						'snPaggingDropDown'		=> 4,
						'ssBottomDivId'			=> 'ashesbottompagingdiv'
					)
				);
            echo '</div>';            
            echo '<div class="clearb">&nbsp;</div>';
        echo '</div>';    	
    ?>
    </form>	
	<!------------------------------- Exhumation Listing Part ---------------------------------->
	<?php
        echo jq_form_remote_tag(
                array(
                    'url'       => $ssModuleName.'/index?request_type=ajax_request_exhumation',
                    'update'    => 'exhumationlisting',
                    'script'    => true,
                    'loading'   => jq_visual_effect('fadeIn','#indicator1'),
                    'complete'  => jq_visual_effect('fadeOut','#indicator1').";sortingdiv3();",
                ),
                array('method' => 'post', 'name' => 'frm_list_exhumation', 'id' => 'frm_list_exhumation')
            );

        echo input_hidden_tag('page',$snPage, array('readonly' => true));
        echo input_hidden_tag('paging',$snPaging, array('readonly' => true));    
        echo input_hidden_tag('form_name','frm_list_exhumation', array('readonly' => true));
		echo input_hidden_tag('service_type', 2, array('readonly' => true));
		echo input_hidden_tag('service_date',$ssServiceDate, array('readonly' => true));
		
        echo '<div>';
            echo '<div style="width:100%;float:left;">';    
				echo '<div  id="exhumationlisting" >';
					include_partial(
						'exhumation_list_middle_part',
						array(
							'oExhumationSummaryList'  	=> $oExhumationSummaryList,
							'amExhumationSummaryList'  	=> $amExhumationSummaryList,
							'amExtraParameters' 	=> $amExtraParameters,
							'amSearch'          	=> $amSearch,	                                                
							'ssModuleName'      	=> $ssModuleName,
							'sortby'            	=> $amExtraParameters['ssSortBy'],
							'sortmode'          	=> $amExtraParameters['ssSortMode'],
							'inactivateIds'     	=> 'idservicebooking',
							'snPageTotalExhumationRecords' => $snPageTotalExhumationRecords
						)
					);
				echo '</div>';
						
				include_partial(
					'global/listing_bottom',
					array(
						'amPagerSearchResults'  => $oExhumationSummaryList, 
						'amExtraParameters'     => $amExtraParameters,
						'ssForm'				=> 'frm_list_exhumation',
						'snPaggingDropDown'		=> 6,
						'ssBottomDivId'			=> 'exhumationbottompagingdiv'
					)
				);
            echo '</div>';            
            echo '<div class="clearb">&nbsp;</div>';
        echo '</div>';    	
    ?>
    </form>	
	<!------------------------------- Chapel Listing Part ---------------------------------->
	<?php
        echo jq_form_remote_tag(
                array(
                    'url'       => $ssModuleName.'/index?request_type=ajax_request_chapel',
                    'update'    => 'chapellisting',
                    'script'    => true,
                    'loading'   => jq_visual_effect('fadeIn','#indicator1'),
                    'complete'  => jq_visual_effect('fadeOut','#indicator1').";sortingdiv4();",
                ),
                array('method' => 'post', 'name' => 'frm_list_chapel', 'id' => 'frm_list_chapel')
            );

        echo input_hidden_tag('page',$snPage, array('readonly' => true));
        echo input_hidden_tag('paging',$snPaging, array('readonly' => true));    
        echo input_hidden_tag('form_name','frm_list_chapel', array('readonly' => true));
		echo input_hidden_tag('service_type', 2, array('readonly' => true));
		echo input_hidden_tag('service_date',$ssServiceDate, array('readonly' => true));
		
        echo '<div>';
            echo '<div style="width:100%;float:left;">';    
				echo '<div  id="chapellisting" >';
					include_partial(
						'chapel_list_middle_part',
						array(
							'oChapelSummaryList'  	=> $oChapelSummaryList,
							'amChapelSummaryList'  	=> $amChapelSummaryList,
							'amExtraParameters' 	=> $amExtraParameters,
							'amSearch'          	=> $amSearch,	                                                
							'ssModuleName'      	=> $ssModuleName,
							'sortby'            	=> $amExtraParameters['ssSortBy'],
							'sortmode'          	=> $amExtraParameters['ssSortMode'],
							'inactivateIds'     	=> 'idservicebooking',
							'snPageTotalChapelRecords' => $snPageTotalChapelRecords
						)
					);
				echo '</div>';
				/*
				include_partial(
					'global/listing_bottom',
					array(
						'amPagerSearchResults'  => $oChapelSummaryList, 
						'amExtraParameters'     => $amExtraParameters,
						'ssForm'				=> 'frm_list_chapel',
						'snPaggingDropDown'		=> 8,
						'ssBottomDivId'			=> 'chapelbottompagingdiv'
					)
				);
            echo '</div>';*/
            echo '<div class="clearb">&nbsp;</div>';
        echo '</div>';    	
    ?>
    </form>
	<!------------------------------- Room Listing Part ---------------------------------->
	<?php
        echo jq_form_remote_tag(
                array(
                    'url'       => $ssModuleName.'/index?request_type=ajax_request_room',
                    'update'    => 'roomlisting',
                    'script'    => true,
                    'loading'   => jq_visual_effect('fadeIn','#indicator1'),
                    'complete'  => jq_visual_effect('fadeOut','#indicator1').";sortingdiv5();",
                ),
                array('method' => 'post', 'name' => 'frm_list_room', 'id' => 'frm_list_room')
            );

        echo input_hidden_tag('page',$snPage, array('readonly' => true));
        echo input_hidden_tag('paging',$snPaging, array('readonly' => true));    
        echo input_hidden_tag('form_name','frm_list_room', array('readonly' => true));
		echo input_hidden_tag('service_type', 2, array('readonly' => true));
		echo input_hidden_tag('service_date',$ssServiceDate, array('readonly' => true));
		
        echo '<div>';
            echo '<div style="width:100%;float:left;">';    
				echo '<div  id="roomlisting" >';
					include_partial(
						'room_list_middle_part',
						array(
							'oRoomSummaryList'  	=> $oRoomSummaryList,
							'amRoomSummaryList'  	=> $amRoomSummaryList,
							'amExtraParameters' 	=> $amExtraParameters,
							'amSearch'          	=> $amSearch,	                                                
							'ssModuleName'      	=> $ssModuleName,
							'sortby'            	=> $amExtraParameters['ssSortBy'],
							'sortmode'          	=> $amExtraParameters['ssSortMode'],
							'inactivateIds'     	=> 'idservicebooking',
							'snPageTotalRoomRecords' => $snPageTotalRoomRecords
						)
					);
				echo '</div>';
				/*
				include_partial(
					'global/listing_bottom',
					array(
						'amPagerSearchResults'  => $oRoomSummaryList, 
						'amExtraParameters'     => $amExtraParameters,
						'ssForm'				=> 'frm_list_room',
						'snPaggingDropDown'		=> 10,
						'ssBottomDivId'			=> 'roombottompagingdiv'
					)
				);
            echo '</div>';*/
            echo '<div class="clearb">&nbsp;</div>';
        echo '</div>';    	
    ?>
    </form>	
</div>
<!--Sorting for selected field-->
<?php 
	echo javascript_tag('
		jQuery(document).ready(function() 
		{
			sortingdiv();
		});
		function sortingdiv1(){
			showHideSortDiv("chkunchk2","selectopt2");
			showHideSortDiv("chkunchk3","selectopt3");			
		}
		function sortingdiv2(){
			showHideSortDiv("chkunchk4","selectopt4");
			showHideSortDiv("chkunchk5","selectopt5");			
		}
		function sortingdiv3(){
			showHideSortDiv("chkunchk6","selectopt6");
			showHideSortDiv("chkunchk7","selectopt7");			
		}
		function sortingdiv4(){
			showHideSortDiv("chkunchk8","selectopt8");
			showHideSortDiv("chkunchk9","selectopt9");			
		}
		function sortingdiv5(){
			showHideSortDiv("chkunchk10","selectopt10");
			showHideSortDiv("chkunchk11","selectopt11");			
		}								
		
		function sortingdiv()
		{
			showHideSortDiv("chkunchk2","selectopt2");
			showHideSortDiv("chkunchk3","selectopt3"); 
			
			showHideSortDiv("chkunchk4","selectopt4");
			showHideSortDiv("chkunchk5","selectopt5"); 
			
			showHideSortDiv("chkunchk6","selectopt6");
			showHideSortDiv("chkunchk7","selectopt7"); 
			
			showHideSortDiv("chkunchk8","selectopt8");
			showHideSortDiv("chkunchk9","selectopt9"); 
			
			showHideSortDiv("chkunchk10","selectopt10");
			showHideSortDiv("chkunchk11","selectopt11"); 
						 
		}');
?>
