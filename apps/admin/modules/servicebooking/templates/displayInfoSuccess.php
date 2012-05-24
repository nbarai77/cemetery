<?php 
    use_helper('pagination');
    use_javascript("http://maps.google.com/maps?file=api&v=2&sensor=true&key=".sfConfig::get('app_google_map_key'));
    $ssModuleName = $sf_params->get('module'); 
?>
<div id="wapper">
    <?php include_partial('global/indicator');?>
    <div class="clearb">&nbsp;</div>
<?php		
    $snGravePos = array_search($sf_params->get('id_grave'), $sf_data->getRaw('amLinkedGrave'));
    $snNextKey  = ((array_key_exists($snGravePos+1, $sf_data->getRaw('amLinkedGrave'))) ? true : false);
    $snPrvKey   = ((array_key_exists($snGravePos-1, $sf_data->getRaw('amLinkedGrave'))) ? true : false);
      
    $ssBackUrl  = ($sf_params->get('isearch')) ? 'intermentsearch/search?' : ( ($sf_params->get('gsearch')) ? 'gravesearch/addedit?back=true&' : 'servicebooking/interment?back=true&');
	      
    include_partial(
        'global/listing_top',
        array(
	        'form_name'             => '',
	        'id_checkboxes'         => 'id[]',
	        'inactivateIds'         => 'idgrave',
	        'update_div'            => 'success_msgs',
	        'url'                   => 'servicebooking/index?request_type=ajax_request',
	        'admin_act_status'      => 'status',
	        'admin_act_module'      => 'delete',
	        'bStatusButton'         => 'false',
	        'bChangeOrderButton'    => 'false',
	        'back_url'				=> ((!$sf_request->isXmlHttpRequest()) ? url_for($ssBackUrl.html_entity_decode($amExtraParameters['ssQuerystr'])) : ''),
	        'next_url'				=> (($sf_request->isXmlHttpRequest() && $snNextKey) ? url_for('servicebooking/displayInfo?gsearch=true&id_grave='.$amLinkedGrave[$snGravePos+1].'&linked_array='.base64_encode($ssLinkedArray)) : ''),
	            'previous_url'			=> (($sf_request->isXmlHttpRequest() && $snPrvKey) ? url_for('servicebooking/displayInfo?gsearch=true&id_grave='.$amLinkedGrave[$snGravePos-1].'&linked_array='.base64_encode($ssLinkedArray)) : ''),
	            'next_link'				=> ((!$sf_request->isXmlHttpRequest() && $snNextKey) ? url_for('servicebooking/displayInfo?id_grave='.$amLinkedGrave[$snGravePos+1].'&linked_array='.base64_encode($ssLinkedArray).(($sf_params->get('isearch')) ? '&isearch=true' : '').(($sf_params->get('gsearch')) ? '&gsearch=true' : '')) : ''),
	            'previous_link'			=> ((!$sf_request->isXmlHttpRequest() && $snPrvKey) ? url_for('servicebooking/displayInfo?id_grave='.$amLinkedGrave[$snGravePos-1].'&linked_array='.base64_encode($ssLinkedArray).(($sf_params->get('isearch')) ? '&isearch=true' : '').(($sf_params->get('gsearch')) ? '&gsearch=true' : '')) : ''),
	        'bDeleteButton'   		=> 'cemAdmin',
	        'checkbox'    			=> 'true',
        )
    );
