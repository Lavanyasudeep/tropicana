<?php

namespace App\Models\Master\Accounting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionType extends Model
{
    use HasFactory;

    protected $table = 'cs_transaction_type';
    protected $primaryKey = 'transaction_type_id';
    protected $guarded = [];
}