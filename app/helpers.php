<?php

use Illuminate\Support\Facades\Route;
use Nwidart\Modules\Facades\Module;

if(!function_exists('getModuleRoutes')){

    function getModuleRoutes() :?array{

        $modulesRoutes = require_once base_path("app/registerModules.php");

        $dynamicRoutes = [];

        foreach ($modulesRoutes as $route){
            $dynamicRoutes[] = "api/v1/$route";
            $dynamicRoutes[] = "$route/{$route}";
            $dynamicRoutes[] = "$route/{$route}/edit";
            $dynamicRoutes[] = "$route/create";
        }

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
        ];

        $mergedRoutes = array_merge($dynamicRoutes, $excludeRoutes);

        $routes = Route::getRoutes();
        $routArr = [];

        foreach ($routes as $route){

            $uri = $route->uri();
            $exclude = false;

            foreach ($mergedRoutes as $pattern) {
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
    function langModule(string $module){
        return require base_path("Modules/{$module}/translate.php");
    }
}


if (!function_exists('getActiveModules')) {
    function getActiveModules(): array{
        $activeModules = [];

        $modules = Module::all();

        foreach ($modules as $module) {
            if ($module->isEnabled()) {
                $activeModules[] = $module->getName();
            }
        }

        return $activeModules;
    }
}
