<?php

namespace App\Http\Controllers\Admin\Common;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use Maatwebsite\Excel\Facades\Excel;

use App\Imports\PreviewImport;
use App\Exports\TemplateExport;

class BulkImportController extends Controller
{
    public function importNew()
    {
        // $availableFields = ['room_name', 'room_description', 'room_total_capacity', 'room_temperature_range',
        //                     'rack_no', 'rack_name', 'rack_capacity', 'rack_position_x', 'rack_position_y',
        //                     'pallet_no', 'pallet_name', 'pallet_barcode', 'pallet_max_weight'
        //                 ];
        // $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();

        $tables = DB::select("SHOW TABLES LIKE 'cs_%'");

        $tableNames = array_map(function($table) {
            return array_values((array)$table)[0];
        }, $tables);

        $tableFields = [];

        foreach ($tableNames as $table) {
            $columns = Schema::getColumnListing($table);
            $tableFields[$table] = $columns;
        }

        return view('admin.import.new', compact('tableNames', 'tableFields'));
    }

    public function importExisting()
    {

        $tables = DB::select("SHOW TABLES LIKE 'cs_%'");

        $tableNames = array_map(function($table) {
            return array_values((array)$table)[0];
        }, $tables);

        $tableFields = [];

        foreach ($tableNames as $table) {
            $columns = Schema::getColumnListing($table);
            $tableFields[$table] = $columns;
        }

        $primaryKeys = $this->getTablePrimaryKeys();

        return view('admin.import.exist', compact('tableNames', 'tableFields', 'primaryKeys'));
    }

    public function downloadTemplate(Request $request)
    {
        $fields = json_decode($request->selected_fields, true);

        if (!is_array($fields) || empty($fields)) {
            return back()->withErrors(['Please select at least one field.']);
        }

        return Excel::download(new TemplateExport($fields), 'cold_storage_template.xlsx');
    }

    public function previewUpload(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:xlsx',
            'selected_fields_upload' => 'required',
        ]);
    
        $fields = json_decode($request->selected_fields_upload, true);
        
        $import = new PreviewImport($fields);
        Excel::import($import, $request->file('import_file'));
        
        $rows = $import->getData();
        
        Session::put('import_preview_data', $rows);
        Session::put('import_selected_fields', $fields);

        return view('admin.import.preview', compact('rows', 'fields'));
    }

    public function processImport(Request $request)
    {
        $data = Session::get('import_preview_data', []);
        $fields = Session::get('import_selected_fields', []);
        $database = DB::connection()->getDatabaseName();
        $modelMap = config('modelmap');

        foreach ($fields as $table => $columns) {
            if (!isset($data[$table])) continue;

            $uniqueKeys = DB::select("
                SELECT kcu.COLUMN_NAME
                FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS tc
                JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE kcu
                    ON tc.CONSTRAINT_NAME = kcu.CONSTRAINT_NAME
                    AND tc.TABLE_NAME = kcu.TABLE_NAME
                    AND tc.TABLE_SCHEMA = kcu.TABLE_SCHEMA
                WHERE tc.CONSTRAINT_TYPE IN ('PRIMARY KEY', 'UNIQUE')
                    AND tc.TABLE_SCHEMA = ?
                    AND tc.TABLE_NAME = ?
            ", [$database, $table]);

            $uniqueKey = $uniqueKeys[0]->COLUMN_NAME ?? null;

            foreach ($data[$table] as $row) {
                $insertData = [];
                foreach ($columns as $column) {
                    if (!isset($row[$column])) continue;

                    if ($column !== $uniqueKey) {
                        $insertData[$column] = $row[$column];
                    }
                }
                

                if ($uniqueKey && isset($row[$uniqueKey])) {
                    $modelMap[$table]::updateOrInsert(
                        [$uniqueKey => $row[$uniqueKey]],
                        $insertData
                    );
                } else {
                    $modelMap[$table]::create($insertData);
                }
            }
        }

        Session::forget('import_preview_data');
        Session::forget('import_selected_fields');

        return redirect()->route('admin.bulk-import.new')->with('success', 'Data imported/updated successfully!');
    }

    public function getTablePrimaryKeys(): array
    {
        $primaryKeys = [];
        $tables = DB::select('SHOW TABLES');
        $tableKey = array_keys((array)$tables[0])[0];

        foreach ($tables as $tableRow) {
            $tableName = $tableRow->$tableKey;
            $result = DB::select("SHOW KEYS FROM `$tableName` WHERE Key_name = 'PRIMARY'");
            if (!empty($result)) {
                $primaryKeys[$tableName] = $result[0]->Column_name;
            }
        }

        return $primaryKeys;
    }
}
