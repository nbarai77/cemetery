<?php

/**
 * Workflow
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    cemetery
 * @subpackage model
 * @author     Prakash Panchal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Workflow extends BaseWorkflow
{
	public function setUp()
    { 
        parent::setUp();
        $this->actAs('Timestampable');
    }
}
