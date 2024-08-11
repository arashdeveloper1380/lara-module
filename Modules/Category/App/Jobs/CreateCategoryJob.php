<?php

namespace Modules\Category\App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Category\src\Commands\Create\CreateCategoryCommand;
use Modules\Category\src\Services\CategoryService;

class CreateCategoryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public CreateCategoryCommand $categoryCommand
    ){}

    public function handle(): void{
        CategoryService::createCategory($this->categoryCommand);
    }
}
