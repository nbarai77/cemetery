<?php


class calTemplateTable extends PlugincalTemplateTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('calTemplate');
    }
}