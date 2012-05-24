<ul class="<?php echo ( $sf_params->get('module') == 'summary') ? 'current' : 'select';?>">
	<li>
		<?php echo link_to('<b>'.__('Today').'</b>',url_for('summary/index'),array('title'=>__('Today')));?></b>
	</li>
</ul>

<div class="nav-divider">&nbsp;</div>
					
<ul class="<?php echo (($sf_params->get('module') == 'workorder' || $sf_params->get('module') == 'gravemaintenance' || $sf_params->get('module') == 'tasknotes' || $sf_params->get('module') == 'departments') ? 'current': 'select')?>">
	<li>
		<a href="JavaScript:void(0);" title="<?php echo __('Work Flow');?>"><b><?php echo __('Work Flow');?></b><!--[if IE 7]><!--></a><!--<![endif]-->
	<!--[if lte IE 6]><table><tr><td><![endif]-->
	<div class="select_sub show">
		<ul class="sub">
			<?php
				$ssTaskNotesSelected = ($sf_params->get('module') == 'tasknotes' && $sf_params->get('action') == 'index') ? 'class="sub_show"': '';
				echo '<li '.$ssTaskNotesSelected.'>'.link_to(__('Tasks/Notes'),url_for('tasknotes/index'), array('title'=>__('Tasks/Notes') )).'</li>';
				
				$ssAnnualCareSelected = ($sf_params->get('module') == 'gravemaintenance' && $sf_params->get('action') == 'index') ? 'class="sub_show"': '';
				echo '<li '.$ssAnnualCareSelected.'>'.link_to(__('Annual Care'),url_for('gravemaintenance/index'),array('title'=>__('Annual Care') )).'</li>';
				
				$ssWorkorderSelected = ($sf_params->get('module') == 'workorder' && $sf_params->get('action') == 'index') ? 'class="sub_show"': '';
				echo '<li '.$ssWorkorderSelected.'>'.link_to(__('Work Order'),url_for('workorder/index'),array('title'=>__('Work Order') )).'</li>';
				
				$ssDepartmentSelected = ($sf_params->get('module') == 'departments' && $sf_params->get('action') == 'index') ? 'class="sub_show"': '';
				echo '<li '.$ssDepartmentSelected.'>'.link_to(__('Delegation'),url_for('departments/index'),array('title'=>__('Delegation') )).'</li>';
            ?>
		</ul>
	</div>
	<!--[if lte IE 6]></td></tr></table></a><![endif]-->
	</li>
</ul>

<div class="nav-divider">&nbsp;</div>

<ul class="<?php echo ( (( $sf_params->get('module') == 'user' && $sf_params->get('action') == 'index') || $sf_params->get('module') == 'admin') ? 'current' : 'select'); ?>">
	<li>
		<a href="JavaScript:void(0);" title="<?php echo __('User Setup');?>"><b><?php echo __('User Setup');?></b><!--[if IE 7]><!--></a><!--<![endif]-->
	<!--[if lte IE 6]><table><tr><td><![endif]-->
	<div class="select_sub show">
		<ul class="sub">
			<?php
				$ssUsersSelected = ($sf_params->get('module') == 'user' && $sf_params->get('action') == 'index') ? 'class="sub_show"': '';				
				echo '<li '.$ssUsersSelected.'>'.link_to(__('Users'),url_for('user/index'),array('title'=>__('Users') )).'</li>';
			?>
		</ul>
	</div>
	<!--[if lte IE 6]></td></tr></table></a><![endif]-->
	</li>
</ul>

<div class="nav-divider">&nbsp;</div>

