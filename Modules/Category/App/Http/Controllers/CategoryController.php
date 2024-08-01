<?php

namespace Modules\Category\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Category\src\Commands\Create\CreateCategoryCommand;
use Modules\Category\src\Helper;
use Modules\Category\src\Services\CategoryService;
use Nwidart\Modules\Facades\Module;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $isEnable = Module::isEnabled('category');

        if($isEnable){
            return view('category::index', compact('isEnable'));
        }else{
            return redirect('/');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse{

        $validate = $request->validate([
            'name'      => 'required',
            'status'    => 'required',
            'image'     => 'nullable|max:2048',
        ]);

        $image = Helper::uploadImage(
            'image',
            base_path('Modules/Category/public/uploads/category/'),
            $request
        );

        $imagePath = "Modules/Category/public/uploads/category/" . $image;

        $command = new CreateCategoryCommand(
            $validate['name'],
            $validate['name'], // generate slug by name
            $validate['status'],
            $imagePath
        );

        $create = CategoryService::createCategory($command);

        if($create){
            return redirect()->route('category.index');
        }else{
            dd("not created");
        }

    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('category::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('category::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
