<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')
{    
    if(isset($_REQUEST['id_client']) && $_REQUEST['id_client'] != '')
    {
        $postfields = array();
        $postfields["clientid"] = $_REQUEST['id_client'];
        $asClientWiseDetail = getAndSetUserDetail('getclientsdetails',$postfields);        
       
        echo '
        <tr>
						<td>
							<table cellpadding="0" cellspacing="0" width="100%" border="0" class="border">
								<tr>
									<th width="100%" align="left">
										Client details
									</th>
									
								</tr>
								<tr>
									<td width="100%">
										<table cellpadding="0" cellspacing="0" border="0">
											<tr>
												<td align="right" width="30%" class="lab padd10"> FirstName:</td>
												<td width="5%" align="center" class="padd10">:</td>
												<td align="left" width="65%" class="padd10">'.$asClientWiseDetail['WHMCSAPI']['CLIENT']['FIRSTNAME'].'</td>
											</tr>
                                           
                                            <tr>
												<td align="right" width="30%" class="lab padd10"> Last name:</td>
												<td width="5%" align="center" class="padd10">:</td>
												<td align="left" width="65%" class="padd10">'.$asClientWiseDetail['WHMCSAPI']['CLIENT']['LASTNAME'].'</td>
											</tr>
                                            
                                             <tr>
												<td align="right" width="30%" class="lab padd10"> EMAIL:</td>
												<td width="5%" align="center" class="padd10">:</td>
												<td align="left" width="65%" class="padd10">'.$asClientWiseDetail['WHMCSAPI']['CLIENT']['EMAIL'].'</td>
											</tr>											
                                            <tr>
												<td align="right" width="30%" class="lab padd10"> ADDRESS:</td>
												<td width="5%" align="center" class="padd10">:</td>
												<td align="left" width="65%" class="padd10">'.$asClientWiseDetail['WHMCSAPI']['CLIENT']['ADDRESS1'].' '.$asClientWiseDetail['WHMCSAPI']['CLIENT']['ADDRESS2'].'</td>
											</tr>	
										</table>	
									</td>
								</tr>
							</table>
						</td>
					</tr>
        ';
        
        exit;
    }
    else
    {
        if($_POST['printbill'] == 'Yes')
        {
            include('sfTCPDFPlugin/lib/tcpdf/tcpdf.php');
            include('sfTCPDFPlugin/lib/sfTCPDF.class.php');

            $oPDF = new sfTCPDF();
			
			// set document information
			$oPDF->SetCreator(PDF_CREATOR);
			
			// set default header data
			$oPDF->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING);
			
			// set header and footer fonts
			$oPDF->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$oPDF->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			
			// set default monospaced font
			$oPDF->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			
			//set margins
			$oPDF->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$oPDF->SetHeaderMargin(PDF_MARGIN_HEADER);
			
			//set auto page breaks
			$oPDF->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);			
			
			// Add a page
			// This method has several options, check the source code documentation for more information.
			$oPDF->AddPage();
			
			$oPDF->SetFont('', '', 6, '', true);		
			
			$ssContent = getHtmlOfBillPDF();
           
			// Print text using writeHTML()			
			$oPDF->writeHTML($ssContent);

			// Close and output PDF document
			// This method has several options, check the source code documentation for more information.
			$ssFileName = 'letters.pdf';
			$ssContent = $oPDF->Output($ssFileName,'I');
			
			// Stop symfony process
			throw new sfStopException();
            exit;			
        }
        else
        {
        $asPostFields = array();
        $asClientDetail = $_POST['whms'];
        $asPostFields["clientid"] = $asClientDetail['clients'];
        $start_time = $asClientDetail['time_from'];
        $end_time = $asClientDetail['time_to'];
        
        $snHours = floor((strtotime($asClientDetail['time_to'])-strtotime($asClientDetail['time_from']))/3600); 
        $snMinutes = round((strtotime($asClientDetail['time_to'])-strtotime($asClientDetail['time_from']))/60);	
        $snMinutes = ($snMinutes%60);
        $snTotalHrs = $snHours.':'.$snMinutes.'Hrs.';
        
        $asPostFields["description"] = $asClientDetail['description'].' Job Number: '.$asClientDetail['job_number'].' Date: '.$asClientDetail['duedate'].' Hours:'.$snTotalHrs;            
        $asPostFields["duedate"] = date('Y-m-d',strtotime($asClientDetail['duedate']));        
        //$asClientDetail = getAndSetUserDetail('addbillableitem',$asPostFields);
                
        $ssSuccMsg = "Your billing details sent sucessfully";
        }        
    }
}
//else
//{

