<?php use_helper('pagination');
 ?>
 <h1>
	<?php echo __('Interment Records');?> 
	<span id="no_of_items"><?php include_partial('global/total_items',array('snTotalItems'=> $snPageTotalSearchInterment));?></span>
</h1>
<div id="main" class="listtable">
    <div class="maintablebg">
        <?php 
            if(count($amSearchIntermentList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('idinterment');
       
                echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">';
                	echo '<tbody>';
		               echo '<tr>';
							echo '<th width="20%" align="left" valign="top" class="none">';
								echo __('Name');
							echo '</th>';
							echo '<th width="10%" align="left" valign="top" class="none">';
								echo __('Date Of Birth');
							echo '</th>';
							echo '<th width="10%" align="left" valign="top" class="none">';
								echo __('Date Of Interment');
							echo '</th>';
							echo '<th width="5%" align="left" valign="top" class="none">';
								echo __('Action');
							echo '</th>';
                       echo '</tr>';

                        foreach($sf_data->getRaw('amSearchIntermentList') as $snKey=>$asValues):
							$ssClass = ($snKey%2 == 0) ? "even" : "odd";
                            echo '<tr class="'.$ssClass.'">';

								echo '<td align="left" valign="top">'.$asValues['name'].'</td>';
								$ssDOB = ($asValues['deceased_date_of_birth'] != '') ? $asValues['deceased_date_of_birth'] : __('Not Available');
								echo '<td align="left" valign="top">'.$ssDOB.'</td>';
								echo '<td align="left" valign="top">'.$asValues['interment_date'].'</td>';

                                echo '<td align="left" valign="top">';
                                echo link_to(__('Details'),
												 url_for('searchintermentplugin/displayInfo?id='.$asValues['id']),
												array('title'=> __('Display Grave, Grantee, Burial Information'),'class'=>'nyroModal link1'));
                                     //echo link_to_function(__('Details'),"showMoreDetails('".$asValues['id']."','show')", array('title' => __('Details') ));
                                echo '</td>';
                            echo '</tr>';
							echo '<tr id="moreDetails_'.$asValues['id'].'" style="display:none;">';
								echo '<td colspan="4">';
									echo '<table width="100%" cellpadding="2" cellspacing="2">';
										echo '<tr class="even">';
											echo '<td colspan="3">';
												echo '<strong>'.__('Interment Detail Information').'</strong>';
											echo '</td>';											
										echo '</tr>';
										echo '<tr class="odd">';
											echo '<td>'.__('Cemetery').'</td>';
											echo '<td>'.$asValues['cem_name'].'</td>';
											if($asValues['cemetery_map_path'] != ''):
												$ssCemeteryMapPath = sfConfig::get('app_site_url').sfConfig::get('app_upload_dir').'/'.sfConfig::get('app_mappath_dir').'/'.sfConfig::get('app_cemeter_dir').'/'.$asValues['cemetery_map_path'];
												echo '<td>'.link_to_function(__('See Map'),"displayMap('".$ssCemeteryMapPath."');return false;", array('title' => __('Details') )).'</td>';
											endif;
										echo '</tr>';
										echo '<tr class="even">';
											echo '<td>'.__('Area').'</td>';
											$ssArea = ($asValues['area_code'] != '') ? $asValues['area_code'] : __('N/A');
											echo '<td>'. $ssArea .'</td>';
											if($asValues['area_map_path'] != ''):
												$ssAreaMapPath = sfConfig::get('app_site_url').sfConfig::get('app_upload_dir').'/'.sfConfig::get('app_mappath_dir').'/'.sfConfig::get('app_area_dir').'/'.$asValues['area_map_path'];
												echo '<td>'.link_to_function(__('See Map'),"displayMap('".$ssAreaMapPath."');return false;", array('title' => __('Details') )).'</td>';
											endif;
										echo '</tr>';
										echo '<tr class="odd">';
											echo '<td>'. __('Section').'</td>';
											$ssSection = ($asValues['section_code'] != '') ? $asValues['section_code'] : __('N/A');
											echo '<td>'. $ssSection .'</td>';
											if($asValues['section_map_path'] != ''):
												$ssSectionMapPath = sfConfig::get('app_site_url').sfConfig::get('app_upload_dir').'/'.sfConfig::get('app_mappath_dir').'/'.sfConfig::get('app_section_dir').'/'.$asValues['section_map_path'];
												echo '<td>'.link_to_function(__('See Map'),"displayMap('".$ssSectionMapPath."');return false;", array('title' => __('Details') )).'</td>';
											endif;
										echo '</tr>';
										echo '<tr class="even">';
											echo '<td>'. __('Row') .'</td>';
											$ssRow = ($asValues['row_name'] != '') ? $asValues['row_name'] : __('N/A');
											echo '<td>'. $ssRow .'</td>';
											if($asValues['row_map_path'] != ''):
												$ssRowMapPath = sfConfig::get('app_site_url').sfConfig::get('app_upload_dir').'/'.sfConfig::get('app_mappath_dir').'/'.sfConfig::get('app_row_dir').'/'.$asValues['row_map_path'];
												echo '<td>'.link_to_function(__('See Map'),"displayMap('".$ssRowMapPath."');return false;", array('title' => __('Details') )).'</td>';
											endif;
										echo '</tr>';
										echo '<tr class="odd">';
											echo '<td>'. __('Plot') .'</td>';
											$ssPlot = ($asValues['plot_name'] != '') ? $asValues['plot_name'] : __('N/A');
											echo '<td>'. $ssPlot .'</td>';
											if($asValues['plot_map_path'] != ''):
												$ssPlotMapPath = sfConfig::get('app_site_url').sfConfig::get('app_upload_dir').'/'.sfConfig::get('app_mappath_dir').'/'.sfConfig::get('app_plot_dir').'/'.$asValues['section_map_path'];
												echo '<td>'.link_to_function(__('See Map'),"displayMap('".$ssPlotMapPath."');return false;", array('title' => __('Details') )).'</td>';
											endif;
										echo '</tr>';
										echo '<tr class="even">';
											echo '<td>'. __('Grave No.') .'</td>';
											echo '<td>'. $asValues['grave_number'] .'</td>';
										echo '</tr>';
										echo '<tr class="odd">';
											echo '<td>'. __('Cemetery Address') .'</td>';
											echo '<td>'. $asValues['cem_address'] .'</td>';
										echo '</tr>';
										echo '<tr class="even">';
											echo '<td>'. __('Cemetery Phone') .'</td>';
											echo '<td>'. $asValues['cem_phone'] .'</td>';
										echo '</tr>';
										echo '<tr class="odd">';
											echo '<td>'.__('Cemetery Fax').'</td>';
											echo '<td>'.$asValues['cem_fax'].'</td>';
										echo '</tr>';
										echo '<tr class="even">';
											echo '<td>'.__('Cemetery Email') .'</td>';
											echo '<td>'.$asValues['cem_email'] .'</td>';
										echo '</tr>';
										echo '<tr class="odd">';
											echo '<td>'.__('Cemetery URL') .'</td>';
											echo '<td>'.$asValues['cem_url'] .'</td>';
										echo '</tr>';
										echo '<tr class="even">';
											echo '<td>'. __('Grave Image') .'</td>';
											echo '<td>';
													$ssImagePath = sfConfig::get('app_site_url').sfConfig::get('app_upload_dir').'/'.sfConfig::get('app_graveimages_thumbnail_dir').'/';
													$ssImage = ($asValues['grave_image1'] != '') ? $ssImagePath.$asValues['grave_image1'] : ( ($asValues['grave_image2'] != '') ? $ssImagePath.$asValues['grave_image2'] : '/images/admin/noimage.jpeg');
													echo '<img src="'.$ssImage.'" alt="No Image"/>';
											echo '</td>';
										echo '</tr>';
										echo '<tr class="odd">';
											echo '<td align="center" colspan="3">';
                                    			echo link_to_function(__('Close'),"showMoreDetails('".$asValues['id']."','hide')", array('title' => __('Close') ));
											echo '</td>';
										echo '</tr>';
									echo '</table>';
								echo '</td>';
							echo '</tr>';
                        endforeach;
                    echo '</tbody>';
                echo '</table>';
            else:
                echo '<div class="warning-msg"><span>'.__('Record(s) not found').'</span></div>';
            endif;
    echo '</div>';
echo '</div>';
echo input_hidden_tag('sortby',$sortby);
echo input_hidden_tag('sortmode',$sortmode);
echo input_hidden_tag('inactivateIds'); 

include_partial(
	'global/listing_bottom',
	array(
		'amPagerSearchResults'  => $oSearchIntermentList, 
		'amExtraParameters'     => $amExtraParameters,
		'IsPlugin'				=> true
	)
);
?>

