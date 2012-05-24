<?php

require_once '/usr/share/pear/symfony/autoload/sfCoreAutoload.class.php';
//require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';

sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
    public function setup() {
		
		//self::getActive()->loadHelpers(array('viEasy'));
		sfConfig::set('app_ckfinder_active', true);
		
        $this->enablePlugins(
                        array(
                                'sfDoctrinePlugin', 
                                'sfDoctrineGuardPlugin',
                                'sfFormExtraPlugin',
                                'CalendarPlugin', 
                                'sfJqueryReloadedPlugin',
                                'sfTaskExtraPlugin',
								'sfJQueryUIPlugin',
								'sfTCPDFPlugin',
								'sfCKEditorPlugin',
								'ohMailChimpPlugin'
                            )
                        );
    }
}
