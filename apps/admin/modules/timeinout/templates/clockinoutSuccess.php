<?php  use_javascript('/sfFormExtraPlugin/js/double_list.js');?>
<div id="wapper">
<?php echo form_tag($sf_params->get('module').'/'.$sf_params->get('action'),array('name'=>'checkinout','method' => 'post'));?>
    <div class="comment_list"></div>
    <h1><?php echo __('Weekly Timesheet');?></h1>
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
                        <?php if(count($asTimeInOutDetail) > 0 && $sf_user->getAttribute('groupid') != sfConfig::get('app_cemrole_manager')):?>
                        <tr>                      
                        <td align="left" valign="middle">
                        <?php
                            $asTime = explode(' ',$asTimeInOutDetail[0]['created_at']);
                            echo '<h1>Your IN time: '.$asTime[1].'</h1>';                            
                        ?>
                        </td>
                        <td align="right" valign="middle">
                        <?php echo '<h1>Date: '.date('d-m-Y',strtotime($asTimeInOutDetail[0]['task_date'])).'</h1>';?></td>
                        </tr>
                        <?php 
                        endif;                      
                        if($sf_user->getAttribute('groupid') == sfConfig::get('app_cemrole_manager')):?>
                        <tr>
                        <td valign="middle" align="right" width="20%">
                            <?php echo __('Select Staff')?>
                        </td>
                        <td valign="middle" width="30%">
                            <?php   include_partial('get_staff_list', array('asStaffUserList' => $asStaffUser,'snStaffId' => (isset($snStaffId) ? $snStaffId : ''))); ?>
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
	                                                        __('Show'), 
	                                                        array(
	                                                            'class'     => 'delete',
	                                                            'name'      => 'submit_button',
	                                                            'title'     => __('Show'), 
	                                                            'tabindex'  => 8,
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
							<?php 
                            
                            elseif($sf_user->getAttribute('groupid') == sfConfig::get('app_cemrole_staff') || $sf_user->getAttribute('groupid') == sfConfig::get('app_cemrole_staffadmin')):?>
							<tr>                            
                            	
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
	                                                            'title'     => __('Clock In'), 
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
	                                                            'title'     => __('Clock Out'), 
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
                                <td>&nbsp;</td>
                        	</tr>
                            <?php endif;?>
                		</table>
                        <div id="main" class="listtable bordernone">
                    <div class="maintablebg">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <?php if(count($asUserWeeklyDetails) > 0):                        
                        foreach($asUserWeeklyDetails as $snKey=>$asValue): ?> 
                        <tr>                        
                            <?php 
                            if(count($asValue) > 0):                            
                                if($snKey == 0):
                                    foreach($asValue as $snKeys=>$ssValue):
                                    ?>
                                        <th width="15%" align="left" valign="top" class="none"><?php echo $ssValue;?></th>
                                    <?php  
                                    endforeach;
                                elseif($snKey == 4): 
                                    foreach($asValue as $snKeys=>$ssValue): ?>                                        
                                    <td align="left" valign="top">                           
                                        <?php if($snKeys == 0):
                                                echo '<b>'.$ssValue.'</b>';
                                              elseif($snKeys == count($asValue) - 1):?>
                                                <span id="totalHrs"><b><?php echo $ssValue;?></b></span>
                                              <?php else: 
                                              if($sf_user->getAttribute('groupid') == sfConfig::get('app_cemrole_manager')):
                                              ?>
                                                <div id="div_upd_time_out_<?php echo $ssValue['id'];?>">
                                                    <?php 
                                                        include_partial('change_out_time',array('snTime'	=> $ssValue['total_hrs'],
                                                                                                'snTimeInOutId'  => $ssValue['id'],
                                                                                                'snUserId' => $snStaffId,
                                                                                                )
                                                                        );
                                                    ?> 
                                                </div>
                                                <?php 
                                                else:
                                                echo $ssValue['total_hrs'];
                                                endif;
                                                endif;?>
                                    </td>
                                <?php  endforeach;
                                elseif($snKey == 5):
                                foreach($asValue as $snKeys=>$ssValue):
                                ?>
                                <td>
                                <?php if($snKeys == 0):
                                        echo '<b>'.$ssValue.'</b>';
                                      elseif($snKeys == count($asValue) - 1):?>                                                
                                      <span id="totalOvertimeHrs"><b><?php echo $ssValue;?></b></span>
                                    <?php else:?>
                                        <span id="overTime_<?php echo $ssValue['id'];?>">
                                        <?php echo $ssValue['overtime'];?>
                                        </span>
                                <?php endif;?>
                                </td>
                                <?php 
                                endforeach;
                                elseif($snKey == 1):
                                 foreach($asValue as $snKeys=>$ssValue):
                                    ?>
                                        <td align="left" valign="top"><b><?php echo $ssValue;?></b></td>
                                    <?php  
                                    endforeach;
                                else: 
                                    foreach($asValue as $snKeys=>$ssValue):                                   
                                    $ssFinalValue = (($snKeys == 0)?'<b>'.$ssValue.'</b>':$ssValue);
                                    ?>                                    
                                    <td align="left" valign="top"><?php echo $ssFinalValue;?></td>
                                    <?php                                    
                                    endforeach;
                                endif; 
                                endif;?>
                        </tr>                        
                        <?php endforeach;
                        if($sf_user->getAttribute('groupid') == sfConfig::get('app_cemrole_manager')):?>
                        <tr>
                        <td align="right" valign="top" colspan=7>
                        <div class="fright" style="margin-left:5px;">
						<?php   echo button_to(__('Export'),'timeinout/exportTimeSheet?id_user='.$snStaffId, 
								array('title' => __('Export'),'tabindex'=> 1,'id' => 'exportUserDetail')
								);
                        ?>
						</div>
                        </td>
                        </tr>
                        <?php 
                        endif;
                        else:
                            echo '<div class="warning-msg"><span>'.__('Record(s) not found').'</span></div>';
                        endif;?>
                        </table>                        
                        </div>
                        </div>
            		</div>

                </div>
                <div class="clearb"></div>
            </div>
        </div>
    </div>
    <div class="clearb">&nbsp;</div>
    <div class="clearb">&nbsp;</div>    
    </form>
</div>
<?php 
    echo javascript_tag('
        ssTags = document.getElementsByTagName("INPUT");
        document.getElementById(ssTags[0].id).select();
        document.getElementById(ssTags[0].id).focus();'
    );
    
    echo javascript_tag("
    
    function letterAction(ssUrl, ssContentType)
    {
        ssUrl = ssUrl+'?content_type='+ssContentType;
        window.open(ssUrl,'sendletterwindow','width=1200,height=1000,scrollbars=yes');
    }


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
