<?php

namespace App\Models\Inventory;

use App\Models\BaseModel;
use App\Models\Common\StatusUpdate;
use App\Models\Master\General\{Brand, City, District, Place, Port, PostOffice, State, Unit};
use App\Models\Master\Sales\{Customer};
use App\Models\Master\Purchase\{ Supplier, SupplierCategory};
use App\Models\Master\Inventory\{ Pallet, ProdCatSvgImg, Product, ProductCategory, ProductMaster, Rack, Slot, StorageRoom};
use App\Models\Inventory\{Inward, InwardDetail, Outward, OutwardDetail, PackingList, PackingListDetail, PickList, PickListDetail, Stock, StockAdjustment, GatePassDetail};
use App\Models\Purchase\{GRN, GRNDetail};
use App\Models\Master\Accounting\{Payment};
use App\Models\{Company, Client};

use App\Enums\MovementType;

use App\Models\Traits\TracksStatusChanges;

use App\Services\Inventory\StockService;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Carbon\Carbon;

class GatePass extends BaseModel
{
    use HasFactory, TracksStatusChanges;

    protected $table = 'cs_gate_pass';
    protected $primaryKey = 'gate_pass_id';
    protected $guarded = []; 

    public $timestamps = true;
    

    protected static function booted()
    {
        parent::booted();
        
        static::creating(function ($gatepass) {
            $Year = Carbon::now()->format('Y');
            $year = Carbon::now()->format('y');

            $countYear = self::whereYear('created_at', $Year)->count();
            $sequence = str_pad($countYear + 1, 5, '0', STR_PAD_LEFT);

            $gatepass->company_id = auth()->user()->company_id ?? 1;
            $gatepass->branch_id = auth()->user()->branch_id ?? 1;

            $gatepass->doc_type = $gatepass->doc_type ?? "gatepass";
            $gatepass->doc_no = $gatepass->doc_no ?? "GP-{$year}-{$sequence}";
        });
    }
    
    public function gatePassDetails()
    {
        return $this->hasMany(GatePassDetail::class, 'gate_pass_id', 'gate_pass_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status', 'status_name');
    }

    public function statusUpdates()
    {
        return $this->hasMany(StatusUpdate::class, 'row_id', 'inward_detail_id')
            ->where('table_name', $this->getTable());
    }


}
