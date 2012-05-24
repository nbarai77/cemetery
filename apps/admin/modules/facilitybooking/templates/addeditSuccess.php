<?php  use_javascript('/sfFormExtraPlugin/js/double_list.js');
use_javascript('jquery-ui-timepicker-addon.js');
use_stylesheet('jquery-ui-timepicker-addon.css');
?>
<div id="wapper">
<?php 
    echo $oFacilityBookingForm->renderFormTag(
        url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oFacilityBookingForm->getObject()->isNew() ? '?id='.$oFacilityBookingForm->getObject()->getId().'&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '')), 
        array("name" => $oFacilityBookingForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );
?>
    <div class="comment_list"></div>
    <h1><?php echo $oFacilityBookingForm->getObject()->isNew() ?  __('Add Facility Booking') : __('Edit Facility Booking');?></h1>
    <div id="message">
        <div id="success_msgs">
            <?php echo include_partial('global/notification_msg', array('amSuccessMsg' => $amSuccessMsg,'amErrorMsg' => $amErrorMsg));?>
        </div>
    </div>
    <div class="clearb">&nbsp;</div>    
    <div id="main">
        <div class="maintablebg">
            <div class="main_cont">
                <div class="left_part">
            		<div id="info">
                		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sub_table">
							<?php if($sf_user->isSuperAdmin()):?>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFacilityBookingForm['country_id']->renderLabel($oFacilityBookingForm['country_id']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFacilityBookingForm['country_id']->hasError()):
                                    	    echo $oFacilityBookingForm['country_id']->renderError();
                                        endif;
									    echo $oFacilityBookingForm['country_id']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>							

                    		
							<tr>
                            	<td valign="middle" align="right" width="20%">
									<?php echo __('Select Cementery')."<span class='redText'>*</span>"?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
										if($sf_user->hasFlash('ssErrorCemeter') && $sf_user->getFlash('ssErrorCemeter') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorCemeter').'</li></ul>';
											$sf_user->setFlash('ssErrorCemeter','');
										endif;
										include_partial('getCementeryList', array('asCementryList' => $asCementery,'snCementeryId' => $snCementeryId)); 
								    ?>
                                </td>
                    		</tr>                    		
                    		
                    		
                    		
							<?php endif;?>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFacilityBookingForm['title']->renderLabel($oFacilityBookingForm['title']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFacilityBookingForm['title']->hasError()):
                                    	    echo $oFacilityBookingForm['title']->renderError();
                                        endif;
									    echo $oFacilityBookingForm['title']->render(); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFacilityBookingForm['surname']->renderLabel($oFacilityBookingForm['surname']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFacilityBookingForm['surname']->hasError()):
                                    	    echo $oFacilityBookingForm['surname']->renderError();
                                        endif;
									    echo $oFacilityBookingForm['surname']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFacilityBookingForm['first_name']->renderLabel($oFacilityBookingForm['first_name']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFacilityBookingForm['first_name']->hasError()):
                                    	    echo $oFacilityBookingForm['first_name']->renderError();
                                        endif;
									    echo $oFacilityBookingForm['first_name']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFacilityBookingForm['middle_name']->renderLabel($oFacilityBookingForm['middle_name']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFacilityBookingForm['middle_name']->hasError()):
                                    	    echo $oFacilityBookingForm['middle_name']->renderError();
                                        endif;
									    echo $oFacilityBookingForm['middle_name']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFacilityBookingForm['email']->renderLabel($oFacilityBookingForm['email']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFacilityBookingForm['email']->hasError()):
                                    	    echo $oFacilityBookingForm['email']->renderError();
                                        endif;
									    echo $oFacilityBookingForm['email']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>														
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFacilityBookingForm['address']->renderLabel($oFacilityBookingForm['address']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFacilityBookingForm['address']->hasError()):
                                    	    echo $oFacilityBookingForm['address']->renderError();
                                        endif;
									    echo $oFacilityBookingForm['address']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFacilityBookingForm['suburb_town']->renderLabel($oFacilityBookingForm['suburb_town']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFacilityBookingForm['suburb_town']->hasError()):
                                    	    echo $oFacilityBookingForm['suburb_town']->renderError();
                                        endif;
									    echo $oFacilityBookingForm['suburb_town']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>

							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFacilityBookingForm['state']->renderLabel($oFacilityBookingForm['state']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFacilityBookingForm['state']->hasError()):
                                    	    echo $oFacilityBookingForm['state']->renderError();
                                        endif;
									    echo $oFacilityBookingForm['state']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFacilityBookingForm['postal_code']->renderLabel($oFacilityBookingForm['postal_code']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFacilityBookingForm['postal_code']->hasError()):
                                    	    echo $oFacilityBookingForm['postal_code']->renderError();
                                        endif;
									    echo $oFacilityBookingForm['postal_code']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFacilityBookingForm['area_code']->renderLabel($oFacilityBookingForm['area_code']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFacilityBookingForm['area_code']->hasError()):
                                    	    echo $oFacilityBookingForm['area_code']->renderError();
                                        endif;
									    echo $oFacilityBookingForm['area_code']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFacilityBookingForm['telephone']->renderLabel($oFacilityBookingForm['telephone']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFacilityBookingForm['telephone']->hasError()):
                                    	    echo $oFacilityBookingForm['telephone']->renderError();
                                        endif;
									    echo $oFacilityBookingForm['telephone']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFacilityBookingForm['mobile']->renderLabel($oFacilityBookingForm['mobile']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFacilityBookingForm['mobile']->hasError()):
                                    	    echo $oFacilityBookingForm['mobile']->renderError();
                                        endif;
									    echo $oFacilityBookingForm['mobile']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFacilityBookingForm['fax_area_code']->renderLabel($oFacilityBookingForm['fax_area_code']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFacilityBookingForm['fax_area_code']->hasError()):
                                    	    echo $oFacilityBookingForm['fax_area_code']->renderError();
                                        endif;
									    echo $oFacilityBookingForm['fax_area_code']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFacilityBookingForm['fax']->renderLabel($oFacilityBookingForm['fax']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFacilityBookingForm['fax']->hasError()):
                                    	    echo $oFacilityBookingForm['fax']->renderError();
                                        endif;
									    echo $oFacilityBookingForm['fax']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>							
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFacilityBookingForm['chapel']->renderLabel($oFacilityBookingForm['chapel']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFacilityBookingForm['chapel']->hasError()):
                                    	    echo $oFacilityBookingForm['chapel']->renderError();
                                        endif;
									    echo $oFacilityBookingForm['chapel']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
								<td valign="middle" align="right" width="20%">&nbsp;</td>
								<td valign="middle" width="80%">
									<div id="chapeldiv" style="display:block;">
										<?php 
											if($sf_user->isSuperAdmin()):
												include_partial('getChapelTypes', array('amChapelUnAssociated' => $amChapelUnAssociated, 
																						'amChapelAssociated' => $amChapelAssociated)); 
											else:
												echo '<div class="fleft ChapelTime">';
													echo $oFacilityBookingForm['chapel_grouplist']->renderLabel($oFacilityBookingForm['chapel_grouplist']->renderLabelName() );
												echo '</div>';
												echo '<div class="fleft pad_10">';
														if($oFacilityBookingForm['chapel_grouplist']->hasError()):
															echo $oFacilityBookingForm['chapel_grouplist']->renderError();
														endif;
														echo $oFacilityBookingForm['chapel_grouplist']->render();
												echo '</div>';
											endif;
										?>
										<div class="clearb">&nbsp;</div>
										<div class="fleft ChapelTime">
											<?php echo $oFacilityBookingForm['chapel_time_from']->renderLabel($oFacilityBookingForm['chapel_time_from']->renderLabelName() );?>
										</div>
										<div class="fleft pad_10">
											<?php 
												if($oFacilityBookingForm['chapel_time_from']->hasError()):
													echo $oFacilityBookingForm['chapel_time_from']->renderError();
												endif;
												echo $oFacilityBookingForm['chapel_time_from']->render(); ?>
										</div>
										<div class="fleft ChapelTime">
											<?php echo $oFacilityBookingForm['chapel_time_to']->renderLabel($oFacilityBookingForm['chapel_time_to']->renderLabelName() );?>
										</div>
										<div class="fleft pad_10">
											<?php 
												if($oFacilityBookingForm['chapel_time_to']->hasError()):
													echo $oFacilityBookingForm['chapel_time_to']->renderError();
												endif;
												echo $oFacilityBookingForm['chapel_time_to']->render(); ?>
										</div>
										<div class="clearb"></div>
										<div class="fleft ChapelTime MB10">
											<?php echo $oFacilityBookingForm['chapel_cost']->renderLabel($oFacilityBookingForm['chapel_cost']->renderLabelName() );?>
										</div>
										<div class="fleft pad_10 MB10">
											<?php echo $oFacilityBookingForm['chapel_cost']->render(array('class'=>'inputBoxWidth')); ?> $
										</div>																		
									</div>
								</td>
                    		</tr>
							
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFacilityBookingForm['room']->renderLabel($oFacilityBookingForm['room']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFacilityBookingForm['room']->hasError()):
                                    	    echo $oFacilityBookingForm['room']->renderError();
                                        endif;
									    echo $oFacilityBookingForm['room']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
								<td valign="middle" align="right" width="20%">&nbsp;</td>
								<td valign="middle" width="80%">
									<div id="roomdiv" style="display:none;">
											<?php 
											if($sf_user->isSuperAdmin()):
												include_partial('getRoomTypes', array('amRoomUnAssociated' => $amRoomUnAssociated, 
																					  'amRoomAssociated' => $amRoomAssociated)); 
											else:
												echo '<div class="fleft ChapelTime">';
													echo $oFacilityBookingForm['room_grouplist']->renderLabel($oFacilityBookingForm['room_grouplist']->renderLabelName() );
												echo '</div>';
												echo '<div class="fleft pad_10">';
														if($oFacilityBookingForm['room_grouplist']->hasError()):
															echo $oFacilityBookingForm['room_grouplist']->renderError();
														endif;
														echo $oFacilityBookingForm['room_grouplist']->render();
												echo '</div>';
											endif;
											?>											
											<div class="clearb">&nbsp;</div>
                                    		<div class="fleft ChapelTime">
												<?php echo $oFacilityBookingForm['room_time_from']->renderLabel($oFacilityBookingForm['room_time_from']->renderLabelName() );?>
											</div>
											<div class="fleft pad_10">
												<?php  
														if($oFacilityBookingForm['room_time_from']->hasError()):
															echo $oFacilityBookingForm['room_time_from']->renderError();
														endif;
														echo $oFacilityBookingForm['room_time_from']->render(); ?>
											</div>
											<div class="fleft ChapelTime">
												<?php echo $oFacilityBookingForm['room_time_to']->renderLabel($oFacilityBookingForm['room_time_to']->renderLabelName() );?>
											</div>
											<div class="fleft pad_10">
												<?php 
														if($oFacilityBookingForm['room_time_to']->hasError()):
															echo $oFacilityBookingForm['room_time_to']->renderError();
														endif;
													echo $oFacilityBookingForm['room_time_to']->render(); ?>
											</div>
											<div class="clearb"></div>
											<div class="fleft ChapelTime MB10">
												<?php echo $oFacilityBookingForm['no_of_rooms']->renderLabel($oFacilityBookingForm['no_of_rooms']->renderLabelName() );?>
											</div>
											<div class="fleft pad_10 MB10">
												<?php echo $oFacilityBookingForm['no_of_rooms']->render(array('class'=>'inputBoxWidth')); ?>
											</div>
											<div class="fleft ChapelTime MB10">
												<?php echo $oFacilityBookingForm['room_cost']->renderLabel($oFacilityBookingForm['room_cost']->renderLabelName() );?>
											</div>
											<div class="fleft pad_10 MB10">
												<?php echo $oFacilityBookingForm['room_cost']->render(array('class'=>'inputBoxWidth')); ?> $
											</div>
									</div>
								</td>
							</tr>
							<tr>
                            	<td valign="middle" align="left" width="20%">
                                	<?php echo $oFacilityBookingForm['special_instruction']->renderLabel($oFacilityBookingForm['special_instruction']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFacilityBookingForm['special_instruction']->hasError()):
                                    	    echo $oFacilityBookingForm['special_instruction']->renderError();
                                        endif;
									    echo $oFacilityBookingForm['special_instruction']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFacilityBookingForm['receipt_number']->renderLabel($oFacilityBookingForm['receipt_number']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFacilityBookingForm['receipt_number']->hasError()):
                                    	    echo $oFacilityBookingForm['receipt_number']->renderError();
                                        endif;
									    echo $oFacilityBookingForm['receipt_number']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    		<tr>
                            	<td>&nbsp;</td>
                        		<td valign="middle">
                                	<div class="actions">
                                		<ul class="fleft">
                                        	<li class="list1">
                                        		<span>
	                                                <?php 
	                                                    echo submit_tag(
	                                                        __('Save'), 
	                                                        array(
	                                                            'class'     => 'delete',
	                                                            'name'      => 'submit_button',
	                                                            'title'     => __('Save'), 
	                                                            'tabindex'  => 30,
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
                                                		echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>31));
                                                    ?>
                                    			</span>
                                    		</li>
                            			</ul>
                                	</div>
                        		</td>
                        	</tr>
                		</table>
            		</div>

                </div>
                <div class="clearb"></div>
            </div>
        </div>
    </div>
    <div class="clearb">&nbsp;</div>
    <div class="clearb">&nbsp;</div>
    <?php
        echo input_hidden_tag('id', $sf_params->get('id'), array('readonly' => 'true'));
        echo input_hidden_tag('tab', ($sf_params->get('tab') ? $sf_params->get('tab') :'info'), array('readonly' => 'true'));
        echo $oFacilityBookingForm->renderHiddenFields(); 
    ?>
    </form>
</div>
<?php 
    echo javascript_tag('
        ssTags = document.getElementsByTagName("INPUT");
        document.getElementById(ssTags[0].id).select();
        document.getElementById(ssTags[0].id).focus();'
    );
    
    echo javascript_tag("
	
		jQuery('input:radio[name=facilitybooking[chapel]]').click(function() {
			if(this.name == 'facilitybooking[chapel]')
			{
				var ssChapelValue = $(this).val();
				showHideDiv('chapel','chapeldiv',ssChapelValue);
			}
		});
		jQuery('input:radio[name=facilitybooking[room]]').click(function() {
			if(this.name == 'facilitybooking[room]')
			{
				var ssRoomValue = $(this).val();
				showHideDiv('room','roomdiv',ssRoomValue);
			}
		});
        jQuery(document).ready(function() 
		{
			var snCountryId = jQuery('#facilitybooking_country_id').val();
			var snCemeteryId = $('#facilitybooking_cem_cemetery_id option').length;
			if(snCountryId > 0 && snCemeteryId == 1)
				callAjaxRequest(snCountryId,'".url_for('facilitybooking/getCementryListAsPerCountry')."','facilitybooking_cementery_list');

			var ssChapel = $(\"input[name='facilitybooking[chapel]']:checked\").val();
			var ssRoom = $(\"input[name='facilitybooking[room]']:checked\").val();
			
			showHideDiv('chapel','chapeldiv',ssChapel);
			showHideDiv('room','roomdiv',ssRoom);
		});
        function tabSelection(id, ssClassName)
        { 
            var asTabs      = new Array('user_info','user_permission');
            var asUpdateDiv = new Array('info','permission'); 
            
            for(var i=0;i<asTabs.length;i++)
            {
	            jQuery('#' + asTabs[i] ).removeClass(ssClassName);
            }
            
            jQuery('#user_' + id).addClass(ssClassName);
            
            for(var i=0;i<asUpdateDiv.length;i++)
            {
                jQuery('#' + asUpdateDiv[i] ).attr('style','display:none');
            }

            jQuery('#' + id).attr('style','display:block');
        }
    ");
?>

<?php
    echo javascript_tag("
        jQuery(document).ready(function() 
            {
				$('table').find('tr:visible:odd').addClass('even').end().find('tr:visible:even').addClass('odd');
            });
    ");
?>
