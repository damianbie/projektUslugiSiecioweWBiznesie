<?php
namespace App\Data;

class StateOfService
{
    public static function states()
    {
        return [
            'do naprawy'    => 1,
            'trwa naprawa'  => 2,
            'zakończono'    => 3,
            'konsultacja z klientem'   => 4,
            'przerwano'   => 5
        ];
    }
}