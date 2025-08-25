<?php

namespace App\Models\Inventory;

use App\Models\BaseModel;
use App\Models\Common\StatusUpdate;
use App\Models\Master\General\{Brand, City, District, Place, Port, PostOffice, State, Unit};
use App\Models\Master\Sales\{Customer};
use App\Models\Master\Purchase\{ Supplier, SupplierCategory};
use App\Models\Master\Inventory\{ Pallet, ProdCatSvgImg, Product, ProductCategory, ProductMaster, Rack, Slot, StorageRoom};
use App\Models\Inventory\{Inward, InwardDetail, Outward, OutwardDetail, PackingList, PackingListDetail, PickList, PickListDetail, Stock, StockAdjustment, GatePass};
use App\Models\Purchase\{GRN, GRNDetail};
use App\Models\Master\Accounting\{Payment};
use App\Models\{Company, Client};
use App\Models\Master\General\Status;

use App\Enums\MovementType;

use App\Services\Inventory\StockService;
use App\Services\Inventory\InventoryStatusTransitionService;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class GatePassDetail extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'cs_gate_pass_details';
    protected $primaryKey = 'gate_pass_detail_id';
    protected $guarded = []; 

    public $timestamps = true;

    protected static function booted()
    {
        parent::booted();
    }
    
    public function gatePass()
    {
        return $this->belongsTo(GatePass::class, 'gate_pass_id', 'gate_pass_id');
    }

}
