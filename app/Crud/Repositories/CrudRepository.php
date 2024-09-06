<?php

namespace App\Crud\Repositories;

use App\Crud\Contract\CrudRepositoryContract;
use App\Models\CrudGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CrudRepository implements CrudRepositoryContract{
    public function getDataSupports(
        array $supports, Request $request
    ): array{
        $dataSupports = [];

        foreach($supports as $value){
            $dataSupports[$value] = $request->get($value);
        }

        return $dataSupports;
    }

    public function getCrudData(string $crudName) : object{
        return DB::table($crudName)->orderByDesc('id')->get();
    }

    public function findCrudDataForEdit(
        string $crudName, int $id
    ) :object{
        return DB::table($crudName)->find($id);
    }

    public function getCurrentCrudSupports(string $crudName) : ? array{
        return CrudGenerator::query()
            ->where('name', $crudName)
            ->first()
            ->support;
    }

    public function isCrudExist(string $crudName) : bool{
        if (Schema::hasTable($crudName)) {
            return true;
        }else{
            return false;
        }
    }

    public function getSupports(string $crudName) : ? array{
        return CrudGenerator::query()
            ->where('name', $crudName)
            ->first()
            ->support;
    }

}
