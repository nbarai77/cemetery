<?php  use_javascript('/sfFormExtraPlugin/js/double_list.js'); ?>
<div id="wapper">
	<?php
		echo $osfGuardAdminsForm->renderFormTag(
			url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$osfGuardAdminsForm->getObject()->isNew() ? '?id='.$osfGuardAdminsForm->getObject()->getId().'&tab=info&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '?tab=info')), 
			array("name" => $osfGuardAdminsForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
		);
	?>	
	
    <div class="comment_list"></div>
    <h1><?php echo $sf_params->get('id') ?  __('Edit Admin') : __('Add New Admin');?></h1>
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
                            <?php foreach($osfGuardAdminsForm as $ssKey => $asField): ?>
                            <?php if($ssKey == 'group_id') { ?>
								
                            <?php } ?>
                            <tr>
                                <td valign="middle" align="right" width="20%">
                                    <?php
                                        if($ssKey != 'id' && $ssKey != '_csrf_token'):
                                            if($osfGuardAdminsForm->getWidget($ssKey)->getAttribute('type') != 'hidden' && $osfGuardAdminsForm->getValidator($ssKey)->getOption('required') == true) :
                                                echo $asField->renderLabel($asField->renderLabelName()."<span class='redText'>*</span>");
                                            else:
                                                echo $asField->renderLabel(null, array());
                                            endif;
                                        endif;
                                    ?>
                                </td>
                                <?php if($osfGuardAdminsForm->getWidget($ssKey)->getAttribute('type') != 'hidden' || $ssKey == 'username') : 
								$ssClass = ($ssKey != 'is_active') ? array('class' => 'inputBoxWidth') : array();
								?>
                                <td valign="middle" width="80%">
                                    <?php 
                                        if($asField->hasError()):
                                    	    echo $asField->renderError();
                                        endif;
                                        if($ssKey == 'username')
                                            echo ($osfGuardAdminsForm->getObject()->isNew()) ? $asField->render($ssClass) : '<strong>&nbsp;&nbsp;&nbsp;&nbsp;'.$osfGuardAdminsForm[$ssKey]->getValue().'</strong>';
                                        else    
                                            echo $asField->render($ssClass);
                                    ?> 
                                </td>
                                <?php endif; ?>
                            </tr>
                            
                            <?php endforeach; ?>
                            <tr>
                            	<td>&nbsp;</td>
                                <td valign="top">
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
                        <?php
                            echo input_hidden_tag('sf_guard_user[id]', $sf_params->get('id'), array('readonly' => 'true'));
                            echo input_hidden_tag('tab', ($sf_params->get('tab') ? $sf_params->get('tab') :'info'), array('readonly' => 'true'));
                            echo $osfGuardAdminsForm->renderHiddenFields(); 
                        ?>
                        </form>
                    </div>
                   
                </div>
                <div class="clearb"></div>
            </div>
        </div>
    </div>
    
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
            var asTabs      = new Array('user_info','user_affiliation');
            var asUpdateDiv = new Array('info','affiliation'); 
            
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