<ul class="<?php echo (($sf_params->get('module') == 'cemetery' || $sf_params->get('module') == 'area' || $sf_params->get('module') == 'section' || $sf_params->get('module') == 'row' || $sf_params->get('module') == 'plot' || $sf_params->get('module') == 'grave' || $sf_params->get('module') == 'granteedetails' || ($sf_params->get('module') == 'grantee' && $sf_params->get('action') != 'granteeInvoice') || ($sf_params->get('module') == 'servicebooking' && $sf_params->get('action') == 'interment') || $sf_params->get('module') == 'fndirector' || $sf_params->get('module') == 'stonemason' || $sf_params->get('module') == 'mailcontent' ||  $sf_params->get('module') == 'chapel' ||  $sf_params->get('module') == 'room') ? 'current': 'select')?>">
	<li>
		<a href="JavaScript:void(0);" title="<?php echo __('Cemetery Actions');?>"><b><?php echo __('Cemetery Actions');?></b><!--[if IE 7]><!--></a><!--<![endif]-->
	<!--[if lte IE 6]><table><tr><td><![endif]-->
	<div class="select_sub show">
		<ul class="sub">
			<?php
				
				$ssSelectedCemetery = ($sf_params->get('module') == 'cemetery' && $sf_params->get('index') == 'index') ? 'class="sub_show"': '';
				echo '<li '.$ssSelectedCemetery.'>'.link_to(__('Cemetery'),url_for('cemetery/index'),array('title'=>__('Cemetery') )).'</li>';
				
				$ssSelectedArea = ($sf_params->get('module') == 'area' && $sf_params->get('action') == 'index') ? 'class="sub_show"': '';
				echo '<li '.$ssSelectedArea.'>'.link_to(__('Area'),url_for('area/index'),array('title'=>__('Area') )).'</li>';
				
				$ssSelectedSection = ($sf_params->get('module') == 'section' && $sf_params->get('action') == 'index') ? 'class="sub_show"': '';
				echo '<li '.$ssSelectedSection.'>'.link_to(__('Section'),url_for('section/index'),array('title'=>__('Section') )).'</li>';
				
				$ssSelectedRow = ($sf_params->get('module') == 'row' && $sf_params->get('action') == 'index') ? 'class="sub_show"': '';
				echo '<li '.$ssSelectedRow.'>'.link_to(__('Row'),url_for('row/index'),array('title'=>__('Row') )).'</li>';
				
				$ssSelectedPlot = ($sf_params->get('module') == 'plot' && $sf_params->get('action') == 'index') ? 'class="sub_show"': '';
				echo '<li '.$ssSelectedPlot.'>'.link_to(__('Plot'),url_for('plot/index'),array('title'=>__('Plot') )).'</li>';
				
				$ssSelectedGrave = ($sf_params->get('module') == 'grave' && $sf_params->get('action') == 'index') ? 'class="sub_show"': '';
				echo '<li '.$ssSelectedGrave.'>'.link_to(__('Grave'),url_for('grave/index?flag=true'),array('title'=>__('Grave') )).'</li>';
				
				$ssSelectedGrantee = ($sf_params->get('module') == 'granteedetails' && $sf_params->get('action') == 'index') ? 'class="sub_show"': '';
				echo '<li '.$ssSelectedGrantee.'>'.link_to(__('Grantee'),url_for('granteedetails/index?flag=true'),array('title'=>__('Grantee') )).'</li>';
				
				$ssSelectedChapel = ($sf_params->get('module') == 'chapel' && $sf_params->get('action') == 'index') ? 'class="sub_show"': '';
				echo '<li '.$ssSelectedChapel.'>'.link_to(__('Chapel'),url_for('chapel/index'),array('title'=>__('Chapel') )).'</li>';
				
				$ssSelectedRoom = ($sf_params->get('module') == 'room' && $sf_params->get('action') == 'index') ? 'class="sub_show"': '';
				echo '<li '.$ssSelectedRoom.'>'.link_to(__('Rooms'),url_for('room/index'),array('title'=>__('Rooms') )).'</li>';
      				
				$ssSelectedInterment = ($sf_params->get('module') == 'servicebooking' && $sf_params->get('action') == 'interment') ? 'class="sub_show"': '';
				echo '<li '.$ssSelectedInterment.'>'.link_to(__('Interment'),url_for('servicebooking/interment?flag=true'),array('title'=>__('Interment') )).'</li>';
				
				$ssSelectedLetters = ($sf_params->get('module') == 'mailcontent' && ($sf_params->get('action') == 'customCemetery' && $sf_params->get('type') == 'letter') ) ? 'class="sub_show"': '';
				$ssLettersActions = ($sf_user->isSuperAdmin()) ? 'customCemetery' : 'index';
				echo '<li '.$ssSelectedLetters.'>'.link_to(__('Letters'),url_for('mailcontent/'.$ssLettersActions.'?type=letter'),array('title'=>__('Letters') )).'</li>';
				
				$ssSelectedCertificate = ($sf_params->get('module') == 'mailcontent' && ($sf_params->get('action') == 'customCemetery' && $sf_params->get('type') == 'certificate') ) ? 'class="sub_show"': '';
				echo '<li '.$ssSelectedCertificate.'>'.link_to(__('Certificates'),url_for('mailcontent/'.$ssLettersActions.'?type=certificate'),array('title'=>__('Certificates') )).'</li>';
                
                $ssSelectedCommonLetters = ($sf_params->get('module') == 'mailcontent' && ($sf_params->get('action') == 'customCemetery' && $sf_params->get('type') == 'common_letter') ) ? 'class="sub_show"': '';
				echo '<li '.$ssSelectedCommonLetters.'>'.link_to(__('Daily Services'),url_for('mailcontent/'.$ssLettersActions.'?type=common_letter'),array('title'=>__('Daily Services') )).'</li>';
			?>
		</ul>
	</div>
	<!--[if lte IE 6]></td></tr></table></a><![endif]-->
	</li>
