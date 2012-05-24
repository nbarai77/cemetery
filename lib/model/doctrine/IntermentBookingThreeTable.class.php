<?php


class IntermentBookingThreeTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('IntermentBookingThree');
    }
}