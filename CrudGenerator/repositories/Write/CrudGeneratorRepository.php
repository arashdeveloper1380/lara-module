<?php

namespace CrudGenerator\repositories\Write;
use App\Models\CrudGenerator;
use CrudGenerator\commands\CreateCrudGeneratorCommand;
use CrudGenerator\Contracts\Repositories\CrudRepositoryContract;

class CrudGeneratorRepository implements CrudRepositoryContract {

    public function create(
        CreateCrudGeneratorCommand $command
    ) : ? object{
        return CrudGenerator::query()->create($command->arr());
    }
}
