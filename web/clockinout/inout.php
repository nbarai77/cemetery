<?php
session_start();
/****************************************************
 * index.php
 *
 * @package    : Interment Search Plugin
 * @subpackage : view
 * @author     : Prakash Panchal
 * @version    : 1.0

****************************************************/
$oCon = mysql_connect('192.168.0.155','root','vi155vi');
$oDb  = mysql_select_db('cemetery',$oCon);

if($_SESSION['id_user'] == '')
    header('Location: /clockinout/login.php');

$asTimeInOutDetail = array();
$snUserId = $_SESSION['id_user'];
$ssQuery = "SELECT tio.* FROM time_in_out tio where tio.user_id='".$snUserId."' and tio.task_date='".date('Y-m-d')."'";
$amResult = mysql_query($ssQuery);
$asTimeInOutDetail = mysql_fetch_array($amResult);

/* ================================== */
$asUserWeeklyDetails = getUserWeeklyDetail($snUserId);
/* ================================== */
if($_POST)
{
    $snTotalHrs = '';
    $snCurrentTime = date('H:i:s');
    $snCurrentDate = date('Y-m-d');
    
    $ssStatus = (($_REQUEST['timein'] == 'Clock In')?'IN':'OUT');
    
    if(mysql_num_rows($amResult) > 0)
    {
        if($ssStatus == 'OUT')
        {
            $snTotalHrs = diff_between_time($snCurrentTime,$asTimeInOutDetail['time_in']);
                    
            if($asTimeInOutDetail['total_hrs'] != '')
                $snTotalHrs = sum_the_time($snTotalHrs,$asTimeInOutDetail['total_hrs']);
            
            $ssUpdateQuery = "update time_in_out tio set tio.status='".$ssStatus."',tio.total_hrs='".$snTotalHrs."', 
                              tio.time_out='".$snCurrentTime."' where tio.user_id ='".$asTimeInOutDetail['user_id']."' and tio.task_date ='".date('Y-m-d')."'";
            
            mysql_query($ssUpdateQuery);            
        }                
        else
        {
            $ssUpdateQuery = "update time_in_out tio set tio.status='".$ssStatus."',tio.time_in='".$snCurrentTime."' 
                              where tio.user_id ='".$snUserId."' and tio.task_date ='".date('Y-m-d')."'";
            
            mysql_query($ssUpdateQuery);
        }
    }
    else
    {               
        $ssInsertQuery  = "insert into time_in_out (user_id, day_type_id, created_at, updated_at, task_date, 
                           time_in, time_out, total_hrs, status) values('".$snUserId."', 1, '".date('Y-m-d H:i:s')."', 
                           '".date('Y-m-d H:i:s')."', '".$snCurrentDate."','".$snCurrentTime."','00:00:00','','".$ssStatus."')";
        
        mysql_query($ssInsertQuery);        
    }
    header('Location: /clockinout/inout.php');             
}


