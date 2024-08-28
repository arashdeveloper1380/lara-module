<?php

namespace CrudGenerator\commands;

use CrudGenerator\Contracts\Repositories\CrudGeneratorRepositoryContract;

class CreateCrudGeneratorCommandHandler
{
    public function __construct(
        public CrudGeneratorRepositoryContract $contract
    ){}

    public function handle(CreateCrudGeneratorCommand $command) :void{
        $this->contract->create($command);
    }
}