$asClientDetail = getAndSetUserDetail('getclients');

$asPostFields = array();
$asPostFields['limitstart'] = 0;
$asPostFields['limitnum'] = $asClientDetail['WHMCSAPI']['TOTALRESULTS'];
$asClientDetail = getAndSetUserDetail('getclients',$asPostFields);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bill detail</title>
<link href="/whms/css/style.css" rel="stylesheet" type="text/css" />
</head>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js">
</script>
<script type="text/javascript" src="/whms/js/jquery-ui-1.8.16.custom.min.js"></script>
<link href="/whms/css/jquery-ui-timepicker-addon.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/whms/js/jquery-ui-timepicker-addon.js"></script>

</head>
<body>
<script type="text/javascript">

function printBillValue()
{
    document.getElementById('printbill').value = 'Yes';
    document.getElementById('whms').submit();
}
function displayClientDetail(form)
{
    return $.ajax({
				type: 'POST',
				url: '/whms/index.php?id_client='+form.value,
				async: false,				
				success: function display(responseText)
						{
							$('#displayUserDetail').html(responseText);
						}
			  })
}
</script>
<link rel="stylesheet" type="text/css" media="screen" href="/whms/css/jquery-ui-1.8.16.custom.css" />
<body>
<form name="whms" method="post" enctype="multipart/form-data" action="index.php" id="whms">
<input type="hidden" name="printbill" id="printbill" value="No"/>
	<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td>
				<table cellpadding="0" cellspacing="0" width="100%" border="0" align="center">
					<tr>
						<td>
							<table cellpadding="0" cellspacing="0" width="100%" border="0">
								<tr>
									<td align="left" valign="middle" width="55%" class="padd15">
										<img src="logo.png" height="53" width="332" alt="logo" align="middle" />
									</td>
									<td align="right" valign="middle" width="45%">
										<table cellpadding="0" cellspacing="0" border="0" width="90%" align="center">
											<tr>
												<td align="right" width="30%" class="lab"> Job number</td>
												<td width="5%" align="center">:</td>
												<td align="left" width="65%"><input readonly="true" name="whms[job_number]" type="text" class="border" value="<?php echo  isset($_POST["whms"]["job_number"])?$_POST["whms"]["job_number"]:genRandomString();?>"/>
                                                </td>
											</tr>
                                            <?php if(isset($_POST['whms']['duedate'])):?>
											<tr>
												<td align="right" width="30%" class="lab"> Date </td>
												<td width="5%" align="center">:</td>
												<td align="left" width="65%"><?php echo $_POST['whms']['duedate'];?></td>
											</tr>
											<?php endif;?>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
                    <?php if(isset($ssSuccMsg)):?>
						<td width="25%" style="color:green;">
							<?php  echo $ssSuccMsg;?>
							<br/>
                            <input type="button" name="btnPrint" onClick="printBillValue()" value="Print" class="savebtn"/>
						</td>                       
                    <?php endif; ?>
					</tr>					
					<tr>	
						<td height="20px">&nbsp;</td>
					</tr>
					<tr>
						<td>
							<table cellpadding="0" cellspacing="0" width="100%" border="0" class="border">
								<tr>
									<th width="100%" align="left">Client Details</th>
									<!--<th width="50%" align="left">Job Details </th>-->
								</tr>
								<tr>
									<td width="100%" class="borderright padd15">                                    
                                    <select tabindex="1" name="whms[clients]" class="inputBoxWidth" id="whms_clients" onChange="displayClientDetail(this)">
                                <option value="<?php echo (isset($_POST['whms']['clients'])? $_POST['whms']['clients'] :'')?>" selected="selected">Select client</option>
                                <?php                                 
                                if(count($asClientDetail['WHMCSAPI']['CLIENTS']) > 0):
                                foreach($asClientDetail['WHMCSAPI']['CLIENTS'] as $ssColumn=>$asClientDetail):
                                if($asClientDetail['FIRSTNAME'] != ''):
                                ?>
                                <option value="<?php echo $asClientDetail['ID']?>"> 
                                <?php echo $asClientDetail['FIRSTNAME']." ".$asClientDetail['LASTNAME']?> 
                                </option>
                                <?php endif;endforeach;
                                endif;
                                ?>
                                </select>
                                    </td>
									<td width="50%">
										<table cellpadding="0" cellspacing="0" border="0">
											<tr>
												<!--<td align="right" width="30%" class="lab padd10"> Your order Number:</td>
												<td width="5%" align="center" class="padd10">:</td>
												<td align="left" width="65%" class="padd10"><input name="" type="text" class="inputnew"/></td>-->
											</tr>
											<tr>
												<!--<td align="right" width="30%" class="lab padd10">Your Reference Number:</td>
												<td width="5%" align="center" class="padd10">:</td>
												<td align="left" width="65%" class="padd10"><input name="" type="text" class="inputnew"/></td>-->
											</tr>
											<tr>
												<!--<td align="right" width="30%" class="lab padd10">Consultant</td>
												<td width="5%" align="center" class="padd10">:</td>
												<td align="left" width="65%" class="padd10"><input name="" type="text" class="inputnew"/></td>-->
											</tr>
											
										</table>
									</td>									
								</tr>
							</table>
						</td>
                    </tr>                    
					<tr>	
						<td height="20px">&nbsp;</td>
					</tr>
                    <tr>
						<td>
                    <table id="displayUserDetail" cellpadding="0" cellspacing="0" width="100%" border="0" class="border">
                    <?php if(isset($_POST['whms']['clients'])):
                        $postfields = array();
                        $postfields["clientid"] = $_POST['whms']['clients'];
                        $asClientWiseDetail = getAndSetUserDetail('getclientsdetails',$postfields);        
                    ?>
                    <tr>
						<td>
							<table cellpadding="0" cellspacing="0" width="100%" border="0" class="border">
								<tr>
									<th width="100%" align="left">
										Client details
									</th>									
								</tr>
								<tr>
									<td width="100%">
										<table cellpadding="0" cellspacing="0" border="0">
											<tr>
												<td align="right" width="30%" class="lab padd10"> Firstname</td>
												<td width="5%" align="center" class="padd10">:</td>
												<td align="left" width="65%" class="padd10"><?php echo $asClientWiseDetail['WHMCSAPI']['CLIENT']['FIRSTNAME']?></td>
											</tr>
                                           
                                            <tr>
												<td align="right" width="30%" class="lab padd10"> Lastname:</td>
												<td width="5%" align="center" class="padd10">:</td>
												<td align="left" width="65%" class="padd10"><?php echo $asClientWiseDetail['WHMCSAPI']['CLIENT']['LASTNAME']?></td>
											</tr>
                                            
                                             <tr>
												<td align="right" width="30%" class="lab padd10"> Email:</td>
												<td width="5%" align="center" class="padd10">:</td>
												<td align="left" width="65%" class="padd10"><?php echo $asClientWiseDetail['WHMCSAPI']['CLIENT']['EMAIL']?></td>
											</tr>											
                                            <tr>
												<td align="right" width="30%" class="lab padd10"> Address</td>
												<td width="5%" align="center" class="padd10">:</td>
												<td align="left" width="65%" class="padd10"><?php echo $asClientWiseDetail['WHMCSAPI']['CLIENT']['ADDRESS1'].' '.$asClientWiseDetail['WHMCSAPI']['CLIENT']['ADDRESS2']?></td>
											</tr>	
										</table>	
									</td>
								</tr>
							</table>
						</td>
					</tr>
                    <?php endif;?>
                    </table>
                    </td>
                    </tr>                    
					<tr>	
						<td height="20px">&nbsp;</td>
					</tr>                    
					<tr>
						<td>
							<table cellpadding="0" cellspacing="0" width="100%" border="0" class="border">
								<tr>
									<th width="100%" align="left">
										Problem Description/Work Request
									</th>
									
								</tr>
								<tr>
									<td width="100%">
										<!--<textarea name="" class="textarea"> Type Here </textarea>-->
                                        <textarea class="textarea" rows="4" cols="30" tabindex="1" name="whms[description]" class="inputBoxWidth" id="whms_description" >
                                        <?php 
                                        if(isset($_POST["whms"]["description"])):
                                            echo $_POST["whms"]["description"];
                                        endif;
                                        ?>
                                        </textarea>
									</td>
								</tr>
							</table>
						</td>
					</tr>
                    <tr>	
						<td height="20px">&nbsp;</td>
					</tr>
					
                    <tr>
						<td>
							<table cellpadding="0" cellspacing="0" width="100%" border="0" class="border">
                            <tr>
                                <th width="33%" align="left">
                                    Date
                                </th>
                                <th width="33%" align="left">
                                    Time From
                                </th>
                                <th width="33%" align="left">
                                    Time To
                                </th>
                            </tr>
                            <tr>
                                <td width="33%" class="padd15">
                                <input tabindex="2" type="text" name="whms[duedate]" id="whms_duedate" value="<?php echo ((isset($_POST['whms']['duedate']))?$_POST['whms']['duedate']:'')?>"/>
                                <script type="text/javascript">
                                $(function() 
                                    {
                                        var params = {
                                            changeMonth : true,
                                            changeYear : true,
                                            numberOfMonths : 1,
                                            dateFormat: 'dd-mm-yy',
                                            showButtonPanel : false,
                                            showOn: "button",
                                            buttonImage: 'css/images/calendar.gif',
                                            buttonImageOnly: true,
                                            showSecond: true,
                                            timeFormat: 'hh:mm:ss',
                                    };
                                    if(false)
                                    {
                                        var params = {
                                            minDate: new Date(1970, 1, 1),
                                            maxDate: new Date,
                                            changeMonth : true,
                                            changeYear : true,
                                            numberOfMonths : 1,
                                            dateFormat: 'dd-mm-yy',
                                            showButtonPanel : false,
                                            showOn: "button",
                                            buttonImage: 'css/images/calendar.gif',
                                            buttonImageOnly: true,
                                            showSecond: true,
                                            timeFormat: 'hh:mm:ss',
                                            };
                                    }
                                    if(false)
                                        $("#whms_duedate").timepicker(params);
                                    else if(false)
                                        $("#whms_duedate").datetimepicker(params);
                                    else
                                        $("#whms_duedate").datepicker(params);
                                });
                                </script>
                            </td>
                            <td width="33%" class="padd15">                           
                            <input style="width:100px;" tabindex="7" type="text" name="whms[time_from]" value="<?php echo ((isset($_POST["whms"]["time_from"]))?$_POST["whms"]["time_from"]:'00:00:00')?>" id="whms_time_from" />
                                <script type="text/javascript">
                                $(function() 
                                {
                                    var params = {
                                            changeMonth : false,
                                            changeYear : false,
                                            numberOfMonths : 1,
                                            dateFormat: 'yy-mm-dd',
                                            showButtonPanel : true,
                                            showOn: "button",
                                            buttonImage: 'css/images/calendar.gif',
                                            buttonImageOnly: true,
                                            showSecond: true,
                                            timeFormat: 'hh:mm:ss',
                                    };

                                    if(false)
                                    {
                                        var params = {
                                            minDate: new Date(1970, 1, 1),
                                            maxDate: new Date,
                                            changeMonth : false,
                                            changeYear : false,
                                            numberOfMonths : 1,
                                            dateFormat: 'yy-mm-dd',
                                            showButtonPanel : true,
                                            showOn: "button",
                                            buttonImage: 'css/images/calendar.gif',
                                            buttonImageOnly: true,
                                            showSecond: true,
                                            timeFormat: 'hh:mm:ss',
                                        };
                                    }
                                    if(true)
                                        $("#whms_time_from").timepicker(params);
                                    else if(true)
                                        $("#whms_time_from").datetimepicker(params);
                                    else
                                        $("#whms_time_from").datepicker(params);
                                });
                            </script>
							</td>
                            <td width="33%" class="padd15">
							<input style="width:100px;" tabindex="7" type="text" name="whms[time_to]" value="<?php echo ((isset($_POST["whms"]["time_to"]))?$_POST["whms"]["time_to"]:'00:00:00')?>" id="whms_time_to" />
                            <script type="text/javascript">
                            $(function() 
                            {
                                var params = {
                                        changeMonth : false,
                                        changeYear : false,
                                        numberOfMonths : 1,
                                        dateFormat: 'yy-mm-dd',
                                        showButtonPanel : true,
                                        showOn: "button",
                                        buttonImage: 'css/images/calendar.gif',
                                        buttonImageOnly: true,
                                        showSecond: true,
                                        timeFormat: 'hh:mm:ss',
                                };

                                if(false)
                                {
                                    var params = {
                                        minDate: new Date(1970, 1, 1),
                                        maxDate: new Date,
                                        changeMonth : false,
                                        changeYear : false,
                                        numberOfMonths : 1,
                                        dateFormat: 'yy-mm-dd',
                                        showButtonPanel : true,
                                        showOn: "button",
                                        buttonImage: 'css/images/calendar.gif',
                                        buttonImageOnly: true,
                                        showSecond: true,
                                        timeFormat: 'hh:mm:ss',
                                    };
                                }
                                if(true)
                                    $("#whms_time_to").timepicker(params);
                                else if(true)
                                    $("#whms_time_to").datetimepicker(params);
                                else
                                    $("#whms_time_to").datepicker(params);

                            });
                            </script>
							</td>
                            </tr>
							</table>
						</td>
					</tr>
					<tr>	
						<td height="20px">&nbsp;</td>
					</tr>                     
					<!--<tr>
						<td>
							<table cellpadding="0" cellspacing="0" border="0" class="border" width="100%">
								<tr>
									<td class="borderright padd15" width="25%">
                                    
										<strong>From :</strong>&nbsp;<input name="" type="text" class="bordernone"/>
									</td>
									<td class="borderright padd15" width="25%">
										<strong>To :</strong>&nbsp;<input name="" type="text" class="bordernone"/>
									</td>
									<td class="borderright padd15" width="50%">
										<strong>Consultant's Signature :</strong>&nbsp;<input name="" type="text" class="bordernone w79"/>
									</td>
								</tr>
								
							</table>
						</td>
					</tr>-->
					<tr>	
						<td height="20px">&nbsp;</td>
					</tr>
					<tr>
						<td align="center" valign="middle">
							<input type="submit" name="submit_button" value="Save" class="savebtn" title="Save" tabindex="10" onclick="jQuery('#tab').val('');" />
						</td>
					</tr>
					<tr>
						<td>
							<table cellpadding="0" cellspacing="0" border="0" class="border" width="100%">
								<tr>
									<!--<th width="50%" align="left">
										Equipment / Materials Supplied
									</th>
									<th width="50%" align="left">
										Client'sAcceptance
									</th>-->
								</tr>								
							</table>
						</td>
					</tr>
				</table>				
			</td>
		</tr>
	</table>
    </form>
