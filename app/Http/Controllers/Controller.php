<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Nwidart\Modules\Facades\Module;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function viewWhenEnableModule(
        string $module, string $view, array $data = []
    ) :View|RedirectResponse {

        $enable = Module::isEnabled($module);

        if(!$enable){
            return redirect()->back();
        }else{
            return view($view, $data);
        }
    }
}
