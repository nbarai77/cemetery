<?php 
    use_helper('pagination'); 

    $ssModuleName = $sf_params->get('module');

    slot('first_update');
        include_partial(
            'showMailDetails',
            array(
                'amCemMailsDetails' => $amCemMailsDetails,
                'amExtraParameters' => $amExtraParameters,
				'snMailId'			=> $snMailId,
				'snUserMailId'		=> $snUserMailId
            )
        );
    end_slot();

    echo javascript_tag(
        jq_update_element_function( 'contentlisting', array('content' => get_slot('first_update')))
    );
?>
