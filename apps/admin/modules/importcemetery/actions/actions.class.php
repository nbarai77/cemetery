<?php

/**
 * importcemetery actions.
 *
 * @package    cemetery
 * @subpackage importcemetery
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php,v 1.1.1.1 2012/03/24 12:17:07 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N','Url'));
class importcemeteryActions extends sfActions
{
    /**
     * preExecutes  action
     *
     * @access public
     * @param sfRequest $request A request object
     */
    public function preExecute()
    {
        sfContext::getInstance()->getResponse()->addCacheControlHttpHeader('no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->ssFormName = 'frm_list_area';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Declaration of messages.
        $this->amSuccessMsg = array(
                                    1 => __('Status changes successfully'),
                                    2 => __('Record has been updated successfully'),
                                    3 => __('Record has been deleted successfully'),
                                    4 => __('Record has been inserted successfully'),
									5 => __('Data has been imported successfully')
                                );

		$ssDownFileName = '';
		if($omRequest->getParameter('action') == 'importGraveData')
			$ssDownFileName = base64_encode('grave_sample.csv');
		elseif($omRequest->getParameter('action') == 'importGranteeData')
			$ssDownFileName = base64_encode('grantee_sample.csv');
		else
			$ssDownFileName = base64_encode('interment_sample.csv');

		$ssRedirectUrl = url_for($omRequest->getParameter('module').'/downloadSample?filename='.$ssDownFileName);
		$ssUrl = '<a href="'.$ssRedirectUrl.'" title="'.__('Click here').'">'.__('Click here').'</a>';
        $this->amErrorMsg = array(1 => __('Please select at least one'), 
								  2 => __('The file is not well formated. Please '.$ssUrl.' to download the sample format'),
								  3 => __('Some information was missing')
								  );

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','id');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','desc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

        if($this->getRequestParameter('sortby') != '' )        // Sorting parameters
            $this->ssQuerystr .= '&sortby='.$this->getRequestParameter('sortby').'&sortmode='.$this->getRequestParameter('sortmode');

        $this->amExtraParameters['ssQuerystr']     = $this->ssQuerystr;
        $this->amExtraParameters['ssSortQuerystr'] = $this->ssSortQuerystr;
    }
	/**
	* Executes importGraveData action
	*
	* @param sfRequest $request A request object
	*/
	public function executeImportGraveData(sfWebRequest $oRequest)
	{
		$this->ssHeading = __('Import Grave Data');
		$this->ssDownFileName = base64_encode('grave_sample.csv');

		$this->snCementeryId = $oRequest->getParameter('importcemetery_cem_cemetery_id', '');
		$this->asCementery = array();

		$this->omImportDataForm = new ImportDataForm();	
		$this->getConfigurationFields($this->omImportDataForm);
		
		$amFormRequest = $oRequest->getParameter($this->omImportDataForm->getName());
		$amFileRequest = $oRequest->getFiles($this->omImportDataForm->getName());
		
		$this->snCementeryId = isset($amFormRequest['cem_cemetery_id']) ? $amFormRequest['cem_cemetery_id'] : $this->snCementeryId;
		
		if($amFormRequest['country_id'] != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($amFormRequest['country_id']);
			
		if($oRequest->isMethod('post'))
        {
			$this->omImportDataForm->bind($amFormRequest,$amFileRequest);
			
			$bSelectCemetery = false;
			if($this->getUser()->isSuperAdmin())
			{
				if($oRequest->getParameter('importcemetery_cem_cemetery_id') != '')
					$bSelectCemetery = true;
			}
			else
				$bSelectCemetery = true;
				
			if($this->omImportDataForm->isValid() && $bSelectCemetery)
			{
                $ssXlsTempFile = ($amFileRequest['import_file']['tmp_name']) ? $amFileRequest['import_file']['tmp_name'] : '';
                if($ssXlsTempFile != '')
				{
                    // Start Extract xls file and insert data into DB.
					/*---------------- OLD -------------------------
                    $oData = new Spreadsheet_Excel_Reader();					
                    $oData->read($ssXlsTempFile);
					*/
					$amArgs = array (
									'csv_file'          => $ssXlsTempFile,
									//'csv_delimiter'     => ',',
									'csv_fields_num'    => FALSE,
									'csv_head_read'     => TRUE,
									'csv_head_label'    => FALSE
								);
					$oChipCSV = new Chip_csv();
					$oData = $oChipCSV->get_read( $amArgs );
					
                    if(trim($oData['csv_file_data'][1][0]) != 'AREA' || trim($oData['csv_file_data'][1][1]) != 'SECTION' || trim($oData['csv_file_data'][1][4]) != 'GRAVE' ||
						trim($oData['csv_file_data'][1][5]) != 'COMM1' || trim($oData['csv_file_data'][1][6]) != 'COMM2')
					{
						$this->getUser()->setFlash('snErrorMsgKey', 2);   //Set messages for add and update records
					}
					else
					{
						// SET GRAVE DATA AND INSERT INTO TABLE
						$this->setGraveData($oData['csv_file_data'], $amFormRequest, $this->snCementeryId);

						$this->getUser()->setFlash('snSuccessMsgKey', 5);   //Set messages for add and update records
						$this->redirect('importcemetery/importGraveData');
					}
                }
			}
			else
			{
				if(!$bSelectCemetery)
					$this->getUser()->setFlash('ssErrorCemeter',__('Please select cemetery'));
			}
		}
		$this->setTemplate('import');
	}
	
	private function setGraveData($amExcelData, $amFormRequest, $snCemeteryId)
	{
		$snAreaCol = 0;							// 0 Column
		$snSecCol = $snAreaCol + 1;				// 1 Column
		$snRowCol = $snSecCol + 1;				// 2 Column
		$snPlotCol = $snRowCol + 1;				// 3 Column
		$snGraveCol = $snPlotCol + 1;			// 4 Column
		$snComm1Col = $snGraveCol + 1;			// 5 Column
		$snComm2Col = $snComm1Col + 1;			// 6 Column
		
		for($snI=1,$snJ=2; $snI <= count($amExcelData)-1; $snI++,$snJ++) 
		{
			// CHECK FOR MANDATRORY FIELDS VALUES ARE EXISTS OR NOT
			if( isset($amExcelData[$snJ][$snGraveCol]) && $amExcelData[$snJ][$snGraveCol] != '')
			{
				$amParseData = array();
				$amParseData['country_id'] = $amFormRequest['country_id'];
				$amParseData['cem_cemetery_id'] = $snCemeteryId;

				////////////////////////////////
				//		CHECK AREA	EXISTS	  //
				////////////////////////////////
				$amParseData['ar_area_id'] = '';
				if(isset($amExcelData[$snJ][$snAreaCol]) && $amExcelData[$snJ][$snAreaCol] != '')
				{
					$snAreaId = Doctrine::getTable('ArArea')->getAreaIdAsPerCriteria($amParseData['country_id'], $amParseData['cem_cemetery_id'], $amExcelData[$snJ][$snAreaCol]);
					$amParseData['ar_area_id'] = $snAreaId;
				}
				
				///////////////////////////////////
				//		CHECK SECTION EXISTS	 //
				///////////////////////////////////
				$amParseData['ar_section_id'] = '';
				if(isset($amExcelData[$snJ][$snSecCol]) && $amExcelData[$snJ][$snSecCol] != '')
				{
					$snSectionId = Doctrine::getTable('ArSection')->getSectionIdAsPerCriteria($amParseData['country_id'], $amParseData['cem_cemetery_id'], $amParseData['ar_area_id'], $amExcelData[$snJ][$snSecCol]);
					$amParseData['ar_section_id'] = $snSectionId;
				}
				//////////////////////////////
				//		CHECK ROW EXISTS	//
				//////////////////////////////
				$amParseData['ar_row_id'] = '';
				if(isset($amExcelData[$snJ][$snRowCol]) && $amExcelData[$snJ][$snRowCol] != '')
				{
					$snRowId = Doctrine::getTable('ArRow')->getRowIdAsPerCriteria($amParseData['country_id'], $amParseData['cem_cemetery_id'], $amParseData['ar_area_id'], $amParseData['ar_section_id'], $amExcelData[$snJ][$snRowCol]);
					$amParseData['ar_row_id'] = $snRowId;
				}
				///////////////////////////////
				//		CHECK PLOT EXISTS	 //
				///////////////////////////////
				$amParseData['ar_plot_id'] = '';
				if(isset($amExcelData[$snJ][$snPlotCol]) && $amExcelData[$snJ][$snPlotCol] != '')
				{
					$snPlotId = Doctrine::getTable('ArPlot')->getPlotIdAsPerCriteria($amParseData['country_id'], $amParseData['cem_cemetery_id'], $amParseData['ar_area_id'], $amParseData['ar_section_id'], $amParseData['ar_row_id'], $amExcelData[$snJ][$snPlotCol]);
					$amParseData['ar_plot_id'] = $snPlotId;
				}
				////////////////////////////////
				//		CHECK GRAVE	EXISTS	  //
				////////////////////////////////

				$ssGraveComment1 = isset($amExcelData[$snJ][$snComm1Col]) ? preg_replace("/'/", " ", addslashes($amExcelData[$snJ][$snComm1Col])) : '';
				$ssGraveComment2 = isset($amExcelData[$snJ][$snComm2Col]) ? preg_replace("/'/", " ", addslashes($amExcelData[$snJ][$snComm2Col])) : '';
				
				$snGraveId = Doctrine::getTable('ArGrave')->getGraveIdAsPerCriteria($amParseData['country_id'], $amParseData['cem_cemetery_id'], $amParseData['ar_area_id'], $amParseData['ar_section_id'], $amParseData['ar_row_id'], $amParseData['ar_plot_id'], $amExcelData[$snJ][$snGraveCol], trim($ssGraveComment1), trim($ssGraveComment2) );
			}
		}
	}
	/**
	* Executes importGranteeData action
	*
	* @param sfRequest $request A request object
	*/
	public function executeImportGranteeData(sfWebRequest $oRequest)
	{
		$this->ssHeading = __('Import Grantee Data');
		$this->ssDownFileName = base64_encode('grantee_sample.csv');
		
		$this->snCementeryId = $oRequest->getParameter('importcemetery_cem_cemetery_id', '');
		$this->asCementery = array();

		$this->omImportDataForm = new ImportDataForm();	
		$this->getConfigurationFields($this->omImportDataForm);
		
		$amFormRequest = $oRequest->getParameter($this->omImportDataForm->getName());
		$amFileRequest = $oRequest->getFiles($this->omImportDataForm->getName());
			
		$this->snCementeryId = isset($amFormRequest['cem_cemetery_id']) ? $amFormRequest['cem_cemetery_id'] : $this->snCementeryId;
		
		if($amFormRequest['country_id'] != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($amFormRequest['country_id']);
			
		if($oRequest->isMethod('post'))
        {
			$this->omImportDataForm->bind($amFormRequest,$amFileRequest);
			
			$bSelectCemetery = false;
			if($this->getUser()->isSuperAdmin())
			{
				if($oRequest->getParameter('importcemetery_cem_cemetery_id') != '')
					$bSelectCemetery = true;
			}
			else
				$bSelectCemetery = true;
				
			if($this->omImportDataForm->isValid() && $bSelectCemetery)
			{
                $ssXlsTempFile = ($amFileRequest['import_file']['tmp_name']) ? $amFileRequest['import_file']['tmp_name'] : '';
                if($ssXlsTempFile != '')
				{
                    // Start Extract xls file and insert data into DB.
					$amArgs = array (
									'csv_file'          => $ssXlsTempFile,
									//'csv_delimiter'     => ',',
									'csv_fields_num'    => FALSE,
									'csv_head_read'     => TRUE,
									'csv_head_label'    => FALSE
								);
					$oChipCSV = new Chip_csv();
					$oData = $oChipCSV->get_read( $amArgs );
					
                    if(trim($oData['csv_file_data'][1][0]) != 'AREA' || trim($oData['csv_file_data'][1][1]) != 'SECTION' || trim($oData['csv_file_data'][1][4]) != 'GRAVE' || 
						trim($oData['csv_file_data'][1][5]) != 'SNAME' || trim($oData['csv_file_data'][1][6]) != 'FNAME' || 
						trim($oData['csv_file_data'][1][7]) != 'ADD1' || trim($oData['csv_file_data'][1][8]) != 'ADD2' || 
						trim($oData['csv_file_data'][1][9]) != 'PURCHASE_DATE' || trim($oData['csv_file_data'][1][10]) != 'COMM1' || 
						trim($oData['csv_file_data'][1][11]) != 'COMM2')
                    {
						$this->getUser()->setFlash('snErrorMsgKey', 2);   //Set messages for add and update records
                    }
					else
					{						
						// SET INTERMENT DATA AND INSERT INTO TABLE
						$this->setGranteeData($oData['csv_file_data'], $amFormRequest, $this->snCementeryId);

						$this->getUser()->setFlash('snSuccessMsgKey', 5);   //Set messages for add and update records
						$this->redirect('importcemetery/importGranteeData');
					}
                }
			}
			else
			{
				if(!$bSelectCemetery)
					$this->getUser()->setFlash('ssErrorCemeter',__('Please select cemetery'));
			}
		}
		$this->setTemplate('import');
	}
	private function setGranteeData($amExcelData, $amFormRequest, $snCemeteryId)
	{
		$snAreaCol = 0;									// 0 Column
		$snSecCol = $snAreaCol + 1;						// 1 Column
		$snRowCol = $snSecCol + 1;						// 2 Column
		$snPlotCol = $snRowCol + 1;						// 3 Column
		$snGraveCol = $snPlotCol + 1;					// 4 Column
		$snSnameCol = $snGraveCol + 1;					// 5 Column
		$snFnameCol = $snSnameCol + 1;					// 6 Column
		$snAdd1Col = $snFnameCol + 1;					// 7 Column
		$snAdd2Col = $snAdd1Col + 1;					// 8 Column
		$snPurDateCol = $snAdd2Col + 1;					// 9 Column
		$snComm1Col = $snPurDateCol + 1;				// 10 Column
		$snComm2Col = $snComm1Col + 1;					// 11 Column
		
		for($snI=1,$snJ=2; $snI <= count($amExcelData)-1; $snI++,$snJ++) 
		{
			// Check for mandatory fields values
			if( (isset($amExcelData[$snJ][$snGraveCol]) && $amExcelData[$snJ][$snGraveCol] != '') && 
				(isset($amExcelData[$snJ][$snFnameCol]) && $amExcelData[$snJ][$snFnameCol] != '') && 
				(isset($amExcelData[$snJ][$snSnameCol]) && $amExcelData[$snJ][$snSnameCol] != '') 
			  )
			{
				$amParseData = array();
				$amParseData['country_id'] = $amFormRequest['country_id'];
				$amParseData['cem_cemetery_id'] = $snCemeteryId;

				//////////////////////
				//		AREA		//
				//////////////////////
				$amParseData['ar_area_id'] = '';
				if(isset($amExcelData[$snJ][$snAreaCol]) && $amExcelData[$snJ][$snAreaCol] != '')
				{
					$snAreaId = Doctrine::getTable('ArArea')->getAreaIdAsPerCriteria($amParseData['country_id'], $amParseData['cem_cemetery_id'], $amExcelData[$snJ][$snAreaCol]);
					$amParseData['ar_area_id'] = $snAreaId;
				}
				
				//////////////////////
				//		SECTION		//
				//////////////////////
				$amParseData['ar_section_id'] = '';
				if(isset($amExcelData[$snJ][$snSecCol]) && $amExcelData[$snJ][$snSecCol] != '')
				{
					$snSectionId = Doctrine::getTable('ArSection')->getSectionIdAsPerCriteria($amParseData['country_id'], $amParseData['cem_cemetery_id'], $amParseData['ar_area_id'], $amExcelData[$snJ][$snSecCol]);
					$amParseData['ar_section_id'] = $snSectionId;
				}
				//////////////////////
				//		ROW			//
				//////////////////////
				$amParseData['ar_row_id'] = '';
				if(isset($amExcelData[$snJ][$snRowCol]) && $amExcelData[$snJ][$snRowCol] != '')
				{
					$snRowId = Doctrine::getTable('ArRow')->getRowIdAsPerCriteria($amParseData['country_id'], $amParseData['cem_cemetery_id'], $amParseData['ar_area_id'], $amParseData['ar_section_id'], $amExcelData[$snJ][$snRowCol]);
					$amParseData['ar_row_id'] = $snRowId;
				}
				//////////////////////
				//		PLOT		//
				//////////////////////
				$amParseData['ar_plot_id'] = '';
				if(isset($amExcelData[$snJ][$snPlotCol]) && $amExcelData[$snJ][$snPlotCol] != '')
				{
					$snPlotId = Doctrine::getTable('ArPlot')->getPlotIdAsPerCriteria($amParseData['country_id'], $amParseData['cem_cemetery_id'], $amParseData['ar_area_id'], $amParseData['ar_section_id'], $amParseData['ar_row_id'], $amExcelData[$snJ][$snPlotCol]);
					$amParseData['ar_plot_id'] = $snPlotId;
				}
				//////////////////////
				//		GRAVE		//
				//////////////////////
				$amParseData['ar_grave_id'] = '';
				if(isset($amExcelData[$snJ][$snGraveCol]) && $amExcelData[$snJ][$snGraveCol] != '')
				{
					$snGraveId = Doctrine::getTable('ArGrave')->getGraveIdAsPerCriteria($amParseData['country_id'], $amParseData['cem_cemetery_id'], $amParseData['ar_area_id'], $amParseData['ar_section_id'], $amParseData['ar_row_id'], $amParseData['ar_plot_id'], $amExcelData[$snJ][$snGraveCol]);
					$amParseData['ar_grave_id'] = $snGraveId;
				}

				//////////////////////////////
				// OTHER GRANTEE PARAMETERS	//
				//////////////////////////////
				$amParseData['grantee_surname'] = $amExcelData[$snJ][$snSnameCol];
				$amParseData['grantee_first_name'] = $amExcelData[$snJ][$snFnameCol];
				$amParseData['grantee_address'] = isset($amExcelData[$snJ][$snAdd1Col]) ? preg_replace("/'/", " ", addslashes($amExcelData[$snJ][$snAdd1Col])) : ''; 	// ADD1
				$amParseData['town'] = isset($amExcelData[$snJ][$snAdd2Col]) ? $amExcelData[$snJ][$snAdd2Col] : ''; 													// ADD2
				$amParseData['date_of_purchase'] = isset($amExcelData[$snJ][$snPurDateCol]) ? date('Y-m-d',strtotime($amExcelData[$snJ][$snPurDateCol])) : '';			// DATE OF PURCHASE
				$amParseData['remarks_1'] = isset($amExcelData[$snJ][$snComm1Col]) ? preg_replace("/'/", " ", addslashes($amExcelData[$snJ][$snComm1Col])) : '';		// COMMENT 1
				$amParseData['remarks_2'] = isset($amExcelData[$snJ][$snComm2Col]) ? preg_replace("/'/", " ", addslashes($amExcelData[$snJ][$snComm2Col])) : '';		// COMMENT 2
				
				// SAVE INTERMENT RECORD.
				GranteeDetails::saveGranteeRecords($amParseData);
			}
		}		
	}
	/**
	* Executes importIntermentsData action
	*
	* @param sfRequest $request A request object
	*/
	public function executeImportIntermentsData(sfWebRequest $oRequest)
	{
		$this->ssHeading = __('Import Interment Data');
		$this->ssDownFileName = base64_encode('interment_sample.csv');
		
		$this->snCementeryId = $oRequest->getParameter('importcemetery_cem_cemetery_id', '');
		$this->asCementery = array();

		$this->omImportDataForm = new ImportDataForm();	
		$this->getConfigurationFields($this->omImportDataForm);
		
		$amFormRequest = $oRequest->getParameter($this->omImportDataForm->getName());
		$amFileRequest = $oRequest->getFiles($this->omImportDataForm->getName());
			
		$this->snCementeryId = isset($amFormRequest['cem_cemetery_id']) ? $amFormRequest['cem_cemetery_id'] : $this->snCementeryId;
		
		if($amFormRequest['country_id'] != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($amFormRequest['country_id']);
			
		if($oRequest->isMethod('post'))
        {
			$this->omImportDataForm->bind($amFormRequest,$amFileRequest);
			
			$bSelectCemetery = false;
			if($this->getUser()->isSuperAdmin())
			{
				if($oRequest->getParameter('importcemetery_cem_cemetery_id') != '')
					$bSelectCemetery = true;
			}
			else
				$bSelectCemetery = true;
				
			if($this->omImportDataForm->isValid() && $bSelectCemetery)
			{
                $ssXlsTempFile = ($amFileRequest['import_file']['tmp_name']) ? $amFileRequest['import_file']['tmp_name'] : '';
                if($ssXlsTempFile != '')
				{
                    // Start Extract xls file and insert data into DB.
                    $amArgs = array (
									'csv_file'          => $ssXlsTempFile,
									//'csv_delimiter'     => ',',
									'csv_fields_num'    => FALSE,
									'csv_head_read'     => TRUE,
									'csv_head_label'    => FALSE
								);
					$oChipCSV = new Chip_csv();
					$oData = $oChipCSV->get_read( $amArgs );
					
                    if(trim($oData['csv_file_data'][1][0]) != 'AREA' || trim($oData['csv_file_data'][1][1]) != 'SECTION' || trim($oData['csv_file_data'][1][4]) != 'GRAVE' || 
						trim($oData['csv_file_data'][1][5]) != 'CONTROL_NUMBER' || trim($oData['csv_file_data'][1][6]) != 'SNAME' || 
						trim($oData['csv_file_data'][1][7]) != 'FNAME' || trim($oData['csv_file_data'][1][8]) != 'ADD1' || trim($oData['csv_file_data'][1][9]) != 'ADD2' || 
						trim($oData['csv_file_data'][1][10]) != 'AGE' || trim($oData['csv_file_data'][1][11]) != 'DEATH_DATE' || 
						trim($oData['csv_file_data'][1][12]) != 'INTERMENT_DATE' || trim($oData['csv_file_data'][1][13]) != 'FND_CODE' || 
						trim($oData['csv_file_data'][1][14]) != 'COMM1' || trim($oData['csv_file_data'][1][15]) != 'COMM2')
                    { 
						$this->getUser()->setFlash('snErrorMsgKey', 2);   //Set messages for add and update records
                    }
					else
					{
						// SET INTERMENT DATA AND INSERT INTO TABLE
						$this->setIntermentData($oData['csv_file_data'], $amFormRequest, $this->snCementeryId);
						
						$this->getUser()->setFlash('snSuccessMsgKey', 5);   //Set messages for add and update records
						$this->redirect('importcemetery/importIntermentsData');
					}
                }
			}
			else
			{
				if(!$bSelectCemetery)
					$this->getUser()->setFlash('ssErrorCemeter',__('Please select cemetery'));
			}
		}
		$this->setTemplate('import');
	}
	private function setIntermentData($amExcelData, $amFormRequest, $snCemeteryId)
	{
		$snAreaCol = 0;								// 0 Column
		$snSecCol = $snAreaCol + 1;					// 1 Column
		$snRowCol = $snSecCol + 1;					// 2 Column
		$snPlotCol = $snRowCol + 1;					// 3 Column
		$snGraveCol = $snPlotCol + 1;				// 4 Column
		$snCtrlNumCol = $snGraveCol + 1;			// 5 Column
		$snSnameCol = $snCtrlNumCol + 1;			// 6 Column
		$snFnameCol = $snSnameCol + 1;				// 7 Column
		$snAdd1Col = $snFnameCol + 1;				// 8 Column
		$snAdd2Col = $snAdd1Col + 1;				// 9 Column
		$snAgeCol = $snAdd2Col + 1;					// 10 Column
		$snDeathDateCol = $snAgeCol + 1;			// 11 Column
		$snIntDateCol = $snDeathDateCol + 1;		// 12 Column
		$snFndCol = $snIntDateCol + 1;				// 13 Column
		$snComm1Col = $snFndCol + 1;				// 14 Column
		$snComm2Col = $snComm1Col + 1;				// 15 Column
		
		for($snI=1,$snJ=2; $snI <= count($amExcelData)-1; $snI++,$snJ++) 
		{
			// Check for mandatory fields values
			if( (isset($amExcelData[$snJ][$snGraveCol]) && $amExcelData[$snJ][$snGraveCol] != '') && 
				(isset($amExcelData[$snJ][$snSnameCol]) && $amExcelData[$snJ][$snSnameCol] != '') && 
				(isset($amExcelData[$snJ][$snSnameCol]) && $amExcelData[$snJ][$snSnameCol] != '') && 
				(isset($amExcelData[$snJ][$snFnameCol]) && $amExcelData[$snJ][$snFnameCol] != '') && 
				(isset($amExcelData[$snJ][$snIntDateCol]) && $amExcelData[$snJ][$snIntDateCol] != '')
			  )
			{
				$amParseData = array();
				$amParseData['country_id'] = $amFormRequest['country_id'];
				$amParseData['cem_cemetery_id'] = $snCemeteryId;

				//////////////////////
				//		AREA		//
				//////////////////////
				$amParseData['ar_area_id'] = '';
				if(isset($amExcelData[$snJ][$snAreaCol]) && $amExcelData[$snJ][$snAreaCol] != '')
				{
					$snAreaId = Doctrine::getTable('ArArea')->getAreaIdAsPerCriteria($amParseData['country_id'], $amParseData['cem_cemetery_id'], $amExcelData[$snJ][$snAreaCol]);
					$amParseData['ar_area_id'] = $snAreaId;
				}
				//////////////////////
				//		SECTION		//
				//////////////////////
				$amParseData['ar_section_id'] = '';
				if(isset($amExcelData[$snJ][$snSecCol]) && $amExcelData[$snJ][$snSecCol] != '')
				{
					$snSectionId = Doctrine::getTable('ArSection')->getSectionIdAsPerCriteria($amParseData['country_id'], $amParseData['cem_cemetery_id'], $amParseData['ar_area_id'], $amExcelData[$snJ][$snSecCol]);
					$amParseData['ar_section_id'] = $snSectionId;
				}
				//////////////////////
				//		ROW			//
				//////////////////////
				$amParseData['ar_row_id'] = '';
				if(isset($amExcelData[$snJ][$snRowCol]) && $amExcelData[$snJ][$snRowCol] != '')
				{
					$snRowId = Doctrine::getTable('ArRow')->getRowIdAsPerCriteria($amParseData['country_id'], $amParseData['cem_cemetery_id'], $amParseData['ar_area_id'], $amParseData['ar_section_id'], $amExcelData[$snJ][$snRowCol]);
					$amParseData['ar_row_id'] = $snRowId;
				}
				//////////////////////
				//		PLOT		//
				//////////////////////
				$amParseData['ar_plot_id'] = '';
				if(isset($amExcelData[$snJ][$snPlotCol]) && $amExcelData[$snJ][$snPlotCol] != '')
				{
					$snPlotId = Doctrine::getTable('ArPlot')->getPlotIdAsPerCriteria($amParseData['country_id'], $amParseData['cem_cemetery_id'], $amParseData['ar_area_id'], $amParseData['ar_section_id'], $amParseData['ar_row_id'], $amExcelData[$snJ][$snPlotCol]);
					$amParseData['ar_plot_id'] = $snPlotId;
				}
				//////////////////////
				//		GRAVE		//
				//////////////////////
				$amParseData['ar_grave_id'] = '';
				if(isset($amExcelData[$snJ][$snGraveCol]) && $amExcelData[$snJ][$snGraveCol] != '')
				{
					$snGraveId = Doctrine::getTable('ArGrave')->getGraveIdAsPerCriteria($amParseData['country_id'], $amParseData['cem_cemetery_id'], $amParseData['ar_area_id'], $amParseData['ar_section_id'], $amParseData['ar_row_id'], $amParseData['ar_plot_id'], $amExcelData[$snJ][$snGraveCol]);
					$amParseData['ar_grave_id'] = $snGraveId;
				}
				//////////////////////////////////
				//		FUNERAL DIRECTOR		//
				//////////////////////////////////
				/*
				if(isset($amExcelData[$snJ][14]) && $amExcelData[$snJ][14] != '')
				{
					$snFuneralId = Doctrine::getTable('ArGrave')->getFuneralIdAsPerCriteria($amExcelData[$snJ][14]);
					$amParseData['fnd_fndirector_id'] = $snFuneralId;
				}*/
				
				$amParseData['control_number'] = $amExcelData[$snJ][$snSnameCol];																					// CONTROL NUMBER
				$amParseData['deceased_surname'] = $amExcelData[$snJ][$snSnameCol];																					// DEC SURNAME
				$amParseData['deceased_first_name'] = $amExcelData[$snJ][$snFnameCol];																				// DEC FIRST NAME
				$amParseData['interment_date'] = date('Y-m-d',strtotime($amExcelData[$snJ][$snIntDateCol]));														// INTERMENT DATE				
				$amParseData['deceased_usual_address'] = isset($amExcelData[$snJ][$snAdd1Col]) ? preg_replace("/'/", " ", addslashes($amExcelData[$snJ][$snAdd1Col])) : '';  // ADD1
				//$amParseData['deceased_usual_address'] = isset($amExcelData[$snJ][10]) ? $amExcelData[$snJ][10] : ''; 											// ADD2
				$amParseData['deceased_age'] = isset($amExcelData[$snJ][$snAgeCol]) ? $amExcelData[$snJ][$snAgeCol] : ''; 											// AGE
				$amParseData['deceased_date_of_death'] = isset($amExcelData[$snJ][$snDeathDateCol]) ? $amExcelData[$snJ][$snDeathDateCol] : ''; 					// DEATH DATE				
				$amParseData['fnd_fndirector_id'] = isset($amExcelData[$snJ][$snFndCol]) ? $amExcelData[$snJ][$snFndCol] : '';										// FUNERAL DIRECTOR
				$amParseData['comment1'] = isset($amExcelData[$snJ][$snComm1Col]) ? preg_replace("/'/", " ", addslashes($amExcelData[$snJ][$snComm1Col])) : '';		// COMMENT 1
				$amParseData['comment2'] = isset($amExcelData[$snJ][$snComm2Col]) ? preg_replace("/'/", " ", addslashes($amExcelData[$snJ][$snComm2Col])) : '';		// COMMENT 2
				
				// SAVE INTERMENT RECORD.
				IntermentBooking::saveIntermentRecord($amParseData);
			}
		}
	}
	
	/**
    * Executes getCementryListAsPerCountry action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetCementryListAsPerCountry(sfWebRequest $request)
    {	
		$snIdCountry = $request->getParameter('id','');	
		$asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($snIdCountry);
		return $this->renderPartial('getCementeryList', array('asCementryList' => $asCementery));
	}
	/**
    * Executes downloadSample action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeDownloadSample(sfWebRequest $request)
    {
		$ssFile = base64_decode($request->getParameter('filename'));
		$ssFilePath = sfConfig::get('sf_web_dir').'/importSample/'.$ssFile;
		
		$ssFileInfo = pathinfo($ssFilePath);
		header("Content-type: application/force-download");
		header('Content-Disposition: inline; filename="'.$ssFileInfo['basename'].'"');
		header("Content-Transfer-Encoding: Binary");
		header('Content-Type: application/excel');
		readfile($ssFilePath);
		exit();
	}
	
	
	/**
     * getConfigurationFields
     *
     * Function for prepare configuration fields for form
     * @access private
     * @param  object $oForm form object
     *     
     */
    private function getConfigurationFields($oForm)
    {
        $oForm->setWidgets(
			array(
					'cem_cemetery_id' 	=> __('Select Cemetery'),
					'country_id'		=> __('Select Country'),
				 )
		);

        $oForm->setLabels(
            array(
				'country_id'       	=> __('Country'),
				'cem_cemetery_id'  	=> __('Cemetery'),
                'import_file'       => __('Select File')
            )
        );

        $oForm->setValidators(
            array(
					'import_file'              => array(
														'required'  => __('Please select file'),
														'invalid'  => __('Please select only EXCEL and CSV file'),
														'maxsize'  => __('The file size is too large')
													),
    	            'country_id'        => array(
														'required'  => __('Please select country')
												),
    	            'cem_cemetery_id'        => array(
														'required'  => __('Please select cemetery')
												),
				)
        );
    }
}