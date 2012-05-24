<?php 
    use_helper('pagination');
    $ssModuleName = $sf_params->get('module'); 
?>
<div id="wapper">
    <?php include_partial('global/indicator');?>

    <div id="result"></div>
    <h1>
        <?php echo __('Permission list');?> 
        <span id="no_of_items"><?php include_partial('global/total_items',array('snTotalItems'=> $snPageTotalGuardPermissionPages));?></span>
    </h1>

    <div id="success_msgs">
        <?php echo include_partial('global/notification_msg', array('amSuccessMsg' => $amSuccessMsg,'amErrorMsg' => $amErrorMsg));?>
    </div>
    <?php
        echo jq_form_remote_tag(
                array(
                    'url'       => $ssModuleName.'/index?request_type=ajax_request',
                    'update'    => 'contentlisting',
                    'script'    => true,
                    'loading'   => jq_visual_effect('fadeIn','#indicator1'),
                    'complete'  => jq_visual_effect('fadeOut','#indicator1').";sortingdiv();",
                ),
                array('name' => $ssFormName, 'id' => $ssFormName)
            );

        echo input_hidden_tag('page',$snPage);
        echo input_hidden_tag('paging',$snPaging);
        echo input_hidden_tag('form_name',$ssFormName);

        include_partial(
            'global/listing_top',
            array(
                'form_name'             => $ssFormName,
                'id_checkboxes'         => 'id_permission[]',
                'inactivateIds'         => 'idpermission',
                'update_div'            => 'success_msgs',
                'url'                   => $ssModuleName.'/index?request_type=ajax_request',
                'admin_act_status'      => 'status',
                'admin_act_module'      => 'delete',
                'add_new_url'           => $ssModuleName.'/addedit',
                'bStatusButton'         => 'false',
                'bChangeOrderButton'    => 'false',
            )
        );
    
        echo '<div>';
            echo '<div style="width:80%;float:left;">';
                if($snPageTotalGuardPermissionPages == 0): 
                    echo '<div class="warning-msg"><span>'.__('Record(s) not found').'</span></div>';
                else:
                    echo '<div  id="contentlisting" >';
                        include_partial(
                            'list_middle_part',
                            array(
                                'oGuardPermissionList'  => $oGuardPermissionList,
                                'amGuardPermissionList' => $amGuardPermissionList,
                                'amExtraParameters'     => $amExtraParameters,
                                'amSearch'              => $amSearch,	                                                
                                'ssModuleName'          => $ssModuleName,
                                'sortby'                => $amExtraParameters['ssSortBy'],
                                'sortmode'              => $amExtraParameters['ssSortMode'],
                                'inactivateIds'         => 'idpermission',
                            )
                        );
                    echo '</div>';
                    
                    include_partial(
                        'global/listing_bottom',
                        array(
                            'amPagerSearchResults'  => $oGuardPermissionList, 
                            'amExtraParameters'     => $amExtraParameters
                        )
                    );
                endif; 
            echo '</div>';
            echo '<div class="searchRightPart">';
                include_partial(
                    'global/search',
                    array(
                        'url'               => $ssModuleName.'/index?request_type=ajax_request',
                        'update_div'        => 'contentlisting',
                        'amSearchByArray'   => $amSearch,
                        'amExtraParameters' => $amExtraParameters,
                    )
                );
            echo '</div>';
            echo '<div class="clearb">&nbsp;</div>';
        echo '</div>';
    ?>
    <div class="clearb">&nbsp;</div>
    <div class="clearb">&nbsp;</div>
    </form>
</div>
<!--Sorting for selected field-->
<?php 
    if($snPageTotalGuardPermissionPages > 0):
        echo javascript_tag('
            jQuery(document).ready(function() 
            {
                sortingdiv();
            });
            function sortingdiv()
            {
                showHideSortDiv("sort_div_name","field_div_name");
                showHideSortDiv("chkunchk2","selectopt2");
                showHideSortDiv("chkunchk3","selectopt3");  
            }');
    endif;
?>
