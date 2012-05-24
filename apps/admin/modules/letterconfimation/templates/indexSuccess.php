<?php  use_javascript('/sfFormExtraPlugin/js/double_list.js');?>
<div id="wapper">
<?php 
if($bInvalidOrExpireLink):
    echo $oLetterConfirmationForm->renderFormTag(
        url_for($sf_params->get('module').'/'.$sf_params->get('action')), 
        array("name" => $oLetterConfirmationForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );?>
    <div class="comment_list"></div>
    <h1><?php echo __('Letter Attachment');?></h1>
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
                		<table width="100%" border="0" cellspacing="0" cellpadding="15" class="sub_table">
							<tr>
                            	<td valign="middle" align="right" width="20%">
									<?php echo $oLetterConfirmationForm['confirmed']->renderLabel($oLetterConfirmationForm['confirmed']->renderLabelName());?>
								</td>
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oLetterConfirmationForm['confirmed']->hasError()):
                                    	    echo $oLetterConfirmationForm['confirmed']->renderError();
                                        endif;
									    echo $oLetterConfirmationForm['confirmed']->render(); 
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
	                                                        __('Submit'), 
	                                                        array(
	                                                            'class'     => 'delete',
	                                                            'name'      => 'submit_button',
	                                                            'title'     => __('Submit'), 
	                                                            'tabindex'  => 2,
	                                                            'onclick'   => "jQuery('#tab').val('');"
	                                                        )
	                                                    );
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
	<?php
        echo input_hidden_tag('id', $snBookingFiveId, array('readonly' => 'true'));
		echo input_hidden_tag('token', $ssToken, array('readonly' => 'true'));
		echo input_hidden_tag('content_type', $ssContentType, array('readonly' => 'true'));
        echo $oLetterConfirmationForm->renderHiddenFields(); 
    ?>
    </form>
<?php else:?>
		<div><h1 style="color:#F00000;"><?php echo __('The link has been expired!');?><h1></div>
<?php endif;?>
</div>
<?php 
    echo javascript_tag('
        ssTags = document.getElementsByTagName("INPUT");
        document.getElementById(ssTags[0].id).select();
        document.getElementById(ssTags[0].id).focus();

		jQuery(document).ready(function() 
		{
			$("table").find("tr:visible:odd").addClass("odd").end().find("tr:visible:even").addClass("even");
		});		
	');
?>
