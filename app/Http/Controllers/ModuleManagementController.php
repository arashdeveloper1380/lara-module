<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\UploadModule\Contracts\UploadModuleContract;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ModuleManagementController extends Controller
{
    public function __construct(
        public UploadModuleContract $contract
    ){}

    public function uploadModule() :View{
        return view('modules.upload');
    }

    public function storeUploadModule(Request $request) :RedirectResponse{

        $request->validate([
            'module' => 'required|file|mimes:zip|max:2048',
        ]);

        $this->contract->upload($request);

        return redirect()->back()->with('success', 'Module installed successfully!');
    }

}
