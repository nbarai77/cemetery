<?php 
/****************************************************
 * index.php
 *
 * @package    : Interment Search Plugin
 * @subpackage : view
 * @author     : Prakash Panchal
 * @version    : 1.0

****************************************************/
/*
include("../../../../members/bootstrap.php");
$oUser =  Am_Di::getInstance()->auth->getUser();

if($oUser == null)
	header('Location: http://interments.info/live/cemetery_live/web/searchPlugin/login.php');
*/

/*require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');      
$configuration = ProjectConfiguration::getApplicationConfiguration('admin', 'dev', true);
sfContext::createInstance($configuration);
sfProjectConfiguration::getActive()->loadHelpers('Url');
sfProjectConfiguration::getActive()->loadHelpers('JavascriptBase');
sfProjectConfiguration::getActive()->loadHelpers('jQuery');
sfProjectConfiguration::getActive()->loadHelpers('Form');
sfProjectConfiguration::getActive()->loadHelpers('I18N');*/


if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
{	
	$ssSurname 	= isset($_REQUEST['surname']) ? $_REQUEST['surname'] : '';
	$ssName 	= isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
	$snYrFrom 	= isset($_REQUEST['yrfrom']) ? $_REQUEST['yrfrom'] : '';
	$snYrTo 	= isset($_REQUEST['yrto']) ? $_REQUEST['yrto'] : '';
	$snPagging	= isset($_REQUEST['paging']) ? $_REQUEST['paging'] : 10;
	$snPage		= isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
	$ssRequired = '';
	
	if(trim($ssSurname) != '' && trim($ssName) != '')
	{
		include_once("class/search.class.php");
		include_once("class/xmlParser.class.php");
	
		$oCommonSearch 	= new CommonSearch();
		$oResponse 	= $oCommonSearch->searchInterments($ssSurname, $ssName, $snYrFrom, $snYrTo, $snPage, $snPagging);
			
		$oXml = new xmlParser();
		$amResponse = $oXml->xml2array($oResponse);	
	}
	else
	{
		echo $ssRequired = "Please enter compulsory fields";exit;
	}
}
echo '<h1>';
	echo 'Results - <span id="no_of_items">'.$amResponse['interments']['response']['totalrecord'].' Items';	
echo '</h1>';
$amResultSet = $amResponse['interments']['response']['data']['row'];
if(!isset($amResultSet[0]))
	$amResultSet = array(0 => $amResultSet);

