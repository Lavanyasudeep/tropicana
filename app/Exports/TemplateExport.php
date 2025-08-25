<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;

class TemplateExport implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     //
    // }

    protected $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function array(): array
    {
        return [$this->fields]; // Only headers
    }
}
