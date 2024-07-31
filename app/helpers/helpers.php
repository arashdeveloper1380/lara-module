<?php

use App\Http\Controllers\DashboardController;

if(!function_exists('isEnableModules')){

    function isEnableModules(string $module) : bool{
        return DashboardController::isEnableModules($module);
    }

}