<?php

namespace CrudGenerator\Contracts;

use CrudGenerator\commands\CreateCrudGeneratorCommand;

interface CrudRepositoryContract{
    public function create(CreateCrudGeneratorCommand $command);

}
