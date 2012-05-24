<?php 
/**
 * common actions.
 *
 * @package    arp
 * @subpackage lib
 * @author     Jaimin Shelat
 * @author     Raghuvir Dodiya
 * @author     Bipin Patel
 *     
 */
sfProjectConfiguration::getActive()->loadHelpers('I18N');
class common
{
    /**
     * Executes getConditonStatus for check condition in database for searching for all listing functionality.
     *
     * @param   string  $ssMatchValue
     * @param   string  $ssDbFieldName
     * @param   string  $ssOptionOne    
     * @param   string  $ssOptionTwo 
     * @param   string  $ssOptionThree
     * @param   string  $ssOptionFour 
     * @return  mixed   string|boolean
     *
     */
    public static function getConditonStatus($ssMatchValue = '',$ssDbFieldName = '', $ssOptionOne = '', $ssOptionTwo = '', $ssOptionThree = "", $ssOptionFour = "", $ssOptionFive = "")
    { 
        if($ssMatchValue == '' || $ssDbFieldName == '' || $ssOptionOne == '' || $ssOptionTwo == '') return false;
      
        $ssCondtion = '';

        if($ssMatchValue == 'All')
            $ssCondtion =  $ssDbFieldName.' LIKE "'.$ssOptionOne.'" OR '.$ssDbFieldName.' LIKE "'.$ssOptionTwo.'" OR '.$ssDbFieldName.' LIKE "'.$ssOptionThree.'" OR '.$ssDbFieldName.' LIKE "'.$ssOptionFour.'"';
        else
            $ssCondtion =  $ssDbFieldName.' LIKE "'.$ssMatchValue.'"';
        
        return $ssCondtion;
    }

    /**
     * Executes generatenewpassword for generate new password at forgot password and registration time.
     * 
     * @param   string  $ssLength - Optional
     * @return  string
     *
     */
    public static function generatenewpassword($ssLength = null)
    {   
        $snLength   = ($ssLength) ? $ssLength : 8;              // start with a blank password
        $smPassword = "";                                       // define possible characters
        $smPossible = "0123456789bcdfghjkmnpqrstvwxyz";         // set up a counter
        $snCounter  = 0;         
        
        // add random characters to password until length is reached
        while ($snCounter < $snLength) 
        {       
            $smChar = substr($smPossible, mt_rand(0, strlen($smPossible)-1), 1);    // pick a random character from the possible ones
            if (!strstr($smPassword, $smChar))      // we don't want this character if it's already in the password
            { 
               $smPassword .= $smChar;
               $snCounter++;
            }
        }       
        return $smPassword;     
    }
 
    /**
     * Executes UpdateStatusComposite for update status of any table at admin side Just Put Only One Line Coding for update status
     *
     * @param   string  $ssTableName 
     * @param   string  $ssTableFieldName 
     * @param   integer $ssIdsForActive
     * @param   string  $ssSetStatusName  
     * @param   integer $ssMatchIdFieldValue 
     * @return  boolean 
     * 
     */
    public function UpdateStatusComposite($ssTableName = '', $ssTableFieldName = '', $ssIdsForActive = '', $ssSetStatusName = '', $ssMatchIdFieldValue = '')
    {
        if($ssTableName == '' || $ssTableFieldName == '' || $ssIdsForActive == '' || $ssSetStatusName == '' || $ssMatchIdFieldValue == '') return false;

        $ssQuery = Doctrine_Query::create()->update($ssTableName)->set($ssTableFieldName, '?', $ssSetStatusName)->whereIn($ssTableName.'.'.$ssMatchIdFieldValue, $ssIdsForActive)->execute();
				
        return true;
    }

    /**
     * Executes DeleteRecordsComposite For delete records from admin side Just Put Only One Line Coding for delete record
     *
     * @param   string  $ssTableName 
     * @param   integer $anIdsForDelete
     * @param   integer $ssMatchIdFieldValue 
     * @return  boolean
     * 
     */
    public function DeleteRecordsComposite($ssTableName = '', $anIdsForDelete = '', $ssMatchIdFieldValue = '')
    {
        if($ssTableName == '' || $anIdsForDelete == ''|| $ssMatchIdFieldValue== '') return false;

        $ssQuery = Doctrine_Query::create()->delete()->from($ssTableName)->andWhereIn($ssTableName.'.'.$ssMatchIdFieldValue,$anIdsForDelete)->execute();
        return true;
    }

    /**
     * Executes positionUpdateComposite For change the position of records at admin side.
     *
     * @param   integer $amIdsForChange 
     * @param   integer $amIdPositionsValue
     * @param   string  $ssTableName
     * @param   string  $ssSetFieldName
     * @param   string  $ssIdFieldName
     * @return  boolean
     * 
     */
    public function positionUpdateComposite($amIdsForChange = '', $amIdPositionsValue = '', $ssTableName = '', $ssSetFieldName = '', $ssIdFieldName = '')    
    {      
        if(!is_array($amIdsForChange) || !is_array($amIdPositionsValue) || $amIdsForChange == ''|| $amIdPositionsValue == '' 
                || $ssTableName == '' || $ssSetFieldName == '' || $ssIdFieldName == '') return false; 
           $snCount = count($amIdsForChange);
           
        for($snI=0;$snI<$snCount;$snI++)
        {
            Doctrine_Query::create()
                      ->update($ssTableName)
                      ->set($ssSetFieldName, '?', is_numeric($amIdPositionsValue[$snI]) ? $amIdPositionsValue[$snI] : 0 )
                      ->where($ssIdFieldName.' = ?', $amIdsForChange[$snI])
                      ->execute();
        }
        return true;
    }