?>
    <?php //if($sf_request->isXmlHttpRequest()): ?>
        <ul class="tab_content">
            <li id="detail_grave" class="active">
	            <?php 
		            echo link_to_function(
			            __('Grave'), 
			            'tabSelection("grave", "active");', 
			            array('title' => __('Grave Detail'))
		            ); 
	            ?>
            </li>
            <li id="detail_grantee">
	            <?php
		            echo link_to_function(
			            __('Grantee'), 
			            'tabSelection("grantee", "active");', 
			            array('title' => __('Grantee Detail'))
		            ); 
	            ?>
            </li>
            <li id="detail_burial">
	            <?php
                 echo link_to_function(
			            __('Burials/Ashes/Exhumations'), 
			            'tabSelection("burial", "active");', 
			            array('title' => __('Burials/Ashes/Exhumations Detail'))
		            ); 
	            ?>
            </li>
            <li id="detail_history">
	            <?php
		            echo link_to_function(
			            __('History'), 
			            'tabSelection("history", "active");', 
			            array('title' => __('Grave History'))
		            ); 
	            ?>
            </li>
        </ul>
    <?php //endif; ?>
    <div style="width:100%;float:left;">
        <div id="main">
            <!------------------- SHOW GRAVE DETAILS ----------------------->
	        <div id="grave" class="gravedetails">
	            <div class="clearb"></div>
	            <h1><?php echo __('Details of Grave');?></h1>
	            <div class="clearb"></div>
				<div class="<?php echo (($sf_request->isXmlHttpRequest()) ? 'gravedetailpopupbox' : 'gravedetailbox');?>">
					<?php if($sf_user->isSuperAdmin()): ?>
						<div class="fleft w48">
							<div class="fright title w48"><?php echo __('Country');?> :</div>	
							<div class="fleft details w48"><strong><?php echo $amDisplayInfo[0]['Country']['name'];?></strong></div>
						</div>
						<div class="fleft w48">
							<div class="fright title w48"><?php echo __('Cemetery');?> :</div>	
							<div class="fleft details w48"><strong><?php echo $amDisplayInfo[0]['CemCemetery']['name'];?></strong></div>				
						</div>
						<div class="clearb dottedline"></div>
					<?php endif; ?>
					<div class="fleft w48">
						<div class="fright title w48"><?php echo __('Area');?> :</div>	
						<div class="fleft details w48">
							<strong>
								<?php echo (isset($amDisplayInfo[0]['ArArea']['area_code']) && $amDisplayInfo[0]['ArArea']['area_code'] != '') ? $amDisplayInfo[0]['ArArea']['area_code'] : __('N/A');?>
							</strong>
						</div>
					</div>
					<div class="fleft w48">
						<div class="fright title w48"><?php echo __('Section');?> :</div>	
						<div class="fleft details w48">
							<strong>
								<?php echo (isset($amDisplayInfo[0]['ArSection']['section_code']) && $amDisplayInfo[0]['ArSection']['section_code'] != '') ? $amDisplayInfo[0]['ArSection']['section_code'] : __('N/A');?> 
							</strong>
						</div>
					</div>
					<div class="clearb dottedline"></div>
					<div class="fleft w48">
						<div class="fright title w48"><?php echo __('Row');?> :</div>	
						<div class="fleft details w48">
							<strong>
								<?php echo (isset($amDisplayInfo[0]['ArRow']['row_name']) && $amDisplayInfo[0]['ArRow']['row_name'] != '') ? $amDisplayInfo[0]['ArRow']['row_name'] : __('N/A');?> 
							</strong>
						</div>
					</div>
					<div class="fleft w48">
						<div class="fright title w48"><?php echo __('Block/Plot');?> :</div>	
						<div class="fleft details w48">
							<strong>
								<?php echo (isset($amDisplayInfo[0]['ArPlot']['plot_name']) && $amDisplayInfo[0]['ArPlot']['plot_name'] != '') ? $amDisplayInfo[0]['ArPlot']['plot_name'] : __('N/A');?>
							</strong>
						</div>				
					</div>
					<div class="clearb dottedline"></div>
					<div class="fleft w48">
						<div class="fright title w48"><?php echo __('Number');?> :</div>	
						<div class="fleft details w48"><strong>

			<?php //echo $amDisplayInfo[0]['grave_number']; ?> 
		                                <?php 
		                                    echo link_to($amDisplayInfo[0]['grave_number'],
		                                        'grave/addedit?id='.$amDisplayInfo[0]['grave_id'],
		                                        array('title'=>__('Edit Grave') ,'class'=>'link1'));
		                                ?>

