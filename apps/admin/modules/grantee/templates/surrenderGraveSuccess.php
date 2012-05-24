<?php use_javascript('/sfFormExtraPlugin/js/double_list.js');
use_javascript('jquery-ui-timepicker-addon.js');
use_stylesheet('jquery-ui-timepicker-addon.css');
use_helper('jQuery');
?>
<div id="wapper">
<?php 
	echo jq_form_remote_tag(array(
		'update'   => 'div_surrender_grave',
		'url'      => $sf_params->get('module').'/surrenderGrave?request_type=ajax_request',
	));
?>
    <div class="comment_list"></div>
    <h1><?php echo __('Surrender Grave to Grantee'); ?></h1> 
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
						<div id="div_surrender_grave">
                			<?php echo include_partial('surrenderGrave', array('oSurrenderdGraveForm' 	=> $oSurrenderdGraveForm,
																				'snIdGranteeDetailId' 	=> $snIdGranteeDetailId,
																				'amExtraParameters'		=> $amExtraParameters,
																				'snGraveId'             => $snGraveId
																			)
														);?>
						</div>
            		</div>

                </div>
            </div>
        </div>
    </div>
    <?php
        echo input_hidden_tag('grantee_id', $snIdGranteeDetailId, array('readonly' => 'true'));
		echo input_hidden_tag('id', $sf_params->get('id'), array('readonly' => 'true'));
		echo input_hidden_tag('grave_id', $snGraveId, array('readonly' => 'true'));
		echo input_hidden_tag('cemetery_id', $snCemeteryId, array('readonly' => 'true'));
        echo $oSurrenderdGraveForm->renderHiddenFields(); 
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