<?php  use_javascript('/sfFormExtraPlugin/js/double_list.js');?>
<div id="wapper">
<?php 
    echo $oArSectionForm->renderFormTag(
        url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oArSectionForm->getObject()->isNew() ? '?id='.$oArSectionForm->getObject()->getId().'&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '')), 
        array("name" => $oArSectionForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );
?>
    <div class="comment_list"></div>
    <h1><?php echo $oArSectionForm->getObject()->isNew() ?  __('Add New Section') : __('Edit Section');?></h1>
    <div id="message">
        <div id="success_msgs">
            <?php echo include_partial('global/notification_msg', array('amSuccessMsg' => $amSuccessMsg,'amErrorMsg' => $amErrorMsg));//echo $oArSectionForm->getErrorSchema();?>
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
                                	<?php echo $oArSectionForm['country_id']->renderLabel($oArSectionForm['country_id']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oArSectionForm['country_id']->hasError()):
                                    	    echo $oArSectionForm['country_id']->renderError();
                                        endif;
									    echo $oArSectionForm['country_id']->render(array('class'=>'inputBoxWidth')); 
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
									<?php echo __('Select Area');?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
										if($sf_user->hasFlash('ssErrorArea') && $sf_user->getFlash('ssErrorArea') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorArea').'</li></ul>';
											$sf_user->setFlash('ssErrorArea','');
										endif;
										include_partial('getAreaList', array('asAreaList' => $asAreaList,'snAreaId' => $snAreaId)); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oArSectionForm['section_name']->renderLabel($oArSectionForm['section_name']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oArSectionForm['section_name']->hasError()):
                                    	    echo $oArSectionForm['section_name']->renderError();
                                        endif;
									    echo $oArSectionForm['section_name']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oArSectionForm['section_code']->renderLabel($oArSectionForm['section_code']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oArSectionForm['section_code']->hasError()):
                                    	    echo $oArSectionForm['section_code']->renderError();
                                        endif;
									    echo $oArSectionForm['section_code']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oArSectionForm['first_grave']->renderLabel($oArSectionForm['first_grave']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oArSectionForm['first_grave']->hasError()):
                                    	    echo $oArSectionForm['first_grave']->renderError();
                                        endif;
									    echo $oArSectionForm['first_grave']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oArSectionForm['last_grave']->renderLabel($oArSectionForm['last_grave']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oArSectionForm['last_grave']->hasError()):
                                    	    echo $oArSectionForm['last_grave']->renderError();
                                        endif;
									    echo $oArSectionForm['last_grave']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oArSectionForm['section_user']->renderLabel($oArSectionForm['section_user']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oArSectionForm['section_user']->hasError()):
                                    	    echo $oArSectionForm['section_user']->renderError();
                                        endif;
									    echo $oArSectionForm['section_user']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oArSectionForm['section_map_path']->renderLabel($oArSectionForm['section_map_path']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oArSectionForm['section_map_path']->hasError()):
                                    	    echo $oArSectionForm['section_map_path']->renderError();
                                        endif;
									    echo $oArSectionForm['section_map_path']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                        <tr>
                            <td valign="middle">
                                <?php echo $oArSectionForm['is_enabled']->renderLabel($oArSectionForm['is_enabled']->renderLabelName());?>
                            </td>
                            <td valign="middle" colspan="3"> <?php echo $oArSectionForm['is_enabled']->render();?> </td>
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
	                                                            'tabindex'  => 11,
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
                                                		echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>12));
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
        echo $oArSectionForm->renderHiddenFields(); 
    ?>
    </form>
</div>
<?php

	if(!$sf_user->isSuperAdmin() && $oArSectionForm->getObject()->isNew() && !sfContext::getInstance()->getRequest()->isMethod('post'))
	{
		$snCemeteryId = $sf_user->getAttribute('cemeteryid');
		 echo javascript_tag("
			jQuery(document).ready(function() 
				{
					".
					// Ger area list as per cemetery.
					jq_remote_function(
						array('url'		=> url_for('section/getAreaListAsPerCemetery'),
							  'update'	=> 'section_area_list',
							  'with'	=> "'cemetery_id='+".$snCemeteryId."+'&country_id='+$('#section_country_id').val()",
							  'loading' => '$("#IdAjaxLocaderArea").show();',
							  'complete'=> '$("#IdAjaxLocaderArea").hide();'))
					."
				});
			");
	}

    echo javascript_tag('
        ssTags = document.getElementsByTagName("INPUT");
        document.getElementById(ssTags[0].id).select();
        document.getElementById(ssTags[0].id).focus();'
    );
    
    echo javascript_tag("
        jQuery(document).ready(function() 
		{
			var snCountryId = jQuery('#section_country_id').val();
			var snCemeteryId = $('#section_cem_cemetery_id option').length;
			if(snCountryId > 0 && snCemeteryId == 1)
				callAjaxRequest(snCountryId,'".url_for('section/getCementryListAsPerCountry')."','section_cementery_list');
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
