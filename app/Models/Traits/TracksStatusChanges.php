<?php

namespace App\Models\Traits;

use App\Models\Common\StatusUpdate;
use Illuminate\Support\Facades\Auth;

trait TracksStatusChanges
{
    protected static function bootTracksStatusChanges()
    {
        // static::created(function ($model) {
        //     //if($model->getOriginal('status')=='created') {
        //         $model->logStatusChange(true);
        //     //}
        // });

        static::saving(function ($model) {
            // if($model->getOriginal('status')==null) {
            //     $model->logStatusChange(true);
            // } else 
            if ($model->isDirty('status')) {
                $model->logStatusChange();
            }
        });

        // static::saving(function ($model) {
        //     if($model->getOriginal('status')==null) {
        //         $model->logStatusChange(true);
        //     } else if ($model->isDirty('status')) {
        //         $model->logStatusChange();
        //     } 
        // });
    }

    public function logStatusChange(bool $isNew = false)
    {
        $userId = Auth::id();

        $companyId = $this->company_id ?? null;
        $branchId  = $this->branch_id ?? null;

        $oldValue = $isNew ? 'N/A' : $this->stringifyStatus($this->getOriginal('status'));
        $newValue = $this->stringifyStatus($this->status);

        $description = ($oldValue === 'null')
            ? "Initial status set to {$newValue}"
            : "Status changed from {$oldValue} to {$newValue}";

        StatusUpdate::create([
            'company_id'   => $companyId,
            'branch_id'    => $branchId,
            'table_name'   => $this->getTable(),
            'row_id'       => $this->getKey(),
            'column_name'  => 'status',
            'column_value' => $newValue,
            'description'  => $description,
            'created_by'   => $userId,
        ]);
    }

    protected function stringifyStatus($value): string
    {
        if (is_null($value)) {
            return 'null';
        }
        
        return (string) $value;
    }
}
