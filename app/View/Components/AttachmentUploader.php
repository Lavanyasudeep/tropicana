<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AttachmentUploader extends Component
{
    public $tableName;
    public $rowId;

    /**
     * Create a new component instance.
     */
    public function __construct($tableName, $rowId)
    {
        $this->tableName = $tableName;
        $this->rowId = $rowId;
    }

    /**
     * Get the view.
     */
    public function render()
    {
        return view('components.attachment-uploader');
    }
}

