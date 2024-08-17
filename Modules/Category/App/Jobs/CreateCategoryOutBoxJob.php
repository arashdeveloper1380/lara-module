<?php

namespace Modules\Category\App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Category\src\Commands\OutBox\CreateCategoryOutBoxCommand;
use Modules\Category\src\Services\OutBoxService;

class CreateCategoryOutBoxJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public CreateCategoryOutBoxCommand $command
    ){}


    public function handle(): void{
        OutBoxService::createCategoryOutBox($this->command);
    }
}