echo '<div id="main" class="listtable">';
    echo'<div class="maintablebg">';
            if($amResponse['interments']['response']['totalrecord'] > 0):
                echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">';
                	echo '<tbody>';
		               echo '<tr>';
							echo '<th width="20%" align="left" valign="top" class="none">';
								echo 'Name';
							echo '</th>';
							echo '<th width="10%" align="left" valign="top" class="none">';
								echo 'Date Of Birth';
							echo '</th>';
							echo '<th width="10%" align="left" valign="top" class="none">';
								echo 'Date Of Interment';
							echo '</th>';
							echo '<th width="5%" align="left" valign="top" class="none">';
								echo 'Action';
							echo '</th>';
                       echo '</tr>';

                       foreach($amResultSet as $snKey=>$asValues):
                       $ssClass = ($snKey%2 == 0) ? "even" : "odd";
                            echo '<tr class="'.$ssClass.'">';

								echo '<td align="left" valign="top">'.$asValues['name'].'</td>';
								$ssDOB = (!empty($asValues['deceased_date_of_birth'])) ? $asValues['deceased_date_of_birth'] : 'Not Available';
								echo '<td align="left" valign="top">'.$ssDOB.'</td>';
								echo '<td align="left" valign="top">'.$asValues['interment_date'].'</td>';

                                echo '<td align="left" valign="top">';?>									
                                    <a onClick="showHideDiv('<?php echo $asValues['id'] ?>','show'); return false;" href="#" title="Details">Details</a>
									 <!--<img src="images/paypal.jpg" onclick="getpayment();" alt="Pay" />-->
									 <a href="pay.php?id=<?php echo base64_encode($asValues['id']);?>"><img src="images/paypal.jpg" alt="Pay" /></a>
								<?php	
                                echo '</td>';
                            echo '</tr>';
							echo '<tr id="moreDetails_'.$asValues['id'].'" style="display:none;">';
								echo '<td colspan="4">';
									echo '<table width="100%" cellpadding="2" cellspacing="2">';
										echo '<tr class="even">';
											echo '<td colspan="3">';
												echo '<strong>'.'Interment Detail Information'.'</strong>';
											echo '</td>';											
										echo '</tr>';
										echo '<tr class="odd">';
											echo '<td>'.'Cemetery'.'</td>';
											echo '<td>'.$asValues['cem_name'];
											if(!empty($asValues['cemetery_map_path'])):
												$ssCemeteryMapPath = SITE_URL.UPLOAD_DIR.'/'.MAP_PATH_DIR.'/'.CEMETER_MAP_PATH.'/'.$asValues['cemetery_map_path'];?>
												<span style="float:right; padding-right:10px;">
												 <a onclick="displayMap('<?php echo $ssCemeteryMapPath ?>'); return false;" href="javascript: void(0);" title="See Map">See Map</a>
												</span>
											<?php
											echo '</td>';
											endif;
										echo '</tr>';
										echo '<tr class="even">';
											echo '<td>'.'Area'.'</td>';
											$ssArea = ( !empty($asValues['area_code']) ) ? $asValues['area_code'] : 'N/A';
											echo '<td>'. $ssArea .'</td>';
											if(!empty($asValues['area_map_path'])):
												$ssAreaMapPath = SITE_URL.UPLOAD_DIR.'/'.MAP_PATH_DIR.'/'.AREA_MAP_PATH.'/'.$asValues['area_map_path'];
												echo "<td>";?>
												<a onclick="displayMap('<?php echo $ssAreaMapPath ?>'); return false;" href="javascript: void(0);" title="See Map">See Map</a>
												<?php
												echo "</td>";
											endif;
										echo '</tr>';
										echo '<tr class="odd">';
											echo '<td>'. 'Section'.'</td>';
											$ssSection = ( !empty($asValues['section_code']) ) ? $asValues['section_code'] : 'N/A';
											echo '<td>'. $ssSection;
											if(!empty($asValues['section_map_path'])):
												$ssSectionMapPath = SITE_URL.UPLOAD_DIR.'/'.MAP_PATH_DIR.'/'.SECTION_MAP_PATH.'/'.$asValues['section_map_path'];?>
												<span style="float:right; padding-right:10px;">
													<a onclick="displayMap('<?php echo $ssSectionMapPath ?>'); return false;" href="javascript: void(0);" title="See Map">See Map</a>
												</span>	
											<?php
											endif;
											echo "</td>";
										echo '</tr>';
										echo '<tr class="even">';
											echo '<td>'. 'Row' .'</td>';
											$ssRow = ( !empty($asValues['row_name']) ) ? $asValues['row_name'] : 'N/A';
											echo '<td>'. $ssRow;
											if(!empty($asValues['row_map_path'])):
												$ssRowMapPath = SITE_URL.UPLOAD_DIR.'/'.MAP_PATH_DIR.'/'.ROW_MAP_PATH.'/'.$asValues['row_map_path'];?>
												<span style="float:right; padding-right:10px;">
													<a onclick="displayMap('<?php echo $ssRowMapPath ?>'); return false;" href="javascript: void(0);" title="See Map">See Map</a>
												</span>
											<?php
											endif;
											echo "</td>";
										echo '</tr>';
										echo '<tr class="odd">';
											echo '<td>'.'Plot'.'</td>';
											$ssPlot = ( !empty($asValues['plot_name']) ) ? $asValues['plot_name'] : 'N/A';
											echo '<td>'. $ssPlot;
											if(!empty($asValues['plot_map_path'])):
												$ssPlotMapPath = SITE_URL.UPLOAD_DIR.'/'.MAP_PATH_DIR.'/'.PLOT_MAP_PATH.'/'.$asValues['section_map_path'];
												echo "<td>";?>
												<span style="float:right; padding-right:10px;">
													<a onclick="displayMap('<?php echo $ssPlotMapPath ?>'); return false;" href="javascript: void(0);" title="See Map">See Map</a>
												</span>
											<?php
											endif;
											echo "</td>";											
										echo '</tr>';
										echo '<tr class="even">';
											echo '<td>Grave No</td>';
											echo '<td colspan="2">'. $asValues['grave_number'].'&nbsp;';
													$smLat = ( !empty($asValues['latitude']) ) ? $asValues['latitude'] : '';
													$smLong = ( !empty($asValues['longitude']) ) ? $asValues['longitude'] : '';
													
													if($smLat != '' && $smLong != ''):
														$amGraveDetails = array(
																	'cemetery'	=> $asValues['cem_name'],
																	'area'		=> $ssArea,
																	'section'	=> $ssSection,
																	'row'		=> $ssRow,
																	'plot'		=> $ssPlot,
																	'grave'		=> $asValues['grave_number'],
																	'latitude'	=> $asValues['latitude'],
																	'longitude'	=> $asValues['longitude']
																	);
													$ssRequestIds = base64_encode(implode(",", $amGraveDetails ));?>
													<span style="color:#258ECA;float:right; padding-right:10px;"><a onclick="window.open('seeOnMap.php?ssParams=<?php echo $ssRequestIds?>','mywindow','width=600,height=450'); return false;" href="#" title="See on map">See on map</a></span>
											<?php		
													endif;
											echo '</td>';
										echo '</tr>';
										echo '<tr class="odd">';
											echo '<td>'. 'Cemetery Address' .'</td>';
											echo '<td colspan="2">'. $asValues['cem_address'] .'</td>';
										echo '</tr>';
										echo '<tr class="even">';
											echo '<td>'. 'Cemetery Phone' .'</td>';
											echo '<td colspan="2">'. $asValues['cem_phone'] .'</td>';
										echo '</tr>';
										echo '<tr class="odd">';
											echo '<td>'.'Cemetery Fax'.'</td>';
											echo '<td colspan="2">'.$asValues['cem_fax'].'</td>';
										echo '</tr>';
										echo '<tr class="even">';
											echo '<td>'.'Cemetery Email' .'</td>';
											echo '<td colspan="2">'.$asValues['cem_email'] .'</td>';
										echo '</tr>';
										echo '<tr class="odd">';
											echo '<td>'.'Cemetery URL' .'</td>';
											echo '<td colspan="2">'.$asValues['cem_url'] .'</td>';
										echo '</tr>';
										echo '<tr class="even">';
											echo '<td>'. 'Grave Image' .'</td>';
											echo '<td colspan="2">';
													$ssImagePath = SITE_URL.UPLOAD_DIR.'/'.GRAVE_THUMB_DIR.'/';
													$ssImage = (!empty($asValues['grave_image1'])) ? $ssImagePath.$asValues['grave_image1'] : ( ( !empty($asValues['grave_image2']) ) ? $ssImagePath.$asValues['grave_image2'] : 'images/noimage.jpeg');
													echo '<img src="'.$ssImage.'" alt="No Image"/>';
											echo '</td>';
										echo '</tr>';
										echo '<tr class="odd">';
											echo '<td align="center" colspan="3">';?>
												<a onclick="showHideDiv('<?php echo $asValues['id'] ?>','hide'); return false;" href="javascript: void(0);" title="Close">Close</a>												
											<?php
											echo '</td>';
										echo '</tr>';
									echo '</table>';
								echo '</td>';
							echo '</tr>';
						endforeach;
						
			 		echo '</tbody>';
                echo '</table>';								
            else:
                echo '<div class="warning-msg"><span>Record(s) not found</span></div>';
            endif;
    echo '</div>';
