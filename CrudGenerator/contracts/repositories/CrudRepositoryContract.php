<?php

namespace CrudGenerator\Contracts\Repositories;

use CrudGenerator\commands\CreateCrudGeneratorCommand;

interface CrudRepositoryContract{
    public function create(CreateCrudGeneratorCommand $command);

}
