<?php

namespace Modules\Category\src;

class Helper{
    public static function slugGenerate(string $name) : string{

        $string = str_replace('-','',$name);

        $string = str_replace('/','',$string);

        return preg_replace('/\s+/','-',$string);

    }
}
