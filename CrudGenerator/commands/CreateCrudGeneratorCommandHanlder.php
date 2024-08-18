<?php

namespace CrudGenerator\commands;

use CrudGenerator\Contracts\CrudRepositoryContract;

class CreateCrudGeneratorCommandHanlder
{
    public function __construct(
        public CrudRepositoryContract $contract
    ){}

    public function handle(CreateCrudGeneratorCommand $command) :void{
        $this->contract->create($command);
    }
}
