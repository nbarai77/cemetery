<?php use_javascript('/sfFormExtraPlugin/js/double_list.js');
    //use_helper('pagination');
    $ssModuleName = $sf_params->get('module'); 
?>
 
	<?php 
		echo $oSummaryForm->renderFormTag(
			url_for($sf_params->get('module').'/'.'selectdate'.($oSummaryForm->getObject()->isNew() ? '?id='.$sf_params->get('id_letter') : '')), 
			array("name" => $oSummaryForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
		);
	include_partial('global/indicator');?>
	<h1><?php echo __('Generate Letter');?></h1>
    <div class="comletterbox">
		<div class="fleft title">
			<?php echo $oSummaryForm['service_date']->renderLabel($oSummaryForm['service_date']->renderLabelName());?> : 
		</div>
		<div class="fleft">
			<?php 
				if($oSummaryForm['service_date']->hasError()):
					echo $oSummaryForm['service_date']->renderError();
				endif;
				echo $oSummaryForm['service_date']->render(); 
			?>
	 </div>
	 <div class="clearb">&nbsp;</div>	
	  <div class="marL72">
	  	<div class="actions">
					<ul class="fleft">
						<li class="list1">
							<span>
								<?php 
									echo submit_tag(
										__('Generate PDF'), 
										array(
											'class'     => 'delete',
											'name'      => 'submit_button',
											'id'      => 'commonLetter',
											'title'     => __('Show'), 
											'tabindex'  => 2,
											'onclick'   => "jQuery('#tab').val('');"
										)
									);
								?>
							</span>
						</li>						
					</ul>
				</div>
	 </div>	
	</div>
</form>
<?php echo javascript_tag('
     $(document).ready(function() { 
	  $("#commonLetter").click(function(){
    	setTimeout(\'jQuery("#nryroclosebutton").trigger("click")\', 1500);	 	
		});
	 });');
?>