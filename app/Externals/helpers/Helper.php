<?php

namespace App\Externals\helpers;

class Helper
{
    public static function bankCardCheck($publicNumber): bool
    {
        $card = (string)preg_replace('/\D/', '', $publicNumber);
        $strlen = strlen($card);
        if ($strlen != 16)
            return false;
        if (($strlen < 13 or $strlen > 19))
            return false;
        if (!in_array($card[0], [2, 4, 5, 6, 9]))
            return false;

        for ($i = 0; $i < $strlen; $i++) {
            $res[$i] = $card[$i];
            if (($strlen % 2) == ($i % 2)) {
                $res[$i] *= 2;
                if ($res[$i] > 9)
                    $res[$i] -= 9;
            }
        }
        return array_sum($res) % 10 == 0 ? true : false;
    }

    public static function generateCardNumber(): int
    {
        $number = 213;
        $keepGenerating = true;
        while($keepGenerating) {
            $number = rand(1111111111111111,9999999999999999);
            $keepGenerating = !self::bankCardCheck($number);
        }
        return $number;
    }

}
