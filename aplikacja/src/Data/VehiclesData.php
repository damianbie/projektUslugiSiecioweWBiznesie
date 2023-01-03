<?php
namespace App\Data;

class VehiclesData
{
    public static function data()
    {
        return [
            'Audi' => [
            'A1', 'A3', 'A4', 'A6', 'A6 Allroad', 'A7', 'A8', 'e-tron'
            ],
            'BMW' => [
                '1', '2', '3', '2 Active Tourer', '4', '5', '6', 'X1', 'X3', 'z4'
            ],
            'Citroen' => [
                'Berlingo', 'C1', 'C3', 'C4', 'C5 Aircross', 'Jumper', 'Spacetourer'
            ],
            'Fiat' => [
                '500', 'Doblo', 'Ducato', 'Panda', 'Fiorino', 'Tipo', 'Panda Van'
            ],
            'Ford' => [
                'EcoSport', 'Explorer', 'Fiesta', 'Focus', 'Galaxy', 'Kuga', 'Mondeo', 'Mustang', 'Mach-E'
            ],
            'Mercedes' => [
                'A', 'AMG GT', 'B', 'C', 'Cita', 'CLA', 'E', 'EQA', 'EQB', 'GLC', 'GLA', 'S', 'Marco Polo', 'S'
            ]
        ];
    }
}