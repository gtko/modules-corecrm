<?php


namespace Modules\CoreCRM\Helpers;

use Illuminate\Support\Str;

class Number
{

    public static function tofloat($num) {
        $number = Str::replaceFirst(',', '.', $num);
        $number = Str::replaceFirst(' ', '', $number);
        $number = trim($number);

        return (float) $number;
    }

    public static function prix($money, int $decimal = 0){
        return number_format((float) $money,$decimal, ',' , ' ');
    }

    public static function marge($money, int $decimal = 2){
        return number_format((float) $money,$decimal, ',' , ' ');
    }

}
