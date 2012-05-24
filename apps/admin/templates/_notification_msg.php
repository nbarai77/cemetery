<?php
    if($sf_user->getFlash('snSuccessMsgKey') != 0):
        echo "<div class='succ-msg'><span>".html_entity_decode($amSuccessMsg[$sf_user->getFlash('snSuccessMsgKey')])."</span></div>";
        $sf_user->setFlash('snSuccessMsgKey','');
    endif;
    if($sf_user->getFlash('snErrorMsgKey') != 0):
        echo "<div class='error-msg'><span>".html_entity_decode($amErrorMsg[$sf_user->getFlash('snErrorMsgKey')])."</span></div>";
        $sf_user->setFlash('snErrorMsgKey','');
    endif; 
?>