</strong></div>
					</div>
					<div class="clearb"></div>
				</div>
	            <div class="clearb">&nbsp;</div>
				<?php //if($sf_request->isXmlHttpRequest()): ?>
				<div class="<?php echo (($sf_request->isXmlHttpRequest()) ? 'gravedetailpopupbox' : 'gravedetailbox');?>">
					<!---------------------- Map CAnvas -------------------->
					<div id="showmap">
						<table cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td valign="top">
									<div id="directionsPanel" style=" float:left; overflow:auto; width:300px;"></div>
								</td>
								<td>
									<div id="map_canvas" style="width:700px; height:350px; overflow:auto; float:left;"> </div>
								</td>
							</tr>
						</table>
					</div>
					<div class="clearb">&nbsp;</div>
					<!---------------------- Map Marker Click -------------------->
					<div id="grave_info" style="display:none;">
						<strong style="font-family: Arial, Helvetica, sans-serif; font-size:14px;"><u><?php echo __('Grave Details');?></u></strong>
						<div style="font-family: Arial, Helvetica, sans-serif; font-size:13px;">
							<div><?php echo '<b>'.__('Cemetery: ').'</b>'.$ssCemetery;?></div>	
							<div><?php echo '<b>'.__('Area:').'</b>'.'&nbsp;'.$ssArea ;?> </div>
							<div><?php echo '<b>'.__('Section:').'</b>'.'&nbsp;'.$ssSection;?></div>
							<div><?php echo '<b>'.__('Row:').'</b>'.'&nbsp;'.$ssRow;?></div>
							<div><?php echo '<b>'.__('Plot:').'</b>'.'&nbsp;'.$ssPlot;?></div>
							<div><?php echo '<b>'.__('Grave: ').'</b>'.$ssGrave;?></div>	
						</div>
					</div>
					
				</div>
                <?php //endif;?>
                <div class="clearb">&nbsp;</div>   
            </div>	
            <!------------------- SHOW LIST OF ALL GRANTEES ----------------------->
			<div id="grantee" class="gravedetails">
				<div class="clearb"></div>
	            <h1><?php echo __('Grantee(s)');?></h1>
	            <div class="clearb"></div>
				<?php if(count($amDisplayInfo[0]['Grantee']) > 0):
		            foreach($amDisplayInfo[0]['Grantee'] as $snKey=>$asValues): ?>
						<div class="<?php echo (($sf_request->isXmlHttpRequest()) ? 'gravedetailpopupbox' : 'gravedetailbox');?>">
					        <div class="fleft w48">
						        <div class="fright title w48"><?php echo __('Identity'); ?> :</div>	
						        <div class="fleft details w48">
							        <strong>
							            <?php 
							                $ssGranteeIdentity = ($asValues['GranteeIdentity']['name'] != '') ? $asValues['GranteeIdentity']['name'] : '-';
							                echo $ssGranteeIdentity; 
                                        ?>
                                    </strong>
						        </div>
					        </div>
					        <div class="fleft w48">
						        <div class="fright title w48"><?php echo __('Identity Number'); ?> :</div>	
						        <div class="fleft details w48">
							        <strong>
							            <?php 
							                $ssGranteeIdentityNo = ($asValues['grantee_identity_number'] != '') ? $asValues['grantee_identity_number'] : '-';
							                echo $ssGranteeIdentityNo; 
                                        ?>
                                    </strong>
						        </div>
					        </div>
					        <div class="clearb dottedline"></div>
					        <div class="fleft w48">
						        <div class="fright title w48"><?php echo __('Surname');?> :</div>	
						        <div class="fleft details w48">
							        <strong>
								    <?php 
					                    $ssGranteeSurname = ($asValues['GranteeDetails']['grantee_surname'] != '') ? $asValues['GranteeDetails']['grantee_surname'] : '-';
					                    echo $ssGranteeSurname;
				            	    ?>
							        </strong>
						        </div>
					        </div>
					        <div class="fleft w48">
						        <div class="fright title w48"><?php echo __('First Name');?> :</div>	
						        <div class="fleft details w48">
							        <strong>
                                    <?php 
                                        $ssGranteeName = ($asValues['GranteeDetails']['grantee_first_name'] != '') ? $asValues['GranteeDetails']['grantee_first_name'] : '-';
									    $ssGranteeName = ($asValues['GranteeDetails']['title'] != '') ? $asValues['GranteeDetails']['title'].'&nbsp;'.$ssGranteeName : $ssGranteeName;

										
											echo link_to($ssGranteeName, url_for('granteedetails/addedit?id='.$asValues['GranteeDetails']['grantee_id']),array('title'=>__('Edit Grantee Details') ,'class'=>'link1'));
									
									    
				               		 ?>
							        </strong>
						        </div>				
					        </div>
					        <div class="clearb dottedline"></div>
					        <div class="fleft w48">
						        <div class="fright title w48"><?php echo __('Date of Interment');?> :</div>	
						        <div class="fleft details w48"><strong>
                                <?php 
                                if($asValues['date_of_purchase'] != ''):
                                    echo date('d-m-Y',strtotime($asValues['date_of_purchase']));
                                else:
                                    echo '00-00-0000';
                                endif; ?></strong></div>
					        </div>
					        <div class="clearb"></div>
				        </div>
				        <div class="clearb">&nbsp;</div>
				<?php endforeach;
		            else:
			            echo '<div class="warning-msg"><span>'.__('Grantee(s) not found').'</span></div><div class="clearb">&nbsp;</div>';
		            endif;
	            ?>
			</div>
            <!------------------- SHOW LIST OF ALL INTERMENTS/ASHES/EXHUMATIONS ----------------------->
            <div id="burial" class="gravedetails">
			    <div class="clearb"></div>
                <h1><?php echo __('Burials/Ashes/Exhumations');?></h1>
                <div class="clearb"></div>
			    <?php if(count($amDisplayInfo[0]['IntermentBooking']) > 0):
	                foreach($amDisplayInfo[0]['IntermentBooking'] as $snKey=>$asValues): ?>
					    <div class="<?php echo (($sf_request->isXmlHttpRequest()) ? 'gravedetailpopupbox' : 'gravedetailbox');?>">
				            <div class="fleft w48">
					            <div class="fright title w48"><?php echo __('Control Number');?> :</div>	
					            <div class="fleft details w48">
						            <strong>
						                <?php 
						                    $ssControlNo = ($asValues['IntermentBookingFour'][0]['control_number'] != '') ? $asValues['IntermentBookingFour'][0]['control_number'] : '-';
						                    echo $ssControlNo; 
                                        ?>
                                    </strong>
					            </div>
				            </div>
				            <div class="fleft w48">
					            <div class="fright title w48"><?php echo __('Surname');?> :</div>	
					            <div class="fleft details w48">
						            <strong>
						                <?php 
					                        $ssDeceasedSurname = ($asValues['deceased_surname'] != '') ? $asValues['deceased_surname'] : '-';
					                        echo $ssDeceasedSurname;
				                        ?>
                                    </strong>
					            </div>
				            </div>
				            <div class="clearb dottedline"></div>
				            <div class="fleft w48">
					            <div class="fright title w48"><?php echo __('First Name');?> :</div>	
					            <div class="fleft details w48">
						            <strong>
							            <?php 
					                        $ssDeceasedFirstName = ($asValues['deceased_first_name'] != '') ? $asValues['deceased_first_name'] : '-';
					                        $ssDeceasedFirstName = ($asValues['deceased_title'] != '') ? $asValues['deceased_title'].'&nbsp;'.$ssDeceasedFirstName : $ssDeceasedFirstName;

										
											echo link_to($ssDeceasedFirstName,
												url_for('servicebooking/addedit?id='.$asValues['interment_id']),
												array('title'=>__('Edit Booking')));
										
					                        
				                        ?>
						            </strong>
					            </div>
				            </div>
				            <div class="fleft w48">
					            <div class="fright title w48"><?php echo __('Service Type');?> :</div>	
					            <div class="fleft details w48">
						            <strong>
						                <?php 
						                    $ssServiceType = ($asValues['ServiceType']['name'] != '') ? $asValues['ServiceType']['name'] : '-';
						                    echo $ssServiceType; 
                                        ?>
                                    </strong>
					            </div>				
				            </div>
				            <div class="clearb dottedline"></div>
				            <div class="fleft w48">
					            <div class="fright title w48"><?php echo __('Date of Interment');?> :</div>	
					            <div class="fleft details w48">
					                <strong> 
					                    <?php
						                    if($asValues['interment_date'] != ''):
							                    list($snYear,$snMonth,$snDay) = explode('-', $asValues['interment_date']);
							                    echo $ssIntermentDate = $snDay.'-'.$snMonth.'-'.$snYear;
						                    else:
							                    echo '00-00-0000';
						                    endif;
				                        ?>
                                    </strong>
                                </div>
				            </div>
				            <div class="fleft w48">
					            <div class="fright title w48"><?php echo __('Age');?> :</div>	
					            <div class="fleft details w48">
					                <strong> 
					                    <?php
						                    if($asValues['IntermentBookingFour'][0]['deceased_date_of_birth'] != ''):
							                    //list($snYear,$snMonth,$snDay) = explode('-', $asValues['IntermentBookingFour'][0]['deceased_date_of_birth']);
							                    //echo $ssDOB = $snDay.'-'.$snMonth.'-'.$snYear;
                                                $asAge = sfGeneral::dateDifference($asValues['IntermentBookingFour'][0]['deceased_date_of_birth'],date('Y-m-d'));
                                                echo ((isset($asAge[0]) && $asAge[0] != '')?$asAge:''); 
						                    else:
							                    echo '-';
						                    endif;
				                        ?>
					                </strong>
					            </div>
				            </div>
				            <div class="clearb dottedline"></div>
				            <div class="fleft w48">
					            <div class="fright title w48"><?php echo __('Date of Death');?> :</div>	
					            <div class="fleft details w48">
					                <strong> 
					                    <?php
					                        if( $asValues['IntermentBookingFour'][0]['deceased_date_of_death'] != ''):
						                        list($snYear,$snMonth,$snDay) = explode('-', $asValues['IntermentBookingFour'][0]['deceased_date_of_death']);
						                        echo $ssDOD = $snDay.'-'.$snMonth.'-'.$snYear;
					                        else:
						                        echo '-';
					                        endif;
				                        ?>
					                </strong>
					            </div>
				            </div>
				            <div class="clearb"></div>
			            </div>
			            <div class="clearb">&nbsp;</div>
			    <?php endforeach;
	                else:
		                echo '<div class="warning-msg"><span>'.__('Burials/Ashes/Exhumations not found').'</span></div><div class="clearb">&nbsp;</div>';
	                endif;
                ?>
		    </div>
            <!------------------- SHOW GRAVE HISTORY ----------------------->
            <?php //if($sf_request->isXmlHttpRequest()): ?>
            <div id="history" class="gravedetails">
				<div class="clearb"></div>
	            <h1><?php echo __('Grave History');?></h1>
	            <div class="clearb"></div>
				<?php if(count($amGraveHistoryList) > 0):
		            foreach($sf_data->getRaw('amGraveHistoryList') as $snKey=>$asValues): ?>
						<div class="<?php echo (($sf_request->isXmlHttpRequest()) ? 'gravedetailpopupbox' : 'gravedetailbox');?>">
					        <div class="fleft w48">
						        <div class="fright title w48"><?php echo __('Surrender From'); ?> :</div>	
						        <div class="fleft details w48">
							        <strong>
