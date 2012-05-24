<?php

class appCommon 
{
    public $oForm;
    public $oRequest;	
    public $ssModuleName;
    public $ssBaseId;
    public $ssTableName;
    public $oContent;
    public $oQuery;
    public $oPager;
    public $oResults;
    public $ssTitle;
    public $ssSortOn;
    public $ssSortBy;
    public $snItemPerPage;
    public $aSearchOptions;
    public $aFields;
    public $ssLink;
    public $ssDivId = 'getList';
    public $ssParams='';
    public $ssShowDeleteButton = true;
    public $ssShowCreateButton = true;
    public $ssShowSendButton = false; // Shows Send Button.
    public $ssShowPaging = true;
    public $ssShowCheckBox = true;
    public $ssButtonMenu = false;
    public $ssButtonTopMenu = false;
    public $ssRenderListFileName = 'global/recordListing';
    public $ssMetaDataRequired = false;
    public $ssRankRequired = false;
    public $ssPostForm = false;
    public $ssDeleteButton = false;
    
    function  __construct($ssModuleName)
    {
		if($ssModuleName != "")
			$this->ssModuleName = $ssModuleName;
			
    }

	/*
	 *  THis function for Generate Form
	 */		
	
     public function processForm($ssRequest)
     {
    	if($ssRequest != "")
		{
		   if(($ssRequest->isMethod('post') || $ssRequest->isMethod('put')) && $ssRequest->getParameter('Save'))
		    { 
				
				$this->oForm->bind($ssRequest->getParameter($this->oForm->getName()),($this->oForm->isMultipart() ? $ssRequest->getFiles($this->oForm->getName()) : null));
				
			   return $this->oForm->isValid();
		   }
		 }  
		   return false;
	}

	/*
	 *  THis function for Save Data
	 */		
	
	public function saveFormData()
	{	
		$oFormObject = $this->oForm->getObject();

		if($this->oForm->getObject()->isNew()  && isset($oFormObject['created_at']))
			$this->oForm->getObject()->setCreatedAt(date('Y-m-d H:i:s'));
			
		if(isset($oFormObject['updated_at']))
			$this->oForm->getObject()->setUpdatedAt(date('Y-m-d H:i:s'));
	
		$this->oContent = $this->oForm->save();	
			    		
	}
	
	public function getSqlQueryCriteria()
	{
		$this->oRequest = sfContext::getInstance()->getRequest();
	
		if($this->oRequest->getParameter('ssSearchWord')!='')
		{
		
			if($this->oRequest->getParameter('ssSearchOption') == 'all')
			{
				$ssSearchString = '';
				foreach($this->aSearchOptions as $ssFieldName=>$ssValue)
				{
					$ssSearchString.=(($ssSearchString!="") ? " OR " : "" );
								
					$ssSearchString.="(".$ssFieldName." LIKE '%".trim(addslashes($this->oRequest->getParameter('ssSearchWord')))."%' )";
					//	
				}				
				$this->oQuery = $this->oQuery->andWhere("(".$ssSearchString.")"); 
			}
			else
		  		 $this->oQuery->andWhere($this->oRequest->getParameter('ssSearchOption')." LIKE '%".trim(addslashes($this->oRequest->getParameter('ssSearchWord')))."%'");
		
		   $this->ssParams.= (($this->ssParams!='') ? "&" : "")."ssSearchOption=".$this->oRequest->getParameter('ssSearchOption')."&ssSearchWord=".trim(addslashes($this->oRequest->getParameter('ssSearchWord')));		
		}		
		
	}

	/*
	 *  THis function for get All Records For Listing
	 */		
	public function getList($ssQueryCriteria= true)
	{

		$this->oRequest = sfContext::getInstance()->getRequest();
		$this->ssSortOn = $this->oRequest->getParameter('ssSortOn', $this->ssSortOn );
		
		$this->ssSortBy = $this->oRequest->getParameter('ssSortBy', (isset($this->ssSortBy))?$this->ssSortBy:'asc');
		
		if($this->ssSortOn!='' && $this->ssSortBy!='')
		$this->oQuery->orderBy($this->ssSortOn." ".$this->ssSortBy);
		
		if($ssQueryCriteria)
			$this->getSqlQueryCriteria();
				
		if($this->ssShowPaging)
		{
			$oPager = new sfMyPager();
		   	$this->oPager =  $oPager->getResults($this->ssTableName,($this->snItemPerPage ? $this->snItemPerPage : sfConfig::get('app_per_page')),$this->oQuery);
	    	$this->oResults = $this->oPager->getResults(Doctrine::HYDRATE_ARRAY);
	    }
	    else
	    	$this->oPager = $this->oResults = $this->oQuery->execute(array(), Doctrine::HYDRATE_ARRAY);	 

    }