echo '</div>';

//////////////////////////////////////////////////////////////////////////
//							PAGINATION									//
//////////////////////////////////////////////////////////////////////////
$bHaveToPaginate = $amResponse['interments']['response']['havetopaginate'];
if($bHaveToPaginate):
	$snCurrentPage = $amResponse['interments']['response']['currentpage'];	
	$snFirstPage = $amResponse['interments']['response']['firstpage'];
	$snLastPage = $amResponse['interments']['response']['lastpage'];
	
	echo '<div style="background:#ffffff;float:left;" class="actions">';
	  echo '<ul class="paggingDiv" id="bottompagingdiv">';
		if($snCurrentPage != 1):
			echo '<li><a onclick="setFirstPage('.$snFirstPage.',\'searchinterment\'); return false;" href="#" id="first"><img src="images/first.png" name="right" title="First"></a></li>';
			echo '<li><a onclick="setPreviousPage(\'searchinterment\'); return false;" href="#" id="previous"><img src="images/prev.png" name="right" title="Previous"></a></li>';
		else:
			echo '<li><img src="images/first-disable.png" name="right" title="First"></li>';
			echo '<li><img src="images/prev-disable.png" name="right" title="Previous"></li>';
		endif;
		echo '<li style="padding-top:4px;">';
		  echo '<ul>';
			echo '<li>';
			  echo '<input type="text" size="5" style="height:20px;" onkeydown="jumpTo('.$snLastPage.',event,\'searchinterment\');" name="jump_to" id="jump_to" value="'.$snCurrentPage.'">';
			echo '</li>';
		  echo '</ul>';
		echo '</li>';
		if ($snCurrentPage != $snLastPage):
			echo '<li><a onclick="setNextPage(\'searchinterment\'); return false;" href="#" id="next"><img src="images/next.png" title="Next"></a></li>';
			echo '<li><a onclick="setLastPage('.$snLastPage.',\'searchinterment\'); return false;" href="#" id="last"><img src="images/last.png" title="Last"></a></li>';
		else:
			echo '<li><img src="images/next-disable.png" title="Next"></li>';
			echo '<li><img src="images/last-disable.png" title="Last"></li>';
		endif;
	  echo '</ul>';
	echo '</div>';
