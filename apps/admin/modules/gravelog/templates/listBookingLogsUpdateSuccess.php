<?php 
    use_helper('pagination'); 

    $ssModuleName = $sf_params->get('module');

    slot('first_update');
        include_partial(
            'booking_log_list_middle_part',
            array(
                'oBookingLogList'   => $oBookingLogList,
                'amBookingLogList'  => $amBookingLogList,
                'amExtraParameters' => $amExtraParameters,
                'amSearch'          => $amSearch,                                                
                'ssModuleName'      => $ssModuleName,
                'sortby'            => $amExtraParameters['ssSortBy'],
                'sortmode'          => $amExtraParameters['ssSortMode'],
                'inactivateIds'     => 'idbookinglog',
            )
        );
    end_slot();

    slot('second_update');
        include_partial(
            'global/paging',
            array(
                'pager_search_result'   => $oBookingLogList,
                'snPaging'              => $amExtraParameters['snPaging'],                                            
            )
        );  
    end_slot();

    slot('third_update');
        include_partial('global/notification_msg', array('amSuccessMsg' => $amSuccessMsg, 'amErrorMsg' => $amErrorMsg));
    end_slot();

    slot('forth_update');
        include_partial('global/total_items',array('snTotalItems'=> $snPageTotalBookingLogPages));
    end_slot();

    echo javascript_tag(
        jq_update_element_function( 'contentlisting', array('content' => get_slot('first_update'))).
        jq_update_element_function('bottompagingdiv', array('content' => get_slot('second_update'),)).
        jq_update_element_function('success_msgs', array('content' => get_slot('third_update'),)).
        jq_update_element_function('no_of_items', array('content' => get_slot('forth_update'),))
    );

    if(sfContext::getInstance()->getRequest()->isXmlHttpRequest())
        echo javascript_tag('$j("#checkall").attr("checked", false); $j("#checkall2").attr("checked", false);');
?>
