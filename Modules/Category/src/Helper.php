<?php

namespace Modules\Category\src;

class Helper{
    public static function slugGenerate(string $name) : string{

        $string = str_replace('-','',$name);

        $string = str_replace('/','',$string);

        return preg_replace('/\s+/','-',$string);

    }

    public static function uploadImage(
        string $image, string $directory, $request
    ) : string|null {

        if($request->hasFile($image)){

            $file_name = time() . '.' . $request->file($image)->getClientOriginalExtension();

            if($request->file($image)->move($directory, $file_name)){
                return $file_name;
            }else{
                return null;
            }

        }else{
            return null;
        }

    }

}
