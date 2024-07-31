<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Nwidart\Modules\Facades\Module;
use ZipArchive;

class ExportModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-module {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export Module format zip';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $moduleName = $this->argument('name');

        if(!$this->moduleNotFound($moduleName)){
            $this->error("Module $moduleName dose not exist");
        }

        $modulePath = Module::getModulePath($moduleName);
        $zipFileName = public_path("{$moduleName}.zip");

        $zip = new ZipArchive();

        if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            $this->error("Could not create ZIP file.");
            return 1;
        }

        $files = $this->getFiles($modulePath);

        $this->pushFiles($files, $modulePath, $zip);

        $zip->close();

        $this->info("Module $moduleName exported to $zipFileName");
        return 0;

    }

    private function moduleNotFound($moduleName){
        return Module::find($moduleName);
    }

    private function getFiles($modulePath){
        return new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($modulePath),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );
    }

    private function pushFiles($files, $modulePath, $zip){
        foreach ($files as $name => $file){
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = str_replace(
                    [realpath($modulePath) . DIRECTORY_SEPARATOR, '\\'],
                    ['', '/'],
                    $filePath
                );
                $zip->addFile($filePath, $relativePath);
            }
        }
    }

}
