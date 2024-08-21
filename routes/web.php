<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModuleManagementController;
use App\Http\Controllers\CrudGenerateController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('/')->group(function (){

    Route::controller(DashboardController::class)->group(function (){

        Route::get('/', [DashboardController::class, 'index'])
            ->name('home');

        Route::post('/enable/{name}', [DashboardController::class, 'enableModule'])
            ->name('module.enable');

        Route::post('/disable/{name}', [DashboardController::class, 'disableModule'])
            ->name('module.disable');

        Route::post('/install/{name}', [DashboardController::class, 'installModule'])
            ->name('module.install');

        Route::post('/uninstall/{name}', [DashboardController::class, 'uninstallModule'])
            ->name('module.uninstall');

        Route::post('export-module/{category}', [DashboardController::class,'exportModule'])
            ->name('module.export');
    });

});

Route::prefix('modules')->group(function (){

    Route::controller(ModuleManagementController::class)->group(function (){

        Route::get('upload-module', [ModuleManagementController::class, 'uploadModule'])
            ->name('module.upload');

        Route::post('store-upload-module', [ModuleManagementController::class, 'storeUploadModule'])
            ->name('module.store.upload');

    });

});

Route::prefix('crud-generators')->group(function (){

    Route::controller(CrudGenerateController::class)->group(function (){

        Route::resource('crud', CrudGenerateController::class);

    });

});

require_once base_path('routes/crud_routes.php');
