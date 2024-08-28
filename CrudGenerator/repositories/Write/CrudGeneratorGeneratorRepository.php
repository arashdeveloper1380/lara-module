<?php

namespace CrudGenerator\repositories\Write;
use App\Models\CrudGenerator;
use CrudGenerator\commands\CreateCrudGeneratorCommand;
use CrudGenerator\Contracts\Repositories\CrudGeneratorRepositoryContract;

class CrudGeneratorGeneratorRepository implements CrudGeneratorRepositoryContract {

    public function create(
        CreateCrudGeneratorCommand $command
    ) : ? object{
        return CrudGenerator::query()->create($command->arr());
    }
}
