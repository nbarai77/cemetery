<?php  use_helper('Calendar','jQuery'); 

echo javascript_tag('
        jQuery(document).ready(function() 
        { 
            loadNyroModal();
        } );
');

?>

<div id="wapper">

<div id="success_msgs">
        <?php 
           if($sf_user->hasFlash('ssSuccessMsgKey')):
                echo $sf_user->getFlash('ssSuccessMsgKey');
           endif;  
        
        ?>
</div>

    <ul class="tab_content">
        <li><?php echo link_to(__('template'), '/template' , array('title' => __('template'))); ?></li>
        <li><?php echo link_to(__('scheduler'), '/scheduler', array('title' => __('scheduler'))); ?></li>
        <li><?php echo link_to(__('special res'), '/', array('title' => __('special res'))); ?></li> 
    </ul>

    <ul class="tab_content">
        <li><?php echo link_to(__('New'), '/template/newTemplate' , array('title' => __('New'),'class'=> 'nyroModal')); ?></li>
        <li><?php echo link_to(__('Verify'), '/verifyTemplate', array('title' => __('Verify'))); ?></li>
        <li><?php echo link_to(__('Save'), '/', array('title' => __('Save'))); ?></li> 
    </ul>

<?php
    $ssCurrentDateFormat =  sfConfig::get('app_current_date_format');      
    $snWeekStartDayFrom = sfConfig::get('app_set_week_start_day_display');
    
    switch($snWeekStartDayFrom)
    {
        case 1:
            $amDays = array('Sunday'=>'1','Monday'=>'2','Tuesday'=>'3','Wednesday'=>'4','Thursday'=>'5','Friday'=>'6','Saturday'=>'7');
            break;  
    
        case 2:
            $amDays = array('Sunday'=>'7','Monday'=>'1','Tuesday'=>'2','Wednesday'=>'3','Thursday'=>'4','Friday'=>'5','Saturday'=>'6');
            break;  

        case 3:
            $amDays = array('Sunday'=>'6','Monday'=>'7','Tuesday'=>'1','Wednesday'=>'2','Thursday'=>'3','Friday'=>'4','Saturday'=>'5');
            break;  

        case 4:
            $amDays = array('Sunday'=>'5','Monday'=>'6','Tuesday'=>'7','Wednesday'=>'1','Thursday'=>'2','Friday'=>'3','Saturday'=>'4');
            break;  

        case 5:
            $amDays = array('Sunday'=>'4','Monday'=>'5','Tuesday'=>'6','Wednesday'=>'7','Thursday'=>'1','Friday'=>'2','Saturday'=>'3');
            break;  

        case 6:
            $amDays = array('Sunday'=>'3','Monday'=>'4','Tuesday'=>'5','Wednesday'=>'6','Thursday'=>'7','Friday'=>'1','Saturday'=>'2');
            break;  

        case 7:
            $amDays = array('Sunday'=>'2','Monday'=>'3','Tuesday'=>'4','Wednesday'=>'5','Thursday'=>'6','Friday'=>'7','Saturday'=>'1');
            break;  
    
    }

    $amDays[prepareDateFormat("l",$ssMonthWeek)];

    $snDayNumberMinus = $amDays[prepareDateFormat("l",$ssMonthWeek)] - 1; //calcualte date of the previous sunday
    $snDayNumberPlus = 6 - $snDayNumberMinus;                             //calcualte date of the next saturday

    //Calculate date of monday to sunday
    $ssResultStartDate[0] = prepareNavigation($ssMonthWeek,"DAY",- $snDayNumberMinus,$ssCurrentDateFormat); 

    for($snJ=1;$snJ<7;$snJ++):
        $ssResultStartDate[$snJ] = prepareNavigation($ssResultStartDate[0],"DAY",$snJ,$ssCurrentDateFormat);
    endfor; 

    //$ssResultEndDate = prepareNavigation($ssMonthWeek,"DAY",$snDayNumberPlus,$ssCurrentDateFormat);    
    
    include_partial('template/equipmentWeekView',array('ssResultStartDate' => $ssResultStartDate));
    
?>
</div>