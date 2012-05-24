<?php use_javascript('/sfFormExtraPlugin/js/double_list.js');
use_helper('jQuery');
use_javascript('jquery-ui-timepicker-addon.js');
use_stylesheet('jquery-ui-timepicker-addon.css');
?>
<div id="wapper">
<?php 
	echo jq_form_remote_tag(array(
		'update'   => 'div_purchase_grave',
		'url'      => $sf_params->get('module').'/PurchaseGrave?request_type=ajax_request',
	));
?>
    <div class="comment_list"></div>
    <h1><?php echo __('Grave Purchase'); ?></h1> 
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
						<div id="div_purchase_grave">
                			<?php echo include_partial('purchaseGrave', array('oPurchaseGraveForm' 	=> $oPurchaseGraveForm,
																				'amExtraParameters'	=> $amExtraParameters
																			)
														);?>
						</div>
            		</div>
                </div>
            </div>
        </div>
    </div>
    <?php
		echo input_hidden_tag('id', $sf_params->get('id'), array('readonly' => 'true'));
        echo $oPurchaseGraveForm->renderHiddenFields(); 
    ?>
    </form>
</div>