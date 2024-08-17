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


    public function store(Request $request): RedirectResponse{

        $dataValidate = $this->validationService->validate(
            $request->all()
        );

        $image = Helper::uploadImage(
            'image',
            base_path($this->uploadPath),
            $request
        );

        //create category on db
        $imagePath = $this->uploadPath . $image;
        $command = new CreateCategoryCommand(
            name    : $dataValidate['name'],
            slug    : $dataValidate['name'], // generate slug by name
            status  : $dataValidate['status'],
            image   : $imagePath
        );
        $create = CreateCategoryJob::dispatch($command);

        //create category on db but pattern outbox
        $outboxData = [
            $dataValidate['name'],
            $dataValidate['name'], // generate slug by name
            $dataValidate['status'],
            $imagePath
        ];

        $commandOutBoxCategory = new CreateCategoryOutBoxCommand(
            type: "category_created",
            payload: json_encode($outboxData),
            processed_at: Carbon::now()
        );
        CreateCategoryOutBoxJob::dispatch($commandOutBoxCategory);

        if($create){
            return redirect()->route('category.index');
        }else{
            throw new \Exception("Failed Created Category !!!");
        }

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
