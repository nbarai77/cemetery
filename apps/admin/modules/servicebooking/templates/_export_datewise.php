<?php 
    echo $oGravePlotReportForm->renderFormTag(
        url_for($sf_params->get('module').'/bookingInvoice'), 
        array("name" => $oGravePlotReportForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );
?>
<div class="main_cont">
            <div class="">
                <div id="info">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="sub_table">    
                        <tr>
                            <td valign="middle" align="right" width="20%">
                                <?php echo $oGravePlotReportForm['from_date']->renderLabel($oGravePlotReportForm['from_date']->renderLabelName());?>
                            </td>

                            <td valign="middle" width="20%">
                                <?php 
                                    if($oGravePlotReportForm['from_date']->hasError()):
                                        echo $oGravePlotReportForm['from_date']->renderError();
                                    endif;
                                    echo $oGravePlotReportForm['from_date']->render(array('class'=>'inputBoxWidth')); 
                                ?>
                            </td>
                        
                            <td valign="middle" align="right" width="10%">
                                <?php echo $oGravePlotReportForm['to_date']->renderLabel($oGravePlotReportForm['to_date']->renderLabelName());?>
                            </td>

                            <td valign="middle" width="20%">
                                <?php 
                                    if($oGravePlotReportForm['to_date']->hasError()):
                                        echo $oGravePlotReportForm['to_date']->renderError();
                                    endif;
                                    echo $oGravePlotReportForm['to_date']->render(array('class'=>'inputBoxWidth')); 
                                ?>
                            </td>
                       
                            <td valign="middle" colspan="2" width="30%">
                                <div class="actions">
                                    <ul class="fleft">
                                        <li class="list1">
                                            <span>
                                                <?php 
                                                    echo submit_tag(
                                                        __('Export'), 
                                                        array(
                                                            'class'     => 'delete',
                                                            'name'      => 'submit_button',
                                                            'title'     => __('Export'), 
                                                            'tabindex'  => 7,
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
        </div>
<?php 
$ssToDate = ((isset($ssToDate) && $ssToDate != '' ) ? $ssToDate : date('d-m-Y'));
$ssFromDate = ((isset($ssFromDate) && $ssFromDate != '' ) ? $ssFromDate : '');
echo javascript_tag("
            jQuery(document).ready(function() 
            {
                $('#reports_to_date').val('".$ssToDate."');
                $('#reports_from_date').val('".$ssFromDate."');
            })");
?>
</form>
