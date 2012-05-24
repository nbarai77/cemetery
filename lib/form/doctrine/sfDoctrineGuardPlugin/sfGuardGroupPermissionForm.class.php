<?php

/**
 * sfGuardGroup form.
 *
 * @package    arp
 * @subpackage form
 * @author     Bipin Patel
 *
 */
class sfGuardGroupPermissionForm extends BasesfGuardGroupPermissionForm
{
    /**
     * Function for set form configuration.
     *
     * This function is access by admin user.
     * 
     * @access  public
     */        
    public function configure()
    {
        unset($this['created_at'], $this['updated_at']);
        $this->disableLocalCSRFProtection();

        $this->setWidgets(
            array(
                    'permissions_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardPermission')),
            )
        );


        //$this->widgetSchema['permissions_id']->setOption('renderer_class', 'sfWidgetFormSelectDoubleList');

        $this->setValidators(
                            array(
                                    'permissions_id' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardPermission', 'required' => false))
                                )
                          );

        //$this->widgetSchema->setNameFormat('sf_guard_group_permission[%s]'); 

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    }

    public function updateDefaultsFromObject()
    {
        parent::updateDefaultsFromObject();

        if (isset($this->widgetSchema['permissions_id']))
        {
        $this->setDefault('permissions_id', $this->object->Permissions->getPrimaryKeys());
        }

    }

    protected function doSave($con = null)
    {
        $this->savePermissionsList($con);

        parent::doSave($con);
    }

    public function savePermissionsList($con = null)
    {
        if (!$this->isValid())
        {
        throw $this->getErrorSchema();
        }

        if (!isset($this->widgetSchema['permissions_id']))
        {
        // somebody has unset this widget
        return;
        }

        if (null === $con)
        {
        $con = $this->getConnection();
        }

        $existing = $this->object->Permissions->getPrimaryKeys();
        $values = $this->getValue('permissions_id');
        if (!is_array($values))
        {
        $values = array();
        }

        $unlink = array_diff($existing, $values);
        if (count($unlink))
        {
        $this->object->unlink('Permissions', array_values($unlink));
        }

        $link = array_diff($values, $existing);
        if (count($link))
        {
        $this->object->link('Permissions', array_values($link));
        }
    }
} 