	/*
	 *  THis function for Delete Record
	 */		
	public function deleteRecords($anIds)
	{

		if(count($anIds) > 0 && $this->ssTableName != "" && $this->ssBaseId != "")
		{	
			$oQuery = Doctrine_Query::create()
									->delete()
									->from($this->ssTableName." ".strtolower(substr($this->ssTableName,0,1)))
									->whereIn(strtolower(substr($this->ssTableName,0,1)).".".$this->ssBaseId,$anIds)
									->execute();
			  
			 if($oQuery && $this->ssMetaDataRequired) 
			 	Doctrine::getTable('MetaData')->deleteByIdModuleAndModuleName($anIds,$this->ssTableName);	
			 
				return $oQuery;
		}
		else
			return false;
	}
	
	/*
	 *  THis function for Active Inactive Record
	 */	
	
	public function activeRecord($snId,$ssStatus,$ssFieldName='')
	{
		$snId = (int)$snId;
		if($snId!='' && $ssStatus != '' && $this->ssTableName != '' && $this->ssBaseId!= "")
		{	
			$ssFieldName = ($ssFieldName=='') ? 'active': $ssFieldName;	
			$query = Doctrine_Query::create()
			  ->update($this->ssTableName." ".strtolower(substr($this->ssTableName,0,1)))
			  ->set(strtolower(substr($this->ssTableName,0,1)).'.'.$ssFieldName,'?',$ssStatus)
			  ->where(strtolower(substr($this->ssTableName,0,1)).".".$this->ssBaseId." = ?",$snId)
			  ->execute();
			   return true;	
		}
		else
		  return false;  		  		   
	}
	
	


	/*
	 *  THis function for Active Inactive Record for child Parent
	 */	
	
	public function activeRecordChildParent($snId,$ssStatus,$ssFieldName='')
	{
		
		$snId = (int)$snId;
		if($snId!='' && $ssStatus != '' && $this->ssTableName != '' && $this->ssBaseId!= "")
		{	
			$ssFieldName = ($ssFieldName=='') ? 'active': $ssFieldName;	
			$query1 = Doctrine_Query::create()
			  ->update($this->ssTableName." ".strtolower(substr($this->ssTableName,0,1)))
			  ->set(strtolower(substr($this->ssTableName,0,1)).'.'.$ssFieldName,'?',$ssStatus)
			  ->where(strtolower(substr($this->ssTableName,0,1)).".".$this->ssBaseId." = ?",$snId)
			  ->execute();

			$query2 = Doctrine_Query::create()
			  ->update($this->ssTableName." ".strtolower(substr($this->ssTableName,0,1)))
			  ->set(strtolower(substr($this->ssTableName,0,1)).'.'.$ssFieldName,'?',$ssStatus)
			  ->andWhere(strtolower(substr($this->ssTableName,0,1))."."." id_parent= ?",$snId)
			  ->execute();
			   return true;	
		}
		else
		  return false;  		  		   
	} 
	
	
	
	/*
	 *  THis function for update Rank and level
	 */	
	    
    public function updateRankAndLavel($aIdRank,$snRank1,$snRank2)
    {    

    	if($aIdRank!='' && $snRank1 != '' && $snRank2 != '' && $this->ssTableName != '')			
		{
			$oRecord1 = Doctrine::getTable($this->ssTableName)->find($aIdRank[$snRank1]);
			$oRecord2 = Doctrine::getTable($this->ssTableName)->find($aIdRank[$snRank2]);

	 	 	$snRank1 = $oRecord1->getRank();
	 		$snRank2 = $oRecord2->getRank();
	 		
	 		$snLvl1 = $oRecord1->getLvl();
	 		$snLvl2 = $oRecord2->getLvl();

	 		 $snIdparent1 =  $oRecord1->getIdParent();
	 		 $snIdparent2 =  $oRecord2->getIdParent();
	 		 
	 		$ssLvl1 = Doctrine::getTable($this->ssTableName)->calculateLevel($snIdparent1,$snRank2);
	 	 	$ssLvl2 = Doctrine::getTable($this->ssTableName)->calculateLevel($snIdparent2,$snRank1);	 			 	

			$oRecord1->setRank($snRank2);
			$oRecord1->setLvl($ssLvl1);		
			$oRecord1->save();
			$oRecord2->setRank($snRank1);	
			$oRecord2->setLvl($ssLvl2);		
			$oRecord2->save();	
			Doctrine::getTable($this->ssTableName)->calculateLevelByRank($oRecord1->getIdListingDetailCategory(),$snLvl1,$ssLvl1);
			Doctrine::getTable($this->ssTableName)->calculateLevelByRank($oRecord2->getIdListingDetailCategory(),$snLvl2,$ssLvl2);
		 		
			return true;
		}	
		else
			return false;
    }	   
	
	
}


