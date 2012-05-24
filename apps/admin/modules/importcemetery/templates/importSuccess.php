<?php  use_javascript('/sfFormExtraPlugin/js/double_list.js');?>
<div id="wapper">
<?php 
    echo $omImportDataForm->renderFormTag( url_for($sf_params->get('module').'/'.$sf_params->get('action')), 
        array("name" => $omImportDataForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    ); 
?>
    <div class="comment_list"></div>
    <h1><?php echo $ssHeading; ?></h1>
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
                    		<?php if($sf_user->isSuperAdmin()):?>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $omImportDataForm['country_id']->renderLabel($omImportDataForm['country_id']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($omImportDataForm['country_id']->hasError()):
                                    	    echo $omImportDataForm['country_id']->renderError();
                                        endif;
									    echo $omImportDataForm['country_id']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>							

							<tr>
                            	<td valign="middle" align="right" width="20%">
									<?php echo __('Select Cementery')."<span class='redText'>*</span>"?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
										if($sf_user->hasFlash('ssErrorCemeter') && $sf_user->getFlash('ssErrorCemeter') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorCemeter').'</li></ul>';
											$sf_user->setFlash('ssErrorCemeter','');
										endif;
										include_partial('getCementeryList', array('asCementryList' => $asCementery,'snCementeryId' => $snCementeryId)); 
								    ?>
                                </td>
                    		</tr>
							<?php endif;?>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $omImportDataForm['import_file']->renderLabel($omImportDataForm['import_file']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($omImportDataForm['import_file']->hasError()):
                                    	    echo $omImportDataForm['import_file']->renderError();
                                        endif;
									    echo $omImportDataForm['import_file']->render();
										echo '<span style="color:#ff0000;">&nbsp;';
										echo link_to('Download Sample Format',$sf_params->get('module').'/downloadSample?filename='.$ssDownFileName,array('title' => __('Download Sample Format') ) );
										echo '&nbsp;&nbsp;(Note: '.__('The file must be of CSV format').')';
										
										echo '</span>';
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
	                                                        __('Import'), 
	                                                        array(
	                                                            'class'     => 'delete',
	                                                            'name'      => 'submit_button',
	                                                            'title'     => __('Save'), 
	                                                            'tabindex'  => 4,
	                                                            'onclick'   => "jQuery('#tab').val('');"
	                                                        )
	                                                    );
	                                                ?>
                                        		</span>
                                        	</li>
                                			<!--<li class="list1">
                                        		<span>
                                        			<?php  
                                                		//echo button_to(__('Cancel'),url_for($sf_params->get('module').'/index'),array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>27));
                                                    ?>
                                    			</span>
                                    		</li>-->
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
        echo $omImportDataForm->renderHiddenFields(); 
    ?>
    </form>
</div>
<?php
echo javascript_tag("
	ssTags = document.getElementsByTagName('select');
	document.getElementById(ssTags[1].id).focus();

	jQuery(document).ready(function() 
	{
		var snCountryId = jQuery('#importdata_country_id').val();
		var snCemeteryId = $('#importcemetery_cem_cemetery_id option').length;
		if(snCountryId > 0 && snCemeteryId == 1)
			callAjaxRequest(snCountryId,'".url_for('importcemetery/getCementryListAsPerCountry')."','importcemetery_cementery_list');

		$('table').find('tr:visible:odd').addClass('even').end().find('tr:visible:even').addClass('odd');
	});
");?>