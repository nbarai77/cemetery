<?php  use_helper('Form','I18N','jQuery'); ?>
<div id="wapper">
<?php     
    echo $oCalTemplateForm->renderFormTag(url_for($sf_params->get('module').'/'.$sf_params->get('action')), array("name" => $oCalTemplateForm->getName(), "method" => "post","class"=>"nyroModal"));    
    echo $oCalTemplateForm->renderHiddenFields();
?>
    <h1><?php echo __('New template');?></h1>

    <div id="main">
        <div class="maintablebg">
            <div class="main_cont">
                <div class="left_part">
                    <table width="100%" border="0" cellspacing="12" cellpadding="0" class="sub_table">

                        <?php if($oCalTemplateForm['name']->hasError()):?>
                        <tr>
                            <td valign="top">&nbsp;</td>
                            <td valign="top"><?php echo $oCalTemplateForm['name']->renderError();?></td>
                        </tr>
                        <?php endif; ?>

                        <tr>
                            <td valign="top">
                                <span class="redText">&nbsp;&nbsp;</span>
                                <?php echo $oCalTemplateForm['name']->renderLabel($oCalTemplateForm['name']->renderLabelName()."<span class='redText'>*</span>");?>
                            </td>

                            <td valign="top"><?php echo $oCalTemplateForm['name']->render(); ?> </td>
                        </tr>

                        <?php if($oCalTemplateForm['description']->hasError()):?>
                        <tr>
                            <td valign="top">&nbsp;</td>
                            <td valign="top"><?php echo $oCalTemplateForm['description']->renderError();?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td valign="top">
                                <span class="redText">&nbsp;&nbsp;</span>
                                <?php echo $oCalTemplateForm['description']->renderLabel($oCalTemplateForm['description']->renderLabelName()."<span class='redText'>*</span>");?>
                            </td>
                            <td valign="top"> <?php echo $oCalTemplateForm['description']->render(); ?> </td>
                        </tr>
<!--Start New widget -->                        
                        <tr>
                            <td valign="top">
                                <span class="redText">&nbsp;&nbsp;</span>
                                <?php echo $oCalTemplateForm['start_time']->renderLabel($oCalTemplateForm['start_time']->renderLabelName()."<span class='redText'>*</span>");?>
                            </td>
                            <td valign="top"> <?php echo $oCalTemplateForm['start_time']->render(); ?> </td>
                        </tr>

                        <tr>
                            <td valign="top">
                                <span class="redText">&nbsp;&nbsp;</span>
                                <?php echo $oCalTemplateForm['end_time']->renderLabel($oCalTemplateForm['end_time']->renderLabelName()."<span class='redText'>*</span>");?>
                            </td>
                            <td valign="top"> <?php echo $oCalTemplateForm['end_time']->render(); ?> </td>
                        </tr>

                        <tr>
                            <td valign="top">
                                <span class="redText">&nbsp;&nbsp;</span>
                                <?php echo $oCalTemplateForm['duration']->renderLabel($oCalTemplateForm['duration']->renderLabelName()."<span class='redText'>*</span>");?>
                            </td>
                            <td valign="top"> <?php echo $oCalTemplateForm['duration']->render(); ?> </td>
                        </tr>
                     
                        <tr>
                            <td valign="top">
                                <span class="redText">&nbsp;&nbsp;</span>
                                <?php echo $oCalTemplateForm['night_job']->renderLabel($oCalTemplateForm['night_job']->renderLabelName());?>
                            </td>
                            <td valign="top"> <?php echo $oCalTemplateForm['night_job']->render(); ?> </td>
                        </tr>

                        <tr>
                            <td valign="top">
                                <span class="redText">&nbsp;&nbsp;</span>
                                <?php echo $oCalTemplateForm['week_end']->renderLabel($oCalTemplateForm['week_end']->renderLabelName());?>
                            </td>
                            <td valign="top"> <?php echo $oCalTemplateForm['week_end']->render(); ?> </td>
                        </tr>
<!--End New widget -->        
                        <tr>
                            <td valign="top">
                                <div class="actions">
                                    <ul class="fleft">
                                        <li class="list1">
                                            <span>
                                                <?php echo submit_tag(__('Submit'), array('class'=>'delete','name'=>'submit_button','title'=>__('btn_submit'),'tabindex'=>1));?>
                                            </span>
                                        </li>
                                        <li class="list1">
                                            <span>
                                                <?php  $ssCancelUrl    = $sf_params->get('module').'/index';
                                                       echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>1));?>
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
    </form>
</div>
<?php
        echo javascript_tag("
                jQuery('#cal_template_start_time').timepicker({});
                jQuery('#cal_template_end_time').timepicker({});
                jQuery('#cal_template_duration').timepicker({});
        ");
    if($sf_user->getFlash('ssSuccessMsgKey')):
        echo javascript_tag("
                jQuery(window.location).attr('href', window.location.pathname);
        ");
    endif;
?>