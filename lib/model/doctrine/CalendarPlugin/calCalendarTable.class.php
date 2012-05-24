<?php


class calCalendarTable extends PlugincalCalendarTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('calCalendar');
    }
}