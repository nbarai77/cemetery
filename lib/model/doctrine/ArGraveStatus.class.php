<?php

/**
 * ArGraveStatus
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    cemetery
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class ArGraveStatus extends BaseArGraveStatus
{
	public function setUp()
    { 
        parent::setUp();
        $this->actAs('Timestampable');
    }
   /**
    * Function to call magic mathod.
    * 
    */
    public function __toString()
    {
        return $this->getGraveStatus();
    }
}