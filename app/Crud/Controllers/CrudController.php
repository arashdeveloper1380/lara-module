<?php
namespace App\Crud\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CrudGenerator;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CrudController extends Controller {

    private static array $support = [];

    public function index() :string{
        return $this->getCurrentPath() . "index";
    }

    public function create(){
        return view('crud.create', [
            'crudName'  => $this->crudName(),
            'supports'  => $this->getSupports()
        ]);
    }

    public function store(Request $request){
    
        $crudName = $request->get('crud_name');

        $exist = $this->isCrudExist($crudName);

        $this->returnExceptionWhenTableNotExist($exist, $crudName);

        DB::table($crudName)->insert([
            'title'         => $request->get('title') ?? null,
            'desc'          => $request->get('desc') ?? null,
            'thumbnail'     => $request->get('thumbnail') ?? null,
            'excerpt'       => $request->get('excerpt') ?? null,
            'created_at'    => Carbon::now()
        ]);

        dd("create");
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
}
