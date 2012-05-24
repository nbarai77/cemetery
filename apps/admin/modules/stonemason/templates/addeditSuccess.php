<?php  use_javascript('/sfFormExtraPlugin/js/double_list.js');?>
<div id="wapper">
<?php 
    echo $oCemStonemasonForm->renderFormTag(
        url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oCemStonemasonForm->getObject()->isNew() ? '?id='.$oCemStonemasonForm->getObject()->getId().'&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '')), 
        array("name" => $oCemStonemasonForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );
?>
    <div class="comment_list"></div>
    <h1><?php echo $oCemStonemasonForm->getObject()->isNew() ?  __('Add New Stone Mason') : __('Edit Stone Mason');?></h1>
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
                                	<?php echo $oCemStonemasonForm['country_id']->renderLabel($oCemStonemasonForm['country_id']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemStonemasonForm['country_id']->hasError()):
                                    	    echo $oCemStonemasonForm['country_id']->renderError();
                                        endif;
									    echo $oCemStonemasonForm['country_id']->render(array('class'=>'inputBoxWidth')); 
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
                                	<?php echo $oCemStonemasonForm['work_type_stone_mason_id']->renderLabel($oCemStonemasonForm['work_type_stone_mason_id']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemStonemasonForm['work_type_stone_mason_id']->hasError()):
                                    	    echo $oCemStonemasonForm['work_type_stone_mason_id']->renderError();
                                        endif;
									    echo $oCemStonemasonForm['work_type_stone_mason_id']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>							 
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemStonemasonForm['company_name']->renderLabel($oCemStonemasonForm['company_name']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemStonemasonForm['company_name']->hasError()):
                                    	    echo $oCemStonemasonForm['company_name']->renderError();
                                        endif;
									    echo $oCemStonemasonForm['company_name']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemStonemasonForm['address']->renderLabel($oCemStonemasonForm['address']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemStonemasonForm['address']->hasError()):
                                    	    echo $oCemStonemasonForm['address']->renderError();
                                        endif;
									    echo $oCemStonemasonForm['address']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemStonemasonForm['town']->renderLabel($oCemStonemasonForm['town']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemStonemasonForm['town']->hasError()):
                                    	    echo $oCemStonemasonForm['town']->renderError();
                                        endif;
									    echo $oCemStonemasonForm['town']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemStonemasonForm['state']->renderLabel($oCemStonemasonForm['state']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemStonemasonForm['state']->hasError()):
                                    	    echo $oCemStonemasonForm['state']->renderError();
                                        endif;
									    echo $oCemStonemasonForm['state']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemStonemasonForm['zip_code']->renderLabel($oCemStonemasonForm['zip_code']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemStonemasonForm['zip_code']->hasError()):
                                    	    echo $oCemStonemasonForm['zip_code']->renderError();
                                        endif;
									    echo $oCemStonemasonForm['zip_code']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemStonemasonForm['area_code']->renderLabel($oCemStonemasonForm['area_code']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemStonemasonForm['area_code']->hasError()):
                                    	    echo $oCemStonemasonForm['area_code']->renderError();
                                        endif;
									    echo $oCemStonemasonForm['area_code']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemStonemasonForm['telephone']->renderLabel($oCemStonemasonForm['telephone']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemStonemasonForm['telephone']->hasError()):
                                    	    echo $oCemStonemasonForm['telephone']->renderError();
                                        endif;
									    echo $oCemStonemasonForm['telephone']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemStonemasonForm['fax_area_code']->renderLabel($oCemStonemasonForm['fax_area_code']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemStonemasonForm['fax_area_code']->hasError()):
                                    	    echo $oCemStonemasonForm['fax_area_code']->renderError();
                                        endif;
									    echo $oCemStonemasonForm['fax_area_code']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemStonemasonForm['fax_number']->renderLabel($oCemStonemasonForm['fax_number']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemStonemasonForm['fax_number']->hasError()):
                                    	    echo $oCemStonemasonForm['fax_number']->renderError();
                                        endif;
									    echo $oCemStonemasonForm['fax_number']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>							
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemStonemasonForm['email']->renderLabel($oCemStonemasonForm['email']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemStonemasonForm['email']->hasError()):
                                    	    echo $oCemStonemasonForm['email']->renderError();
                                        endif;
									    echo $oCemStonemasonForm['email']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemStonemasonForm['accredited_to']->renderLabel($oCemStonemasonForm['accredited_to']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemStonemasonForm['accredited_to']->hasError()):
                                    	    echo $oCemStonemasonForm['accredited_to']->renderError();
                                        endif;
									    echo $oCemStonemasonForm['accredited_to']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemStonemasonForm['contact_name']->renderLabel($oCemStonemasonForm['contact_name']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemStonemasonForm['contact_name']->hasError()):
                                    	    echo $oCemStonemasonForm['contact_name']->renderError();
                                        endif;
									    echo $oCemStonemasonForm['contact_name']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemStonemasonForm['contact_area_number']->renderLabel($oCemStonemasonForm['contact_area_number']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemStonemasonForm['contact_area_number']->hasError()):
                                    	    echo $oCemStonemasonForm['contact_area_number']->renderError();
                                        endif;
									    echo $oCemStonemasonForm['contact_area_number']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>                    		
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemStonemasonForm['company_telephone']->renderLabel($oCemStonemasonForm['company_telephone']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemStonemasonForm['company_telephone']->hasError()):
                                    	    echo $oCemStonemasonForm['company_telephone']->renderError();
                                        endif;
									    echo $oCemStonemasonForm['company_telephone']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>

							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemStonemasonForm['comment']->renderLabel($oCemStonemasonForm['comment']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemStonemasonForm['comment']->hasError()):
                                    	    echo $oCemStonemasonForm['comment']->renderError();
                                        endif;
									    echo $oCemStonemasonForm['comment']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>							
							<tr>
								<td valign="middle">
									<?php echo $oCemStonemasonForm['is_enabled']->renderLabel($oCemStonemasonForm['is_enabled']->renderLabelName());?>
								</td>
								<td valign="middle" colspan="3"> <?php echo $oCemStonemasonForm['is_enabled']->render();?> </td>
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
	                                                            'tabindex'  => 19,
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
                                                		echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>20));
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
        echo $oCemStonemasonForm->renderHiddenFields(); 
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
