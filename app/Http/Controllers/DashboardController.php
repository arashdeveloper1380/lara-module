<?php

namespace App\Http\Controllers;

use App\Services\ModuleState\Contracts\ModuleManagementContract;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Nwidart\Modules\Facades\Module;

class DashboardController extends Controller
{
    public function __construct(
        public ModuleManagementContract $contract
    ){}

    public function index(){
        return view('admin');
    }

    public function enableModule(string $module){
        $this->contract->enableModule($module);
        return $this->handleOkAndRedirect('back');
    }

    public function disableModule(string $module){
        $this->contract->disableModule($module);
        return $this->handleOkAndRedirect('back');
    }

    public function installModule(string $module){
        $this->contract->installModule($module);
        return $this->handleOkAndRedirect('back');
    }

    public function uninstallModule(string $module){
        $this->contract->uninstallModule($module);
        return $this->handleOkAndRedirect('back');
    }

    public function exportModule(string $module){
        $this->contract->exportModule($module);
        return $this->handleOkAndRedirect('back');
    }

    public static function isEnableModules(string $module) {
        if(Module::find($module)){
            return Module::isEnabled($module);
        }
    }

    public static function existTableModule(string $module) : bool{
        return Schema::hasTable(strtolower($module));
    }

    private function handleOkAndRedirect($url = '/'){
        return match ($url){
            'back'          => redirect()->back(),
            '/', 'home'     => redirect('/'),
            $url            => redirect($url),
        };
    }
}
