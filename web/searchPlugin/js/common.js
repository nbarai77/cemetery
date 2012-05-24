
function showHideSortDiv(sortdiv,fieldnamediv)
{
jQuery(document).click(function(e){ 
    jQuery("#"+sortdiv).hide();
});

jQuery("#"+fieldnamediv).click(function(e)
{ 
        

    if( jQuery('#'+sortdiv).is(':hidden') )
    {
    jQuery(".inn_drupdownSort").hide();
    jQuery(".inn_drupdown").hide();
    jQuery(".inn_drupdown1").hide();
    jQuery("#"+sortdiv).show();
    }
    else
    {
    jQuery("#"+sortdiv).hide();
    jQuery(".inn_drupdownSort").hide();
    jQuery(".inn_drupdown").hide();
    jQuery(".inn_drupdown1").hide();
    }
    e.stopPropagation();
});

jQuery("#"+sortdiv).click(function(e){
    e.stopPropagation();
});
} 

function uncheck(oCheckbox, ssCheckbox, checkboxid)
{     
var inactivateIds = document.getElementById(checkboxid);
var anCheck= eval('document.getElementsByName("' + oCheckbox.name + '")');
    if(ssCheckbox)
var anCheckbox = eval('document.getElementById("' + ssCheckbox + '")');
smStrId = oCheckbox.id;
snId = smStrId.split("_");
snId = snId[2]; //Fetch the ID

ssInactiveIds = inactivateIds.value;
anInactiveIds = new Array();

if(ssInactiveIds != '') anInactiveIds = ssInactiveIds.split(","); //Convert String to Array
var bFlag = true;   
if(oCheckbox.checked) 
{ 
    anInactiveIds.push(snId);
    for(snX = 0; snX < anCheck.length; snX++ )
    {
    if(!anCheck[snX].checked)
    {
        bFlag = false;
    }
    } 
    if(ssCheckbox && bFlag == true)
    { 
    anCheckbox.checked = true;
    }
}
else
{ 
    bFlag = false;
    anInactiveIds  = removeItems(anInactiveIds, snId ); // Remove Item from the Array
    if(ssCheckbox)
    anCheckbox.checked = false;
}
    
    if(bFlag)
        document.getElementById('checkall').checked = true;
    else
        document.getElementById('checkall').checked = false;

inactivateIds.value = anInactiveIds.join(",") // Convert Array to String and assign to the hidden variable  
}


function checkAll(oCheckbox, ssCheckbox, ssValueField)
{   

var anCommonId = eval('document.getElementsByName("' + ssCheckbox + '")');
if(oCheckbox.checked) 
{
    
    var anId = new Array();
    for( snX = 0; snX < anCommonId.length; snX++ )
    {
    anCommonId[snX].checked = true;
    anId.push(anCommonId[snX].value);
    } 
    if(anId && anId != '')
    {
        document.getElementById(ssValueField).value = anId;
    }
    document.getElementById('checkall').checked = true;
}
else
{ 
    if(anCommonId.length > 0)
    {
        document.getElementById(ssValueField).value = '';
        for( snX = 0; snX < anCommonId.length; snX++ )
        {
        anCommonId[snX].checked = false;
        }
    }
    
    document.getElementById('checkall').checked = false;
}
}  

function singleCheck(oCheckbox, ssCheckbox, ssValueField)
{
    var asCheckedValue = new Array();
    if(document.getElementById(ssValueField).value != '')
    asCheckedValue = document.getElementById(ssValueField).value.split(',');

    var asCheckBox = document.getElementsByName(ssCheckbox);
    var bFlag = true;
    if(oCheckbox.checked)
    {
        asCheckedValue.push(oCheckbox.value);
        for(i=0;i<asCheckBox.length; i++)
        {
            if(!asCheckBox[i].checked)
                bFlag = false;
            
        }
    }
    else
    {
        removeItems(asCheckedValue,oCheckbox.value);
        bFlag = false;
    }
    if(bFlag)
        {
            document.getElementById('checkall').checked = true;
        }
        else
        {
            document.getElementById('checkall').checked = false;
        }
    document.getElementById(ssValueField).value = asCheckedValue;
}

