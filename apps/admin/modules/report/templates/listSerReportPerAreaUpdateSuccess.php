<?php 
    use_helper('pagination'); 

    $ssModuleName = $sf_params->get('module');

    slot('first_update');
        include_partial(
            'list_service_report_middle_part',
            array(
                'oGuardUserList'    => $oSerReportAsPerAreaList,
                'amGuardUserList'   => $amSerReportAsPerAreaList,
                'amExtraParameters' => $amExtraParameters,
                'amSearch'          => '',                                                
                'ssModuleName'      => $ssModuleName,
                'sortby'            => $amExtraParameters['ssSortBy'],
                'sortmode'          => $amExtraParameters['ssSortMode'],
                'inactivateIds'     => 'iduser',
                'snCountryId'       => (isset($snCountryId)?$snCountryId:''),
                'snCemeteryId'      => (isset($snCemeteryId)?$snCemeteryId:''),
            )
        );
    end_slot();

    slot('second_update');
        include_partial(
            'global/paging',
            array(
                'pager_search_result' => $oSerReportAsPerAreaList,
                'snPaging'            => $amExtraParameters['snPaging'],                                            
            )
        );  
    end_slot();

    slot('third_update');
        include_partial('global/notification_msg', array('amSuccessMsg' => $amSuccessMsg, 'amErrorMsg' => $amErrorMsg));
    end_slot();

    slot('forth_update');
        include_partial('global/total_items',array('snTotalItems'=> $snPageTotalSerReportAsPerPages));
    end_slot();

    echo javascript_tag(
        jq_update_element_function('contentlisting', array('content' => get_slot('first_update'))).
        jq_update_element_function('bottompagingdiv', array('content' => get_slot('second_update'),)).
        jq_update_element_function('success_msgs', array('content' => get_slot('third_update'),)).
        jq_update_element_function('no_of_items', array('content' => get_slot('forth_update'),))
    );

    if(sfContext::getInstance()->getRequest()->isXmlHttpRequest())
        echo javascript_tag('jQuery("#checkall").attr("checked", false); jQuery("#checkall2").attr("checked", false);');
?>