</ul>

<div class="nav-divider">&nbsp;</div>

<ul class="<?php echo (($sf_params->get('module') == 'facilitybooking' || ($sf_params->get('module') == 'servicebooking') && $sf_params->get('action') == 'index') ? 'current': 'select')?>">
	<li>
		<a href="JavaScript:void(0);" title="<?php echo __('Booking');?>"><b><?php echo __('Booking');?></b><!--[if IE 7]><!--></a><!--<![endif]-->
	<!--[if lte IE 6]><table><tr><td><![endif]-->
	<div class="select_sub show">
		<ul class="sub">
			<?php
					$ssSelectedFacility = ($sf_params->get('module') == 'facilitybooking' && $sf_params->get('action') == 'index') ? 'class="sub_show"': '';					
					echo '<li '.$ssSelectedFacility.'>'.link_to(__('Facility'),url_for('facilitybooking/index'),array('title'=>__('Facility Booking') )).'</li>';
					
					$ssSelectedBooking = ($sf_params->get('module') == 'servicebooking' && $sf_params->get('action') == 'index') ? 'class="sub_show"': '';
					echo '<li '.$ssSelectedBooking.'>'.link_to(__('Service'),url_for('servicebooking/index'),array('title'=>__('Service Booking') )).'</li>';
			?>
		</ul>
	</div>
	<!--[if lte IE 6]></td></tr></table></a><![endif]-->
	</li>
</ul>

<div class="nav-divider">&nbsp;</div>

<ul class="<?php echo (($sf_params->get('module') == 'gravesearch' || $sf_params->get('module') == 'granteesearch' || $sf_params->get('module') == 'intermentsearch' || $sf_params->get('module') == 'annualsearch') ? 'current': 'select')?>">
	<li>
		<a href="JavaScript:void(0);" title="<?php echo __('Search');?>"><b><?php echo __('Search');?></b><!--[if IE 7]><!--></a><!--<![endif]-->
	<!--[if lte IE 6]><table><tr><td><![endif]-->
	<div class="select_sub show">
		<ul class="sub">
			<?php
				$ssSelectedGSearch = ($sf_params->get('module') == 'gravesearch' && $sf_params->get('action') == 'addedit') ? 'class="sub_show"': '';				
				echo '<li '.$ssSelectedGSearch.'>'.link_to(__('Grave'),'gravesearch/addedit',array('title'=>__('Grave') )).'</li>';
				
				$ssSelectedGtSearch = ($sf_params->get('module') == 'granteesearch' && $sf_params->get('action') == 'search') ? 'class="sub_show"': '';
				echo '<li '.$ssSelectedGtSearch.'>'.link_to(__('Grantee'),'granteesearch/search',array('title'=>__('Grantee') )).'</li>';
				
				$ssSelectedIntSearch = ($sf_params->get('module') == 'intermentsearch' && $sf_params->get('action') == 'search') ? 'class="sub_show"': '';
				echo '<li '.$ssSelectedIntSearch.'>'.link_to(__('Interment'),'intermentsearch/search',array('title'=>__('Interment') )).'</li>';
				
				$ssSelectedAnnualSearch = ($sf_params->get('module') == 'annualsearch' && $sf_params->get('action') == 'report') ? 'class="sub_show"': '';
				echo '<li '.$ssSelectedAnnualSearch.'>'.link_to(__('Annual Care'),'annualsearch/report',array('title'=>__('Annual Care') )).'</li>';
			?>
		</ul>
	</div>
	<!--[if lte IE 6]></td></tr></table></a><![endif]-->
	</li>
