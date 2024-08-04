<?php

namespace Modules\Category\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Category\src\Commands\Create\CreateCategoryCommand;
use Modules\Category\src\Helper;
use Modules\Category\src\Services\CategoryService;
use Modules\Category\src\Services\ValidationService;
use Nwidart\Modules\Facades\Module;

class CategoryController extends Controller
{
    public function __construct(
        protected ValidationService $validationService
    ){}

    public function index(){
        return $this->viewWhenEnableModule('Category','category::index');
    }


    public function create(){
        return $this->viewWhenEnableModule('Category','category::create');
//        return view('category::create');
    }


    public function store(Request $request): RedirectResponse{

//        $validate = $request->validate([
//            'name'      => 'required',
//            'status'    => 'required',
//            'image'     => 'nullable|max:2048',
//        ]);

        $dataValidate = $this->validationService->validate($request->all());

        $image = Helper::uploadImage(
            'image',
            base_path('Modules/Category/public/uploads/category/'),
            $request
        );

        $imagePath = "Modules/Category/public/uploads/category/" . $image;

        $command = new CreateCategoryCommand(
            $dataValidate['name'],
            $dataValidate['name'], // generate slug by name
            $dataValidate['status'],
            $imagePath
        );

        $create = CategoryService::createCategory($command);

        if($create){
            return redirect()->route('category.index');
        }else{
            dd("not created");
        }

    }

    public function show($id)
    {
        return view('category::show');
    }


    public function edit($id)
    {
        return view('category::edit');
    }


    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
