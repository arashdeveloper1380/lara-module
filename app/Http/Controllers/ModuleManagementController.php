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
//        $file = $request->file('module');
//        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
//        $filePath = $file->storeAs('modules', "{$originalName}.zip");
//        $this->installModule($filePath, $originalName);
        return redirect()->back()->with('success', 'Module installed successfully!');
    }

//    private function installModule($zipPath, $dirName)
//    {
//        $zip = new \ZipArchive();
//        if ($zip->open(storage_path("app/{$zipPath}")) === true) {
//            $modulePath = base_path("Modules/$dirName");
//
//            // Extract the ZIP file
//            $zip->extractTo($modulePath);
//            $zip->close();
//
//            // Get the module name from the ZIP file (assuming the name of the module folder)
//            $moduleName = basename($zipPath, '.zip');
//
//            // Enable the module
//            if (!Module::has($moduleName)) {
//                Artisan::call('module:enable', ['module' => $moduleName]);
//            }
//
//            // Run migrations
//            Artisan::call('module:migrate', ['module' => $moduleName]);
//
//            // Publish config
//            Artisan::call('module:publish-config', ['module' => $moduleName]);
//
//            // Publish assets
//            Artisan::call('module:publish', ['module' => $moduleName]);
//
//            Artisan::call('route:cache');
//            Artisan::call('view:cache');
//            Artisan::call('cache:clear');
//
//        } else {
//            throw new \Exception('Could not open ZIP file.');
//        }
//    }
}
