<?php

namespace CrudGenerator\Contracts\Repositories;

use CrudGenerator\commands\CreateCrudGeneratorCommand;

interface CrudGeneratorRepositoryContract{
    public function create(CreateCrudGeneratorCommand $command);
}
