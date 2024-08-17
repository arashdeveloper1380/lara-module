<?php

namespace Modules\Category\src\Services;

use Modules\Category\src\Commands\OutBox\CreateCategoryOutBoxCommand;
use Modules\Category\src\Commands\OutBox\CreateCategoryOutBoxCommandHandler;

class OutBoxService{

    private static array $commands = [
        CreateCategoryOutBoxCommand::class => CreateCategoryOutBoxCommandHandler::class
    ];

    public static function createCategoryOutBox(CreateCategoryOutBoxCommand $command){

        $handleClass = self::$commands[CreateCategoryOutBoxCommand::class];

        return app($handleClass)->handle($command);
    }

}