function SetAllCheckBoxes(FormName, FieldName, CheckValue,act,CheckboxIds)
{ 
if(!document.forms[FormName])
    return;

var objCheckBoxes = document.forms[FormName].elements[FieldName];

if(!objCheckBoxes)
    return;
var countCheckBoxes = objCheckBoxes.length;

if(!countCheckBoxes) 
    objCheckBoxes.checked = CheckValue; 

if(act == "all"){
    document.getElementById('checkall').checked = true;
    }
else if(act == "none"){
    document.getElementById('checkall').checked = false;
}   
document.getElementById('chkunchk').style.display = "none";
    
    var anId = new Array();
    var asCheckboxStatus = new Array(); 
    // set the check value for all check boxes
    for(var i = 0; i < countCheckBoxes; i++)
    {      
    if(CheckValue && act != "starred" && act != "unstarred"){ 
        anId.push(objCheckBoxes[i].value); }
    else{ 
        anId = removeItems(anId, objCheckBoxes[i].value); // Remove Item from the Array   
        }
    
            if(act == "starred")
        {
        if(objCheckBoxes[i].className){
            objCheckBoxes[i].checked = CheckValue;
            anId.push(objCheckBoxes[i].value);
            }
        else
            objCheckBoxes[i].checked = '';
    }
    if(act == "unstarred")
        {
        if(objCheckBoxes[i].className){ 
            objCheckBoxes[i].checked = '';
            }
        else{
            objCheckBoxes[i].checked = CheckValue;
            anId.push(objCheckBoxes[i].value);
        
            }
    }
    
    if(act == "all" || act == "none")
    {   
        objCheckBoxes[i].checked = CheckValue;
            
    }
    
    if(act == "checkbox_status")
    {
        if(objCheckBoxes[i].checked)
            asCheckboxStatus.push('checked');
        else
            asCheckboxStatus.push('');
    }
    }

    document.getElementById(CheckboxIds).value = anId;
}
function removeItems(array, item) 
{  
var i = 0;
while (i < array.length) {
if (array[i] == item) {
array.splice(i, 1);
} else {
i++;
}
}

return array;
} 

// Function to set previous page for global paging
function setPreviousPage(ssForm)
{ 
    var ssFormName = (ssForm != '') ? ssForm : jQuery('#form_name').val();
	var oForm = document.getElementById(ssFormName);
    var ssCurrentPage = parseInt(oForm.page.value) - 1;
	oForm.page.value = ssCurrentPage;
	showResults(false);
    //jQuery('#'+ssFormName).trigger('onsubmit');
	
}

// Function to set first page for global paging
function setFirstPage(snPage,ssForm)
{ 
    var ssFormName = (ssForm != '') ? ssForm : jQuery('#form_name').val();
    var ssCurrentPage = parseInt(snPage);

	var oForm = document.getElementById(ssFormName);	
	oForm.page.value = ssCurrentPage;
	showResults(false);
	//jQuery('#'+ssFormName).trigger('onsubmit'); 
}

// Function to jump on page for global paging
function jumpTo(LastPage,e,ssForm)
{
	if(e.keyCode == 13)
	{
		var pageNo = jQuery('#jump_to').val();
		var jumpPage = parseInt(pageNo);
		if(!isNaN(jumpPage))
		{
			if(jumpPage <= LastPage && jumpPage > 0)
			{
				var ssFormName = (ssForm != '') ? ssForm : jQuery('#form_name').val(); 			
				var ssPage = jumpPage;
				
				var oForm = document.getElementById(ssFormName);	
				oForm.page.value = ssPage;
				showResults(false);
				//jQuery('#'+ssFormName).trigger('onsubmit'); 
			}
		}
	}
}

// Function to set record per page for global paging
function recordPerPage(pageNo,ssForm)
{ 
    var jumpPage = parseInt(pageNo);
    if(!isNaN(jumpPage))
    {
	    if(jumpPage > 0)
	    {
	        var ssFormName = (ssForm != '') ? ssForm : jQuery('#form_name').val();  
	        var ssPage = jumpPage;
	        
			var oForm = document.getElementById(ssFormName);	
			oForm.page.value = 1;
			oForm.paging.value = ssPage;
			jQuery('#'+ssFormName).trigger('onsubmit'); 
	    }
    }
}

