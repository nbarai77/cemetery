<?php  use_javascript('/sfFormExtraPlugin/js/double_list.js');?>
<div id="wapper">
<?php 
    echo $oFndFndirectorForm->renderFormTag(
        url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oFndFndirectorForm->getObject()->isNew() ? '?id='.$oFndFndirectorForm->getObject()->getId().'&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '')), 
        array("name" => $oFndFndirectorForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );
?>
    <div class="comment_list"></div>
    <h1><?php echo $oFndFndirectorForm->getObject()->isNew() ?  __('Add New Funeral Director') : __('Edit Funeral Director');?></h1>
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
                                	<?php echo $oFndFndirectorForm['country_id']->renderLabel($oFndFndirectorForm['country_id']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFndFndirectorForm['country_id']->hasError()):
                                    	    echo $oFndFndirectorForm['country_id']->renderError();
                                        endif;
									    echo $oFndFndirectorForm['country_id']->render(array('class'=>'inputBoxWidth')); 
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
                                	<?php echo $oFndFndirectorForm['title']->renderLabel($oFndFndirectorForm['title']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFndFndirectorForm['title']->hasError()):
                                    	    echo $oFndFndirectorForm['title']->renderError();
                                        endif;
									    echo $oFndFndirectorForm['title']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFndFndirectorForm['last_name']->renderLabel($oFndFndirectorForm['last_name']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFndFndirectorForm['last_name']->hasError()):
                                    	    echo $oFndFndirectorForm['last_name']->renderError();
                                        endif;
									    echo $oFndFndirectorForm['last_name']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>                    		
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFndFndirectorForm['first_name']->renderLabel($oFndFndirectorForm['first_name']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFndFndirectorForm['first_name']->hasError()):
                                    	    echo $oFndFndirectorForm['first_name']->renderError();
                                        endif;
									    echo $oFndFndirectorForm['first_name']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>

							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFndFndirectorForm['middle_name']->renderLabel($oFndFndirectorForm['middle_name']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFndFndirectorForm['middle_name']->hasError()):
                                    	    echo $oFndFndirectorForm['middle_name']->renderError();
                                        endif;
									    echo $oFndFndirectorForm['middle_name']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFndFndirectorForm['company_name']->renderLabel($oFndFndirectorForm['company_name']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFndFndirectorForm['company_name']->hasError()):
                                    	    echo $oFndFndirectorForm['company_name']->renderError();
                                        endif;
									    echo $oFndFndirectorForm['company_name']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    		<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFndFndirectorForm['code']->renderLabel($oFndFndirectorForm['code']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFndFndirectorForm['code']->hasError()):
                                    	    echo $oFndFndirectorForm['code']->renderError();
                                        endif;
									    echo $oFndFndirectorForm['code']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>                    		
                    		<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFndFndirectorForm['address']->renderLabel($oFndFndirectorForm['address']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFndFndirectorForm['address']->hasError()):
                                    	    echo $oFndFndirectorForm['address']->renderError();
                                        endif;
									    echo $oFndFndirectorForm['address']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>     
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFndFndirectorForm['town']->renderLabel($oFndFndirectorForm['town']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFndFndirectorForm['town']->hasError()):
                                    	    echo $oFndFndirectorForm['town']->renderError();
                                        endif;
									    echo $oFndFndirectorForm['town']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>               		
                    		<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFndFndirectorForm['state']->renderLabel($oFndFndirectorForm['state']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFndFndirectorForm['state']->hasError()):
                                    	    echo $oFndFndirectorForm['state']->renderError();
                                        endif;
									    echo $oFndFndirectorForm['state']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    		<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFndFndirectorForm['postal_code']->renderLabel($oFndFndirectorForm['postal_code']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFndFndirectorForm['postal_code']->hasError()):
                                    	    echo $oFndFndirectorForm['postal_code']->renderError();
                                        endif;
									    echo $oFndFndirectorForm['postal_code']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFndFndirectorForm['area_code']->renderLabel($oFndFndirectorForm['area_code']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFndFndirectorForm['area_code']->hasError()):
                                    	    echo $oFndFndirectorForm['area_code']->renderError();
                                        endif;
									    echo $oFndFndirectorForm['area_code']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    		<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFndFndirectorForm['phone']->renderLabel($oFndFndirectorForm['phone']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFndFndirectorForm['phone']->hasError()):
                                    	    echo $oFndFndirectorForm['phone']->renderError();
                                        endif;
									    echo $oFndFndirectorForm['phone']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFndFndirectorForm['fax_area_code']->renderLabel($oFndFndirectorForm['fax_area_code']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFndFndirectorForm['fax_area_code']->hasError()):
                                    	    echo $oFndFndirectorForm['fax_area_code']->renderError();
                                        endif;
									    echo $oFndFndirectorForm['fax_area_code']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    		<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFndFndirectorForm['fax_number']->renderLabel($oFndFndirectorForm['fax_number']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFndFndirectorForm['fax_number']->hasError()):
                                    	    echo $oFndFndirectorForm['fax_number']->renderError();
                                        endif;
									    echo $oFndFndirectorForm['fax_number']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>							                    		
                    		<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFndFndirectorForm['email']->renderLabel($oFndFndirectorForm['email']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFndFndirectorForm['email']->hasError()):
                                    	    echo $oFndFndirectorForm['email']->renderError();
                                        endif;
									    echo $oFndFndirectorForm['email']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    			                    		                    		                    		                    		                    		                    		                    		                    		
                    		
                    		
                    		<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oFndFndirectorForm['groups_list']->renderLabel($oFndFndirectorForm['groups_list']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oFndFndirectorForm['groups_list']->hasError()):
                                    	    echo $oFndFndirectorForm['groups_list']->renderError();
                                        endif;
									    echo $oFndFndirectorForm['groups_list']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>                    		
                    		
                    		
                        <tr>
                            <td valign="middle">
                                <?php echo $oFndFndirectorForm['is_enabled']->renderLabel($oFndFndirectorForm['is_enabled']->renderLabelName());?>
                            </td>
                            <td valign="middle" colspan="3"> <?php echo $oFndFndirectorForm['is_enabled']->render();?> </td>
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
                                                		echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>18));
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
        echo $oFndFndirectorForm->renderHiddenFields(); 
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
