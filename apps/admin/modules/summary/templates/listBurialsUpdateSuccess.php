<?php 
    use_helper('pagination'); 

    $ssModuleName = $sf_params->get('module');

    slot('first_update');
        include_partial(
            'burials_list_middle_part',
            array(
                'oBurialSummaryList'	=> $oBurialSummaryList,
                'amBurialSummaryList'  	=> $amBurialSummaryList,
                'amExtraParameters' => $amExtraParameters,
                'amSearch'          => $amSearch,                                                
                'ssModuleName'      => $ssModuleName,
                'sortby'            => $amExtraParameters['ssSortBy'],
                'sortmode'          => $amExtraParameters['ssSortMode'],
                'inactivateIds'     => 'idservicebooking',
				'snPageTotalBurialRecords' => $snPageTotalBurialRecords
            )
        );
    end_slot();

    slot('second_update');
        include_partial(
            'global/paging',
            array(
                'pager_search_result'   => $oBurialSummaryList,
                'snPaging'              => $amExtraParameters['snPaging'],
                'ssForm'				=> 'frm_list_burials'
            )
        );  
    end_slot();

    echo javascript_tag(
        jq_update_element_function('buriallisting', array('content' => get_slot('first_update'))).
        jq_update_element_function('bottompagingdiv', array('content' => get_slot('second_update')))
    );

    if(sfContext::getInstance()->getRequest()->isXmlHttpRequest())
        echo javascript_tag('$j("#checkall").attr("checked", false); $j("#checkall2").attr("checked", false);');
?>
