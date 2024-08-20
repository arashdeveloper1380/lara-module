<?php

namespace App\Http\Controllers;
use CrudGenerator\Contracts\Repositories\CrudRepositoryContract;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CrudGenerateController extends Controller{

    public function __construct(
        public CrudRepositoryContract $contract
    ){}

    public function index(){
        //
    }

    public function create() :View{
        return view('crud.create');
    }

    public function store(Request $request) {
        dd($request->all());
    }

    public function show() {
        //
    }

    public function update() : RedirectResponse{
        //
    }

    public function destroy() : RedirectResponse{
        //
    }
}
