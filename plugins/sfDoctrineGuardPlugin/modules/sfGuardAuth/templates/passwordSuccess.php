<?php use_helper('I18N','JavascriptBase') ?>
<form action="<?php echo url_for('@sf_guard_change_password') ?>" method="post" name="<?php echo $omForm->getName(); ?>">
    <div id="wapper"> 
        <div class="clearb">&nbsp;</div>
        <div id="success_msgs"><?php 
            if ($sf_user->hasFlash('snSuccessMsgKey') && $sf_user->getFlash('snSuccessMsgKey') == 1):
                echo "<div class='succ-msg'>".__('Password has been changed successfully')."</div>"; $sf_user->setFlash('snSuccessMsgKey','');
            endif;
            if ($sf_user->hasFlash('snErrorMsgKey') && $sf_user->getFlash('snErrorMsgKey') == 1):
                echo "<div class='error-msg'>".__('Please enter valid old password')."</div>";  $sf_user->setFlash('snErrorMsgKey','');
            endif; ?>
        </div>
        <div  style="width:100%; margin:0px auto;">
        <div id="main" class="login_main" style="float:none;">
            <div class="maintablebg Login">
                <ul>
                    <li class="active"><?php echo __('Change password');?></li>
                </ul>
                <div class="main_cont">
                    <table cellspacing="0" cellpadding="5" border="0" align="center" class="login_plane">
                        <tr>
                            <td align="right"><?php echo $omForm['password']->renderLabel() ?><span class="redText">*&nbsp;</span></td>
                            <td> 
                                <?php 
                                    if($omForm['password']->hasError()):
                                        echo $omForm['password']->renderError();
                                    endif;
                                    echo $omForm['password']->render(array('class'=>'logintextbox','maxlength'=>'35','size'=>'27')); 
                                ?> 
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo $omForm['new_password']->renderLabel() ?><span class="redText">*&nbsp;</span></td>
                            <td> 
                                <?php 
                                    if($omForm['new_password']->hasError()):
                                        echo $omForm['new_password']->renderError();
                                    endif;
                                    echo $omForm['new_password']->render(array('class'=>'logintextbox','maxlength'=>'35','size'=>'27')); 
                                ?> 
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo $omForm['confirm_password']->renderLabel() ?><span class="redText">*&nbsp;</span></td>
                            <td> 
                                <?php 
                                    if($omForm['confirm_password']->hasError()):
                                        echo $omForm['confirm_password']->renderError();
                                    endif;
                                    echo $omForm['confirm_password']->render(array('class'=>'logintextbox','maxlength'=>'35','size'=>'27')); 
                                ?> 
                            </td>
                        </tr>
                        <tr>
                            <td align="right" valign="top">&nbsp;</td>
                            <td align="left" valign="top">
                                <div class="button">
                                    <ul>
                                        <li class="list1">
                                            <span class="blue">
                                                <?php echo submit_tag(__('Change password'), array('value' => __('Change password'),'style'=>'border: medium none ; cursor: pointer;','name'=>'changepassword','title'=>__('Change password'))); ?>
                                            </span>
                                        </li>
                                        <li class="list1">
                                            <span>
                                                <?php  echo button_to(__('Cancel'),'@homepage',array('class'=>'delete','style'=>'border: medium none ; cursor: pointer;','title'=>__('Cancel'),'alt'=>__('Cancel')));?>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        </div>
        <div class="clearb">&nbsp;</div>
        <div class="clearb">&nbsp;</div>
    </div>
    <?php  echo $omForm->renderHiddenFields(); ?>
</form>
