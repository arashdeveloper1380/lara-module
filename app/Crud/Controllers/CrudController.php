<?php
namespace App\Crud\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CrudGenerator;

class CrudController extends Controller {

    private static array $support = [];

    public function index() :string{
        return $this->getCurrentPath() . "index";
    }

    public function create(){
        return view('crud.create', [
            'crudName'  => $this->crudName(),
            'support'   => $this->getSupports()
        ]);
    }

    public function store(){

    }

    public function show(){

    }

    public function update(){

    }

    public function destory(){

    }

    private function getCurrentPath() :string{
        return request()->path();
    }

    private function getCurrentPathExplode() : array{
        return explode('/', $this->getCurrentPath());
    }

    private function crudName(){
        return $this->getCurrentPathExplode()[0];
    }

    private function getSupports() : ? array{
        return self::$support = CrudGenerator::query()
            ->where('name', $this->crudName())
            ->first()
            ->support;
    }
}
