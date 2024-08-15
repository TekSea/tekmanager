<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateModels extends Command
{
    protected $signature = 'generate:models {tables?*}';
    protected $description = 'Generate Eloquent models for specific tables';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $tables = $this->argument('tables');

        if (empty($tables)) {
            $this->error("No tables specified. Please provide the tables you want to generate models for.");
            return;
        }

        $tableKey = 'Tables_in_' . env('DB_DATABASE');

        foreach ($tables as $tableName) {
            $modelName = ucfirst(Str::camel(Str::singular($tableName)));
            $this->info("Generating model for table: $tableName");

            // Generate the model manually
            $this->generateModel($tableName, $modelName);

            // Add custom properties to the generated model
            $modelPath = app_path("Models/{$modelName}.php");
            $this->customizeModel($modelPath, $tableName);
        }

        $this->info('Selected models have been generated successfully.');
    }

    protected function generateModel($tableName, $modelName)
    {
        $modelTemplate = <<<EOD
        <?php

        namespace App\Models;

        use Illuminate\Database\Eloquent\Factories\HasFactory;
        use Illuminate\Database\Eloquent\Model;

        class $modelName extends Model
        {
            use HasFactory;

            protected \$table = '$tableName';
        }
        EOD;

        $modelPath = app_path("Models/{$modelName}.php");
        file_put_contents($modelPath, $modelTemplate);
    }

    protected function customizeModel($modelPath, $tableName)
    {
        $columns = DB::select("SHOW COLUMNS FROM {$tableName}");
        $fillable = [];
        $primaryKey = 'id';
        $hasCreatedAt = false;
        $hasUpdatedAt = false;
        $hasTimeStamp = false;

        foreach ($columns as $column) {
            $fillable[] = "'{$column->Field}'";
            if ($column->Key == 'PRI') {
                $primaryKey = $column->Field;
            }
            if ($column->Field == 'created_at') {
                $hasCreatedAt = true;
            }
            if ($column->Field == 'updated_at') {
                $hasUpdatedAt = true;
            }
            if ($column->Field == 'time_stamp') {
                $hasTimeStamp = true;
            }
        }

        $fillableProperties = implode(', ', $fillable);
        $timestamps = ($hasCreatedAt && $hasUpdatedAt) ? 'true' : 'false';
        $timeStampField = $hasTimeStamp ? "const UPDATED_AT = 'time_stamp';" : '';

        $modelContent = file_get_contents($modelPath);

        // Add fillable properties and manage timestamps
        $customContent = <<<EOD
        protected \$fillable = [$fillableProperties];
        public \$timestamps = $timestamps;
        protected \$primaryKey = '$primaryKey';
        $timeStampField
        EOD;

        $modelContent = preg_replace('/\}\s*$/', "\n    $customContent\n}", $modelContent);

        file_put_contents($modelPath, $modelContent);
    }
}
