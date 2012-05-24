<?php  use_javascript('/sfFormExtraPlugin/js/double_list.js');?>
<div id="wapper">
<?php 
    echo $oCemCemeteryForm->renderFormTag(
        url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oCemCemeteryForm->getObject()->isNew() ? '?id='.$oCemCemeteryForm->getObject()->getId().'&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '')), 
        array("name" => $oCemCemeteryForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );
?>
    <div class="comment_list"></div>
    <h1><?php echo $oCemCemeteryForm->getObject()->isNew() ?  __('Add New Cemetery') : __('Edit Cemetery');?></h1>
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
                    		<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemCemeteryForm['country_id']->renderLabel($oCemCemeteryForm['country_id']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemCemeteryForm['country_id']->hasError()):
                                    	    echo $oCemCemeteryForm['country_id']->renderError();
                                        endif;
									    echo $oCemCemeteryForm['country_id']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>							
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemCemeteryForm['name']->renderLabel($oCemCemeteryForm['name']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemCemeteryForm['name']->hasError()):
                                    	    echo $oCemCemeteryForm['name']->renderError();
                                        endif;
									    echo $oCemCemeteryForm['name']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    		<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemCemeteryForm['description']->renderLabel($oCemCemeteryForm['description']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemCemeteryForm['description']->hasError()):
                                    	    echo $oCemCemeteryForm['description']->renderError();
                                        endif;
									    echo $oCemCemeteryForm['description']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    		<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemCemeteryForm['url']->renderLabel($oCemCemeteryForm['url']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemCemeteryForm['url']->hasError()):
                                    	    echo $oCemCemeteryForm['url']->renderError();
                                        endif;
									    echo $oCemCemeteryForm['url']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    		<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemCemeteryForm['address']->renderLabel($oCemCemeteryForm['address']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemCemeteryForm['address']->hasError()):
                                    	    echo $oCemCemeteryForm['address']->renderError();
                                        endif;
									    echo $oCemCemeteryForm['address']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    		<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemCemeteryForm['suburb_town']->renderLabel($oCemCemeteryForm['suburb_town']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemCemeteryForm['suburb_town']->hasError()):
                                    	    echo $oCemCemeteryForm['suburb_town']->renderError();
                                        endif;
									    echo $oCemCemeteryForm['suburb_town']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    		<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemCemeteryForm['state']->renderLabel($oCemCemeteryForm['state']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemCemeteryForm['state']->hasError()):
                                    	    echo $oCemCemeteryForm['state']->renderError();
                                        endif;
									    echo $oCemCemeteryForm['state']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    		<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemCemeteryForm['postcode']->renderLabel($oCemCemeteryForm['postcode']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemCemeteryForm['postcode']->hasError()):
                                    	    echo $oCemCemeteryForm['postcode']->renderError();
                                        endif;
									    echo $oCemCemeteryForm['postcode']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemCemeteryForm['area_code']->renderLabel($oCemCemeteryForm['area_code']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemCemeteryForm['area_code']->hasError()):
                                    	    echo $oCemCemeteryForm['area_code']->renderError();
                                        endif;
									    echo $oCemCemeteryForm['area_code']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    		<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemCemeteryForm['phone']->renderLabel($oCemCemeteryForm['phone']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemCemeteryForm['phone']->hasError()):
                                    	    echo $oCemCemeteryForm['phone']->renderError();
                                        endif;
									    echo $oCemCemeteryForm['phone']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemCemeteryForm['fax_area_code']->renderLabel($oCemCemeteryForm['fax_area_code']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemCemeteryForm['fax_area_code']->hasError()):
                                    	    echo $oCemCemeteryForm['fax_area_code']->renderError();
                                        endif;
									    echo $oCemCemeteryForm['fax_area_code']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    		<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemCemeteryForm['fax']->renderLabel($oCemCemeteryForm['fax']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemCemeteryForm['fax']->hasError()):
                                    	    echo $oCemCemeteryForm['fax']->renderError();
                                        endif;
									    echo $oCemCemeteryForm['fax']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    		<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemCemeteryForm['email']->renderLabel($oCemCemeteryForm['email']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemCemeteryForm['email']->hasError()):
                                    	    echo $oCemCemeteryForm['email']->renderError();
                                        endif;
									    echo $oCemCemeteryForm['email']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemCemeteryForm['cemetery_map_path']->renderLabel($oCemCemeteryForm['cemetery_map_path']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemCemeteryForm['cemetery_map_path']->hasError()):
                                    	    echo $oCemCemeteryForm['cemetery_map_path']->renderError();
                                        endif;
									    echo $oCemCemeteryForm['cemetery_map_path']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    			                    		                    		                    		                    		                    		                    		                    		                    		
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemCemeteryForm['latitude']->renderLabel($oCemCemeteryForm['latitude']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="40%" colspan="3">
                                	<?php 
                                	    if($oCemCemeteryForm['latitude']->hasError()):
                                    	    echo $oCemCemeteryForm['latitude']->renderError();
                                        endif;
									    echo $oCemCemeteryForm['latitude']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>                                
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemCemeteryForm['longitude']->renderLabel($oCemCemeteryForm['longitude']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="40%" colspan="3">
                                	<?php 
                                	    if($oCemCemeteryForm['longitude']->hasError()):
                                    	    echo $oCemCemeteryForm['longitude']->renderError();
                                        endif;
									    echo $oCemCemeteryForm['longitude']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>                                
                    		</tr>                    		
                        <tr>
                            <td valign="middle">
                                <?php echo $oCemCemeteryForm['is_enabled']->renderLabel($oCemCemeteryForm['is_enabled']->renderLabelName());?>
                            </td>
                            <td valign="middle" colspan="3"> <?php echo $oCemCemeteryForm['is_enabled']->render();?> </td>
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
	                                                            'tabindex'  => 18,
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
                                                		echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'), 'tabindex'=> 19));
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
        echo $oCemCemeteryForm->renderHiddenFields(); 
    ?>
    </form>
</div>
<?php 
    echo javascript_tag('
        ssTags = document.getElementsByTagName("select");
        //document.getElementById(ssTags[0].id).select();
        document.getElementById(ssTags[1].id).focus();'
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
