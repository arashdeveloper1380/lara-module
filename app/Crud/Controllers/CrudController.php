<?php
namespace App\Crud\Controllers;

use App\Http\Controllers\Controller;

class CrudController extends Controller {
    private function getCurrentPath(){
        return request()->path();
    }

    public function index() :string{
//        return DB::table($this->getCurrentPath())->orderByDesc('created_at')->get();
        return $this->getCurrentPath() . "index";
    }

    public function create(){
//        reutnDB::table($this->getCurrentPath())->orderByDesc('created_at')->get();
        return $this->getCurrentPath() . "create";
    }

    public function store(){

    }

    public function show(){

    }

    public function update(){

    }

    public function destory(){

    }

}
