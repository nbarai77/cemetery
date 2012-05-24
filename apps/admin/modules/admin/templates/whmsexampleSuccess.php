<?php  use_javascript('/sfFormExtraPlugin/js/double_list.js');?>
<div id="wapper">
<?php 
    echo $OmWhmsClientForm->renderFormTag(
        url_for($sf_params->get('module').'/'.$sf_params->get('action')), 
        array("name" => $OmWhmsClientForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );
?>
    <div class="comment_list"></div>
    <h1><?php echo __('Add Bill detail');?></h1>
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
							<?php //if($sf_user->isSuperAdmin()):?>
                    		<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $OmWhmsClientForm['clients']->renderLabel($OmWhmsClientForm['clients']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($OmWhmsClientForm['clients']->hasError()):
                                    	    echo $OmWhmsClientForm['clients']->renderError();
                                        endif;
									    echo $OmWhmsClientForm['clients']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>							
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $OmWhmsClientForm['description']->renderLabel($OmWhmsClientForm['description']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($OmWhmsClientForm['description']->hasError()):
                                    	    echo $OmWhmsClientForm['description']->renderError();
                                        endif;
									    echo $OmWhmsClientForm['description']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $OmWhmsClientForm['amount']->renderLabel($OmWhmsClientForm['amount']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($OmWhmsClientForm['amount']->hasError()):
                                    	    echo $OmWhmsClientForm['amount']->renderError();
                                        endif;
									    echo $OmWhmsClientForm['amount']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $OmWhmsClientForm['recur']->renderLabel($OmWhmsClientForm['recur']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($OmWhmsClientForm['recur']->hasError()):
                                    	    echo $OmWhmsClientForm['recur']->renderError();
                                        endif;
									    echo $OmWhmsClientForm['recur']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $OmWhmsClientForm['recurcycle']->renderLabel($OmWhmsClientForm['recurcycle']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($OmWhmsClientForm['recurcycle']->hasError()):
                                    	    echo $OmWhmsClientForm['recurcycle']->renderError();
                                        endif;
									    echo $OmWhmsClientForm['recurcycle']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $OmWhmsClientForm['recurfor']->renderLabel($OmWhmsClientForm['recurfor']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($OmWhmsClientForm['recurfor']->hasError()):
                                    	    echo $OmWhmsClientForm['recurfor']->renderError();
                                        endif;
									    echo $OmWhmsClientForm['recurfor']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                            
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $OmWhmsClientForm['invoiceaction']->renderLabel($OmWhmsClientForm['invoiceaction']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($OmWhmsClientForm['invoiceaction']->hasError()):
                                    	    echo $OmWhmsClientForm['invoiceaction']->renderError();
                                        endif;
									    echo $OmWhmsClientForm['invoiceaction']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                            <tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $OmWhmsClientForm['duedate']->renderLabel($OmWhmsClientForm['duedate']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($OmWhmsClientForm['duedate']->hasError()):
                                    	    echo $OmWhmsClientForm['duedate']->renderError();
                                        endif;
									    echo $OmWhmsClientForm['duedate']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                            
                            <?php /*
                        <tr>
                            <td valign="middle">
                                <?php echo $oArAreaForm['is_enabled']->renderLabel($oArAreaForm['is_enabled']->renderLabelName());?>
                            </td>
                            <td valign="middle" colspan="3"> <?php echo $oArAreaForm['is_enabled']->render();?> </td>
                        </tr> */?>
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
	                                                            'tabindex'  => 10,
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
                                                		echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>11));
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
        echo $OmWhmsClientForm->renderHiddenFields(); 
    ?>
    </form>
</div>