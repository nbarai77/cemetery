<?php 
    $ssConfigWeekDisplayHeight = sfConfig::get('app_week_view_height');  
    $snTdHeight = sfConfig::get('app_week_view_height')+50;
    $ssSlot = sfConfig::get('app_slot_time');
?>
<table cellspacing="0" cellpadding="0" width="100%">
    <tr >
        <td style="height:<?php echo $snTdHeight ?>px;width:5%; ">
            <table cellspacing="0" cellpadding="0" width="100%" style="height:<?php echo $snTdHeight ?>px;" border="0">
                <tr>
                    <td align="center" valign="top" class="calendar-day-head" style="height:25px;padding:0px 0px;">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" valign="top" class="calendar-day-head" style="height:25px;padding:0px 0px;">&nbsp;</td>
                </tr>
                <tr class="calendar-row">
                    <td align="center" valign="top" class="calendar-day-head" style="height:<?php echo $ssConfigWeekDisplayHeight ?>px;padding:0px 0px;">
                        <?php   
                                        
                                $ssDivWidth =  $ssConfigWeekDisplayHeight/48; //24
                                $ssTopMargin = ($ssDivWidth-12)/2;
                                $ssDivWidth = ($ssDivWidth-$ssTopMargin);
                                    
                                for($i=0;$i<=47;$i++):  //23
                                    $snStartTime = ($i == 0) ? strtotime('00:00') : strtotime('+'.$ssSlot, $snStartTime);
                                    $snEndTime   =  strtotime('+'.$ssSlot, $snStartTime);
                                    $ssDisplayStartTime = date("H:i",$snStartTime);
                                    $ssDisplayEndTime = date("H:i",$snEndTime);
                                    $ssDisplayEndTime = ($ssDisplayEndTime == date("H:i",strtotime('00:00'))) ? '24:00' : $ssDisplayEndTime ;   
                                    echo '<div ><span  style="display:block; height: '.$ssDivWidth.'px; padding-top:'.$ssTopMargin.'px;cursor: default;" >'.$ssDisplayStartTime.' - '.$ssDisplayEndTime .'&nbsp;</span></div>';
                                endfor;   
                        ?>
                    </td>
                </tr>
                <tr>
                    <td align="center" valign="top" class="calendar-day-head" style="height:25px;padding:0px 0px;">&nbsp;</td>
                </tr>
            </table>
        </td>
        <?php             
            for($snJ=0;$snJ<7;$snJ++): 
        ?>
        <td  style="height:<?php echo $snTdHeight ?>px;width:5%;">
            <table cellspacing="0" cellpadding="0" width="100%" style="height:<?php echo $snTdHeight ?>px;" border="0">                
                <tr>
                    <td align="center" valign="top" class="calendar-day-head" style="height:25px;padding:0px 0px;">
                    <?php    
                        //$ssResultStartDate[$snJ].                      
                        $ssMultiLangShortDay = date("D",strtotime(prepareDateFormat("Y-m-d H:i:s",$ssResultStartDate[$snJ])));
                        echo '('. __($ssMultiLangShortDay).')';
                    ?></td>
                </tr>
                <tr class="calendar-row">
                    <td align="center" valign="top" class="calendar-day-head" style="height:<?php echo $ssConfigWeekDisplayHeight ?>px;padding:0px 0px;">
                        <?php  //echo $asWeekDisplay[$snJ]; 

                            if(preg_match("/Mon/i", $ssMultiLangShortDay)) :
                         ?>
                            <div onclick="configPeriode(0);" style="height:<?php echo $ssDivWidth; ?>px;border-bottom-style:solid;border-bottom-width:1px;border-bottom-color:black;" class="colp0" id="0">P0 - C0</div>                            
                         <?php endif; ?>   
                    </td>
                </tr>        
            </table>
        </td>
        <?php endfor;  ?>
    </tr>    
</table> 