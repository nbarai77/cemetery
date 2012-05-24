<?php 
    use_helper('pagination');
    use_javascript("http://maps.google.com/maps?file=api&v=2&sensor=true&key=".sfConfig::get('app_google_map_key'));
    $ssModuleName = $sf_params->get('module'); 
?>
<div id="wapper">
    <?php include_partial('global/indicator');?>
    <div class="clearb">&nbsp;</div>
<?php		
    /*$snGravePos = array_search($sf_params->get('id_grave'), $sf_data->getRaw('amLinkedGrave'));
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
    );*/
?>
    <?php //if($sf_request->isXmlHttpRequest()): ?>
        <ul class="tab_content">
            <li id="detail_grave" class="active">
	            <?php 
		            echo link_to_function(
			            __('Grave Detail'), 
			            'tabSelection("grave", "active");', 
			            array('title' => __('Grave Detail'))
		            ); 
	            ?>
            </li>
            <li id="detail_grantee">
	            <?php
		            echo link_to_function(
			            __('Cemetery Detail'), 
			            'tabSelection("grantee", "active");', 
			            array('title' => __('Cemetery Detail'))
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
	            <h1><?php echo __('Grave Details');?></h1>
	            <div class="clearb"></div>
				<div class="<?php echo (($sf_request->isXmlHttpRequest()) ? 'gravedetailpopupbox' : 'gravedetailbox');?>">
					
					<div class="fleft w48">
						<div class="fright title w48"><?php echo __('Area');?> :</div>	
						<div class="fleft details w48">
							<strong>
								<?php 
								echo (isset($amDisplayInfo[0]['area_code']) && $amDisplayInfo[0]['area_code'] != '') ? $amDisplayInfo[0]['area_code'] : __('N/A');?>
							</strong>
						</div>
					</div>
					<div class="fleft w48">
						<div class="fright title w48"><?php echo __('Section');?> :</div>	
						<div class="fleft details w48">
							<strong>
								<?php                                 
                                echo (isset($amDisplayInfo[0]['section_code']) && $amDisplayInfo[0]['section_code'] != '') ? $amDisplayInfo[0]['section_code'] : __('N/A');?> 
							</strong>
						</div>
					</div>
					<div class="clearb dottedline"></div>
					<div class="fleft w48">
						<div class="fright title w48"><?php echo __('Row');?> :</div>	
						<div class="fleft details w48">
							<strong>
								<?php echo (isset($amDisplayInfo[0]['row_name']) && $amDisplayInfo[0]['row_name'] != '') ? $amDisplayInfo[0]['row_name'] : __('N/A');?> 
							</strong>
						</div>
					</div>
					<div class="fleft w48">
						<div class="fright title w48"><?php echo __('Block/Plot');?> :</div>	
						<div class="fleft details w48">
							<strong>
								<?php echo (isset($amDisplayInfo[0]['plot_name']) && $amDisplayInfo[0]['plot_name'] != '') ? $amDisplayInfo[0]['plot_name'] : __('N/A');?>
							</strong>
						</div>				
					</div>
					
					<div class="clearb dottedline"></div>
					<div class="fleft w48">
						<div class="fright title w48"><?php echo __('Number');?> :</div>	
						<div class="fleft details w48"><strong><?php
						echo (isset($amDisplayInfo[0]['grave_number']) && $amDisplayInfo[0]['grave_number'] != '') ? $amDisplayInfo[0]['grave_number'] : __('N/A');?>
						</strong></div>
					</div>
					
					
					<div class="fleft w48">
						<div class="fright title w48"><?php echo __('Grave image');?> :</div>	
						<div class="fleft details w48">
							<strong>
								<?php 
								$ssImagePath = sfConfig::get('app_site_url').sfConfig::get('app_upload_dir').'/'.sfConfig::get('app_graveimages_thumbnail_dir').'/';
								$ssImage = ($amDisplayInfo[0]['grave_image1'] != '') ? $ssImagePath.$amDisplayInfo[0]['grave_image1'] : ( ($amDisplayInfo[0]['grave_image2'] != '') ? $ssImagePath.$amDisplayInfo[0]['grave_image2'] : '/images/admin/noimage.jpeg');
								echo '<img src="'.$ssImage.'" alt="No Image"/>';?>
							</strong>
						</div>				
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
									<div id="directionsPanel" style=" float:left; overflow:auto; width:200px;"></div>
								</td>
								<td>
									<div id="map_canvas" style="width:700px; height:300px; overflow:auto; float:left;"> </div>
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
			
			<div id="grantee" class="gravedetails">
				<div class="clearb"></div>
	            <h1><?php echo __('Cemetry detail');?></h1>
	            <div class="clearb"></div>
				<?php //if(count($amDisplayInfo[0]['Grantee']) > 0):
		           // foreach($amDisplayInfo[0]['Grantee'] as $snKey=>$asValues): ?>
						<div class="<?php echo (($sf_request->isXmlHttpRequest()) ? 'gravedetailpopupbox' : 'gravedetailbox');?>">
					        <div class="fleft w48">
						        <div class="fright title w48"><?php echo __('Cemetry address'); ?> :</div>	
						        <div class="fleft details w48">
							        <strong>
							            <?php echo (isset($amDisplayInfo[0]['cem_address']) && $amDisplayInfo[0]['cem_address'] != '') ? $amDisplayInfo[0]['cem_address'] : __('N/A');?>
                                    </strong>
						        </div>
					        </div>
					        <div class="fleft w48">
						        <div class="fright title w48"><?php echo __('Cemetry phone'); ?> :</div>	
						        <div class="fleft details w48">
							        <strong>
							            <?php echo (isset($amDisplayInfo[0]['cem_phone']) && $amDisplayInfo[0]['cem_phone'] != '') ? $amDisplayInfo[0]['cem_phone'] : '';?>
                                    </strong>
						        </div>
					        </div>
					        <div class="clearb dottedline"></div>
					        <div class="fleft w48">
						        <div class="fright title w48"><?php echo __('Cemetry Fax');?> :</div>	
						        <div class="fleft details w48">
							        <strong>
								   <?php echo (isset($amDisplayInfo[0]['cem_fax']) && $amDisplayInfo[0]['cem_fax'] != '') ? $amDisplayInfo[0]['cem_fax'] : __('N/A');?>
							        </strong>
						        </div>
					        </div>
					        <div class="fleft w48">
						        <div class="fright title w48"><?php echo __('Cemetry email');?> :</div>	
						        <div class="fleft details w48">
							        <strong>
                                    <?php echo (isset($amDisplayInfo[0]['cem_email']) && $amDisplayInfo[0]['cem_email'] != '') ? $amDisplayInfo[0]['cem_email'] : __('N/A');?>
							        </strong>
						        </div>				
					        </div>
					        <div class="clearb dottedline"></div>
					        <div class="fleft w48">
						        <div class="fright title w48"><?php echo __('Cemetry URL');?> :</div>	
						        <div class="fleft details w48"><strong>
                                 <?php echo (isset($amDisplayInfo[0]['cem_url']) && $amDisplayInfo[0]['cem_url'] != '') ? $amDisplayInfo[0]['cem_url'] : __('N/A');?></strong></div>
					        </div>
					        <div class="clearb"></div>
				        </div>
				        <div class="clearb">&nbsp;</div>
				<?php //endforeach;
		            //else:
			           // echo '<div class="warning-msg"><span>'.__('Grantee(s) not found').'</span></div><div class="clearb">&nbsp;</div>';
		            //endif;
	            ?>
			</div>
			
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