</ul>

<div class="nav-divider">&nbsp;</div>

<ul class="<?php echo (($sf_params->get('module') == 'report' || $sf_params->get('module') == 'annualreport' || $sf_params->get('module') == 'gravelog') ? 'current': 'select')?>">
	<li>
		<a href="JavaScript:void(0);" title="<?php echo __('Report');?>"><b><?php echo __('Report');?></b><!--[if IE 7]><!--></a><!--<![endif]-->
	<!--[if lte IE 6]><table><tr><td><![endif]-->
	<div class="select_sub show">
		<ul class="sub">
			<?php
					$ssSelectedServiceReport = ($sf_params->get('module') == 'report' && $sf_params->get('action') == 'serviceReport') ? 'class="sub_show"': '';
			        echo '<li '.$ssSelectedServiceReport.'>'.link_to(__('Service Report'),'report/serviceReport',array('title'=>__('Service Report') )).'</li>';
					
					$ssSelectedGrvReport = ($sf_params->get('module') == 'report' && $sf_params->get('action') == 'gravePlotReport') ? 'class="sub_show"': '';
					echo '<li '.$ssSelectedGrvReport.'>'.link_to(__('Grave/Plot Report'),'report/gravePlotReport',array('title'=>__('Grave/Plot Report') )).'</li>';
					
					$ssSelectedCemReport = ($sf_params->get('module') == 'report' && $sf_params->get('action') == 'report') ? 'class="sub_show"': '';
					echo '<li '.$ssSelectedCemReport.'>'.link_to(__('Cemetery'),'report/report',array('title'=>__('Cemetery Report') )).'</li>';
					
					$ssSelectedOccupancyReport = ($sf_params->get('module') == 'report' && $sf_params->get('action') == 'occupancy') ? 'class="sub_show"': '';
					echo '<li '.$ssSelectedOccupancyReport.'>'.link_to(__('Occupancy'),'report/occupancy',array('title'=>__('Occupancy Report') )).'</li>';
					
					$ssSelectedAnnualReport = ($sf_params->get('module') == 'annualreport' && $sf_params->get('action') == 'index') ? 'class="sub_show"': '';
					echo '<li '.$ssSelectedAnnualReport.'>'.link_to(__('Annual Care'),'annualreport/index',array('title'=>__('Annual Care Report') )).'</li>';
					
					$ssSelectedGrvLog = ($sf_params->get('module') == 'gravelog' && $sf_params->get('action') == 'index') ? 'class="sub_show"': '';
					echo '<li '.$ssSelectedGrvLog.'>'.link_to(__('Grave Log'),url_for('gravelog/index'),array('title'=>__('Grave Log') )).'</li>';
					
					$ssSelectedGtLog = ($sf_params->get('module') == 'gravelog' && $sf_params->get('action') == 'granteeLog') ? 'class="sub_show"': '';
					echo '<li '.$ssSelectedGtLog.'>'.link_to(__('Grantee Log'),url_for('gravelog/granteeLog'),array('title'=>__('Grantee Log') )).'</li>';
					
					$ssSelectedBookingLog = ($sf_params->get('module') == 'gravelog' && $sf_params->get('action') == 'bookingLog') ? 'class="sub_show"': '';
					echo '<li '.$ssSelectedBookingLog.'>'.link_to(__('Booking Log'),url_for('gravelog/bookingLog'),array('title'=>__('Booking/Interment Log') )).'</li>';
			?>
		</ul>
	</div>
	<!--[if lte IE 6]></td></tr></table></a><![endif]-->
	</li>
