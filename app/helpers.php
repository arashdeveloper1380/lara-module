<?php

use Illuminate\Support\Facades\Route;
use Nwidart\Modules\Facades\Module;

if(!function_exists('getModuleRoutes')){
    function getModuleRoutes() :?array{
        $excludeRoutes = [
            'sanctum/csrf-cookie',
            '_ignition/health-check',
            '_ignition/execute-solution',
            '_ignition/update-config',
            'api/user',
            '/',
            'enable/{name}',
            'disable/{name}',
            'install/{name}',
            'uninstall/{name}',
            'export-module/{category}',
            'modules/upload-module',
            'modules/store-upload-module',
            'api/v1/category',
            'category/{category}',
            'category/{category}/edit',
            'category/create'
        ];

        $routes = Route::getRoutes();
        $routArr = [];

        foreach ($routes as $route){

            $uri = $route->uri();
            $exclude = false;

            foreach ($excludeRoutes as $pattern) {
                if (strpos($uri, $pattern) !== false) {
                    $exclude = true;
                    break;
                }
            }

            if (!$exclude && in_array('GET', $route->methods())) {
                $routArr[] = $route;
            }

        }

        return $routArr;
    }
}

if(!function_exists('isEnableModules')){
    function isEnableModules(string $module) :bool{
        if(Module::find($module)){
            return Module::isEnabled($module);
        }
    }
}

if(!function_exists('langModule')){
    function langModule(){
        return require base_path('app/translate.php');
    }
}
