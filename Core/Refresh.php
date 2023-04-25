<?php

namespace App\Core;

class Refresh
{

    static public function refresh(string $location)
    {
        header('Refresh:0.1;url=' . $location);
        exit;
    }
}