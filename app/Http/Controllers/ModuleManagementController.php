<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\UploadModule\Contracts\UploadModuleContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Nwidart\Modules\Facades\Module;

class ModuleManagementController extends Controller
{
    public function __construct(
        public UploadModuleContract $contract
    ){}

    public function uploadModule(){
        return view('modules.upload');
    }

    public function storeUploadModule(Request $request){

        $request->validate([
            'module' => 'required|file|mimes:zip|max:2048',
        ]);

        $this->contract->upload($request);

        return redirect()->back()->with('success', 'Module installed successfully!');
    }

}
