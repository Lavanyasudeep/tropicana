<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BaseModel extends Model
{
    protected static function booted()
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();

                $model->saveQuietly(); 
            }
        });

        static::deleting(function ($model) {
            if (Auth::check()) {
                $model->deleted_by = Auth::id();

                // ✅ this is needed to persist the deleted_by value
                $model->saveQuietly(); // prevents infinite loop
            }
        });
    }

    public function formatDate($column, $format = 'd/m/Y')
    {
        $date = $this->{$column};

        return $date ? \Carbon\Carbon::parse($date)->format($format) : null;
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy() {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