function getUserWeeklyDetail($snIdUser,$ssFlag ='')
    {
        $ssQuery = "SELECT tio.*, dt.* FROM time_in_out tio LEFT JOIN day_type dt ON tio.day_type_id = dt.id where tio.user_id='".$snIdUser."' and tio.task_date<='".date('Y-m-d')."'
                   order by tio.id asc LIMIT 7";
       
        $asRes = mysql_query($ssQuery);
        
        $asUserWeekDetail = array();
        
        if(mysql_num_rows($asRes) > 0)
        {
            $snTotalTime = '00:00:00';
            $snSumOverTime = '00:00:00';
            $snRegularTime = '01:00:00';
            
            $asUserWeekDetail[0][0] = '';
            $asUserWeekDetail[1][0] = 'Activity';
            $asUserWeekDetail[2][0] = 'IN';
            $asUserWeekDetail[3][0] = 'OUT';
            $asUserWeekDetail[4][0] = 'TOTAL';
            $asUserWeekDetail[5][0] = 'OVERTIME';
            
            $snTotalWeekPayment = 0;
            $snTotalPayment = 0;
            if($ssFlag)
                $asUserWeekDetail[6][0] = __('Payment');
                
            $snKey = 0;
            while($asValue = mysql_fetch_array($asRes))
            {
                $asUserWeekDetail[0][$snKey + 1] = date("D", strtotime($asValue['task_date']));                
                $asUserWeekDetail[1][$snKey + 1] = $asValue['name']; 
                $asTime = explode(' ',$asValue['created_at']);
                $snTimeIn = date('H:i',strtotime($asValue['time_in']));
                $asUserWeekDetail[2][$snKey + 1] = $snTimeIn;
                $asUserWeekDetail[3][$snKey + 1] = date('H:i',strtotime($asValue['time_out']));
                $asUserWeekDetail[4][$snKey + 1] = array('total_hrs'=>date('H:i',strtotime($asValue['total_hrs'])),'id'=>$asValue['id']);
                                
                $snTotalTime = sum_the_time($snTotalTime,$asValue['total_hrs']);
                
                if(strtotime($asValue['total_hrs']) > strtotime($snRegularTime))
                {
                    $snOverTime = diff_between_time($asValue['total_hrs'],$snRegularTime);
                    $snSumOverTime = sum_the_time($snSumOverTime,$snOverTime);                    
                }                
                $asUserWeekDetail[5][] = array('overtime'=>((isset($snOverTime))?date('H:i',strtotime($snOverTime)):date('H:i',strtotime('00:00:00'))),'id'=>$asValue['id']);
            $snKey++;   
            }
            $asUserWeekDetail[0]['total'] = 'Total';
            $asUserWeekDetail[4][count($asUserWeekDetail[4])] = date('H:i',strtotime($snTotalTime));
            $asUserWeekDetail[5][count($asUserWeekDetail[5])] = date('H:i',strtotime($snSumOverTime));
            $asUserWeekDetail[3][count($asUserWeekDetail[5])] = '';
            $asUserWeekDetail[2][count($asUserWeekDetail[5])] = '';
            $asUserWeekDetail[1][count($asUserWeekDetail[5])] = '';            
        }        
        return $asUserWeekDetail;
    }
    
    function diff_between_time($snFirstTime, $snSecondTime)
    {
        $snTime = strtotime($snFirstTime) - strtotime($snSecondTime);
        $snHours = floor($snTime/3600);
        $snMinutes= round($snTime/60);
        if($snHours != 0)
        {                
            if($snMinutes > 60)
            {
                $snTotalMin = ($snMinutes - ($snHours * 60));
                $snTotalHrs = ((strlen($snHours) == 1)?'0'.$snHours:$snHours).':'.((strlen($snTotalMin) == 1)?'0'.$snTotalMin:$snTotalMin).':00';
            }
            else
                $snTotalHrs = $snHours.':00:00';
        }
        else
            if(strlen($snMinutes) == 1)
                $snTotalHrs = '00:0'.round($snTime/60).':00';
            else
                $snTotalHrs = '00:'.round($snTime/60).':00';
                
        return $snTotalHrs;
    }
    function sum_the_time($time1, $time2) 
    {
        $times = array($time1, $time2);
        $seconds = 0;
        foreach ($times as $time)
        {
            list($hour,$minute,$second) = explode(':', $time);
            $seconds += $hour*3600;
            $seconds += $minute*60;
            $seconds += $second;
        }
        $hours = floor($seconds/3600);
        $seconds -= $hours*3600;
        $minutes  = floor($seconds/60);
        $seconds -= $minutes*60;
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds); // Thanks to Patrick
    }
?>
<html>
<title>Clockinout</title>
<head>
<script src="js/jquery-1.4.1.min.js"></script>
<script src="js/common.js"></script>

<link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="page-top-outer">    
	<!-- Start: page-top -->
	<div id="page-top">            

		<!-- start logo -->
		<div id="logo">
			<img width="332" height="53" src="/images/logo.png">
        </div>
		<div class="clear"></div>
	</div>
	<!-- End: page-top -->
