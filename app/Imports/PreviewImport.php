<?php

namespace App\Imports;

use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PreviewImport implements ToArray, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    // public function collection(Collection $collection)
    // {
    //     //
    // }

    protected $selectedFields;
    protected $data = [];

    public function __construct($selectedFields)
    {
        $this->selectedFields = $selectedFields;
    }

    public function array(array $rows)
    {
        $output = [];
    
        foreach ($this->selectedFields as $table => $fields) {
            foreach ($rows as $index => $row) {
                $data = [];
    
                foreach ($fields as $field) {
                    $data[$field] = $row[$field] ?? null;
                }
    
                $output[$table][] = $data;
            }
        }
    
        $this->data = $output;
    }    

    public function getData()
    {
        return $this->data;
    }
}