endif;
?>
<script type="text/javascript" src="/sfJqueryReloadedPlugin/js/jquery-1.4.1.min.js"></script>
<script type="text/javascript" src="/js/admin/common.js"></script>
<script type="text/javascript" src="/js/nyroModal/jquery.nyroModal.custom.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps?file=api&v=2&sensor=true&key=<?php echo sfConfig::get('app_google_map_key');?>"></script>
<link rel="stylesheet" type="text/css" media="screen" href="/css/nyroModal/nyroModal.css" />
<form action="<?php echo PAYPAL_URL; ?>" method="post" id="payPalForm" name="payPalForm">
<input type="hidden" name="item_number" value="01 - TEST">
<input type="hidden" name="cmd" value="_xclick"><!-- if you want to show credit card information then pass this parameter -->
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="business" value="<?php echo MERCHANT_ID; ?>">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="return" value="<?php echo RETURN_URL; ?>">
<input type="hidden" name="cancle" value="<?php echo CANCEL_URL; ?>">
<input type="hidden" name="notify_url" value="<?php echo NOTIFY_URL; ?>">
<!--<input name="item_name" type="hidden" id="item_name" size="45">-->
<input type="hidden" name="currency" value="USD">
<input name="amount" type="hidden" id="amount" value="<?php echo AMT; ?>">
<!--<input type="submit" name="paypay" value="Paypal" />-->
</form>
<script type="text/javascript">
function getpayment()
{ 
	document.payPalForm.submit();
}

function showHideDiv(snId, ssType)
	{
		alert(213);
        if(ssType == "show")
			$("#moreDetails_"+snId).show();
		else
			$("#moreDetails_"+snId).hide();
	}
	function displayMap(ssMapPath)
	{
		window.open(ssMapPath,"mywindow","width=900,height=700");
	}
</script>