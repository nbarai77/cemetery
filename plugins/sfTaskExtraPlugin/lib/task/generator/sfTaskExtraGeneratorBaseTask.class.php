<?php

/**
 * Plugin generator base task.
 * 
 * @package     sfTaskExtraPlugin
 * @subpackage  task
 * @author      Kris Wallsmith <kris.wallsmith@symfony-project.com>
 * @version     SVN: $Id: sfTaskExtraGeneratorBaseTask.class.php,v 1.1.1.1 2012/03/24 12:16:47 nitin Exp $
 */
abstract class sfTaskExtraGeneratorBaseTask extends sfGeneratorBaseTask
{
  /**
   * @see sfTaskExtraBaseTask
   */
  public function checkPluginExists($plugin, $boolean = true)
  {
    sfTaskExtraBaseTask::doCheckPluginExists($this, $plugin, $boolean);
  }
}
