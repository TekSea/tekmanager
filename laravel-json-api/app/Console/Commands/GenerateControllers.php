<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateControllers extends Command
{
    protected $signature = 'generate:controllers';
    protected $description = 'Generate resource controllers for all models';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $modelPath = app_path('Models');
        $files = File::files($modelPath);
        $routeDeclarations = '';
        $controllerImports = '';

        foreach ($files as $file) {
            $modelName = pathinfo($file, PATHINFO_FILENAME);
            $controllerName = $modelName . 'Controller';
            $this->info("Generating controller for model: $modelName");

            $this->addCrudLogicToController($controllerName, $modelName);

            // Generate route declaration
            $routeDeclarations .= "Route::apiResource('" . Str::snake($modelName) . "s', " . $controllerName . "::class);\n";
            // Generate controller import
            $controllerImports .= "use App\Http\Controllers\\{$controllerName};\n";
        }

        // Update routes and imports in api.php file
        $this->updateApiFile($controllerImports, $routeDeclarations);

        $this->info('All controllers and routes have been generated successfully.');
    }

    protected function addCrudLogicToController($controllerName, $modelName)
    {
        $controllerPath = app_path("Http/Controllers/{$controllerName}.php");
        $modelVariable = Str::camel($modelName);
        $modelClass = "App\\Models\\{$modelName}";
        $tableName = Str::snake($modelName) . 's';

        // Get the table and column descriptions
        $tableComment = $this->getTableComment($tableName);
        $columns = DB::select("SHOW FULL COLUMNS FROM {$tableName}");
        $columnDefinitions = [];
        $primaryKey = 'id';

        foreach ($columns as $column) {
            $description = $column->Comment ? "description=\"{$column->Comment}\"" : "";
            $columnDefinitions[] = "@OA\Property(property=\"{$column->Field}\", type=\"{$this->getSwaggerType($column->Type)}\", $description)";
            if ($column->Key == 'PRI') {
                $primaryKey = $column->Field;
            }
        }

        $swaggerProperties = implode(",\n                 *                 ", $columnDefinitions);

        $controllerContent = <<<EOD
        <?php

        namespace App\Http\Controllers;

        use $modelClass;
        use Illuminate\Http\Request;

        class $controllerName extends Controller
        {
            /**
             * @OA\Get(
             *     path="/api/{$modelVariable}s",
             *     summary="Get all {$modelVariable}s",
             *     description="$tableComment",
             *     @OA\Response(response="200", description="Get all {$modelVariable}s")
             * )
             */
            public function index()
            {
                \${$modelVariable}s = $modelName::all();
                return response()->json(\${$modelVariable}s);
            }

            /**
             * @OA\Post(
             *     path="/api/{$modelVariable}s",
             *     summary="Create a new {$modelVariable}",
             *     @OA\RequestBody(
             *         required=true,
             *         @OA\JsonContent(
             *             type="object",
             *             properties={
             *                 $swaggerProperties
             *             }
             *         )
             *     ),
             *     @OA\Response(response="201", description="Create a new {$modelVariable}")
             * )
             */
            public function store(Request \$request)
            {
                \${$modelVariable} = $modelName::create(\$request->all());
                return response()->json(\${$modelVariable}, 201);
            }

            /**
             * @OA\Get(
             *     path="/api/{$modelVariable}s/{id}",
             *     summary="Get a {$modelVariable} by ID",
             *     @OA\Parameter(
             *         name="id",
             *         in="path",
             *         required=true,
             *         @OA\Schema(type="integer")
             *     ),
             *     @OA\Response(response="200", description="Get a {$modelVariable} by ID")
             * )
             */
            public function show(\$id)
            {
                \${$modelVariable} = $modelName::where('$primaryKey', \$id)->firstOrFail();
                return response()->json(\${$modelVariable});
            }

            /**
             * @OA\Put(
             *     path="/api/{$modelVariable}s/{id}",
             *     summary="Update a {$modelVariable}",
             *     @OA\Parameter(
             *         name="id",
             *         in="path",
             *         required=true,
             *         @OA\Schema(type="integer")
             *     ),
             *     @OA\RequestBody(
             *         required=true,
             *         @OA\JsonContent(
             *             type="object",
             *             properties={
             *                 $swaggerProperties
             *             }
             *         )
             *     ),
             *     @OA\Response(response="200", description="Update a {$modelVariable}")
             * )
             */
            public function update(Request \$request, \$id)
            {
                \${$modelVariable} = $modelName::where('$primaryKey', \$id)->firstOrFail();
                \${$modelVariable}->update(\$request->all());
                return response()->json(\${$modelVariable}, 200);
            }

            /**
             * @OA\Delete(
             *     path="/api/{$modelVariable}s/{id}",
             *     summary="Delete a {$modelVariable}",
             *     @OA\Parameter(
             *         name="id",
             *         in="path",
             *         required=true,
             *         @OA\Schema(type="integer")
             *     ),
             *     @OA\Response(response="204", description="Delete a {$modelVariable}")
             * )
             */
            public function destroy(\$id)
            {
                \${$modelVariable} = $modelName::where('$primaryKey', \$id)->firstOrFail();
                \${$modelVariable}->delete();
                return response()->json(null, 204);
            }
        }
        EOD;

        File::put($controllerPath, $controllerContent);
    }

    protected function getTableComment($tableName)
    {
        $result = DB::select("SHOW TABLE STATUS LIKE '$tableName'");
        return $result[0]->Comment ?? '';
    }

    protected function getSwaggerType($columnType)
    {
        $type = 'string';
        if (strpos($columnType, 'int') !== false) {
            $type = 'integer';
        } elseif (strpos($columnType, 'float') !== false || strpos($columnType, 'double') !== false || strpos($columnType, 'decimal') !== false) {
            $type = 'number';
        } elseif (strpos($columnType, 'bool') !== false) {
            $type = 'boolean';
        }

        return $type;
    }

    protected function updateApiFile($controllerImports, $routeDeclarations)
    {
        $apiFilePath = base_path('routes/api.php');
        $existingContent = File::get($apiFilePath);

        // Remove existing declarations to avoid duplication
        $existingContent = preg_replace('/Route::apiResource\(\'[a-z_]+s\', [A-Za-z]+Controller::class\);\n/', '', $existingContent);
        $existingContent = preg_replace('/use App\\\Http\\\Controllers\\\[A-Za-z]+Controller;\n/', '', $existingContent);

        // Append imports to the top of the file
        $newContent = preg_replace('/<\?php\n/', "<?php\n\n" . $controllerImports, $existingContent);

        // Append route declarations to the end of the file
        $newContent .= "\n" . $routeDeclarations;

        File::put($apiFilePath, $newContent);
    }
}