</ul>

<div class="nav-divider">&nbsp;</div>

<ul class="<?php echo (($sf_params->get('module') == 'stonemasondocs' || $sf_params->get('module') == 'cemeterydocs') ? 'current': 'select')?>">
	<li>
		<a href="JavaScript:void(0);" title="<?php echo __('Documents');?>"><b><?php echo __('Documents');?></b><!--[if IE 7]><!--></a><!--<![endif]-->
	<!--[if lte IE 6]><table><tr><td><![endif]-->
	<div class="select_sub show">
		<ul class="sub">
			<?php
				$ssSelectedCemDoc = ($sf_params->get('module') == 'cemeterydocs' && $sf_params->get('action') == 'listDocuments') ? 'class="sub_show"': '';
				echo '<li '.$ssSelectedCemDoc.'>'.link_to(__('Cemetery'),url_for('cemeterydocs/listDocuments'),array('title'=>__('Cemetery') )).'</li>';
				
				$ssSelectedStoneDoc = ($sf_params->get('module') == 'stonemasondocs' && $sf_params->get('action') == 'index') ? 'class="sub_show"': '';				
				echo '<li '.$ssSelectedStoneDoc.'>'.link_to(__('Stone Mason'),url_for('stonemasondocs/index'),array('title'=>__('Stone Mason') )).'</li>';
			?>
		</ul>
	</div>
	<!--[if lte IE 6]></td></tr></table></a><![endif]-->
	</li>
</ul>

<div class="nav-divider">&nbsp;</div>

<ul class="<?php echo (($sf_params->get('module') == 'user' && $sf_params->get('action') == 'groupoffice') ? 'current': 'select')?>">
	<li>
		<?php echo link_to('<b>'.__('Intranet').'</b>',url_for('user/groupoffice'),array('title'=>__('Intranet')));?>
	</li>
</ul>

<div class="nav-divider">&nbsp;</div>

<ul class="<?php echo (($sf_params->get('module') == 'importcemetery') ? 'current': 'select')?>">
	<li>
		<a href="JavaScript:void(0);" title="<?php echo __('Import');?>"><b><?php echo __('Import');?></b><!--[if IE 7]><!--></a><!--<![endif]-->
	<!--[if lte IE 6]><table><tr><td><![endif]-->
	<div class="select_sub show">
		<ul class="sub">
			<?php
					$ssSelectedImpGrvData = ($sf_params->get('module') == 'importcemetery' && $sf_params->get('action') == 'importGraveData') ? 'class="sub_show"': '';
					echo '<li '.$ssSelectedImpGrvData.'>'.link_to(__('Grave'),url_for('importcemetery/importGraveData'),array('title'=>__('Grave Data') )).'</li>';
					
					$ssSelectedImpGtData = ($sf_params->get('module') == 'importcemetery' && $sf_params->get('action') == 'importGranteeData') ? 'class="sub_show"': '';
					echo '<li '.$ssSelectedImpGtData.'>'.link_to(__('Grantee'),url_for('importcemetery/importGranteeData'),array('title'=>__('Grantee Data') )).'</li>';
					
					$ssSelectedImpIntData = ($sf_params->get('module') == 'importcemetery' && $sf_params->get('action') == 'importIntermentsData') ? 'class="sub_show"': '';
					echo '<li '.$ssSelectedImpIntData.'>'.link_to(__('Interment'),url_for('importcemetery/importIntermentsData'),array('title'=>__('Interment Data') )).'</li>';
			?>
		</ul>
	</div>
	<!--[if lte IE 6]></td></tr></table></a><![endif]-->
	</li>