    /**
     * Function use to set date format.
     *
     * @param   string   $snDate date.
     * @param   string   $ssFormate date format.
     * @return  mixed    date|boolean 
     * 
     */
    public static function setDateFormat($snDate = '', $ssFormat = 'Y-m-d')
    {
        if($snDate == '' || $ssFormat == '') return false;

        return date($ssFormat,strtotime($snDate));
    }

    /**
     * Function use to set setCriteria
     *
     * @param   object  $omCriteria         query-object
     * @param   array   $amExtraParameters  exra-prameters array (search, sort)
     * @param   string  $ssStatusCondition  status (active/inactive/all)
     * @param   array   $amSearch           search criteria
     * @return  mixed   object|boolean
     *
     */
    public static function setCriteria($omCriteria, $amExtraParameters = array(), $ssStatusCondition = '', $amSearch = array())
    {
        ($ssStatusCondition)    ? $omCriteria->andWhere($ssStatusCondition) : '';

        if(count($amExtraParameters) > 0)
        {
            if(
                (
                    (isset($amExtraParameters['ssSortMode']) && !empty($amExtraParameters['ssSortMode'])) &&  
                    (   
                        (strtolower($amExtraParameters['ssSortMode']) != sfConfig::get('app_sort_mode_asc', 'asc')) && 
                        (strtolower($amExtraParameters['ssSortMode']) != sfConfig::get('app_sort_mode_desc', 'desc')) 
                    ) 
                ) 
            )   return false;

            // Prepare search query
            if(count($amSearch) > 0)
            {
                foreach($amSearch as $ssKey => $aSearch)
                {
                    if(
                       (isset($amExtraParameters['ssSearch'.$aSearch['id']]) && $amExtraParameters['ssSearch'.$aSearch['id']] != '')
                    )
                    {
                        if($aSearch['type'] == 'text')
                            $ssSearchQuery  = $ssKey." LIKE '%".addslashes($amExtraParameters['ssSearch'.$aSearch['id']])."%' ";
                        elseif($aSearch['type'] == 'select' || $aSearch['type'] == 'integer' || $aSearch['type'] == 'selectajax' || $aSearch['type'] == 'checkbox') 
                        {
                            if($amExtraParameters['ssSearch'.$aSearch['id']] != 'NULL') 
                            {
                                if(isset($aSearch['alias']))
                                    $ssSearchQuery  = $aSearch['alias'].'.'.$ssKey." = '".addslashes($amExtraParameters['ssSearch'.$aSearch['id']])."'";
                                else
                                    $ssSearchQuery  = $ssKey." = '".addslashes($amExtraParameters['ssSearch'.$aSearch['id']])."'";
                            }
                            else
                                $ssSearchQuery  = $ssKey." IS NULL ";
                        }
                        elseif($aSearch['type'] == 'year')
                            $ssSearchQuery  = " YEAR(".$ssKey.") = '".addslashes($amExtraParameters['ssSearch'.$aSearch['id']])."'";
                        elseif($aSearch['type'] == 'date')
                            $ssSearchQuery  = " DATE_FORMAT(".$ssKey.", '%d-%m-%Y') = '".addslashes($amExtraParameters['ssSearch'.$aSearch['id']])."'";
                        elseif($aSearch['type'] == 'selectcountry')
                        {
                            if(isset($aSearch['alias']))
                                $ssSearchQuery  = $aSearch['alias'].'.'.$ssKey." = '".addslashes($amExtraParameters['ssSearch'.$aSearch['id']])."'";
                            else
                                $ssSearchQuery  = $ssKey." = '".addslashes($amExtraParameters['ssSearch'.$aSearch['id']])."'";
                        }

                        $omCriteria->andWhere($ssSearchQuery);                	
                        
                    }	
                }
			}
            // Prepare sort query
            if(
                (isset($amExtraParameters['ssSortBy']) && $amExtraParameters['ssSortBy'] != '') && 
                (isset($amExtraParameters['ssSortMode']) && $amExtraParameters['ssSortMode'] != '')
            )
            {
                $ssSortQuery    = $amExtraParameters['ssSortBy'].' '.$amExtraParameters['ssSortMode'];
                $omCriteria->OrderBy($ssSortQuery);
            }
        }
        return $omCriteria;
    }

    /**
     * Function use to set setCriteria
     *
     * @param   string  $ssString url
     * @return  string  encoded url
     *
     */
    public static function myUrlEncode($ssString = '')
    {
        $asEntities     = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D', '+');
        $asReplacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]", " ");

        return str_replace($asEntities, $asReplacements, rawurlencode($ssString));
    }
	
	/**
     * Executes UpdateCompositeField for update field of any table at admin side Just Put Only One Line Coding for update field
     *
     * @param   string  $ssTableName 
     * @param   string  $ssTableFieldName 
     * @param   string  $ssTableFieldValue  
     * @param   integer $ssMatchIdFieldValue 
     * @param   integer $snPrimaryId 	 
     * @return  boolean 
     * 
     */
    public static function UpdateCompositeField($ssTableName = '', $ssTableFieldName = '', $ssTableFieldValue = '', $ssMatchIdFieldValue = '', $snPrimaryId = '')
    {
        if($ssTableName == '' || $ssTableFieldName == '' || $ssTableFieldValue == '' || $ssMatchIdFieldValue == '' || $snPrimaryId == '') return false;
        $ssQuery = Doctrine_Query::create()->update($ssTableName)->set($ssTableFieldName, '?', $ssTableFieldValue)->where($ssTableName.'.'.$ssMatchIdFieldValue.' = ?', $snPrimaryId)->execute();
        return true;
    }
}
