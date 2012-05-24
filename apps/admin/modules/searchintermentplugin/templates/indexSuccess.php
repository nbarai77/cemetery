<head>
<style type="text/css">
body{ background:#f5f5f5; font-size:12px; font-family:Arial, Helvetica, sans-serif; color:#545454; height:100%;}

a {
    outline: medium none;
    text-decoration: none;
}
a:hover {
    text-decoration: none;
}
.listtable table{ color:#545454; font-size:14px; line-height:18px;}
.listtable table a{ color:#6e6e6e; font-weight:bold;}
.listtable table td{ padding:12px 5px;}
.listtable table .normal td{ border-top:solid 1px #f6f6f6; padding:5px 5px 10px 20px;}
.listtable table th{ color:#3e3e3e; background:url(/images/admin/ass-sep.gif) left center no-repeat; padding:12px 5px;}
.listtable table th.none{ color:#ffffff; background:none; font-weight:bold; font-size:12px;}
tr.odd{ background:#ffffff; border-top:1px solid #DEF1F8;}
tr.odd:hover{ background:#FFFECC;}
tr.even{ background:#f2f2f2; border-top:1px solid #DEF1F8;}
tr.even:hover{ background:#FFFECC; }
.listtable table tr.normal{ background:#ffffff;}
.listtable table tr td.select{ background:#fbfbfb;}
.listtable table tr td.hilight { background:#faf7ee;}
.listtable table tr td.down_hilight { background:#faf7ee; border-top:none;}
.listtable table tr td.down_hilight table td { border-top:none; padding-left:0px;}

.listtable table tr td.hilight a,
.listtable table td.none_bold a,
.listtable table tr td.down_hilight a{ font-weight:normal;}

#main .maintablebg table tr th {
    background: none repeat scroll 0 0 #474849;
}

tr.even {
    background: none repeat scroll 0 0 #F2F2F2;
    border-top: 1px solid #DEF1F8;
}
tr.odd {
    background: none repeat scroll 0 0 #FFFFFF;
    border-top: 1px solid #DEF1F8;
}
.actions {
    float: left;
    margin-left: 0;
    padding: 5px 0;
    position: relative;
    width: 100%;
}

#bottompagingdiv {
    margin-left: 0;
    list-style: none;
}
.actions ul {
    list-style: none outside none;
    margin: 0 0 0 10px;
    padding: 0;
}
ul {
    list-style-type: none;
}
#bottompagingdiv li {
    display: block;
    float: left;
    margin: 0 10px 0 0;
    padding: 0; 
    list-style: none;
    background: none;
}
.paggingDiv li {
    display: block;
    float: left;
    margin: 0 4px 0 0;
}
.actions li {
    color: #000000;
    float: left;
    margin-right: 10px;
}
.actions li.list1 {
    background: url("../../images/admin/li-left.gif") no-repeat scroll left top transparent !important;
    float: left;
    padding-left: 2px !important;
    margin-left:  23px !important;
}
.actions li.list1 span {
    background: url("../../images/admin/li-right.gif") no-repeat scroll right top transparent;
    float: left;
    height: 13px;
    margin: 0;
    padding: 6px 12px 7px 10px;
    z-index: -999;
}
.RPP {
    color: #4C4C4C;
    float: left;
    margin: 2px 0 0 3px;
}
.actions li.list1 span.arrow {
    background: url("../../images/admin/down-arrow.gif") no-repeat scroll right center transparent;
    border: medium none !important;
    color: #545454;
    display: inline-block;
    float: left;
    font-size: 12px;
    font-weight: bold;
    margin: 0;
    padding: 0 20px 0 0;
}
.assanding1 {
    display: block;
    position: relative;
    vertical-align: top;
}
.assanding1 .inn_drupdown1 {
    left: -12px;
    margin-top: 5px;
    position: absolute;
    width: 70px;
    z-index: 101;
}
.inn_drupdown1 ul {
    background: url("../../images/admin/inn_drupdown_short_top.png") repeat-y scroll left top transparent;
    list-style: none outside none;
    margin: 0;
    padding: 10px 0 0;
    z-index: 101;
}
.inn_drupdown1 li {
    color: #898989;
    float: none !important;
    font-size: 12px;
    font-weight: normal;
    padding: 2px 5px;
    z-index: 101;
}
.assanding1 .inn_drupdown1Bottom {
    background: url("/images/admin/inn_drupdown_short_bottom.png") no-repeat scroll left bottom transparent;
    height: 13px;
    position: relative;
}
.actions .inn_drupdown1 li a {
    color: #B69747;
    font-weight: normal;
    z-index: 101;
}
.loaderimgText {position:fixed; z-index:9999999999; top:0px; padding-top:20%; margin:0 -20px; width:100%; height:100%; color:#FFFFFF; text-align:center;}
.backTransparant{position:fixed; opacity:0.5;filter:alpha(opacity=50); left:0px; z-index:99999999; top:0px; width:100%; height:100%; background-color:#000000;}
.backTransparant img{ padding-top:300px!important;}


ul.tab_content{float:left; list-style:none; margin:0px; padding:0px; clear:both;}
ul.tab_content li{ float:left; display:inline-block; background:#E7F4F8; margin-right:6px; border-top:#D2DBE9 solid 1px; border-right:#D2DBE9 solid 1px; border-left:#D2DBE9 solid 1px;}
ul.tab_content li a{padding:7px 15px; float:left;}
ul.tab_content li a{color:#666666; font-size:12px; font-weight:bold; font-family:Arial, Helvetica, sans-serif;}
ul.tab_content li:hover{ background:#EBEBEB; color:#000000;}
ul.tab_content li.active{ background:#EBEBEB;}
ul.tab_content li.active a{color:#000000;}

.gravedetailpopupbox { background: none repeat scroll 0 0 #FFFFFF;  border: 1px solid #E5E5E5; margin: 0 auto; padding: 10px;  width: 85%;}
.clearb {
    clear: both !important;
}

#main {
    background: none repeat scroll 0 0 #F2F2F2;
    border: 1px solid #D2DBE9;
    clear: both;
    float: left;
    font-family: Arial;
    text-align: left;
    width: 100%;
}
#wapper {
    clear: both;
    margin: 0 auto;
    min-height: 400px;
    width: 96%;
}
.gravedetails {
    font-size: 12px;
    margin: 0;
    padding: 0;
    width: 100%;
}
.gravedetails h1 {
    margin: 10px;
}

.gravedetails .w48 {
    float: left;
    width: 48%;
}

.gravedetails .dottedline {
    border-bottom: 1px dotted #E5E5E5;
    height: 1px;
    width: 100%;
}

h1 {
    color: #258ECA;
    float: left;
    font-size: 22px;
    font-weight: normal;
}
.gravedetails .title {
    color: #333333;
    font-size: 12px;
    font-weight: normal;
    padding: 10px 0;
    text-align: right;
}
.gravedetails .details {
    color: #333333;
    font-size: 12px;
    font-weight: bold;
    padding: 10px 5px;
}

</style>
<script type="text/javascript" src="/sfJqueryReloadedPlugin/js/jquery-1.4.1.min.js"></script>
<script type="text/javascript" src="/js/admin/common.js"></script>
<script type="text/javascript" src="/js/nyroModal/jquery.nyroModal.custom.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps?file=api&v=2&sensor=true&key=<?php echo sfConfig::get('app_google_map_key');?>"></script>

<link rel="stylesheet" type="text/css" media="screen" href="/css/nyroModal/nyroModal.css" />
<!--<link rel="stylesheet" type="text/css" media="screen" href="/css/admin/style.css" />-->
</head>
<?php 
    use_helper('pagerplugin');    
    $ssModuleName = $sf_params->get('module'); 
?>
<div id="wapper">
	<div class="loaderimgText" style="display:none; margin:0px; left:0px;" id="indicator1">
		<img src="/images/loader.gif" /><br /><?php echo __('msg_loading_result');?>
		<div class="backTransparant"></div>
	</div>
	
	<div class="loaderimgText" style="display:none; margin:0px; left:0px;" id="indicator_page_listing">
		<img src="/images/loader.gif" /><br /><?php echo __('msg_record_updated');?>
		<div class="backTransparant"></div>
	</div>
    <div id="result"></div>	
    <?php
        echo jq_form_remote_tag(
                array(
                    'url'       => 'http://localhost/intermentPlugin/test.php',		//for live: 'intermentPlugin/test.php',
                    'update'    => 'contentlisting',
                    'script'    => true,
                    'loading'   => jq_visual_effect('fadeIn','#indicator1'),
                    'complete'  => jq_visual_effect('fadeOut','#indicator1').";",
                ),
                array('name' => $ssFormName, 'id' => $ssFormName)
            );

        echo input_hidden_tag('page',$snPage, array('readonly' => true));
        echo input_hidden_tag('paging',$snPaging, array('readonly' => true));		
        echo input_hidden_tag('surnm',$sf_params->get('surnm',''), array('readonly' => true));
        echo input_hidden_tag('nm',$sf_params->get('nm',''), array('readonly' => true));
        echo input_hidden_tag('dd',$sf_params->get('dd',''), array('readonly' => true));
        echo input_hidden_tag('db',$sf_params->get('db',''), array('readonly' => true));
        echo input_hidden_tag('form_name',$ssFormName, array('readonly' => true));

        include_partial(
            'global/listing_top',
            array(
                'form_name'             => $ssFormName,
                'id_checkboxes'         => 'id[]',
                'inactivateIds'         => 'idinterment',
                'update_div'            => 'success_msgs',
                'url'                   => $ssModuleName.'/index?request_type=ajax_request',
                'admin_act_module'      => 'delete',
                'bStatusButton'         => 'false',
                'bChangeOrderButton'    => 'false',
				'bDeleteButton'    		=> 'cemAdmin',
                'checkbox'    			=> 'true',
            )
        );

        echo '<div>';
            echo '<div style="width:100%;float:left;">';    
                if($snPageTotalSearchInterment == 0): 
                    echo '<div class="warning-msg"><span>'.__('Record(s) not found').'</span></div>';
                else:
                    echo '<div id="contentlisting" >';
                        include_partial(
                            'list_middle_part',
                            array(
                                'oSearchIntermentList'  => $oSearchIntermentList,
                                'amSearchIntermentList' => $amSearchIntermentList,
                                'amExtraParameters' 	=> $amExtraParameters,
								'snPageTotalSearchInterment' => $snPageTotalSearchInterment,
                                'amSearch'          => $amSearch,
                                'ssModuleName'      => $ssModuleName,
                                'sortby'            => $amExtraParameters['ssSortBy'],
                                'sortmode'          => $amExtraParameters['ssSortMode'],
                                'inactivateIds'     => 'idinterment',
                            )
                        );
                    echo '</div>';					                    
                endif;                            
            echo '</div>'; 			         
            echo '<div class="clearb">&nbsp;</div>';
        echo '</div>';    	
    ?>
    <div class="clearb">&nbsp;</div>
    </form>	
</div>
<!--Sorting for selected field-->

<?php 
    if($snPageTotalSearchInterment > 0):
        echo javascript_tag('        
        
            jQuery(document).ready(function() 
            {
                sortingdiv();
                jQuery(function() {         
					jQuery(".nyroModal").nyroModal();     
			});
            });
            function sortingdiv()
            {
                showHideSortDiv("chkunchk2","selectopt2");
                showHideSortDiv("chkunchk3","selectopt3");  
            }
			function showMoreDetails(snId, ssType)
			{
				if(ssType == "show")
					$("#moreDetails_"+snId).show();
				else
					$("#moreDetails_"+snId).hide();
			}
			function displayMap(ssMapPath)
			{
				window.open(ssMapPath,"mywindow","width=900,height=700");
			}
		');
    endif;
?>