// Function to set next page for global paging
function setNextPage(ssForm)
{ 	
    var ssFormName = (ssForm != '') ? ssForm : jQuery('#form_name').val();  
    
	var oForm = document.getElementById(ssFormName);	
    var ssCurrentPage = parseInt(oForm.page.value) + 1;
	oForm.page.value = ssCurrentPage;
	showResults(false);
    //jQuery('#'+ssFormName).trigger('onsubmit'); 
}

// Function to set last page for global paging
function setLastPage(snPage,ssForm)
{ 
    var ssFormName = (ssForm != '') ? ssForm : jQuery('#form_name').val();  
    
	var oForm = document.getElementById(ssFormName);	
	var ssCurrentPage = parseInt(snPage);
    oForm.page.value = ssCurrentPage;
	showResults(false);
    //jQuery('#'+ssFormName).trigger('onsubmit');
}

function showAll(amSearchKey)
{
    jQuery.each(amSearchKey, function(i,fieldName) {
        jQuery('#search'+fieldName).val("");
    });

    return false;
}

function removeConfirm(checkboxidName,act)
{
    var chks = document.getElementsByName(checkboxidName);
    
    var msg = "Are you sure want to remove selected record(s)?";
    if(act == 'status')
        msg = "Are you sure want to change the status of selected record(s)?";
        
    haschecked = false;
    for(var i = 0;i<chks.length;i++)
    {
        if(chks[i].checked)
        {
            haschecked = true;
        }
    }
    if(!haschecked)
    {
        alert('Please select atleast one record');
    }
    if(haschecked)
    {
        if(confirm(msg))
        {
            return true;
        }
    }
}
function adminAct(actValue)
{
jQuery('#admin_act').val(actValue);
}
function uncheckAllChkbox(chkboxId)
{
    document.getElementById('checkall').checked = false;
}

function triggerSearch(event)
{
    if (event.keyCode == 13) 
    {
        jQuery("#bGo").click();
    }
}

function ajaxloader(updateDiv,hiddenimage,snPadding)
{
var ssPaddingValue = '200px'
if(snPadding != undefined)
    var ssPaddingValue = snPadding+'px';

var ssloaderImage = '/images/'+document.getElementById(hiddenimage).value;
jQuery('div#'+updateDiv).html("<div align='center' style='padding-top:"+ssPaddingValue+";'><img src='"+ssloaderImage+"'/></div>");
}

function trim(stringToTrim) 
{
    return stringToTrim.replace(/^\s+|\s+$/g,"");
}

function checkvalidNumber(amPositionValues,msg)
{   
    jQuery('#admin_act').val('change_order');
    var anPositionId = eval('document.getElementsByName("' + amPositionValues + '")');
    var snFlag = 1;
    var regexp = /^[0-9]+$/;
    for( x=0; x<anPositionId.length; x++ )
    {   
    
    snValue = anPositionId[x].value;
    
    if(regexp.test(snValue))
    {
        snFlag = 1;
    }
    else
    {
        snFlag = 0;
        break;
    }

    }

    if(snFlag == 0)
    {
    alert(msg);
    return false;
    }
    else   
    return true;
}

function loadNyroModal()
{
jQuery(function() {
    jQuery('.nyroModal').nyroModal();
});
}

function lockScreen()
{ 
    var aAllInputs = document.getElementsByTagName('input'); 
    for(var i = 0; i< document.links.length;i++)
    document.links[i].tabIndex = -1;
    for(var i = 0; i< aAllInputs.length;i++)
    aAllInputs[i].tabIndex = -1;
}
function unLockScreen()
{
    var aAllInputs = document.getElementsByTagName('input'); 
    for(var i = 0; i< document.links.length;i++)
    document.links[i].tabIndex = 0;
    for(var i = 0; i< aAllInputs.length;i++)
    aAllInputs[i].tabIndex = 0;
}

function OnClientShow()
{ /*
    var oTop = document.body.scrollTop;
    document.body.style.overflow = "hidden";
    document.body.scrollTop = oTop;
*/
jQuery('body').css('overflow','hidden');
}

function OnClientClose()
{
jQuery('body').css('overflow','');
} 

