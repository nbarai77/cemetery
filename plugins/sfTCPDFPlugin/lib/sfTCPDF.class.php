<?php

/**
 * sfTCPDF class.
 *
 * @package    sfTCPDFPlugin
 * @author     Vernet Loïc aka COil <qrf_coil]at[yahoo[dot]fr>
 * @link       http://www.symfony-project.org/plugins/sfTCPDFPlugin
 * @link       http://www.tcpdf.org
 * @link       http://sourceforge.net/projects/tcpdf/
 */

class sfTCPDF extends TCPDF
{
  /**
   * When set this method is called as a header function.
   * The variable must be a valid argument to call_user_func
   *
   * @var mixed
   */
  public $headerCallback = null;

  /**
   * When set this method is called as a header function.
   * The variable must be a valid argument to call_user_func
   *
   * @var mixed
   */
  public $footerCallback = null;

  /**
   * Holds the data set via php magic methods
   */
  protected $userData = array();



	public $orglogo = '';
	public $orgstring = '';
    public $footerstring ='';
    public $ssLivePath = '';
    public $ssFooterImage = '';
	


  /**
   * Instantiate TCPDF lib.
   *
   * @param string $orientation
   * @param string $unit
   * @param string $format
   * @param boolean $unicode
   * @param string $encoding
   */
  public function __construct($orientation = 'P', $unit = 'mm', $format = 'A4', $unicode = true, $encoding = "UTF-8")
  {
    parent::__construct($orientation, $unit, $format, $unicode, $encoding);
  }

  /**
   * This method is used to render the page header.
   * It is automatically called by AddPage() and could be overwritten using a Callback.
   *
   * @access public
   * @see $headerCallback
   */
 	public function Header() {
			$this->SetHeaderMargin(0);
}
 	/*public function Header() {
		
		if($this->orglogo != '')
        {
            //$image_file = K_PATH_IMAGES.$this->orglogo;        
            $image_file = $this->ssLivePath.$this->orglogo;
            $asExtension = explode('.',$this->orglogo);
            $ssExtenstion = strtoupper($asExtension[count($asExtension) - 1]);
            
            $this->Image($image_file, 5, 5, 150, 15, $ssExtenstion, '', 'T', true, 300, '', false, false, 0, false, false, false);
            // Set font
            $this->SetFont('helvetica', '', 10);
            // Title
            $this->SetXY(165,5);
            $this->Cell(0, 0, $this->orgstring, 0, false, 'L', 0, '', 0, false, 'R', 'R');

			$style = array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0);
			$this->Line(5, 25, 200, 25, $style);
        }
	}
*/

	public function Footer() 
    {
			$this->SetFooterMargin(0);
		/*if($this->ssFooterImage != '') {
            $this->SetXY(5, -25);
            //$image_file = $this->ssLivePath.$this->ssFooterImage;
            $asExtension = explode('.',$this->ssFooterImage);
            $ssExtenstion = strtoupper($asExtension[count($asExtension) - 1]);

			$headerImageFileCheck = sfConfig::get('sf_web_dir').'/js/ckfinder/userfiles/images/'.$this->ssFooterImage;
			if(file_exists($headerImageFileCheck)) {
			
	            $this->Image($headerImageFileCheck, '', '', 150, 15, $ssExtenstion, '', 'L', true, 300, '', false, false, 0, false, false, false);	
			}

            $this->SetFont('helvetica', 'I', 8);
            $this->Cell(0, 25, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
        }*/
	}
  /**
   * Magic setter.
   *
   * @param String $name
   * @param mixed $value
   */
  public function __set($name, $value)
  {
    $this->userData[$name] = $value;
  }

  /**
   * Magic getter.
   *
   * @param String $name Name of data key to return
   * @return mixed
   */
  public function __get($name)
  {
    if (array_key_exists($name, $this->userData))
    {
      return $this->userData[$name];
    }

    $trace = debug_backtrace();    
    trigger_error(
      'Undefined property call via __get(): '. $name. ' in ' . $trace[0]['file']. ' on line ' . $trace[0]['line'],
      E_USER_NOTICE
    );
    
    return null;
  }

  /**
   * Test existence of user data.
   *
   * @param String $name
   * @return Boolean
   */
  public function __isset($name)
  {
    return isset($this->userData[$name]);
  }

  /**
   * Unset user data.
   *
   * @param String $name
   */
  public function __unset($name)
  {
    unset($this->userData[$name]);
  }
}
