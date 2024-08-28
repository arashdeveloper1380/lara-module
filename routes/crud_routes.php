<?php

use \Illuminate\Support\Facades\Route;
use \App\Crud\Controllers\CrudController;

Route::controller(CrudController::class)
    ->group(function (){

    foreach (crudRoutes() as $value){

        Route::resource(
            "$value->slug",
            CrudController::class
        );
    }

});
