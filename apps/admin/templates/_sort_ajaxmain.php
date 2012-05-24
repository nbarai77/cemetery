<ul>
    <li><?php echo __('Sort');?></li>
    <li>
    	<?php
    		$ssSearchString = '';
    		foreach($amSearch as $ssKey => $aSearch):
                if(isset($amExtraParameters['ssSearch'.$aSearch['id']]) && $amExtraParameters['ssSearch'.$aSearch['id']] != '')
                    $ssSearchString .= '&search'.$aSearch['id'].'='.$amExtraParameters['ssSearch'.$aSearch['id']];
    		endforeach; 
    	?>
        <?php echo jq_link_to_remote(__('Ascending'),
                    array('update'   => $update_div,
                          'url'      => html_entity_decode($ssLink.'&sortby='.$ssFieldName.'&sortmode=asc&'.$amExtraParameters['ssSortQuerystr'].$ssSearchString),                          
                          'complete' =>"sortingdiv();"), array('title' => __('Ascending'))); ?>
    </li>
    <li>
        <?php echo jq_link_to_remote(__('Descending'),
                    array('update'   => $update_div,
                          'url'      => html_entity_decode($ssLink.'&sortby='.$ssFieldName.'&sortmode=desc&'.$amExtraParameters['ssSortQuerystr'].$ssSearchString),                          
                          'complete' =>"sortingdiv();"), array('title' => __('Descending'))); ?>
    </li>
</ul>
