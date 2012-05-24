<?php use_javascript('/sfFormExtraPlugin/js/double_list.js');
use_helper('jQuery');
?>
<div id="wapper">
<?php 
	echo jq_form_remote_tag(array(
		'update'   => 'div_finalized_booking',
		'url'      => $sf_params->get('module').'/finalized?request_type=ajax_request',
	));
?>
    <div class="comment_list"></div>
    <h1><?php echo __('Interment Date'); ?></h1> 
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
						<div id="div_finalized_booking">
                			<?php echo include_partial('finalizedBooking', array('oFinalizedBookingForm' 	=> $oFinalizedBookingForm,
																				'amExtraParameters'			=> $amExtraParameters,
																				'ssControlNumber'			=> $ssControlNumber
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
		echo input_hidden_tag('is_finalise', '', array('readonly' => true));
        echo $oFinalizedBookingForm->renderHiddenFields(); 
    ?>
    </form>
</div>

