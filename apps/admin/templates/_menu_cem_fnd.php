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
			?>
		</ul>
	</div>
	<!--[if lte IE 6]></td></tr></table></a><![endif]-->
	</li>
</ul>

<div class="nav-divider">&nbsp;</div>

<ul class="<?php echo ( $sf_params->get('module') == 'user') ? 'current' : 'select';?>">
	<li>
		<?php echo link_to('<b>'.__('Profile').'</b>',url_for('user/profile?id='.sfContext::getInstance()->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser')),
					array('title'=>__('Profile')));?>
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
					$ssSelectedTenative = ($sf_params->get('module') == 'servicebooking' && $sf_params->get('action') == 'index') ? 'class="sub_show"': '';
					echo '<li '.$ssSelectedTenative.'>'.link_to(__('Tentative'),url_for('servicebooking/index'),array('title'=>__('Tentative Booking') )).'</li>';
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
			?>
		</ul>
	</div>
	<!--[if lte IE 6]></td></tr></table></a><![endif]-->
	</li>
</ul>