</ul>


<div class="nav-divider">&nbsp;</div>

<ul class="<?php echo ((($sf_params->get('module') == 'grantee' && $sf_params->get('action') == 'granteeInvoice') || ($sf_params->get('module') == 'grantee' && $sf_params->get('action') == 'transferGraveInvoice') || ($sf_params->get('module') == 'servicebooking' && $sf_params->get('action') == 'bookingInvoice') || ($sf_params->get('module') == 'catalog' && $sf_params->get('action') == 'index')) ? 'current': 'select')?>">
	<li>
		<a href="JavaScript:void(0);" title="<?php echo __('Export');?>"><b><?php echo __('Export');?></b><!--[if IE 7]><!--></a><!--<![endif]-->
	<!--[if lte IE 6]><table><tr><td><![endif]-->
	<div class="select_sub show">
		<ul class="sub">
			<?php
					$ssSelectedCatalog = ($sf_params->get('module') == 'catalog' && $sf_params->get('action') == 'index') ? 'class="sub_show"': '';
                    echo '<li '.$ssSelectedCatalog.'>'.link_to(__('Payment Catalog'),url_for('catalog/index'),array('title'=>__('Payment Catalog') )).'</li>';
                
                    $ssSelectedExpGrvData = ($sf_params->get('module') == 'grantee' && $sf_params->get('action') == 'granteeInvoice') ? 'class="sub_show"': '';
					echo '<li '.$ssSelectedExpGrvData.'>'.link_to(__('Grave Purchase Invoice'),url_for('grantee/granteeInvoice'),array('title'=>__('Grave Purchase Invoice') )).'</li>';
                    
                    $ssSelectedExppsrvData = ($sf_params->get('module') == 'servicebooking' && $sf_params->get('action') == 'bookingInvoice') ? 'class="sub_show"': '';
					echo '<li '.$ssSelectedExppsrvData.'>'.link_to(__('Service Booking  Invoice'),url_for('servicebooking/bookingInvoice'),array('title'=>__('Service Booking Invoice') )).'</li>';
                    
                    $ssSelectedExpwwTrnsData = ($sf_params->get('module') == 'grantee' && $sf_params->get('action') == 'transferGraveInvoice') ? 'class="sub_show"': '';
					echo '<li '.$ssSelectedExpwwTrnsData.'>'.link_to(__('Transfer Grave Invoice'),url_for('grantee/transferGraveInvoice'),array('title'=>__('Transfer Grave Invoice') )).'</li>';
			?>
		</ul>       
	</div>    
	<!--[if lte IE 6]></td></tr></table></a><![endif]-->
	</li>
</ul>


<div class="nav-divider">&nbsp;</div>

<ul class="<?php echo (($sf_params->get('module') == 'timeinout') ? 'current': 'select')?>">
	<li>
		<a href="JavaScript:void(0);" title="<?php echo __('Timesheet Detail');?>"><b><?php echo __('Timesheet Detail');?></b><!--[if IE 7]><!--></a><!--<![endif]-->
	<!--[if lte IE 6]><table><tr><td><![endif]-->
	<div class="select_sub show">
		<ul class="sub">
			<?php
				$ssSelectedAward = ($sf_params->get('module') == 'timeinout' && $sf_params->get('action') == 'index') ? 'class="sub_show"': '';
				echo '<li '.$ssSelectedAward.'>'.link_to(__('Award Template'),url_for('timeinout/index'),array('title'=>__('Award Tempalte') )).'</li>';
				
				$ssSelectedWeek = ($sf_params->get('module') == 'timeinout' && $sf_params->get('action') == 'clockinout') ? 'class="sub_show"': '';				
				echo '<li '.$ssSelectedWeek.'>'.link_to(__('Weekly Timesheet'),url_for('timeinout/clockinout'),array('title'=>__('Weekly Timesheet') )).'</li>';
			?>
		</ul>
	</div>
	<!--[if lte IE 6]></td></tr></table></a><![endif]-->
	</li>
</ul>
