<?php

/**
 * default actions.
 *
 * @package    cemetery
 * @subpackage default
 * @author     Nitin Barai
 * @version    SVN: $Id: actions.class.php,v 1.1.1.1 2012/03/24 12:19:52 nitin Exp $
 */
class defaultActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    //$this->forward('default', 'module');
  }
	/**
	 * Error page for page not found (404) error
	 *
	 */
	public function executeError404()
	{
		
	}
  
	/**
	 * Warning page for restricted area - requires login
	 *
	 */
	public function executeSecure()
	{
	}
/**
 * Warning page for restricted area - requires credentials
 *
 */
	/*public function executeLogin()
	{
		exit('login');
	}*/
	
  
}
