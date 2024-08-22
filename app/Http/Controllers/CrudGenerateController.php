<?php

namespace App\Http\Controllers;
use App\Models\CrudGenerator;
use CrudGenerator\commands\CreateCrudGeneratorCommand;
use CrudGenerator\Contracts\Repositories\CrudRepositoryContract;
use CrudGenerator\Enums\DeveloperModeEnum;
use CrudGenerator\Enums\StatusEnum;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class CrudGenerateController extends Controller {

    public function __construct(
        public CrudRepositoryContract $contract
    ){}

    public function index() :View{
        $cruds = CrudGenerator::query()
            ->orderByDesc('created_at')
            ->get();

        return view('crud.index', compact('cruds'));
    }

    public function create() :View{
        return view('crud.create');
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

    public function show() {
        //
    }

    public function update() {
        //
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
                        'title'         => $table->string('title'),
                        'desc'          => $table->string('desc'),
                        'thumbnail'     => $table->string('thumbnail'),
                        'excerpt'       => $table->string('excerpt'),
                        'slider'        => $table->string('slider'),
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
                    'title'         => "\$table->string('title');\n",
                    'desc'          => "\$table->text('desc');\n",
                    'thumbnail'     => "\$table->text('thumbnail');\n",
                    'excerpt'       => "\$table->text('excerpt');\n",
                    'slider'        => "\$table->text('slider');\n",
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
