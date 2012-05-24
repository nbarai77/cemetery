<?php  use_javascript('/sfFormExtraPlugin/js/double_list.js');
use_javascript('jquery-ui-timepicker-addon.js');
use_stylesheet('jquery-ui-timepicker-addon.css');
?>

<div id="wapper">
<?php 
    echo $oCemTaskNotesForm->renderFormTag(
        url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oCemTaskNotesForm->getObject()->isNew() ? '?id='.$oCemTaskNotesForm->getObject()->getId().'&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '')), 
        array("name" => $oCemTaskNotesForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );
?>
    <div class="comment_list"></div>
    <h1><?php echo $oCemTaskNotesForm->getObject()->isNew() ?  __('Add New Task Notes') : __('Edit Task Notes');?></h1>
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
                                	<?php 
                                    echo $oCemTaskNotesForm['task_title']->renderLabel($oCemTaskNotesForm['task_title']->renderLabelName()."<span class='redText'>*</span>", array('class'=>"dddddddddddddddd"));?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemTaskNotesForm['task_title']->hasError()):
                                    	    echo $oCemTaskNotesForm['task_title']->renderError();
                                        endif;
									    echo $oCemTaskNotesForm['task_title']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemTaskNotesForm['task_description']->renderLabel($oCemTaskNotesForm['task_description']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemTaskNotesForm['task_description']->hasError()):
                                    	    echo $oCemTaskNotesForm['task_description']->renderError();
                                        endif;
									    echo $oCemTaskNotesForm['task_description']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>                    		
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemTaskNotesForm['entry_date']->renderLabel($oCemTaskNotesForm['entry_date']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemTaskNotesForm['entry_date']->hasError()):
                                    	    echo $oCemTaskNotesForm['entry_date']->renderError();
                                        endif;
									    echo $oCemTaskNotesForm['entry_date']->render(); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemTaskNotesForm['due_date']->renderLabel($oCemTaskNotesForm['due_date']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemTaskNotesForm['due_date']->hasError()):
                                    	    echo $oCemTaskNotesForm['due_date']->renderError();
                                        endif;
									    echo $oCemTaskNotesForm['due_date']->render(); 
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
	                                                            'tabindex'  => 17,
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
        echo input_hidden_tag('back', $sf_params->get('back'), array('readonly' => 'true'));
        echo input_hidden_tag('tab', ($sf_params->get('tab') ? $sf_params->get('tab') :'info'), array('readonly' => 'true'));
        echo $oCemTaskNotesForm->renderHiddenFields(); 
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
