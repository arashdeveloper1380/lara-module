<?php

namespace App\Crud\Contract;

use Illuminate\Http\Request;

interface CrudRepositoryContract{

    public function getDataSupports(
        array $supports, Request $request
    ) :array;

    public function getCrudData(string $crudName) : object;

    public function findCrudDataForEdit(
        string $crudName, int $id
    ) :object;

    public function getCurrentCrudSupports(
        string $crudName
    ) : ? array;

    public function isCrudExist(string $crudName) : bool;

    public function getSupports(string $crudName) : ? array;

}
