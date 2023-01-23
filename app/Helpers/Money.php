<?php

namespace App\Helpers;

class Money
{

    public static function price(int|float|null $amount): string 
    {
        if (is_null($amount)) {
            return '';
        }

        return "€ " . \number_format($amount, 2, ".", '');
    }
}