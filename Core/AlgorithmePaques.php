<?php

namespace App\Core;

use DateTime;

class AlgorithmePaques
{
    public static function calculatePaques(string $year)

    {   //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // L'algorithme pour calculer la date de Pâques a été créé par l'Église Catholique                          //
        // et est basé sur les calculs de la lune et du calendrier julien.                                          //
        // cet algorithme est utilisé depuis le 3ème siècle et a été modifié au fil du temps.     //
        // La version actuelle est basée sur le calendrier grégorien et a été fixée par le concile de Nicée en 325. //
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // $a est initialisé avec le reste de l'année donnée divisée par 19.
        $a = $year % 19;

        // $b est initialisé avec l'année donnée divisée par 100 et arrondie à la valeur inférieure.
        $b = floor($year / 100);

        //$c est initialisé avec le reste de l'année donnée divisée par 100.
        $c = $year % 100;

        //$d est initialisé avec la valeur de $b divisée par 4 et arrondie à la valeur inférieure.
        $d = floor($b / 4);

        //$e est initialisé avec le reste de la valeur de $b divisée par 4.
        $e = $b % 4;
        
        //$f est initialisé avec la valeur de $(b+8) divisée par 25 et arrondie à la valeur inférieure.
        $f = floor(($b + 8) / 25);
        
        //$g est initialisé avec la valeur de $(b-$f+1) divisée par 3 et arrondie à la valeur inférieure.
        $g = floor(($b - $f + 1) / 3);

        //$h est initialisé avec le reste de ((19*$a) + $b - $d - $g + 15) divisé par 30.
        $h = (19 * $a + $b - $d - $g + 15) % 30;
        
        //$i est initialisé avec la valeur de $c divisée par 4 et arrondie à la valeur inférieure.
        $i = floor($c / 4);

        //$k est initialisé avec le reste de $c divisé par 4.
        $k = $c % 4;
        
        //$l est initialisé avec le reste de ((32 + 2*$e + 2*$i - $h - $k) divisé par 7).
        $l = (32 + 2 * $e + 2 * $i - $h - $k) % 7;
        
        //$m est initialisé avec la valeur de (($a + 11*$h + 22*$l) divisée par 451) et arrondie à la valeur inférieure.
        $m = floor(($a + 11 * $h + 22 * $l) / 451);
        
        //$month est initialisé avec la valeur de (($h + $l - 7*$m + 114) divisée par 31) et arrondie à la valeur inférieure.
        $month = floor(($h + $l - 7 * $m + 114) / 31);
        
        //$day est initialisé avec la valeur de (($h + $l - 7*$m + 114) modulo 31) plus 1.
        $day = (($h + $l - 7 * $m + 114) % 31) + 1;

        $easter = new DateTime("$year-$month-$day");

        $holidays = [
            'easter_sunday' => $easter->format('Y-m-d'),
            'easter_monday' => $easter->modify('+1 day')->format('Y-m-d'),
            'ascension' => $easter->modify('+39 days')->format('Y-m-d'),
            'pentecost' => $easter->modify('+10 days')->format('Y-m-d')
        ];

        return $holidays;
    }
}
