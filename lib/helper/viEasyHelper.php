<?php
/**
 * this is helper helps you for fast development
 *
 * @package    Package name
 * @subpackage helper
 * @author     Chintan Mirani
 *
 */
 
 
 
/**
* functinon e() to echo and exit your string,array or object
* @param Array/Object/String $amData  contains data
* @param Boolean bFlag contains flag for exit or not
*/
function e($amData,$bFlag = 1)
{
    if(is_array($amData) || is_object($amData))
    {
        echo "<PRE>";
        print_r($amData);
        echo "</PRE>";

        if($bFlag)
            exit;
    }
    else
    {
        echo "<PRE>";
        echo $amData;
        echo "</PRE>";
        if($bFlag)
            exit;
    }
}

/**
* functinon e() to echo and exit your web request parameter holder
* @param Boolean bFlag contains flag for exit or not
*/
        
function p($bFlag = 1)
{
    echo "<PRE>";
    print_r(sfContext::getInstance()->getRequest()->getParameterHolder());
    echo "</PRE>";
    
    if($bFlag)
        exit;
    
}
