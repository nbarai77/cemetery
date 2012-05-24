<div id="wapper">
<?php 
    echo $oSfGuardPermissionForm->renderFormTag(url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oSfGuardPermissionForm->getObject()->isNew() ? '?id='.$oSfGuardPermissionForm->getObject()->getId().'&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '')), array("name" => $oSfGuardPermissionForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data'));
?>
    <div class="comment_list"></div>
    <h1><?php echo $oSfGuardPermissionForm->getObject()->isNew() ?  __('Add New Permission') : __('Edit Permission');?></h1>

    <div class="clearb">&nbsp;</div>
    <ul class="tab_content">
	    <li id="user_info" class="active">
	        <?php 
	            echo link_to_function(
	                __('Info'), 
	                'tabSelection("info", "active");', 
	                array('title' => __('Info'))
	            ); 
	        ?>
	    </li>
	</ul>

    <div id="main">
        <div class="maintablebg">
            <div class="main_cont">
                <div class="left_part">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="sub_table">
                        <tr>
                            <td valign="middle" width="20%">
                                <span class="redText">&nbsp;&nbsp;</span>
                                <?php echo $oSfGuardPermissionForm['name']->renderLabel($oSfGuardPermissionForm['name']->renderLabelName()."<span class='redText'>*</span>");?>
                            </td>

                            <td valign="middle" width="80%">
                            	<?php if($oSfGuardPermissionForm['name']->hasError()):?>
                                	<?php echo $oSfGuardPermissionForm['name']->renderError();?>
                                <?php endif; ?>
								<?php echo $oSfGuardPermissionForm['name']->render(array('class'=>'inputBoxWidth')); ?> 
                                
                            </td>
                        </tr>
                       
                        <tr>
                            <td valign="top">
                                <span class="redText">&nbsp;&nbsp;</span>
                                <?php echo $oSfGuardPermissionForm['description']->renderLabel($oSfGuardPermissionForm['description']->renderLabelName()."<span class='redText'>*</span>");?>
                            </td>
                            <td valign="middle"> 
                            	<?php if($oSfGuardPermissionForm['description']->hasError()):?>
 		                               <?php echo $oSfGuardPermissionForm['description']->renderError();?>
                                <?php endif; ?>   
								<?php echo $oSfGuardPermissionForm['description']->render(array('class'=>'textAreaWidth')); ?> 
                                                            
                           </td>
                        </tr>
                        <tr>
							<td>&nbsp;</td>
                            <td valign="middle">
                                <div class="actions">
                                    <ul class="fleft">
                                        <li class="list1">
                                            <span>
                                                <?php echo submit_tag(__('Save'), array('class'=>'delete','name'=>'submit_button','title'=>__('Save'), 'tabindex' => 1));?>
                                            </span>
                                        </li>
                                    <li class="list1">
                                        <span>
                                            <?php  $ssCancelUrl    = $sf_params->get('module').'/index?'.html_entity_decode($amExtraParameters['ssQuerystr']);
                                                    echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'), 'tabindex' => 1));?>
                                        </span>
                                    </li>
                                </ul>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="clearb">&nbsp;</div>
            </div>
        </div>
    </div>
    <div class="clearb">&nbsp;</div>
    <div class="clearb">&nbsp;</div>
    <?php  
        echo input_hidden_tag('Next','Next');
        echo input_hidden_tag('id', $sf_params->get('id'), array('readonly' => 'true'));
        echo $oSfGuardPermissionForm->renderHiddenFields(); 
    ?>
    </form>
</div>
<?php
    echo javascript_tag('
        ssTags = document.getElementsByTagName("INPUT");
        document.getElementById(ssTags[0].id).select();
        document.getElementById(ssTags[0].id).focus();'
    );        
?>

<?php
    echo javascript_tag("
        jQuery(document).ready(function() 
            {
				$('table').find('tr:visible:odd').addClass('even').end().find('tr:visible:even').addClass('odd');
                
            });
    ");
?>
