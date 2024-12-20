<?php

namespace App\Http\Controllers;
use App\Models\CrudGenerator;
use Carbon\Carbon;
use CrudGenerator\commands\CreateCrudGeneratorCommand;
use CrudGenerator\Contracts\Repositories\CrudGeneratorRepositoryContract;
use CrudGenerator\Enums\DeveloperModeEnum;
use CrudGenerator\Enums\StatusEnum;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CrudGenerateController extends Controller {

    public function __construct(
        public CrudGeneratorRepositoryContract $contract,
    ){}

    public function index() :View{
        $cruds = CrudGenerator::query()
            ->orderByDesc('created_at')
            ->get();

        return view('crud-generator.index', compact('cruds'));
    }

    public function create() :View{
        return view('crud-generator.create');
    }

    public function store(Request $request) :RedirectResponse {
        $developMode = $this->isDevelopMod($request); //return 1 or 0

        $table_name = $developMode
            ? $this->generateMigrationName($request) // return create_blog_table
            : $this->generateTableName($request); // return blog

        $supports = $request->get('support', []);

        if($developMode == 1){
            $this->createMigrationFileWhenDeveloperMode($table_name, $supports);
            $this->migrateCommand($table_name);
        }else{
            $this->generateTable($table_name, $supports);
        }

        $status         = StatusEnum::from((int) $request->get('status'));
        $developMode    = DeveloperModeEnum::from($developMode);

        $command = new CreateCrudGeneratorCommand(
            $request->get('name'),
            slugGenerator($request->get('name')),
            $request->get('desc'),
            $table_name,
            $supports,
            $status,
            $developMode
        );

        $this->contract->create($command);

        return redirect()->back();
    }

    public function addMeta(int $id){
        
        $crud = CrudGenerator::query()->find($id);
        $getMetaTable = $crud->fields;

        return view('crud-generator.add_meta_field', compact('crud', 'getMetaTable'));
    }

    public function AddMetaStore(Request $request) : RedirectResponse{

        $tableName = $request->get('name');
        $crudName = $request->get('crud_name');

        if(!Schema::hasTable($tableName)){

            Schema::create($tableName, function($table){
                $table->id();

                $table->integer('crud_data_id')->nulable();
                $table->string('crud_name')->nulable();
                $table->string('meta_key')->nullable();
                $table->text('meta_value')->nullable();
                $table->string('type')->default('text'); // select - checkbox - radio ... 
                $table->string('return_type')->nullable(); // array - string - bool ...
                
                $table->timestamps();
            });

        }else{
            return redirect()->back()->with('meta_table_exist', 'جدول متا از قبل وجود دارد');  
        }

        CrudGenerator::query()
            ->where('name', $crudName)
            ->update(['fields' => $tableName]);

            return redirect()->back();
    }

    public function AddMetaFieldStore(Request $request){

        $request->validate([
            'meta_key.*'    => 'required|string',
            'type.*'        => 'required|string',
            'return_type.*' => 'required|string',
        ]);


        $crud_name      = $request->get('crud_name');
        $metaTable      = CrudGenerator::query()->where('name', $crud_name)->first()->fields;
        $metaKeys       = $request->input('meta_key');
        $types          = $request->input('type');
        $returnTypes    = $request->input('return_type');

        $dataToInsert = [];

        foreach ($metaKeys as $index => $metaKey) {
            $dataToInsert[] = [
                'crud_name'     => $crud_name,
                'meta_key'      => $metaKey,
                'type'          => $types[$index],
                'return_type'   => $returnTypes[$index],
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ];
        }

        DB::table($metaTable)->insert($dataToInsert);

        return redirect()->back();
    }

    public function destroy() {
        //
    }

    private function isDevelopMod($request) :int{
        return (int) $request->get('develop_mode');
    }

    private function generateMigrationName($request) :string{
        return 'create_' . strtolower($request->get('name')) . '_table';
    }

    private function generateTableName($request) :string{
        return strtolower($request->get('name'));
    }

    private function generateTable(string $tableName, array $supports = []) :void{
        if(!Schema::hasTable($tableName)){
            Schema::create($tableName, function ($table) use ($supports){
                $table->id();

                foreach ($supports as $support){
                    match ($support){
                        'title'         => $table->text('title')->nullable(),
                        'desc'          => $table->text('desc')->nullable(),
                        'thumbnail'     => $table->text('thumbnail')->nullable(),
                        'excerpt'       => $table->text('excerpt')->nullable(),
                        'slider'        => $table->text('slider')->nullable(),
                        default         => null
                    };
                }

                $table->timestamps();
            });
        }
    }

    private function migrateCommand(string $tableName) :void{
        Artisan::call('migrate');
    }

    private function createMigrationFileWhenDeveloperMode(
        string $tableName, array $supports
    ) :void {

        $migrationNameWithTimestamp = "create_{$tableName}_table";

        Artisan::call('make:migration', [
            'name' => $migrationNameWithTimestamp,
        ]);

        $timestampFilePath = database_path(
            'migrations/' .
            now()->format('Y_m_d_His') . "_create_{$tableName}_table.php"
        );

        $newMigrationFilePath = database_path(
            'migrations/' . "{$tableName}.php"
        );

        if (file_exists($timestampFilePath)) {
            rename($timestampFilePath, $newMigrationFilePath);
        }

        if (file_exists($newMigrationFilePath)) {
            $stubPath = resource_path('stubs/customMigration.stub');

            $stubContent = file_get_contents($stubPath);

            $schemaBlueprint = "\$table->id();\n";

            foreach ($supports as $support) {
                $schemaBlueprint .= match ($support) {
                    'title'         => "\$table->text('title')->nullable();\n",
                    'desc'          => "\$table->text('desc')->nullable();\n",
                    'thumbnail'     => "\$table->text('thumbnail')->nullable();\n",
                    'excerpt'       => "\$table->text('excerpt')->nullable();\n",
                    'slider'        => "\$table->text('slider')->nullable();\n",
                    default         => '',
                };
            }

            $schemaBlueprint .= "\$table->timestamps();\n";
            $explodeTableName = explode('_', $tableName);

            $migrationContent = str_replace(
                ['{{tableName}}', '{{schemaBlueprint}}'],
                [$explodeTableName[1], $schemaBlueprint],
                $stubContent
            );

            file_put_contents($newMigrationFilePath, $migrationContent);
        }
    }
}
