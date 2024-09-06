<?php

namespace Modules\Category\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Category\App\Jobs\CreateCategoryJob;
use Modules\Category\App\Jobs\CreateCategoryOutBoxJob;
use Modules\Category\src\Commands\Create\CreateCategoryCommand;
use Modules\Category\src\Commands\OutBox\CreateCategoryOutBoxCommand;
use Modules\Category\src\Helper;
use Modules\Category\src\Services\CategoryService;
use Modules\Category\src\Services\ValidationService;
use Nwidart\Modules\Facades\Module;

class CategoryController extends Controller
{

    private string $uploadPath = 'Modules/Category/public/uploads/category/';

    private string $currentModel = 'Category';

    private array $views = [
        'index'     => 'category::index',
        'create'    => 'category::create',
        'show'      => 'category::show',
        'edit'      => 'category::edit'
    ];

    public function __construct(
        protected ValidationService $validationService // use pipeline
    ){}

    public function index(){
        return $this->viewWhenEnableModule(
            $this->currentModel,
            $this->views['index']
        );
    }

    public function create(){
        return $this->viewWhenEnableModule(
            $this->currentModel,
            $this->views['create']
        );
    }

    private function setDataOnCommand($validate, $imagePath){

        return new CreateCategoryCommand(
            name    : $validate['name'],
            slug    : $validate['name'], // generate slug by name
            status  : $validate['status'],
            image   : $imagePath
        );
    }

    private function setDataOnCommandOutBox($outboxData){
        return new CreateCategoryOutBoxCommand(
            type            : "category_created",
            payload         : json_encode($outboxData),
            processed_at    : null
        );
    }

    public function store(Request $request): RedirectResponse|\Exception{
        $dataValidate = $this->validationService->validate(
            $request->all()
        );

        $image = Helper::uploadImage(
            'image',
            base_path($this->uploadPath),
            $request
        );

        
        $imagePath = $this->uploadPath . $image;
        $command = $this->setDataOnCommand($dataValidate, $imagePath);
        
        $create = CreateCategoryJob::dispatch($command);

        
        if(config('category.useOutBox')){
            $commandOutBoxCategory = $this->setDataOnCommandOutBox($command);
            CreateCategoryOutBoxJob::dispatch($commandOutBoxCategory);
        }

        if(!$create){
            throw new \Exception("Failed Created Category !!!");
        }
        
        return redirect()->route('category.index');
    }

    public function show($id){
        return view('category::show');
    }


    public function edit($id){
        return view('category::edit');
    }


    public function update(Request $request, $id): RedirectResponse{
        //
    }

    public function destroy($id){
        //
    }
}
