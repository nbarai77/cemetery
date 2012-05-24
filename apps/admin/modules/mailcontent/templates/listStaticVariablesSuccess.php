<div id="wapper">  
	<div class="clearb">&nbsp;</div>  
    <?php
       include_partial(
				'global/listing_top',
				array(
					'form_name'             => $ssFormName,
					'id_checkboxes'         => 'id[]',
					'inactivateIds'         => 'idcountry',
					'update_div'            => 'success_msgs',
					'admin_act_status'      => 'status',
					'admin_act_module'      => 'delete',
					'bStatusButton'         => 'false',
					'bChangeOrderButton'    => 'false',
					'bDeleteButton'    		=> 'cemAdmin',
					'checkbox'    			=> 'true',
					'back_url'				=> url_for('mailcontent/index?'.html_entity_decode($amExtraParameters['ssQuerystr'])),
				)
			);
		echo '<h1>'.__('List of Static { } Varibales');
		echo '<span style="color:#FF0000; padding-left:30px;font-size:14px;">'.__("Note - Copy & Paste below variables into mail content for Print/Email %type%.", array("%type%" => ($sf_params->get('type') == 'letter') ? __('Letters') : __('Certificates'))).'</span>';
		echo '</h1>';
		

        echo '<div>';
            echo '<div style="width:100%;float:left;">';    
				echo '<div  id="contentlisting" >';
				  	 echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sub_table">';
							echo '<tr>';
								 	$snCnt = 0;$snCol = 4;
								 	if($sf_params->get('type') == 'letter'):
									    foreach(sfConfig::get('SF_LIST_STATIC_VARIABLES') as $snKey => $ssValue):
										    $snColspan = $snCol - (count(sfConfig::get('SF_LIST_STATIC_VARIABLES'))%4);
										    $ssColspanCriteria = (count(sfConfig::get('SF_LIST_STATIC_VARIABLES'))%4) != 0 ? 'colspan="'.$snColspan.'"' : '';
										    $snCnt++;
										    echo '<td valign="middle" align="left">';
											    echo '{'.$ssValue.'}';
										    echo '</td>';
										    if($snCnt >= $snCol):
											    $snCnt = 0;
											    echo '</tr><tr class="">';
										    endif;
									    endforeach;
                                    elseif($sf_params->get('type') == 'common_letter'):
									foreach(sfConfig::get('SF_COMMON_LETTER_STATIC_VARIABLES') as $snKey => $ssValue):
										    $snColspan = $snCol - (count(sfConfig::get('SF_COMMON_LETTER_STATIC_VARIABLES'))%4);
										    $ssColspanCriteria = (count(sfConfig::get('SF_COMMON_LETTER_STATIC_VARIABLES'))%4) != 0 ? 'colspan="'.$snColspan.'"' : '';
										    $snCnt++;
										    echo '<td valign="middle" align="left">';
											    echo '{'.$ssValue.'}';
										    echo '</td>';
										    if($snCnt >= $snCol):
											    $snCnt = 0;
											    echo '</tr><tr class="">';
										    endif;
									endforeach;
                                    else:
                                        foreach(sfConfig::get('SF_LIST_STATIC_VARIABLES_CERTIFICATE') as $ssKey => $amCertificateVar):
                                            echo '<tr><td colspan="'.$snCol.'"><b style="padding-left:0px;">'.$amCertificateVar['title'].'</b></td></tr>';
                                            foreach($amCertificateVar['variable'] as $snKey => $ssValue):
										        $snColspan = $snCol - (count($amCertificateVar['variable'])%4);
										        $ssColspanCriteria = (count($amCertificateVar['variable'])%4) != 0 ? 'colspan="'.$snColspan.'"' : '';
										        $snCnt++;
										        echo '<td valign="middle" align="left">';
											        echo '{'.$ssValue.'}';
										        echo '</td>';
										        if($snCnt >= $snCol):
											        $snCnt = 0;
											        echo '</tr><tr class="">';
										        endif;
                                            endforeach;
                                            $snCnt = 0;
									    endforeach;
                                        /*
                                        // List of static variable for transfer grave burial certificate
                                        echo '<tr><td colspan="'.$snCol.'"><b>'.__('Transfer Grave Burial Certificate').'</b></td></tr>';
                                        foreach(sfConfig::get('SF_STATIC_VAR_TRANS_GRAVE_BURIAL_CERT') as $snKey => $ssValue):
										    $snColspan = $snCol - (count(sfConfig::get('SF_STATIC_VAR_TRANS_GRAVE_BURIAL_CERT'))%4);
										    $ssColspanCriteria = (count(sfConfig::get('SF_STATIC_VAR_TRANS_GRAVE_BURIAL_CERT'))%4) != 0 ? 'colspan="'.$snColspan.'"' : '';
										    $snCnt++;
										    echo '<td valign="middle" align="left">';
											    echo '{'.$ssValue.'}';
										    echo '</td>';
										    if($snCnt >= $snCol):
											    $snCnt = 0;
											    echo '</tr><tr class="">';
										    endif;
									    endforeach;
									    $snCnt = 0;
									    // List of static variable for burial licence certificate
									    echo '<tr><td colspan="'.$snCol.'"><b>'.__('Burial Licence Certificate').'</b></td></tr>';
									    foreach(sfConfig::get('SF_STATIC_VAR_BURIAL_LICENCE_CERT') as $snKey => $ssValue):
										    $snColspan = $snCol - (count(sfConfig::get('SF_STATIC_VAR_BURIAL_LICENCE_CERT'))%4);
										    $ssColspanCriteria = (count(sfConfig::get('SF_STATIC_VAR_BURIAL_LICENCE_CERT'))%4) != 0 ? 'colspan="'.$snColspan.'"' : '';
										    $snCnt++;
										    echo '<td valign="middle" align="left">';
											    echo '{'.$ssValue.'}';
										    echo '</td>';
										    if($snCnt >= $snCol):
											    $snCnt = 0;
											    echo '</tr><tr class="">';
										    endif;
									    endforeach;
									    $snCnt = 0;
									    // List of static variable for gave licence certificate
									    echo '<tr><td colspan="'.$snCol.'"><b>'.__('Grave Licence Certificate').'</b></td></tr>';
									    foreach(sfConfig::get('SF_STATIC_VAR_GRAVE_LICENCE_CERT') as $snKey => $ssValue):
										    $snColspan = $snCol - (count(sfConfig::get('SF_STATIC_VAR_GRAVE_LICENCE_CERT'))%4);
										    $ssColspanCriteria = (count(sfConfig::get('SF_STATIC_VAR_GRAVE_LICENCE_CERT'))%4) != 0 ? 'colspan="'.$snColspan.'"' : '';
										    $snCnt++;
										    echo '<td valign="middle" align="left">';
											    echo '{'.$ssValue.'}';
										    echo '</td>';
										    if($snCnt >= $snCol):
											    $snCnt = 0;
											    echo '</tr><tr class="">';
										    endif;
									    endforeach;
									    $snCnt = 0;
									    // List of static variable for grantee burial certificate
									    echo '<tr><td colspan="'.$snCol.'"><b>'.__('Grantee Burial Certificate').'</b></td></tr>';
									    foreach(sfConfig::get('SF_STATIC_VAR_GRANTEE_BURIAL_CERT') as $snKey => $ssValue):
										    $snColspan = $snCol - (count(sfConfig::get('SF_STATIC_VAR_GRANTEE_BURIAL_CERT'))%4);
										    $ssColspanCriteria = (count(sfConfig::get('SF_STATIC_VAR_GRANTEE_BURIAL_CERT'))%4) != 0 ? 'colspan="'.$snColspan.'"' : '';
										    $snCnt++;
										    echo '<td valign="middle" align="left">';
											    echo '{'.$ssValue.'}';
										    echo '</td>';
										    if($snCnt >= $snCol):
											    $snCnt = 0;
											    echo '</tr><tr class="">';
										    endif;
									    endforeach;*/
                                    endif;
                	echo '</table>';
				echo '</div>';
            echo '</div>';

            echo '<div class="clearb">&nbsp;</div>';
        echo '</div>';    	
    ?>
</div>