<?php echo ($asValues['surrender_from_name'] != '') ? link_to($asValues['surrender_from_name'], url_for('granteedetails/addedit?id='.$asValues['grantee_details_id']),array('title'=>__('Edit Grantee Details') ,'class'=>'link1')) : '-'; ?>



</strong>
						        </div>
					        </div>
					        <div class="fleft w48">
						        <div class="fright title w48"><?php echo __('Surrender To'); ?> :</div>	
						        <div class="fleft details w48">
							        <strong><?php echo ($asValues['surrender_from_to'] != '') ? link_to($asValues['surrender_from_to'], url_for('granteedetails/addedit?id='.$asValues['grantee_details_surrender_id']),array('title'=>__('Edit Grantee Details') ,'class'=>'link1')) : '-'; ?></strong>


						        </div>
					        </div>
					        <div class="clearb dottedline"></div>
					        <div class="fleft w48">
						        <div class="fright title w48"><?php echo __('Date Of Surrender'); ?> :</div>	
						        <div class="fleft details w48" id="div_upd_transfer_date_<?php echo $asValues['id'];?>">
							        <strong>
								        <?php echo date('d-m-Y',strtotime($asValues['surrender_date']));?>
							        </strong>
						        </div>
					        </div>
					        <div class="fleft w48">
						        <div class="fright title w48"><?php echo __('Grave Number'); ?> :</div>	
						        <div class="fleft details w48">
							        <strong>
		                                <?php 
		                                    echo link_to($amDisplayInfo[0]['grave_number'],
		                                        'grave/addedit?id='.$amDisplayInfo[0]['grave_id'],
		                                        array('title'=>__('Edit Grave') ,'class'=>'link1'));
		                                ?>
