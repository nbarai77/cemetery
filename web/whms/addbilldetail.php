<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')
{    
    if(isset($_REQUEST['id_client']) && $_REQUEST['id_client'] != '')
    {
        $postfields = array();
        $postfields["clientid"] = $_REQUEST['id_client'];
        $asClientWiseDetail = getAndSetUserDetail('getclientsdetails',$postfields);
        
        echo $ssFisttttt = $asClientWiseDetail['WHMCSAPI']['CLIENT']['FIRSTNAME'];
        echo $asClientWiseDetail['WHMCSAPI']['CLIENT']['LASTNAME'];
        echo $asClientWiseDetail['WHMCSAPI']['CLIENT']['COMPANYNAME'];
        echo $asClientWiseDetail['WHMCSAPI']['CLIENT']['EMAIL'];
        echo $asClientWiseDetail['WHMCSAPI']['CLIENT']['ADDRESS1'];
        echo $asClientWiseDetail['WHMCSAPI']['CLIENT']['ADDRESS2'];
        echo $asClientWiseDetail['WHMCSAPI']['CLIENT']['CITY'];
        echo $asClientWiseDetail['WHMCSAPI']['CLIENT']['STATE'];
        echo $asClientWiseDetail['WHMCSAPI']['CLIENT']['POSTCODE'];
        echo $asClientWiseDetail['WHMCSAPI']['CLIENT']['COUNTRYNAME'];
        
        echo $asClientWiseDetail['WHMCSAPI']['STATS']['INCOME'];
        echo $asClientWiseDetail['WHMCSAPI']['STATS']['CREDITBALANCE'];
        echo $asClientWiseDetail['WHMCSAPI']['STATS']['PAIDINVOICESAMOUNT'];      
        exit;
    }
    else
    {
        $asPostFields = array();
        $asClientDetail = $_POST['whms'];
        $asPostFields["clientid"] = $asClientDetail['clients'];
        $asPostFields["description"] = $asClientDetail['description'];
        $asPostFields["amount"] = $asClientDetail['amount'];
        $asPostFields["recur"] = $asClientDetail['recur'];
        $asPostFields["recurcycle"] = $asClientDetail['recurcycle'];
        $asPostFields["recurfor"] = $asClientDetail['recurfor'];        
        $asPostFields["duedate"] = date('Y-m-d',strtotime($asClientDetail['duedate']));        
        $asClientDetail = getAndSetUserDetail('addbillableitem',$asPostFields);
    }
}
//else
//{
$asClientDetail = getAndSetUserDetail('getclients');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="title" content="Cemetery" />
<meta name="description" content="interments" />
<meta name="keywords" content="cemetery, interments" />
<title>Cemetery</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js">
</script>
<script type="text/javascript" src="/whms/js/jquery-ui-1.8.16.custom.min.js"></script>
</head>
<body>
<script type="text/javascript">
function displayClientDetail(form)
{
    return $.ajax({
				type: 'POST',
				url: '/whms/addbilldetail.php?id_client='+form.value,
				async: false,				
				success: function display(responseText)
						{
							$('#displayUserDetail').html(responseText);
						}
			  })
}
</script>
<link rel="stylesheet" type="text/css" media="screen" href="/whms/css/jquery-ui-1.8.16.custom.css" />
<div id="container"><div id="wapper">
<form name="whms" method="post" enctype="multipart/form-data" action="addbilldetail.php">
<div class="comment_list"></div>
    <h1>Add Bill detail</h1>
    <div id="message">
        <div id="success_msgs">
                    </div>
    </div>
    <div class="clearb">&nbsp;</div>    
    <div id="main">
        <div class="maintablebg">
            <div class="main_cont">
                <div class="left_part">
            		<div id="info">
                		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sub_table">
                            <tr>
                           	<td valign="middle" align="right" width="20%"><label for="whms_clients">Job Number</label></td>
	                        <td valign="middle" width="80%"><?php echo genRandomString();?></td>
                            </tr>
			        		<tr>
                           	<td valign="middle" align="right" width="20%"><label for="whms_clients">Clients</label></td>
	                         	<td valign="middle" width="80%">
                                <select tabindex="1" name="whms[clients]" class="inputBoxWidth" id="whms_clients" onChange="displayClientDetail(this)">
                                <option value="" selected="selected">Select client</option>
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
                    		</tr>
                            <tr>
                            <td id="displayUserDetail">
                            
                            </td>
                            </tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<label for="whms_description">Description</label>                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<textarea rows="4" cols="30" tabindex="1" name="whms[description]" class="inputBoxWidth" id="whms_description"></textarea>                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<label for="whms_amount">Amount</label>                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<input tabindex="1" type="text" name="whms[amount]" class="inputBoxWidth" id="whms_amount" />                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<label for="whms_recur">Recur</label>                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<input tabindex="1" type="text" name="whms[recur]" class="inputBoxWidth" id="whms_recur" />                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<label for="whms_recurcycle">Recurcycle</label>                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<input tabindex="1" type="text" name="whms[recurcycle]" class="inputBoxWidth" id="whms_recurcycle" />                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<label for="whms_recurfor">Recurfor</label>                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<input tabindex="1" type="text" name="whms[recurfor]" class="inputBoxWidth" id="whms_recurfor" />                                </td>
                    		</tr>                            
                            <tr>
                            	<td valign="middle" align="right" width="20%">
                                	<label for="whms_duedate">Duedate</label>
                                </td>	
                            	<td valign="middle" width="80%">
                                	<input tabindex="2" type="text" name="whms[duedate]" id="whms_duedate" />
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
                                                    buttonImage: '/images/jquery/calendar.gif',
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
                                                    buttonImage: '/images/jquery/calendar.gif',
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
                            </tr>
                            <tr>
                            	<td>&nbsp;</td>
                        		<td valign="middle">
                                	<div class="actions">
                                		<ul class="fleft">
                                        	<li class="list1">
                                        		<span>
	                                                <input type="submit" name="submit_button" value="Save" class="delete" title="Save" tabindex="10" onclick="jQuery('#tab').val('');" /></span>
                                        	</li>                                			
                            			</ul>
                                	</div>
                        		</td>
                        	</tr>
                		</table>
            		</div>

                </div>
                <div class="clearb"></div>
            </div>
        </div>
    </div>
    <div class="clearb">&nbsp;</div>
    <div class="clearb">&nbsp;</div>
  </body>
  </html>
<?php
//} 
function getAndSetUserDetail($ssActionName, $asPostFields = array())
{ 
    $url = "http://bruntech.net.au/clients/includes/api.php"; # URL to WHMCS API file goes here
    $username = "nitinbarai"; # Admin username goes here
    $password = "nitinbarai"; # Admin password goes here
    //$postfields = array();
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
    function whmcsapixmlparser($rawxml) {    
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
   function genRandomString() {
        $length = 12;
        $characters = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $string = "";    

        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[rand(0, strlen($characters))];
        }

        return $string;
    }
?>