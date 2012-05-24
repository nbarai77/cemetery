<?php  use_javascript('/sfFormExtraPlugin/js/double_list.js');
use_javascript('jquery-ui-timepicker-addon.js');
use_stylesheet('jquery-ui-timepicker-addon.css');
?>

<div id="wapper">
<?php 
    echo $oGranteeDetailsForm->renderFormTag(
        url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oGranteeDetailsForm->getObject()->isNew() ? '?id='.$oGranteeDetailsForm->getObject()->getId().'&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '')), 
        array("name" => $oGranteeDetailsForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );
?>
    <div class="comment_list"></div>
    <h1><?php echo $oGranteeDetailsForm->getObject()->isNew() ?  __('Add New Grantee Details') : __('Edit Grantee Details');?></h1>
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
                                	<?php echo $oGranteeDetailsForm['cem_id']->renderLabel($oGranteeDetailsForm['cem_id']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeDetailsForm['cem_id']->hasError()):
                                    	    echo $oGranteeDetailsForm['cem_id']->renderError();
                                        endif;
									    echo $oGranteeDetailsForm['cem_id']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>							
							<?php endif;?>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeDetailsForm['title']->renderLabel($oGranteeDetailsForm['title']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeDetailsForm['title']->hasError()):
                                    	    echo $oGranteeDetailsForm['title']->renderError();
                                        endif;
									    echo $oGranteeDetailsForm['title']->render(); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeDetailsForm['grantee_surname']->renderLabel($oGranteeDetailsForm['grantee_surname']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeDetailsForm['grantee_surname']->hasError()):
                                    	    echo $oGranteeDetailsForm['grantee_surname']->renderError();
                                        endif;
									    echo $oGranteeDetailsForm['grantee_surname']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>                    		
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeDetailsForm['grantee_first_name']->renderLabel($oGranteeDetailsForm['grantee_first_name']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeDetailsForm['grantee_first_name']->hasError()):
                                    	    echo $oGranteeDetailsForm['grantee_first_name']->renderError();
                                        endif;
									    echo $oGranteeDetailsForm['grantee_first_name']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeDetailsForm['grantee_middle_name']->renderLabel($oGranteeDetailsForm['grantee_middle_name']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeDetailsForm['grantee_middle_name']->hasError()):
                                    	    echo $oGranteeDetailsForm['grantee_middle_name']->renderError();
                                        endif;
									    echo $oGranteeDetailsForm['grantee_middle_name']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<?php if($sf_params->get('grave_id') != ''):?>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeDetailsForm['grantee_identity_id']->renderLabel($oGranteeDetailsForm['grantee_identity_id']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeDetailsForm['grantee_identity_id']->hasError()):
                                    	    echo $oGranteeDetailsForm['grantee_identity_id']->renderError();
                                        endif;
									    echo $oGranteeDetailsForm['grantee_identity_id']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeDetailsForm['grantee_identity_number']->renderLabel($oGranteeDetailsForm['grantee_identity_number']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeDetailsForm['grantee_identity_number']->hasError()):
                                    	    echo $oGranteeDetailsForm['grantee_identity_number']->renderError();
                                        endif;
									    echo $oGranteeDetailsForm['grantee_identity_number']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeDetailsForm['date_of_purchase']->renderLabel($oGranteeDetailsForm['date_of_purchase']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeDetailsForm['date_of_purchase']->hasError()):
                                    	    echo $oGranteeDetailsForm['date_of_purchase']->renderError();
                                        endif;
									    echo $oGranteeDetailsForm['date_of_purchase']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeDetailsForm['tenure_expiry_date']->renderLabel($oGranteeDetailsForm['tenure_expiry_date']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeDetailsForm['tenure_expiry_date']->hasError()):
                                    	    echo $oGranteeDetailsForm['tenure_expiry_date']->renderError();
                                        endif;
									    echo $oGranteeDetailsForm['tenure_expiry_date']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<?php endif;?>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeDetailsForm['grantee_dob']->renderLabel($oGranteeDetailsForm['grantee_dob']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeDetailsForm['grantee_dob']->hasError()):
                                    	    echo $oGranteeDetailsForm['grantee_dob']->renderError();
                                        endif;
									    echo $oGranteeDetailsForm['grantee_dob']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>							
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeDetailsForm['grantee_address']->renderLabel($oGranteeDetailsForm['grantee_address']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeDetailsForm['grantee_address']->hasError()):
                                    	    echo $oGranteeDetailsForm['grantee_address']->renderError();
                                        endif;
									    echo $oGranteeDetailsForm['grantee_address']->render(); 
								    ?>
                                </td>
                    		</tr>

							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeDetailsForm['town']->renderLabel($oGranteeDetailsForm['town']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeDetailsForm['town']->hasError()):
                                    	    echo $oGranteeDetailsForm['town']->renderError();
                                        endif;
									    echo $oGranteeDetailsForm['town']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeDetailsForm['state']->renderLabel($oGranteeDetailsForm['state']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeDetailsForm['state']->hasError()):
                                    	    echo $oGranteeDetailsForm['state']->renderError();
                                        endif;
									    echo $oGranteeDetailsForm['state']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeDetailsForm['postal_code']->renderLabel($oGranteeDetailsForm['postal_code']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeDetailsForm['postal_code']->hasError()):
                                    	    echo $oGranteeDetailsForm['postal_code']->renderError();
                                        endif;
									    echo $oGranteeDetailsForm['postal_code']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    		
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeDetailsForm['grantee_email']->renderLabel($oGranteeDetailsForm['grantee_email']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeDetailsForm['grantee_email']->hasError()):
                                    	    echo $oGranteeDetailsForm['grantee_email']->renderError();
                                        endif;
									    echo $oGranteeDetailsForm['grantee_email']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>                    		
                    		
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeDetailsForm['area_code']->renderLabel($oGranteeDetailsForm['area_code']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeDetailsForm['area_code']->hasError()):
                                    	    echo $oGranteeDetailsForm['area_code']->renderError();
                                        endif;
									    echo $oGranteeDetailsForm['area_code']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeDetailsForm['phone']->renderLabel($oGranteeDetailsForm['phone']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeDetailsForm['phone']->hasError()):
                                    	    echo $oGranteeDetailsForm['phone']->renderError();
                                        endif;
									    echo $oGranteeDetailsForm['phone']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeDetailsForm['contact_mobile']->renderLabel($oGranteeDetailsForm['contact_mobile']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeDetailsForm['contact_mobile']->hasError()):
                                    	    echo $oGranteeDetailsForm['contact_mobile']->renderError();
                                        endif;
									    echo $oGranteeDetailsForm['contact_mobile']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeDetailsForm['fax_area_code']->renderLabel($oGranteeDetailsForm['fax_area_code']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeDetailsForm['fax_area_code']->hasError()):
                                    	    echo $oGranteeDetailsForm['fax_area_code']->renderError();
                                        endif;
									    echo $oGranteeDetailsForm['fax_area_code']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeDetailsForm['fax']->renderLabel($oGranteeDetailsForm['fax']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeDetailsForm['fax']->hasError()):
                                    	    echo $oGranteeDetailsForm['fax']->renderError();
                                        endif;
									    echo $oGranteeDetailsForm['fax']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>							
							<!--<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php //echo $oGranteeDetailsForm['grantee_id_number']->renderLabel($oGranteeDetailsForm['grantee_id_number']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    /*if($oGranteeDetailsForm['grantee_id_number']->hasError()):
                                    	    echo $oGranteeDetailsForm['grantee_id_number']->renderError();
                                        endif;
									    echo $oGranteeDetailsForm['grantee_id_number']->render(array('class'=>'inputBoxWidth')); */
								    ?>
                                </td>
                    		</tr>-->
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeDetailsForm['remarks_1']->renderLabel($oGranteeDetailsForm['remarks_1']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeDetailsForm['remarks_1']->hasError()):
                                    	    echo $oGranteeDetailsForm['remarks_1']->renderError();
                                        endif;
									    echo $oGranteeDetailsForm['remarks_1']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeDetailsForm['remarks_2']->renderLabel($oGranteeDetailsForm['remarks_2']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeDetailsForm['remarks_2']->hasError()):
                                    	    echo $oGranteeDetailsForm['remarks_2']->renderError();
                                        endif;
									    echo $oGranteeDetailsForm['remarks_2']->render(array('class'=>'inputBoxWidth')); 
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
	                                                            'tabindex'  => 20,
	                                                            'onclick'   => "jQuery('#tab').val('');"
	                                                        )
	                                                    );
	                                                ?>
                                        		</span>
                                        	</li>
                                			<li class="list1">
                                        		<span>
                                        			<?php 
                                        			
														if($sf_params->get('grave_id') != '') {
															$ssCancelUrl = 'grave/showGrantees?grave_id='.$sf_params->get('grave_id');
														}else {
															if($sf_params->get('back') == true):
																$ssCancelUrl = 'granteesearch/search?back=true';
															else:                                        			 
																$ssCancelUrl    = $sf_params->get('module').'/index?'.html_entity_decode($amExtraParameters['ssQuerystr']);
															endif;	
														}
                                                		echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>21));
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
        echo input_hidden_tag('grave_id', $snGraveId, array('readonly' => 'true'));
        
        echo input_hidden_tag('back', $sf_params->get('back'), array('readonly' => 'true'));
        echo input_hidden_tag('tab', ($sf_params->get('tab') ? $sf_params->get('tab') :'info'), array('readonly' => 'true'));
        echo $oGranteeDetailsForm->renderHiddenFields(); 
    ?>
    </form>
</div>
<?php 
    echo javascript_tag('
        ssTags = document.getElementsByTagName("INPUT");
        document.getElementById(ssTags[0].id).focus();'
    );
    
    echo javascript_tag("
        jQuery(document).ready(function() 
            {
                tabSelection('".(($sf_params->get('tab')) ? $sf_params->get('tab') : 'info')."','active');
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
