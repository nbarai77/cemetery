<?php $ssBottomDivId = (isset($ssBottomDivId)) ? $ssBottomDivId : 'bottompagingdiv';?>
<div class="actions" style="background:#ffffff">
    <ul id="<?php echo $ssBottomDivId;?>" class="paggingDiv">
        <?php echo include_partial('global/paging', array('pager_search_result' => $amPagerSearchResults, 
														  'snPaging' => $amExtraParameters['snPaging'],
														  'ssForm'	=> (isset($ssForm)) ? $ssForm : '',
														  'snPaggingDropDown' => (isset($snPaggingDropDown)) ? $snPaggingDropDown : ''
														  )); ?>
    </ul>
</div>
