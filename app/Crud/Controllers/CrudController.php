<?php
namespace App\Crud\Controllers;

use App\Crud\Contract\CrudRepositoryContract;
use App\Http\Controllers\Controller;
use App\Models\CrudGenerator;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
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
        // dd($this->getCrudMetas());
        return view('crud.create', [
            'crudName'  => $this->crudName(),
            'supports'  => $this->getSupports(),
            'metas'     => $this->getCrudMetas()
        ]);
    }

    public function store(Request $request) : RedirectResponse{

        $crudName = $request->get('crud_name');

        $exist = $this->contract->isCrudExist($crudName);

        $this->returnExceptionWhenTableNotExist($exist, $crudName);

        $supports = $this->contract->getCurrentCrudSupports($crudName);

        $dataSupports = $this->contract->getDataSupports($supports, $request);

        $metaData = collect($request->all())->filter(function($value, $key){

            return strpos($key, 'meta-') === 0;

        })->mapWithKeys(function($value, $key){

            $metaKey = str_replace('meta-', '', $key);

            return [$metaKey => $value];

        })->toArray();


        $getLastId = DB::table($crudName)->insertGetId($dataSupports);

        $metaTable = $this->getCrudMetaTable($this->crudName());
        if(!empty($metaData)){
            foreach ($metaData as $metaKey => $metaValue) {
                DB::table($metaTable)->insert([
                    'crud_data_id'  => $getLastId,
                    'crud_name'     => $crudName,
                    'meta_key'      => $metaKey,
                    'meta_value'    => $metaValue,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ]);
            }
        }

        return redirect()->route('blog.index');

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

    private function returnExceptionWhenTableNotExist(
        string $exist, string $crudName
    ) : Exception|bool{
        if(!$exist){
            throw new Exception("Table $crudName not found!");
        }
        return true;
    }

    private function getCrudMetaTable(string $crudName) : ?string{
        return CrudGenerator::query()
            ->where('name', $crudName)
            ->first()
            ->fields;
    }

    private function getCrudMetas() :?object{
        return DB::table(
            $this->getCrudMetaTable($this->crudName())
        )->get();
    }
}
