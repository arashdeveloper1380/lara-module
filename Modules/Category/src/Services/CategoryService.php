<?php

namespace Modules\Category\src\Services;

use Modules\Category\src\Commands\Create\CreateCategoryCommand;
use Modules\Category\src\Commands\Create\CreateCategoryCommandHandler;
use Modules\Category\src\Contracts\Repositories\CreateCategoryContract;

class CategoryService{

    private array $command = [
        CreateCategoryCommand::class => CreateCategoryCommandHandler::class
    ];
    public static function createCategory(
        CreateCategoryCommand $command
    ) {
        return
            app(CreateCategoryCommandHandler::class)
                ->handle(new CreateCategoryCommand($command->arr()));
    }

}
