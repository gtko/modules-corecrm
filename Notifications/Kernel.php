<?php


namespace Modules\CoreCRM\Notifications;


class Kernel
{

    protected static array $lists = [];

    public static function list():array
    {
        return array_merge([
//           ClientDossierDevisCreateNotification::class,
        ], self::$lists);
    }

    public static function add($classes)
    {
        if(is_array($classes)) {
            self::$lists= array_merge(self::$lists, $classes);
        }else{
            self::$lists[] = $classes;
        }
    }

}