</body>
</html>
<?php
//} 
function getAndSetUserDetail($ssActionName, $asPostFields = array())
{ 
    $url = "http://bruntech.net.au/clients/includes/api.php"; # URL to WHMCS API file goes here
    $username = "nitinbarai"; # Admin username goes here
    $password = "nitinbarai"; # Admin password goes here
    
    $asPostFields["username"] = $username;
    $asPostFields["password"] = md5($password);
    $asPostFields["accesskey"] = "bruntech123";
    $asPostFields["action"] = $ssActionName;
    $asPostFields["responsetype"] = "xml";
     
    $query_string = "";
    foreach ($asPostFields AS $k=>$v) $query_string .= "$k=".urlencode($v)."&";
     
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $xml = curl_exec($ch);
    if (curl_error($ch) || !$xml) $xml = '<whmcsapi><result>error</result>'.
    '<message>Connection Error</message><curlerror>'.
    curl_errno($ch).' - '.curl_error($ch).'</curlerror></whmcsapi>';
    curl_close($ch);
     
    return $asClientDetail = whmcsapixmlparser($xml); # Parse XML
}   
function whmcsapixmlparser($rawxml)
{    
 	$xml_parser = xml_parser_create();
 	xml_parse_into_struct($xml_parser, $rawxml, $vals, $index);
 	xml_parser_free($xml_parser);
 	$params = array();
 	$level = array();
 	$alreadyused = array();
 	$x=0;
    
 	foreach ($vals as $xml_elem) {
    
 	  if ($xml_elem['type'] == 'open') {
 		 if (in_array($xml_elem['tag'],$alreadyused)) {
 		 	$x++;
 		 	$xml_elem['tag'] = $xml_elem['tag'].$x;
 		 }
 		 $level[$xml_elem['level']] = $xml_elem['tag'];
 		 $alreadyused[] = $xml_elem['tag'];
 	  }
 	  if ($xml_elem['type'] == 'complete') {
 	   $start_level = 1;
 	   $php_stmt = '$params';
 	   while($start_level < $xml_elem['level']) {
 		 $php_stmt .= '[$level['.$start_level.']]';
 		 $start_level++;
 	   }
 	   $php_stmt .= '[$xml_elem[\'tag\']] = $xml_elem[\'value\'];';
 	   @eval($php_stmt);
 	  }
 	}    
 	return $params;
}
function genRandomString() 
{
    $length = 12;
    $characters = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $string = "";    

    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[rand(0, strlen($characters))];
    }

    return $string;
}
function getHtmlOfBillPDF()
{
    
	$snDate = (isset($_POST['whms']['duedate'])?$_POST['whms']['duedate']:'');	
	$postfields = array();
    $postfields["clientid"] = $_POST['whms']['clients'];
    $asClientWiseDetail = getAndSetUserDetail('getclientsdetails',$postfields);
	$snFrom = (isset($_POST['whms']['time_from'])?$_POST['whms']['time_from']:'');
	$snTo = (isset($_POST['whms']['time_to'])?$_POST['whms']['time_to']:'');
	if(isset($asClientWiseDetail['WHMCSAPI']['CLIENT']['FIRSTNAME']) && $asClientWiseDetail['WHMCSAPI']['CLIENT']['FIRSTNAME'] != '')
		$ssFirstname = $asClientWiseDetail['WHMCSAPI']['CLIENT']['FIRSTNAME']." ".((isset($asClientWiseDetail['WHMCSAPI']['CLIENT']['LASTNAME']))?$asClientWiseDetail['WHMCSAPI']['CLIENT']['LASTNAME']:'');	
	$ssEmail = (isset($asClientWiseDetail['WHMCSAPI']['CLIENT']['EMAIL'])?$asClientWiseDetail['WHMCSAPI']['CLIENT']['EMAIL']:'');
	if(isset($asClientWiseDetail['WHMCSAPI']['CLIENT']['ADDRESS1']) && $asClientWiseDetail['WHMCSAPI']['CLIENT']['ADDRESS1'] != '')
		$ssAddress = $asClientWiseDetail['WHMCSAPI']['CLIENT']['ADDRESS1']." ".$asClientWiseDetail['WHMCSAPI']['CLIENT']['ADDRESS2'];
	return $ssHtmlContent = '<style>body{ margin:0; padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:8pt;}.fleft{ float:left;}.fright{ float:right;}.clearb{ clear:both;}p{ margin:0; padding:0;}.w50{ width:50%;}.w79{ width:79% !important;}.main{ width:98; margin:0 auto;}table{ margin:0; padding:0;}table td{ margin:0; padding:0; height:15px;}table th{ margin:0; padding:0; height:35px; background-color:#; font-size:10pt !important; text-decoration: underline; padding-left:15px; color:#000; height:15px}table input{background:#f7f7f7; border:none; height:25px; width:88%;}table .inputnew{background:#fff; border:none; border-bottom:dotted 0px #ccc; height:25px; width:100%;}table .textarea{ background:none; border:none; width:97%; padding:5px 15px; min-height:100px;}table .textarea1{ background:noone; border:none; width:97%; padding:5px 15px; min-height:150px;} table .textarea2{ background:noone; border:none; width:95%; padding:5px 15px; min-height:150px;} .borderright{ border-right:none;}.bordernone{ border:none;}.lab{ font-size:7pt; color:#00688a; font-weight:bold;}.belowinput{background:#fff; border:none; height:25px; width:30%;}.ui-datepicker-trigger{ vertical-align:top !important; padding-left:10px;}</style><html><body><table cellpadding="0" cellspacing="0" width="100%"><tr><td align="center"><h1>JOB FORM</h1></td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td><table cellpadding="0" cellspacing="0" width="100%" border="0" align="center"><tr><td style="border-bottom:dashed 1pt #333;"><table cellpadding="0" cellspacing="0" width="100%" border="0"><tr><td align="left" valign="top" width="55%" class="padd15"><img src="http://s004.rookwoodcemetery.com.au:82//images/logo.png" alt="logo" align="middle" height="35" width="150"/></td><td align="right" valign="middle" width="45%"><table cellpadding="0" cellspacing="0" border="0" width="90%" align="center"><tr><td align="right" width="30%" class="lab">Job Number</td><td width="5%" align="center">:</td><td align="left" width="65%">'.$_POST['whms']['job_number'].'</td></tr><tr><td align="right" width="30%" class="lab">Date</td><td width="5%" align="center">:</td><td align="left" width="65%">'.$snDate.'</td></tr></table></td></tr></table></td></tr><tr><td height="20px"></td></tr><tr><td><table cellpadding="0" cellspacing="0" width="100%" border="0" class="border"><tr><th width="50%" align="left">Client Details</th><th width="50%" align="left">Job Details </th></tr><tr><td>&nbsp;</td></tr><tr><td width="50%" class="borderright"><table cellpadding="0" cellspacing="0" border="0"><tr><td align="right" width="30%" class="lab padd10">Client name:</td><td width="5%" align="center" class="padd10">:</td><td align="left" width="65%" class="padd10">'.$ssFirstname.'</td></tr><tr><td align="right" width="30%" class="lab padd10">Email:</td><td width="5%" align="center" class="padd10">:</td><td align="left" width="65%" class="padd10">'.$ssEmail.'</td></tr><tr><td align="right" width="30%" class="lab padd10">Address</td><td width="5%" align="center" class="padd10">:</td><td align="left" width="65%" class="padd10">'.$ssAddress.'</td></tr></table></td><td width="50%"><table cellpadding="0" cellspacing="0" border="0"><tr><td align="right" width="30%" class="lab padd10"> Your order Number:</td><td width="5%" align="center" class="padd10">:</td><td align="left" width="65%" class="padd10"><div style="border-bottom:dashed 1pt #333;"></div></td></tr><tr><td align="right" width="30%" class="lab padd10">Your reference number</td><td width="5%" align="center" class="padd10">:</td><td align="left" width="65%" class="padd10"><div style="border-bottom:dashed 1pt #333;"></div></td></tr><tr><td align="right" width="30%" class="lab padd10">Consultant</td><td width="5%" align="center" class="padd10">:</td><td align="left" width="65%" class="padd10"><div style="border-bottom:dashed 1pt #333;"></div></td></tr></table></td></tr></table></td></tr><tr><td height="20px">&nbsp;</td></tr><tr><td height="20px">&nbsp;</td></tr><tr><td><table cellpadding="0" cellspacing="0" width="100%" border="0" class="border"><tr><th width="100%" align="left">Problem Description/Work Request</th></tr><tr><td width="100%" align="left">'.$_POST['whms']['description'].'</td></tr></table></td></tr><tr><td height="20px">&nbsp;</td></tr><tr><td><table cellpadding="0" cellspacing="0" border="0" class="border" width="100%"><tr><td class="borderright padd15" width="25%" align="left"><strong>From : </strong>'.$snFrom.'</td><td class="borderright padd15" width="25%" align="left"><strong>To : </strong>'.$snTo.'</td><td class="borderright padd15" width="50%" align="left"><strong>Consultant\'s Signature:</strong>&nbsp;</td></tr></table></td></tr><tr><td height="20px">&nbsp;</td></tr><tr><td><table cellpadding="0" cellspacing="0" border="0" class="border" width="100%"><tr><th width="50%" align="left">Equipment / Materials Supplied</th><th width="50%" align="left">Client\'s Acceptance</th></tr><tr><td width="50%" class="borderright" valign="top"></td><td width="50%" valign="top"><table cellpadding="0" cellspacing="0" border="0"><tr><td class="padd15"><P style="margin:20px; padding:20px 0; text-align:left;">I hereby acknowledge receipt from Bruntech and its agents for the services and equipment/materials supplied above. I understand and acknowledge that, while every effort and care has been taken during the work carried out by Bruntech and or it agents they are not responsible for loss or damage to equipment or data. I hereby confirm that the above work was carried out to my satisfaction, and accept all charges related to the specified work and responsibility for their payment.  I also acknowledge that any gods and materials supplied are the property of Bruntech until such time payment of the full amount is paid and cleared in Bruntech bank account.</P></td></tr><tr><td><table cellpadding="0" cellspacing="0" border="0"  width="100%"><tr><td>&nbsp;</td></tr><tr><td class="borderright padd15" width="50%" align="left"><strong>Name:</strong></td><td class="borderright padd15" width="50%" align="left"><strong>Signature :</strong></td></tr></table></td></tr><tr><td>&nbsp;</td></tr><tr><td align="center"><h3>Authorised Company Representative</h3></td></tr></table></td></tr></table></td></tr></table></td></tr></table></body></html>';		
}
?>