</div>
<div id="container">
	<div style="width:98%; padding-left:15px;">
	<form method="post" name="clockin" id="clockin" action="inout.php">
    <div id="main" class="listtable bordernone">
        <div class="maintablebg">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tbody>
			<tr>				
                <td align="left">
                    
					<?php 
						if(isset($_SESSION['title']) && $_SESSION['title'] != ''):
							echo '<h1>Welcome '.$_SESSION['title'].' '.$_SESSION['name'].'</h1>';
					 	endif;?>
				</td>
                <td align="right">
					<h2><a href="logout.php"/>Logout</a></h2>
				</td>
			</tr>    
        
        <?php
        if(count($asTimeInOutDetail) > 1):?>
        <tr class="odd">                      
            <td align="left" valign="middle">
            <?php 
            $asTime = explode(' ',$asTimeInOutDetail['created_at']);
            echo '<h1>Your IN time: '.$asTime[1].'</h1>'; 
            ?>
            </td>
            <td align="right" valign="middle">
            <h1>Date: <?php echo date('d-m-Y',strtotime($asTimeInOutDetail['task_date']));?></h1></td>
        </tr>
            <?php
            endif;
            if($asTimeInOutDetail['status'] == 'OUT'):?>
            <tr class="even">                            
                <td valign="middle">
                   	<div class="actions">
                        <ul class="fleft">
                            <li class="list1">
                            <span>
                                <input type="submit" tabindex="10" title="Clock In" class="delete" value="Clock In" name="timein">                                        		</span>
                            </li>
                        </ul>
                    </div>
                </td>
                <td>&nbsp;</td>
            </tr>
            <?php elseif($asTimeInOutDetail['status'] == 'IN'):?>
            <tr class="even">                            
                <td valign="middle">
                   	<div class="actions">
                        <ul class="fleft">
                            <li class="list1">
                            <span>
                                <input type="submit" tabindex="10" title="Clock Out" class="delete" value="Clock Out" name="timein">                                        		</span>
                            </li>
                        </ul>
                    </div>
                </td>
                <td>&nbsp;</td>
            </tr>
            <?php 
            else:?>
            <tr class="even">                            
                <td valign="middle">
                   	<div class="actions">
                        <ul class="fleft">
                            <li class="list1">
                            <span>
                                <input type="submit" tabindex="10" title="Clock In" class="delete" value="Clock In" name="timein">                                        		</span>
                            </li>
                        </ul>
                    </div>
                </td>
                <td>&nbsp;</td>
            </tr>
            <?php endif;?>
            </table>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <?php if(count($asUserWeeklyDetails) > 0):?>
                        <?php foreach($asUserWeeklyDetails as $snKey=>$asValue): ?> 
                        <tr>                        
                            <?php if(count($asValue) > 0):                            
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
                                                echo $ssValue;
                                              elseif($snKeys == count($asValue) - 1):?>
                                                <span id="totalHrs"><?php echo $ssValue;?></span>
                                              <?php else:
                                                echo $ssValue['total_hrs'];
                                                endif;?>
                                    </td>
                                <?php  endforeach;
                                elseif($snKey == 5):
                                foreach($asValue as $snKeys=>$ssValue):
                                ?>
                                <td>
                                <?php if($snKeys == 0):
                                        echo $ssValue;
                                      elseif($snKeys == count($asValue) - 1):?>                                                
                                      <span id="totalOvertimeHrs"> <?php echo $ssValue;?></span>
                                    <?php else:?>
                                        <span id="overTime_<?php echo $ssValue['id'];?>">
                                        <?php echo $ssValue['overtime'];?>
                                        </span>
                                <?php endif;?>
                                </td>
                                <?php 
                                endforeach;
                                else: 
                                    foreach($asValue as $snKeys=>$ssValue):
                                    ?>
                                        <td align="left" valign="top"><?php echo $ssValue;?></td>
                                    <?php  
                                    endforeach;
                                endif; 
                                endif;?>
                        </tr>                        
                        <?php endforeach;                        
                    endif;?>
                </table>                        
            </div>
        </div>        
	</form>
	</div>
</div>
    <div id="footer">
<!-- <div id="footer-pad">&nbsp;</div> -->
	<!--  start footer-left -->
	<div id="footer-left">
		 &copy;2011 OCMS &ndash; The Online Cemetery Management System	</div>
	<!--  end footer-left -->
	<div class="clear">&nbsp;</div>
</div>
</body>
</html>
