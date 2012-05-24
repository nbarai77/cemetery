<?php

/**
 * @author     
 * @version    1.0.0
 */
class sfWidgetFormDateJQueryUI extends sfWidgetForm
{
  /**
   * Configures the current widget.
   *
   * Available options:
   *
   * @param string   culture           Sets culture for the widget
   * @param boolean  change_month      If date chooser attached to widget has month select dropdown, defaults to false
   * @param boolean  change_year       If date chooser attached to widget has year select dropdown, defaults to false
   * @param integer  number_of_months  Number of months visible in date chooser, defaults to 1
   * @param boolean  show_button_panel If date chooser shows panel with 'today' and 'done' buttons, defaults to false
   * @param string   theme             css theme for jquery ui interface, defaults to '/sfJQueryUIPlugin/css/ui-lightness/jquery-ui.css'
   * 
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    if(sfContext::hasInstance())
     $this->addOption('culture', sfContext::getInstance()->getUser()->getCulture());
    else
     $this->addOption('culture', "en_US");
    $this->addOption('change_month',  false);
    $this->addOption('change_year',  false);
    $this->addOption('number_of_months', 1);
    $this->addOption('show_button_panel',  false);
    $this->addOption('dateFormat',  'yy-mm-dd');
    $this->addOption('timeFormat',  'hh:mm:ss');
    $this->addOption('yearRange',  '-150:+0');
    $this->addOption('nextText',  'Next');
    $this->addOption('prevText',  'Previous');
    $this->addOption('showOn',  'button');
    $this->addOption('buttonImage',  'images/jquery/calendar.gif');
    $this->addOption('buttonImageOnly',  true);

    $this->addOption('showSecond',  false);
    $this->addOption('timeFormat',  'hh:mm:ss');
	$this->addOption('showTime',  false);

    $this->addOption('theme', '/sfJQueryUIPlugin/css/ui-lightness/jquery-ui.css');
	
	$this->addOption('disableDOD',  false);
    parent::configure($options, $attributes);
  }

  /**
   * @param  string $name        The element name
   * @param  string $value       The date displayed in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {

    $attributes = $this->getAttributes();

    $input = new sfWidgetFormInput(array(), $attributes);

    $html = $input->render($name, $value);

    $id 		= $input->generateId($name);
    $culture 	= $this->getOption('culture');
    $cm 		= $this->getOption("change_month") ? "true" : "false";
    $cy 		= $this->getOption("change_year") ? "true" : "false";
    $nom 		= $this->getOption("number_of_months");
    $sbp 		= $this->getOption("show_button_panel") ? "true" : "false";
    $dateFormat = $this->getOption("dateFormat");
	$timeFormat = $this->getOption("timeFormat");
    $yearRange 	= $this->getOption("yearRange");
    $nextText 	= $this->getOption("nextText");
    $prevText	= $this->getOption("prevText");
    $showOn 	= $this->getOption("showOn");
    $showOn 	= $this->getOption("buttonImage");
    $showOn 	= $this->getOption("buttonImageOnly") ? "true" : "false";
	
	$showDateTime = $this->getOption("showSecond") ? "true" : "false";

	$showTime = $this->getOption("showTime") ? "true" : "false";
	
	$bDisableDOD = $this->getOption("disableDOD") ? "true" : "false";

    /*if ($culture!='en')
    {
    $html .= <<<EOHTML
<script type="text/javascript">
	$(function() {
    var params = $.datepicker.regional['$culture'];
    params.changeMonth = $cm;
    params.changeYear = $cy;
    params.numberOfMonths = $nom;
    params.showButtonPanel = $sbp;
    params.dateFormat = '$dateFormat';
	$("#$id").datepicker(params);
	
	});
</script>
EOHTML;
    }
    else
    {*/

	//$ssImageName = url_for('images/jquery/calendar.gif').'/calendar.gif';		// LIVE    
	//$ssImageName = url_for("/images/jquery/calendar.gif");		// LOCAL
    //$ssImageName = '/images/jquery/calendar.gif';
    
    //$ssImageName = sfContext::getInstance()->getRequest()->gethost().sfConfig::get('sf_web_dir').'/images/jquery/calendar.gif';
    $ssImageName =  sfConfig::get('app_site_url')."images/jquery/calendar.gif";  
	
    $html .= <<<EOHTML
<script type="text/javascript">
	$(function() 
	{
		var params = {
				changeMonth : $cm,
				changeYear : $cy,
				numberOfMonths : $nom,
				dateFormat: '$dateFormat',
				showButtonPanel : $sbp,
				showOn: "button",
				buttonImage: '$ssImageName',
				buttonImageOnly: true,
				showSecond: true,
				timeFormat: '$timeFormat',
		};

		if($bDisableDOD)
		{
			var params = {
				minDate: new Date(1970, 1, 1),
				maxDate: new Date,
				changeMonth : $cm,
				changeYear : $cy,
				numberOfMonths : $nom,
				dateFormat: '$dateFormat',
				showButtonPanel : $sbp,
				showOn: "button",
				buttonImage: '$ssImageName',
				buttonImageOnly: true,
				showSecond: true,
				timeFormat: '$timeFormat',
			};
		}
		if($showTime)
			$("#$id").timepicker(params);
		else if($showDateTime)
			$("#$id").datetimepicker(params);
		else
			$("#$id").datepicker(params);

});
</script>
EOHTML;
//    }

    return $html;
  }

  /*
   *
   * Gets the stylesheet paths associated with the widget.
   *
   * @return array An array of stylesheet paths
   */
  public function getStylesheets()
  {
    $theme = $this->getOption('theme');
    return array($theme => 'screen');
  }
  
  /**
   * Gets the JavaScript paths associated with the widget.
   *
   * @return array An array of JavaScript paths
   */
  public function getJavaScripts()
  {
    //check if jquery is loaded
    $js = array();
    

    if (sfConfig::has('sf_jquery_web_dir') && sfConfig::has('sf_jquery_core'))
      $js[] = '/sfJQueryUIPlugin/js/jquery-1.3.1.min.js';
    else
      $js[] = '/sfJQueryUIPlugin/js/jquery-1.3.1.min.js';

    $js[] = '/sfJQueryUIPlugin/js/jquery-ui.js';

    $js[] = '/sfJQueryUIPlugin/js/jquery-ui-timepicker-addon.js';

    $culture = $this->getOption('culture');
    if ($culture!='en')
      $js[] = '/sfJQueryUIPlugin/js/i18n/ui.datepicker-'.$culture.".js";
    
    return $js;
  }
}
