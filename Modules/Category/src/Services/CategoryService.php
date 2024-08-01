<?php

namespace Modules\Category\src\Services;

use Modules\Category\src\Commands\Create\CreateCategoryCommand;
use Modules\Category\src\Commands\Create\CreateCategoryCommandHandler;

class CategoryService{

    private static array $command = [
        CreateCategoryCommand::class => CreateCategoryCommandHandler::class
    ];
    public static function createCategory(CreateCategoryCommand $command) {

        $handleClass = self::$command[CreateCategoryCommand::class];

        return app($handleClass)->handle($command);

    }

}
