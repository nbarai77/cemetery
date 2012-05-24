<?php  use_javascript('/sfFormExtraPlugin/js/double_list.js');?>
<div id="wapper">
<?php 
   /* echo $oAwardForm->renderFormTag(
        url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oAwardForm->getObject()->isNew() ? '?id='.$oAwardForm->getObject()->getId().'&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '')), 
        array("name" => $oAwardForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );*/
    echo form_tag($sf_params->get('module').'/'.$sf_params->get('action'),array('name'=>'checkinout'));
?>
    <div class="comment_list"></div>
    <h1><?php //echo $oAwardForm->getObject()->isNew() ?  __('Add New Award') : __('Edit Award');
    echo __('Check In Check OUt');
    ?></h1>
    <div id="message">
        <div id="success_msgs">
            <?php //echo include_partial('global/notification_msg', array('amSuccessMsg' => $amSuccessMsg,'amErrorMsg' => $amErrorMsg));?>
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
                            <td valign="middle" align="right" width="20%">
                                	<?php //echo $oAwardForm['name']->renderLabel($oAwardForm['name']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
                               
                            	<td valign="middle" width="20%">
                                	<?php 
                                	   /* if($oAwardForm['name']->hasError()):
                                    	    echo $oAwardForm['name']->renderError();
                                        endif;
									    echo $oAwardForm['name']->render(array('class'=>'inputBoxWidth')); */
								    ?>
                                </td>
                                 <td valign="middle" width="60%"></td>
                            </tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php //echo $oAwardForm['name']->renderLabel($oAwardForm['name']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
                               
                            	<td valign="middle" width="20%">
                                	<?php 
                                	   /* if($oAwardForm['name']->hasError()):
                                    	    echo $oAwardForm['name']->renderError();
                                        endif;
									    echo $oAwardForm['name']->render(array('class'=>'inputBoxWidth')); */
								    ?>
                                </td>
                                 <td valign="middle" width="60%"></td>
                    		</tr>
							
                    		<tr>
                            	<td>&nbsp;</td>
                        		<td valign="middle">
                                	<div class="actions">
                                		<ul class="fleft">
                                        <?php if(count($asTimeInOutDetail) > 0 && $asTimeInOutDetail[0]['status'] == 'OUT'):?>
                                        	<li class="list1">
                                        		<span>
	                                                <?php 
	                                                    echo submit_tag(
	                                                        __('Clock In'), 
	                                                        array(
	                                                            'class'     => 'delete',
	                                                            'name'      => 'timein',
	                                                            'title'     => __('Check In'), 
	                                                            'tabindex'  => 10	                                                            
	                                                        )
	                                                    );
	                                                ?>
                                        		</span>
                                        	</li>
                                            <?php elseif(count($asTimeInOutDetail) > 0 && $asTimeInOutDetail[0]['status'] == 'IN'):?>
                                			<li class="list1">
                                        		<span>
                                        			 <?php 
                                                     
	                                                    echo submit_tag(
	                                                        __('Clock Out'), 
	                                                        array(
	                                                            'class'     => 'delete',
	                                                            'name'      => 'timeout',
	                                                            'title'     => __('Check Out'), 
	                                                            'tabindex'  => 10	                                                            
	                                                        )
	                                                    );
                                                    
	                                                ?>
                                    			</span>
                                    		</li>
                                            <?php 
                                            else:?>
                                            <li class="list1">
                                        		<span>
	                                                <?php 
	                                                    echo submit_tag(
	                                                        __('Clock In'), 
	                                                        array(
	                                                            'class'     => 'delete',
	                                                            'name'      => 'timein',
	                                                            'title'     => __('Check In'), 
	                                                            'tabindex'  => 10	                                                            
	                                                        )
	                                                    );
	                                                ?>
                                        		</span>
                                        	</li>
                                            <?php endif;?>
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
    //    echo input_hidden_tag('id', $sf_params->get('id'), array('readonly' => 'true'));
  //      echo input_hidden_tag('tab', ($sf_params->get('tab') ? $sf_params->get('tab') :'info'), array('readonly' => 'true'));
//        echo $oAwardForm->renderHiddenFields(); 
    ?>
    </form>
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
			var snCountryId = jQuery('#chapel_country_id').val();
			var snCemeteryId = $('#chapel_cem_cemetery_id option').length;
			if(snCountryId > 0 && snCemeteryId == 1)
				callAjaxRequest(snCountryId,'".url_for('chapel/getCementryListAsPerCountry')."','cementery_list');
		
		});
        function tabSelection(id, ssClassName)
        { 
            var asTabs      = new Array('user_info','user_permission');
            var asUpdateDiv = new Array('info','permission'); 
            
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
echo javascript_tag("
	jQuery(document).ready(function() 
		{
			$('table').find('tr:visible:odd').addClass('even').end().find('tr:visible:even').addClass('odd');
			
		});
");
?>
