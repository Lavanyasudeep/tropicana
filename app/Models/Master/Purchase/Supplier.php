<?php

namespace App\Models\Master\Purchase;

use App\Models\{ BaseModel, Branch };
use App\Models\Master\General\{Brand, City, District, Place, Port, PostOffice, State, Country, Unit, Tax};
use App\Models\Master\Sales\{Customer};
use App\Models\Master\Purchase\{Supplier, SupplierCategory, SupplierType};
use App\Models\Master\Inventory\{Pallet, ProdCatSvgImg, Product, ProductCategory, ProductMaster, Rack, Slot, StorageRoom};
use App\Models\Inventory\{Inward, InwardDetail, Outward, OutwardDetail, PackingList, PackingListDetail, PickList, PickListDetail, Stock, StockAdjustment};
use App\Models\Purchase\{GRN, GRNDetail};

use App\Models\Master\Accounting\{Payment};
use App\Models\{Company, Client};

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'cs_supplier';
    protected $primaryKey = 'supplier_id';
    protected $guarded = [];

    protected $appends = ['supplier_address'];
    
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'branch_id');
    }

    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id', 'place_id');
    }

    public function postoffice()
    {
        return $this->belongsTo(PostOffice::class, 'post_office_id', 'post_office_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'district_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'state_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'country_id');
    }

    public function supplierCategory()
    {
        return $this->belongsTo(SupplierCategory::class, 'supplier_category_id', 'supplier_category_id');
    }

    public function supplierType()
    {
        return $this->belongsTo(SupplierType::class, 'supplier_type_id', 'supplier_type_id');
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_per', 'tax_per');
    }

    public function getSupplierAddressAttribute()
    {
        $addressParts = array_filter([
            $this->MainAddress1,
            $this->MainAddress2,
            optional($this->place)->PlaceName,
            ($this->postoffice ? ($this->postoffice->post_office . '-' . $this->postoffice->pincode) : null),
            optional($this->city)->city_name,
            optional($this->district)->district_name,
            optional($this->state)->state_name,
        ]);
    
        return implode(', ', $addressParts);
    }
}
