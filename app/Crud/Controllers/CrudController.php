<?php
namespace App\Crud\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CrudGenerator;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class CrudController extends Controller {

    private static array $support = [];

    public function index() :View{

        $curdData = DB::table($this->crudName())->orderByDesc('id')->get();
        
        return view('crud.index', [
            'crudName'  => $this->crudName(),
            'supports'  => $this->getSupports(),
            'curdData'  => $curdData
        ]);
    }

    public function create(){
        return view('crud.create', [
            'crudName'  => $this->crudName(),
            'supports'  => $this->getSupports()
        ]);
    }

    public function store(Request $request) : RedirectResponse{
    
        $crudName = $request->get('crud_name');

        $exist = $this->isCrudExist($crudName);

        $this->returnExceptionWhenTableNotExist($exist, $crudName);

        $supports = $this->getCurrentCrudSupports($crudName);

        $dataSupports = $this->getDataSupports($supports, $request);

        DB::table($crudName)->insert($dataSupports);

        return redirect()->route('blog.index');

    }

    public function show(){

    }

    public function update(){

    }

    public function destroy(int $id){
        
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

    private function isCrudExist(string $crudName) : bool{
        if (Schema::hasTable($crudName)) {
            return true;
        }else{
            return false;
        }
    }
    
    private function returnExceptionWhenTableNotExist(string $exist, string $crudName){
        if(!$exist){
            throw new Exception("Table {$crudName} not found!");
        }
        return true;
    }

    private function getCurrentCrudSupports(string $crudName){
        return CrudGenerator::query()
            ->where('name', $crudName)
            ->first()
            ->support;
    }

    private function getDataSupports(array $supports, $request) : array{
        $dataSupports = [];

        foreach($supports as $value){
            $dataSupports[$value] = $request->get($value);
        }

        return $dataSupports;
    }
}
