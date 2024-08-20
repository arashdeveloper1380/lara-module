<?php

namespace CrudGenerator\services;

use CrudGenerator\commands\CreateCrudGeneratorCommand;
use CrudGenerator\commands\CreateCrudGeneratorCommandHandler;

class CrudGeneratorService{

    private static array $commands = [
        CreateCrudGeneratorCommand::class => CreateCrudGeneratorCommandHandler::class
    ];

    public static function createCrudGenerator(CreateCrudGeneratorCommand $command){
        $handleClass = self::$commands[CreateCrudGeneratorCommand::class];

        return app($handleClass)->handle($command);
    }

}
