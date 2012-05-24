<?php  use_javascript('/sfFormExtraPlugin/js/double_list.js');?>
<div id="wapper">
<?php 
    echo $oCustomCemeteryForm->renderFormTag( url_for($sf_params->get('module').'/customCemetery'), 
	array("name" => $oCustomCemeteryForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')); ?>

    <div class="comment_list"></div>
    <h1><?php echo __('Select Cemetery to Show %type%', array('%type%' => ($ssType == 'letter') ? __('Letters') : __('Certificates')));?></h1>
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
                    		<tr>
								<td valign="middle" align="right" width="30%">
									<?php echo $oCustomCemeteryForm['country_id']->renderLabel($oCustomCemeteryForm['country_id']->renderLabelName()."<span class='redText'>*</span>");?>
								</td>
						
								<td valign="middle" width="70%">
									<?php 
										if($oCustomCemeteryForm['country_id']->hasError()):
											echo $oCustomCemeteryForm['country_id']->renderError();
										endif;
										echo $oCustomCemeteryForm['country_id']->render(array('class'=>'inputBoxWidth')); 
									?>
								</td>
							</tr>							
						
							<tr>
								<td valign="middle" align="right" width="30%">
									<?php echo __('Select Cementery')."<span class='redText'>*</span>"?>
								</td>
						
								<td valign="middle" width="70%">
									<?php 
										if($sf_user->hasFlash('ssErrorCemeter') && $sf_user->getFlash('ssErrorCemeter') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorCemeter').'</li></ul>';
											$sf_user->setFlash('ssErrorCemeter','');
										endif;
										include_partial('getCementeryList', array('asCementryList' => $asCementery,'snCementeryId' => $snCementeryId)); 
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
	                                                        ($ssType == 'letter') ? __('Show Letters') : __('Show Certificates'), 
	                                                        array(
	                                                            'class'     => 'delete',
	                                                            'name'      => 'submit_button',
	                                                            'title'     => ($ssType == 'letter') ? __('Show Letters') : __('Show Certificates'), 
	                                                            'tabindex'  => 3,
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
    <div class="clearb">&nbsp;</div>
    <?php
        echo input_hidden_tag('id', $sf_params->get('id'), array('readonly' => 'true'));
        echo input_hidden_tag('tab', ($sf_params->get('tab') ? $sf_params->get('tab') :'info'), array('readonly' => 'true'));
        echo input_hidden_tag('type', $ssType, array('readonly' => 'true'));
        echo $oCustomCemeteryForm->renderHiddenFields(); 
    ?>
    </form>
</div>

<?php if($sf_user->getAttribute('countryid') != ''):
echo javascript_tag(
  jq_remote_function(array(
    'update'  => 'custom_cementery_list',
    'url'     => url_for('mailcontent/getCementryListAsPerCountry?id='.$sf_user->getAttribute('countryid').'&cnval='.$sf_user->getAttribute('cemeteryid')),
	'loading' => '$("#IdAjaxLocaderCemetery").show();',
	'complete'=> '$("#IdAjaxLocaderCemetery").hide();'
  )));
endif;

if(!$sf_params->get('back')):
	echo javascript_tag("
		jQuery(document).ready(function() 
			{
				var snCountryId = jQuery('#customcemetery_country_id').val();
				var snCemeteryId = $('#customcemetery_cem_cemetery_id option').length;
				if(snCountryId > 0 && snCemeteryId == 1)
					callAjaxRequest(snCountryId,'".url_for('mailcontent/getCementryListAsPerCountry')."','custom_cementery_list');
			});
	");
endif;

echo javascript_tag("
	jQuery(document).ready(function() 
	{
		$('table').find('tr:visible:odd').addClass('even').end().find('tr:visible:even').addClass('odd');				
	});
");
?>

