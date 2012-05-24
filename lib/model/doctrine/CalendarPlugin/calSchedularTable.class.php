<?php


class calSchedularTable extends PlugincalSchedularTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('calSchedular');
    }
}