<?php

namespace CrudGenerator\repositories;
use App\Models\CrudGenerator;
use CrudGenerator\commands\CreateCrudGeneratorCommand;
use CrudGenerator\Contracts\CrudRepositoryContract;

class CrudRepository implements CrudRepositoryContract {

    public function create(
        CreateCrudGeneratorCommand $command
    ) : ? object{
        return CrudGenerator::query()->create($command->arr());
    }
}
