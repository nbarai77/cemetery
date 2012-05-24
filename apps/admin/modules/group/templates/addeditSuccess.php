<?php  use_javascript('/sfFormExtraPlugin/js/double_list.js');?>
<div id="wapper">
<?php 
    echo $oSfGuardGroupForm->renderFormTag(
        url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oSfGuardGroupForm->getObject()->isNew() ? '?id='.$oSfGuardGroupForm->getObject()->getId().'&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '')), 
        array("name" => $oSfGuardGroupForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );
?>
    <div class="comment_list"></div>
    <h1><?php echo $oSfGuardGroupForm->getObject()->isNew() ?  __('Add New Group') : __('Edit Group');?></h1>
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
                                	<?php echo $oSfGuardGroupForm['name']->renderLabel($oSfGuardGroupForm['name']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oSfGuardGroupForm['name']->hasError()):
                                    	    echo $oSfGuardGroupForm['name']->renderError();
                                        endif;
									    echo $oSfGuardGroupForm['name']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    		<tr>
                            	<td valign="top" align="right" width="20%">
                            		<span class="redText"></span>
                            		<?php 
                            		    echo $oSfGuardGroupForm['description']->renderLabel($oSfGuardGroupForm['description']->renderLabelName()."<span class='redText'>*</span>");
                            	    ?>
                        		</td>
                            	<td valign="middle">
                                	<?php 
                                	    if($oSfGuardGroupForm['description']->hasError()):
                                    	    echo $oSfGuardGroupForm['description']->renderError();
                                        endif;
                                 	    echo $oSfGuardGroupForm['description']->render(array('class'=>'textAreaWidth')); 
                                    ?> 
                                </td>
                    		</tr>
                    		
                           	<?php  if($oSfGuardGroupForm['permissions_list']->hasError()): ?>
                            		<tr>
                                    	<td valign="middle">&nbsp;</td>
                                    	<td valign="middle"><?php echo $oSfGuardGroupForm['permissions_list']->renderError();?></td>
                            		</tr>
                                	<?php endif; ?>
                        		<tr>
                                	<td valign="top" align="right" width="20%">
                                		<span class="redText">&nbsp;&nbsp;</span>
                                		<?php echo $oSfGuardGroupForm['permissions_list']->renderLabel($oSfGuardGroupForm['permissions_list']->renderLabelName());?>
	
                            		</td>
                            		<td valign="middle"> <?php echo $oSfGuardGroupForm['permissions_list']->render(array('value' => array('3' => 'user'))); ?> </td>
                            	</tr>
                    		<tr>                    		
                    		
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
	                                                            'tabindex'  => 1,
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
                                                		echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>1));
                                                    ?>
                                    			</span>
                                    		</li>
                            			</ul>
                                	</div>
                        		</td>
                        	</tr>
                		</table>
            		</div>
            		
            		
            		<div id="permission">
                		<table width="100%" border="0" cellspacing="12" cellpadding="0" class="sub_table">
                            	<?php  if($oSfGuardGroupForm['permissions_list']->hasError()): ?>
                            		<tr>
                                    	<td valign="middle">&nbsp;</td>
                                    	<td valign="middle"><?php echo $oSfGuardGroupForm['permissions_list']->renderError();?></td>
                            		</tr>
                                	<?php endif; ?>
                        		<tr>
                                	<td valign="top" align="right" width="20%">
                                		<span class="redText">&nbsp;&nbsp;</span>
                                		<?php echo $oSfGuardGroupForm['permissions_list']->renderLabel($oSfGuardGroupForm['permissions_list']->renderLabelName());?>
	
                            		</td>
                            		<td valign="middle"> <?php echo $oSfGuardGroupForm['permissions_list']->render(array('value' => array('3' => 'user'))); ?> </td>
                            	</tr>
                    		<tr>
                            	<td>&nbsp;</td>
                        		<td valign="middle">
                                	<div class="actions">
                                		<ul class="fleft">
                                        	<li class="list1">
                                        		<span>
	                                                <?php echo submit_tag(
	                                                        __('Save'), 
	                                                        array(
	                                                            'class'     => 'delete',
	                                                            'name'      => 'submit_button',
	                                                            'title'     => __('Save'), 
	                                                            'tabindex'  => 1,
	                                                            'onclick'   => 'jQuery("#tab").val("");'
	                                                        )
	                                                    );
	                                                ?>
                                        		</span>
                                        	</li>
                                        	<li class="list1">
                                        		<span>
	                                                <?php echo submit_tag(
	                                                        __('Save & continue'), 
	                                                        array(
	                                                            'class'     => 'delete',
	                                                            'name'      => 'submit_button',
	                                                            'title'     => __('Save & continue'), 
	                                                            'tabindex'  => 1,
	                                                        )
	                                                    );
	                                                ?>
                                        		</span>
                                        	</li>
                                		    <li class="list1">
                                        	    <span>
                                        		<?php  
                                        		    $ssCancelUrl    = $sf_params->get('module').'/index?'.html_entity_decode($amExtraParameters['ssQuerystr']);
                                                	echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>1));
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
                <div class="clearb">&nbsp;</div>
            </div>
        </div>
    </div>
    <div class="clearb">&nbsp;</div>
    <div class="clearb">&nbsp;</div>
    <?php
        echo input_hidden_tag('id', $sf_params->get('id'), array('readonly' => 'true'));
        echo input_hidden_tag('tab', ($sf_params->get('tab') ? $sf_params->get('tab') :'info'), array('readonly' => 'true'));
        echo $oSfGuardGroupForm->renderHiddenFields(); 
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
