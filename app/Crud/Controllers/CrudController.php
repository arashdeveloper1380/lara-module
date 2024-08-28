<?php
namespace App\Crud\Controllers;

use App\Crud\Contract\CrudRepositoryContract;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CrudController extends Controller {

    public function __construct(
        public CrudRepositoryContract $contract
    ){}

    private static array $support = [];

    public function index() :View{

        $curdData = $this->contract->getCrudData($this->crudName());

        return view('crud.index', [
            'crudName'  => $this->crudName(),
            'supports'  => $this->getSupports(),
            'curdData'  => $curdData
        ]);
    }

    public function create() :View{
        return view('crud.create', [
            'crudName'  => $this->crudName(),
            'supports'  => $this->getSupports()
        ]);
    }

    public function store(Request $request) : RedirectResponse{

        $crudName = $request->get('crud_name');

        $exist = $this->contract->isCrudExist($crudName);

        $this->returnExceptionWhenTableNotExist($exist, $crudName);

        $supports = $this->contract->getCurrentCrudSupports($crudName);

        $dataSupports = $this->contract->getDataSupports($supports, $request);

        DB::table($crudName)->insert($dataSupports);

        return redirect()->route('blog.index');

    }

    public function show(){

    }

    public function edit(int $id) :View{

        $crudData = $this->contract->findCrudDataForEdit(
            $this->crudName(), $id
        );

        return view('crud.edit', [
            'crudName'  => $this->crudName(),
            'data'      => $crudData,
            'supports'  => $this->getSupports(),
        ]);

    }

    public function update(int $id, Request $request) : RedirectResponse{
        $crudName = $request->get('crud_name');

        $exist = $this->contract->isCrudExist($crudName);

        $this->returnExceptionWhenTableNotExist($exist, $crudName);

        $supports = $this->contract->getCurrentCrudSupports($crudName);

        $dataSupports = $this->contract->getDataSupports($supports, $request);

        DB::table($crudName)->where('id', $id)->update($dataSupports);

        return redirect()->route('blog.index');
    }

    public function destroy(int $id) : RedirectResponse{
        DB::table($this->crudName())->where('id', $id)->delete();
        return redirect()->route('blog.index');
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
        return self::$support = $this->contract->getSupports(
            $this->crudName()
        );
    }

    private function returnExceptionWhenTableNotExist(string $exist, string $crudName) : Exception|bool{
        if(!$exist){
            throw new Exception("Table $crudName not found!");
        }
        return true;
    }
}
