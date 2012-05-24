<?php use_javascript('/sfFormExtraPlugin/js/double_list.js');
    use_helper('pagination');
    $ssModuleName = $sf_params->get('module'); 
?>
<div id="wapper">  
	<?php 
		echo $oAnnualReportForm->renderFormTag(
			url_for($sf_params->get('module').'/'.'index'.(!$oAnnualReportForm->getObject()->isNew() ? '?id='.$oAnnualReportForm->getObject()->getId().'&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '')), 
			array("name" => $oAnnualReportForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
		);
	include_partial('global/indicator');?>
    <div id="result"></div>
	<table width="70%" border="0" cellspacing="5" cellpadding="5">
		<tr>
			<td valign="middle" align="right" width="10%">
				<?php echo $oAnnualReportForm['from_date']->renderLabel($oAnnualReportForm['from_date']->renderLabelName());?> : 
			</td>				
			<td valign="middle" width="28%">
				<?php 
					if($oAnnualReportForm['from_date']->hasError()):
						echo $oAnnualReportForm['from_date']->renderError();
					endif;
					echo $oAnnualReportForm['from_date']->render(); 
				?>
			</td>
			<td valign="middle" align="right" width="10%">
				<?php echo $oAnnualReportForm['to_date']->renderLabel($oAnnualReportForm['to_date']->renderLabelName());?> : 
			</td>				
			<td valign="middle" width="28%">
				<?php 
					if($oAnnualReportForm['to_date']->hasError()):
						echo $oAnnualReportForm['to_date']->renderError();
					endif;
					echo $oAnnualReportForm['to_date']->render(); 
				?>
			</td>
			<td valign="middle" width="25%">
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
											'tabindex'  => 3,
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
									echo button_to(__('Reset'),$ssCancelUrl,array('class'=>'delete','title'=>__('Reset'),'alt'=>__('Cancel'),'tabindex'=>4));
								?>
							</span>
						</li>
					</ul>
				</div>
			</td>
		</tr>
	</table>
	</form>
    <?php
        echo jq_form_remote_tag(
                array(
                    'url'       => $ssModuleName.'/index?request_type=ajax_request',
                    'update'    => 'contentlisting',
                    'script'    => true,
                    'loading'   => jq_visual_effect('fadeIn','#indicator1'),
                    'complete'  => jq_visual_effect('fadeOut','#indicator1').";sortingdiv1();",
                ),
                array('method' => 'post', 'name' => 'frm_list_annualreport', 'id' => 'frm_list_annualreport')
            );
		echo input_hidden_tag('page',$snPage, array('readonly' => true));
		echo input_hidden_tag('paging',$snPaging, array('readonly' => true));
        echo input_hidden_tag('form_name','frm_list_annualreport', array('readonly' => true));
        echo input_hidden_tag('from_date',$ssFromDate, array('readonly' => true));
        echo input_hidden_tag('to_date',$ssToDate, array('readonly' => true));

        echo '<div>';
            echo '<div style="width:100%;float:left;">';    
				echo '<div  id="contentlisting" >';
					include_partial(
						'list_middle_part',
						array(
							'oAnnualReportList'  	=> $oAnnualReportList,
							'amAnnualReportList'  	=> $amAnnualReportList,
							'amExtraParameters' => $amExtraParameters,
							'amSearch'          => $amSearch,        
							'ssModuleName'      => $ssModuleName,
							'sortby'            => $amExtraParameters['ssSortBy'],
							'sortmode'          => $amExtraParameters['ssSortMode'],
							'inactivateIds'     => 'idservicebooking',
							'snPageTotalAnnualReportRecords' => $snPageTotalAnnualReportRecords
						)
					);
				echo '</div>';
						
				include_partial(
					'global/listing_bottom',
					array(
						'amPagerSearchResults'  => $oAnnualReportList, 
						'amExtraParameters'     => $amExtraParameters,
						'ssForm'				=> 'frm_list_annualreport'
					)
				);
            echo '</div>';            
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