function updateLaboratoryCombo(ssIdUpdateLaboratory)
{
    var ssLabIdList = jQuery('#lab_id').val();    
    var anLabId     = ssLabIdList.split('@@@');
    
    jQuery('#lab_id').val('0');

    for(var i=1;i<=anLabId.length;i++)
    {
        if(anLabId[i] != '' && jQuery('#'+anLabId[i]).html() != null)
        {
            var opt = document.createElement("option");

            // Add an Option object to Drop Down/List Box
            document.getElementById(ssIdUpdateLaboratory).options.add(opt);

            // Assign text and value to Option object
            opt.text     = jQuery('#lab_name_'+anLabId[i]).html();        
            opt.value    = anLabId[i];

            jQuery('#'+anLabId[i]).remove();
        }            
    }
}

function updateLaboratory(ssAction, ssSelectId, updateDiv, ssIdAvailableGroup)
{ 
    var strSelecteValue = $('#'+ssSelectId).serialize();

    jQuery.ajax({
        type: 'POST', 
        url: ssAction,  
        data: strSelecteValue,         
        success:function(data, textStatus)
        {
            jQuery('#'+updateDiv).html(jQuery('#'+updateDiv).html()+data);
            var list = document.getElementById(ssIdAvailableGroup);

            for(i=list.length-1;i>=0;i--)
            {
                if(list.options[i].selected == true)
                {
                    list.remove(i);
                }
            }
        }            
  });    
}

function toggleSelectLaboratory(snLabId)
{
    var ssLabIdList = jQuery('#lab_id').val(); 

    if(ssLabIdList.search("@@@"+snLabId+"@@@") > 0)
    {
        jQuery('#lab_id').val(ssLabIdList.replace("@@@"+snLabId+"@@@", ""));
        jQuery('#'+snLabId).css('background-color', '');
        jQuery('#'+snLabId).css('color', '');                
    }
    else
    {
        jQuery('#lab_id').val(jQuery('#lab_id').val()+'@@@'+snLabId+'@@@');
        jQuery('#'+snLabId).css('background-color', '#3399ff');
        jQuery('#'+snLabId).css('color', '#ffffff');        
    }
}

function tabSelection(id, ssClassName)
{ 
    var asTabs = new Array('equipment_info','equipment_staff','equipment_media', 'equipment_criteria', 'equipment_calendar');

    for(var i=0;i<asTabs.length;i++)
    {
        jQuery('#' + asTabs[i] ).removeClass(ssClassName);
    }
    jQuery('#' + id).addClass(ssClassName);
    jQuery('#updatediv').attr('style', 'display:block;');
}

function callAjaxRequest(snIdCountry, ssUrl, ssUpdateDivId)
{
	jQuery.ajax({
		type:'POST',
		dataType:'html',
		data:{id: snIdCountry},
		success:function(data, extStatus){jQuery("#"+ssUpdateDivId).html(data);},
		beforeSend:function(XMLHttpRequest){$("#IdAjaxLocaderCemetery").show();},
		complete:function(XMLHttpRequest, textStatus){$("#IdAjaxLocaderCemetery").hide();},
		url:ssUrl
	})
}
function showResults(bNewSearch)
{
	var flag=true;
	var ssSurname = jQuery.trim(jQuery('#surname').val());
	var ssName = jQuery.trim(jQuery('#name').val());
	var snYearFrom = jQuery.trim(jQuery('#yrfrom').val());
	var snYearTo = jQuery.trim(jQuery('#yrto').val());
	var snPage = jQuery.trim(jQuery('#page').val());
	var snPerPage = jQuery.trim(jQuery('#paging').val());

	if(bNewSearch)
		snPage = 1;

	if(ssSurname == '')
		flag = false;
	
	if(ssName == '')
		flag = false;
	
	if(flag)
	{
		ssSurname = ssSurname.replace(/ /g,"_");
		ssName = ssName.replace(/ /g,"_");

		jQuery.ajax({
			type:'POST',
			dataType:'html',
			data:{surname: ssSurname, name: ssName, yrfrom: snYearFrom, yrto: snYearTo, page: snPage, paging: snPerPage},
			beforeSend:function(XMLHttpRequest){$("#ajaxLoader").show();},
			complete:function(XMLHttpRequest, textStatus){$("#ajaxLoader").hide();},
			success:function(data, textStatus){jQuery('#searchResults').html(data);},
			url:'searchResult.php'
		});
	}
	else
		alert('Please enter compulsory fields');
}