</strong>
						        </div>				
					        </div>
					        <div class="clearb"></div>
				        </div>
				        <div class="clearb">&nbsp;</div>
				<?php endforeach;
		            else:
			            echo '<div class="warning-msg"><span>'.__('Grave History not found').'</span></div><div class="clearb">&nbsp;</div>';
		            endif;
	            ?>
			</div>
			<?php //endif; ?>
        </div>
    </div>
    <div class="clearb">&nbsp;</div>
</div>
<?php
   // if($sf_request->isXmlHttpRequest()):
        $smLat     = ($smLat != '') ? $smLat : 0;
        $smLong    = ($smLong != '') ? $smLong : 0;
        $ssCemLat  = ($ssCemLat != '') ? $ssCemLat : 0;
        $ssCemLong = ($ssCemLong != '') ? $ssCemLong : 0;
        $smLat     = ($smLat != 0) ? $smLat : $ssCemLat;
        $smLong     = ($smLong != 0) ? $smLong : $ssCemLong;
        echo javascript_tag("
            jQuery(document).ready(function()
            {   
                tabSelection('grave', 'active');
                var smLat  = '".$smLat."';
                var smLong = '".$smLong."';
                var smCemLat  = '".$ssCemLat."';
                var smCemLong = '".$ssCemLong."';
                if(smLat != 0 && smLong != 0 && smCemLat != 0 && smCemLong != 0)
                    setTimeout('loadMap(".$smLat.",".$smLong.")', 200);
	            
	        });
            function tabSelection(id, ssClassName)
            { 
                var asTabs      = new Array('detail_grave', 'detail_grantee', 'detail_burial', 'detail_history');
	            var asUpdateDiv = new Array('grave', 'grantee', 'burial', 'history'); 

	            for(var i=0;i<asTabs.length;i++)
	            {
		            jQuery('#' + asTabs[i] ).removeClass(ssClassName);
	            }
	
	            jQuery('#detail_' + id).addClass(ssClassName);
	
	            for(var i=0;i<asUpdateDiv.length;i++)
	            {
		            jQuery('#' + asUpdateDiv[i] ).hide();
	            }
	            jQuery('#tab').val(id);
	            jQuery('#' + id).show();
            }
            function loadMap(smLat, smLong) 
            {
                if (GBrowserIsCompatible()) 
                {
	                var map = new GMap2(document.getElementById('map_canvas'));
	
	                var smStartPoint = new GLatLng(".$ssCemLat.", ".$ssCemLong.");
	                var smEndPoint = new GLatLng(smLat,smLong);
	
	                var smDirectionStartPoint = ".$ssCemLat."+','+".$ssCemLong.";
	                var smDirectionEndPoint = smLat+','+smLong;		
	
	                map.removeMapType(G_HYBRID_MAP);
	                map.addControl(new GMapTypeControl());
	                map.addControl(new GSmallMapControl());
	
	                var marker = new GMarker(smEndPoint);
	                map.addOverlay(marker);
	                map.setCenter(smEndPoint, 15);
	                GEvent.addListener(marker, 'click', function(){
		                marker.openInfoWindowHtml(document.getElementById('grave_info').innerHTML);
	                });
	
	                directionsPanel = document.getElementById('directionsPanel');
	                directions = new GDirections(map, directionsPanel);
	                directions.load(smDirectionStartPoint+' to '+smDirectionEndPoint);
                }
            }
        ");
   // endif;
?>
