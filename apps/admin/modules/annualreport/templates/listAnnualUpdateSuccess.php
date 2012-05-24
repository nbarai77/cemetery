<?php 
    use_helper('pagination'); 

    $ssModuleName = $sf_params->get('module');

    slot('first_update');
        include_partial(
            'list_middle_part',
            array(
                'oAnnualReportList'	=> $oAnnualReportList,
                'amAnnualReportList'  	=> $amAnnualReportList,
                'amExtraParameters' => $amExtraParameters,
                'amSearch'          => $amSearch,                                                
                'ssModuleName'      => $ssModuleName,
                'sortby'            => $amExtraParameters['ssSortBy'],
                'sortmode'          => $amExtraParameters['ssSortMode'],
                'inactivateIds'     => 'idservicebooking',
				'snPageTotalAnnualReportRecords' => $snPageTotalAnnualReportRecords
            )
        );
    end_slot();

    slot('second_update');
        include_partial(
            'global/paging',
            array(
                'pager_search_result'   => $oAnnualReportList,
                'snPaging'              => $amExtraParameters['snPaging'],
                'ssForm'				=> 'frm_list_annualreport'
            )
        );  
    end_slot();

    echo javascript_tag(
        jq_update_element_function('contentlisting', array('content' => get_slot('first_update'))).
        jq_update_element_function('bottompagingdiv', array('content' => get_slot('second_update')))
    );

    if(sfContext::getInstance()->getRequest()->isXmlHttpRequest())
        echo javascript_tag('$j("#checkall").attr("checked", false); $j("#checkall2").attr("checked", false);');
?>
