<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CrudGenerateController extends Controller
{
    public function index(){
        //
    }

    public function create(){
        return view('crud.create');
    }

    public function store() :RedirectResponse{
        //
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
