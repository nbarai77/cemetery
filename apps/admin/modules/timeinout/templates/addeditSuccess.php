<?php  use_javascript('/sfFormExtraPlugin/js/double_list.js');?>
<div id="wapper">
<?php 
    echo $oAwardForm->renderFormTag(
        url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oAwardForm->getObject()->isNew() ? '?id='.$oAwardForm->getObject()->getId().'&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '')), 
        array("name" => $oAwardForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );
?>
    <div class="comment_list"></div>
    <h1><?php echo $oAwardForm->getObject()->isNew() ?  __('Add New Award') : __('Edit Award');?></h1>
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
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oAwardForm['name']->renderLabel($oAwardForm['name']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
                               
                            	<td valign="middle" width="20%">
                                	<?php 
                                	    if($oAwardForm['name']->hasError()):
                                    	    echo $oAwardForm['name']->renderError();
                                        endif;
									    echo $oAwardForm['name']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                                 <td valign="middle" width="60%"></td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oAwardForm['description']->renderLabel($oAwardForm['description']->renderLabelName() );?>
                        		</td>                                
                            	<td valign="middle" width="20%">
                                	<?php 
                                	    if($oAwardForm['description']->hasError()):
                                    	    echo $oAwardForm['description']->renderError();
                                        endif;
									    echo $oAwardForm['description']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                                 <td valign="middle" width="60%"></td>
                    		</tr>
                            <tr>
                            <td valign="middle" align="right" width="20%"></td>
                            <td valign="middle" width="20%" style="padding-left: 13px;"><?php echo __('Overtime Hours');?></td>
                            <td valign="middle" width="60%" style="padding-left: 13px;"><?php echo __('Rate($)');?></td>
                            </tr>
                            <?php /*for($snKey=0;$snKey<=2;$snKey++) {?>
                            <tr>
                             <td valign="middle" align="right" width="20%"></td>
                            	<td valign="middle" width="20%">
                                	<?php                                        
                                	    
									    echo $oAwardForm['awardpayrate'][$snKey]['overtime_hrs']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>                          
                            	<td valign="middle" width="60%">
                                	<?php                                        
                                	   
									    echo $oAwardForm['awardpayrate'][$snKey]['overtime_pay_rate']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                                 <td valign="middle" width="60%"></td>
                    		</tr>
                            <?php }*/ ?>
                            <?php $asAllOvertime = array();
                                    $asAllPayRate = array();
                                    if(isset($asAwardPayList) && count($asAwardPayList) > 0):
                                        $asRow = $asAwardPayList;                                        
                                    else:
                                        $asRow = array(1,2,3);                                          
                                    endif;
                                    for($snI = 1; $snI <= 24; $snI++)
                                    {
                                        $asAllOvertime[$snI] =  $snI;
                                    }
                                    for($snJ = 1; $snJ <= 100; $snJ++)
                                    {
                                        $asAllPayRate[$snJ] = $snJ;
                                    }                                                              
                            ?>
                            
                            <?php foreach($asRow as $snKey=>$asVal):?>
                            <tr>
                            	<td valign="middle" align="right" width="20%">                                	
                        		</td>
	
                            	<td valign="middle" width="20%">
                                	<?php
                                        if(isset($asVal['overtime_hrs']) && $asVal['overtime_hrs'] != ''):
                                            $asOverTime = explode(':',$asVal['overtime_hrs']);                                            
                                            $snOverTime = ((substr($asOverTime[0],0,1) == 0) ? substr($asOverTime[0],1) :$asOverTime[0]);                                            
                                        endif;  
                                        
                                        echo select_tag('award_overtime_hrs[]', options_for_select($asAllOvertime ,((isset($snOverTime))?$snOverTime:''), 'include_custom='.__('Select Hrs.')),
                                            array('tabindex'=>1));   
								    ?>
                                </td>
                                <td valign="middle" width="60%">
                                	<?php                                 	   
                                        echo select_tag('award_overtime_rate[]', options_for_select($asAllPayRate ,((isset($asVal['overtime_pay_rate']) && $asVal['overtime_pay_rate'] != '')?$asVal['overtime_pay_rate']:''), 'include_custom='.__('Select Rate.')),
                                            array('tabindex'=>1));   
								    ?>
                                </td>
                    		</tr> 

                            <?php endforeach;?>
                            <tr>
                            
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
	                                                        __('Save'), 
	                                                        array(
	                                                            'class'     => 'delete',
	                                                            'name'      => 'submit_button',
	                                                            'title'     => __('Save'), 
	                                                            'tabindex'  => 10,
	                                                            'onclick'   => "jQuery('#tab').val('');"
	                                                        )
	                                                    );
	                                                ?>
                                        		</span>
                                        	</li>
                                			<li class="list1">
                                        		<span>
                                        			<?php  
                                        			    $ssCancelUrl    = $sf_params->get('module').'/index?'.html_entity_decode($amExtraParameters['ssQuerystr']);
                                                		echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>11));
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
        echo $oAwardForm->renderHiddenFields(); 
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
