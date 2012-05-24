<?php


class calSpecialReservationTable extends PlugincalSpecialReservationTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('calSpecialReservation');
    }
}