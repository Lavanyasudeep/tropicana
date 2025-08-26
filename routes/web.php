<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;

// Inventory
use App\Http\Controllers\Admin\Inventory\PackingListController;
use App\Http\Controllers\Admin\Inventory\PreAlertController;

use App\Http\Controllers\Admin\Inventory\InwardController;
use App\Http\Controllers\Admin\Inventory\PickListController;
use App\Http\Controllers\Admin\Inventory\OutwardController;
use App\Http\Controllers\Admin\Inventory\StockAdjustmentController;
use App\Http\Controllers\Admin\Inventory\StorageRoomController;
use App\Http\Controllers\Admin\Inventory\GatePassController;
use App\Http\Controllers\Admin\Inventory\GatePassInController;
use App\Http\Controllers\Admin\Inventory\TemperatureCheckController;
use App\Http\Controllers\Admin\Inventory\PalletizationController;
use App\Http\Controllers\Admin\Inventory\PutAwayController;

// Purchase
use App\Http\Controllers\Admin\Purchase\GRNController;

// Sales
use App\Http\Controllers\Admin\Sales\CustomerEnquiryController;
use App\Http\Controllers\Admin\Sales\SalesQuotationController;

// Accounting
use App\Http\Controllers\Admin\Accounting\PaymentController;
use App\Http\Controllers\Admin\Accounting\JournalController;

// Masters
use App\Http\Controllers\Admin\Master\Inventory\WarehouseUnitController;
use App\Http\Controllers\Admin\Master\Inventory\DockController;
use App\Http\Controllers\Admin\Master\Inventory\RoomController;
use App\Http\Controllers\Admin\Master\Inventory\BlockController;
use App\Http\Controllers\Admin\Master\Inventory\RackController;
use App\Http\Controllers\Admin\Master\Inventory\SlotController;
use App\Http\Controllers\Admin\Master\Inventory\PalletController;
use App\Http\Controllers\Admin\Master\Inventory\PalletTypeController;
use App\Http\Controllers\Admin\Master\Inventory\BoxCountController;
use App\Http\Controllers\Admin\Master\Inventory\ProductAttributeController;
use App\Http\Controllers\Admin\Master\Inventory\ProductController;

use App\Http\Controllers\Admin\Master\General\StateController;
use App\Http\Controllers\Admin\Master\General\TaxController;
use App\Http\Controllers\Admin\Master\General\UnitController;
use App\Http\Controllers\Admin\Master\General\ProductTypeController;
use App\Http\Controllers\Admin\Master\General\ProductTypePriceController;
use App\Http\Controllers\Admin\Master\General\CompanyController;
use App\Http\Controllers\Admin\Master\General\BranchController;
use App\Http\Controllers\Admin\Master\General\MenuController;
use App\Http\Controllers\Admin\Master\General\RoleController;

use App\Http\Controllers\Admin\Master\Purchase\SupplierController;

use App\Http\Controllers\Admin\Master\Sales\CustomerController;

use App\Http\Controllers\Admin\Master\Accounting\ChartOfAccountController;
use App\Http\Controllers\Admin\Master\Accounting\AnalyticalController;
use App\Http\Controllers\Admin\Master\Accounting\PaymentPurposeController;

use App\Http\Controllers\Admin\Master\HR\EmployeeController;
use App\Http\Controllers\Admin\Master\HR\UserController;

use App\Http\Controllers\Admin\ProductFlowController;

// Reports
use App\Http\Controllers\Admin\Report\StockSummaryController;
use App\Http\Controllers\Admin\Report\StockDetailController;

// Bulk Import
use App\Http\Controllers\Admin\Common\BulkImportController;

// Attachment
use App\Http\Controllers\Admin\Common\AttachmentController;

// General
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingsController;


Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('login');
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index']);
//     Route::resource('products', ProductController::class);
// });

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/settings/update', [SettingsController::class, 'update'])->name('settings.update');
    
    /********** Master ***********/
    Route::group(['prefix' => 'master', 'as' => 'master.'], function() {

        /********** Master : Inventory ***********/
        Route::group(['prefix' => 'inventory', 'as' => 'inventory.'], function() {
            Route::group(['prefix' => 'warehouse-unit', 'as' => 'warehouse-unit.'], function() {
                Route::get('/', [WarehouseUnitController::class, 'index'])->name('index');
                Route::post('/store', [WarehouseUnitController::class, 'store'])->name('store');
                Route::post('/update/{id}', [WarehouseUnitController::class, 'update'])->name('update');
                Route::delete('/destroy/{id}', [WarehouseUnitController::class, 'destroy'])->name('destroy');
                Route::post('/toggle-status', [WarehouseUnitController::class, 'toggleStatus'])->name('toggle-status');
            });

            Route::group(['prefix' => 'docks', 'as' => 'docks.'], function() {
                Route::get('/', [DockController::class, 'index'])->name('index');
                Route::post('/store', [DockController::class, 'store'])->name('store');
                Route::post('/update/{id}', [DockController::class, 'update'])->name('update');
                Route::delete('/destroy/{id}', [DockController::class, 'destroy'])->name('destroy');
                Route::post('/toggle-status', [DockController::class, 'toggleStatus'])->name('toggle-status');
            });

            Route::group(['prefix' => 'rooms', 'as' => 'rooms.'], function() {
                Route::get('/', [RoomController::class, 'index'])->name('index');
                Route::post('/store', [RoomController::class, 'store'])->name('store');
                Route::post('/update/{id}', [RoomController::class, 'update'])->name('update');
                Route::delete('/destroy/{id}', [RoomController::class, 'destroy'])->name('destroy');
                Route::post('/toggle-status', [RoomController::class, 'toggleStatus'])->name('toggle-status');
            });

            Route::group(['prefix' => 'blocks', 'as' => 'blocks.'], function() {
                Route::get('/', [BlockController::class, 'index'])->name('index');
                Route::post('/store', [BlockController::class, 'store'])->name('store');
                Route::post('/update/{id}', [BlockController::class, 'update'])->name('update');
                Route::delete('/destroy/{id}', [BlockController::class, 'destroy'])->name('destroy');
                Route::post('/toggle-status', [BlockController::class, 'toggleStatus'])->name('toggle-status');
            });

            Route::group(['prefix' => 'racks', 'as' => 'racks.'], function() {
                Route::get('/', [RackController::class, 'index'])->name('index');
                Route::post('/', [RackController::class, 'store'])->name('store');
                Route::post('/update/{id}', [RackController::class, 'update'])->name('update');
                Route::delete('/destroy/{id}', [RackController::class, 'destroy'])->name('destroy');
                Route::post('/toggle-status', [RackController::class, 'toggleStatus'])->name('toggle-status');
                Route::post('/{id}/generate-pallets', [RackController::class, 'generatePallets'])->name('generatePallets');
                Route::post('/get-racks', [RackController::class, 'getRacks'])->name('get-racks');
                Route::post('/get-rack-details', [RackController::class, 'getRackDetails'])->name('get-rack-details');
            });

            Route::group(['prefix' => 'slots', 'as' => 'slots.'], function() {
                Route::get('/', [SlotController::class, 'index'])->name('index');
                Route::post('/', [SlotController::class, 'store'])->name('store');
                Route::post('/update/{id}', [SlotController::class, 'update'])->name('update');
                Route::delete('/destroy/{id}', [SlotController::class, 'destroy'])->name('destroy');
                Route::post('/toggle-status', [SlotController::class, 'toggleStatus'])->name('toggle-status');
                Route::post('/get-slots', [SlotController::class, 'getSlots'])->name('get-slots');
                Route::post('/get-slot-detail', [SlotController::class, 'getSlotDetail'])->name('get-slot-detail');
            });

            Route::group(['prefix' => 'pallets', 'as' => 'pallets.'], function() {
                Route::get('/', [PalletController::class, 'index'])->name('index');
                Route::post('/', [PalletController::class, 'store'])->name('store');
                Route::post('/update/{id}', [PalletController::class, 'update'])->name('update');
                Route::delete('/destroy/{id}', [PalletController::class, 'destroy'])->name('destroy');
                Route::post('/toggle-status', [PalletController::class, 'toggleStatus'])->name('toggle-status');
                Route::post('/get-pallets', [PalletController::class, 'getPallets'])->name('get-pallets');
            });

            Route::group(['prefix' => 'pallet-type', 'as' => 'pallet-type.'], function() {
                Route::get('/', [PalletTypeController::class, 'index'])->name('index');
                Route::post('/store', [PalletTypeController::class, 'store'])->name('store');
                Route::put('/update/{id}', [PalletTypeController::class, 'update'])->name('update');
                Route::delete('/destroy/{id}', [PalletTypeController::class, 'destroy'])->name('destroy');
                Route::post('/toggle-status', [PalletTypeController::class, 'toggleStatus'])->name('toggle-status');
            });

            Route::group(['prefix' => 'box-count', 'as' => 'box-count.'], function() {
                Route::get('/', [BoxCountController::class, 'index'])->name('index');
                Route::post('/update', [BoxCountController::class, 'update'])->name('update');
            }); 

            Route::group(['prefix' => 'product-attributes', 'as' => 'product-attributes.'], function() {
                Route::get('/', [ProductAttributeController::class, 'index'])->name('index');
                Route::post('/store', [ProductAttributeController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [ProductAttributeController::class, 'edit'])->name('edit');
                Route::put('/update/{id}', [ProductAttributeController::class, 'update'])->name('update');
                Route::delete('/destroy/{id}', [ProductAttributeController::class, 'destroy'])->name('destroy');
                Route::post('/toggle-status', [ProductAttributeController::class, 'toggleStatus'])->name('toggle-status');
                Route::get('/{id}/input-field', [ProductAttributeController::class, 'inputField']);
            });

            Route::group(['prefix' => 'product', 'as' => 'product.'], function() {
                Route::get('/', [ProductController::class, 'index'])->name('index');
                Route::get('/create', [ProductController::class, 'create'])->name('create');
                Route::post('/store', [ProductController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
                Route::put('/update/{id}', [ProductController::class, 'update'])->name('update');
                Route::delete('/destroy/{id}', [ProductController::class, 'destroy'])->name('destroy');
            });
        });

        /********** Master : Purchase ***********/
        Route::group(['prefix' => 'purchase', 'as' => 'purchase.'], function() {
            Route::group(['prefix' => 'supplier', 'as' => 'supplier.'], function() {
                Route::get('/', [SupplierController::class, 'index'])->name('index');
                Route::get('/create', [SupplierController::class, 'create'])->name('create');
                Route::post('/store', [SupplierController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [SupplierController::class, 'edit'])->name('edit');
                Route::put('/update/{id}', [SupplierController::class, 'update'])->name('update');
                Route::get('/view/{id}', [SupplierController::class, 'show'])->name('view');
                Route::delete('/destroy/{id}', [SupplierController::class, 'destroy'])->name('destroy');
                Route::post('/toggle-status', [SupplierController::class, 'toggleStatus'])->name('toggle-status');
                Route::post('/get-supplier-details', [SupplierController::class, 'getSupplierDetails'])->name('get-supplier-details');
            }); 
        });

        Route::group(['prefix' => 'sales', 'as' => 'sales.'], function() {
            Route::group(['prefix' => 'customer', 'as' => 'customer.'], function() {
                Route::get('/', [CustomerController::class, 'index'])->name('index');
                Route::get('/create', [CustomerController::class, 'create'])->name('create');
                Route::post('/store', [CustomerController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [CustomerController::class, 'edit'])->name('edit');
                Route::put('/update/{id}', [CustomerController::class, 'update'])->name('update');
                Route::get('/view/{id}', [CustomerController::class, 'show'])->name('view');
                Route::delete('/destroy/{id}', [CustomerController::class, 'destroy'])->name('destroy');
                Route::post('/toggle-status', [CustomerController::class, 'toggleStatus'])->name('toggle-status');
                Route::post('/get-customer-details', [CustomerController::class, 'getCustomerDetails'])->name('get-customer-details');
            }); 
        });

        /********** Master : General ***********/
        Route::group(['prefix' => 'general', 'as' => 'general.'], function() {
            Route::group(['prefix' => 'state', 'as' => 'state.'], function() {
                Route::post('/get-state-list', [StateController::class, 'getStates'])->name('get-state-list');
            }); 

            Route::group(['prefix' => 'company', 'as' => 'company.'], function() {
                Route::get('/', [CompanyController::class, 'index'])->name('index');
                Route::get('/create', [CompanyController::class, 'create'])->name('create');
                Route::post('/store', [CompanyController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [CompanyController::class, 'edit'])->name('edit');
                Route::put('/update/{id}', [CompanyController::class, 'update'])->name('update');
                Route::get('/view/{id}', [CompanyController::class, 'show'])->name('view');
                Route::delete('/destroy/{id}', [CompanyController::class, 'destroy'])->name('destroy');
                Route::post('/toggle-status', [CompanyController::class, 'toggleStatus'])->name('toggle-status');
            });

            Route::group(['prefix' => 'branch', 'as' => 'branch.'], function() {
                Route::get('/', [BranchController::class, 'index'])->name('index');
                Route::get('/create', [BranchController::class, 'create'])->name('create');
                Route::post('/store', [BranchController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [BranchController::class, 'edit'])->name('edit');
                Route::put('/update/{id}', [BranchController::class, 'update'])->name('update');
                Route::get('/view/{id}', [BranchController::class, 'show'])->name('view');
                Route::delete('/destroy/{id}', [BranchController::class, 'destroy'])->name('destroy');
                Route::post('/toggle-status', [BranchController::class, 'toggleStatus'])->name('toggle-status');
            });

            Route::group(['prefix' => 'menu', 'as' => 'menu.'], function() {
                Route::get('/', [MenuController::class, 'index'])->name('index');
                Route::get('/get-sub-menu', [MenuController::class, 'getSubMenu'])->name('get-sub-menu');
                Route::get('/get-menu', [MenuController::class, 'getMenu'])->name('get-menu');
                Route::get('/search', [MenuController::class, 'search'])->name('search');
                Route::post('/store', [MenuController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [MenuController::class, 'edit'])->name('edit');
                Route::put('/update/{id}', [MenuController::class, 'update'])->name('update');
                Route::post('/sort/update', [MenuController::class, 'updateSortOrder'])->name('sort.update');
                Route::delete('/destroy/{id}', [MenuController::class, 'destroy'])->name('destroy');
                Route::post('/toggle-status', [MenuController::class, 'toggleStatus'])->name('toggle-status');
            });

            Route::group(['prefix' => 'role', 'as' => 'role.'], function() {
                Route::get('/', [RoleController::class, 'index'])->name('index');
                Route::get('/create', [RoleController::class, 'create'])->name('create');
                Route::post('/store', [RoleController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('edit');
                Route::put('/update/{id}', [RoleController::class, 'update'])->name('update');
                Route::get('/view/{id}', [RoleController::class, 'show'])->name('view');
                Route::delete('/destroy/{id}', [RoleController::class, 'destroy'])->name('destroy');
                Route::post('/toggle-status', [RoleController::class, 'toggleStatus'])->name('toggle-status');
            });

            Route::group(['prefix' => 'tax', 'as' => 'tax.'], function() {
                Route::get('/', [TaxController::class, 'index'])->name('index');
                Route::post('/store', [TaxController::class, 'store'])->name('store');
                Route::post('/update/{id}', [TaxController::class, 'update'])->name('update');
                Route::delete('/destroy/{id}', [TaxController::class, 'destroy'])->name('destroy');
                Route::post('/toggle-status', [TaxController::class, 'toggleStatus'])->name('toggle-status');
            });

            Route::group(['prefix' => 'unit', 'as' => 'unit.'], function() {
                Route::get('/', [UnitController::class, 'index'])->name('index');
                Route::post('/store', [UnitController::class, 'store'])->name('store');
                Route::put('/update/{id}', [UnitController::class, 'update'])->name('update');
                Route::delete('/destroy/{id}', [UnitController::class, 'destroy'])->name('destroy');
                Route::post('/toggle-status', [UnitController::class, 'toggleStatus'])->name('toggle-status');
            });

            Route::group(['prefix' => 'product-type', 'as' => 'product-type.'], function() {
                Route::get('/', [ProductTypeController::class, 'index'])->name('index');
                Route::post('/store', [ProductTypeController::class, 'store'])->name('store');
                Route::put('/update/{id}', [ProductTypeController::class, 'update'])->name('update');
                Route::delete('/destroy/{id}', [ProductTypeController::class, 'destroy'])->name('destroy');
                Route::post('/toggle-status', [ProductTypeController::class, 'toggleStatus'])->name('toggle-status');
            });

            Route::group(['prefix' => 'product-type-price', 'as' => 'product-type-price.'], function() {
                Route::get('/', [ProductTypePriceController::class, 'index'])->name('index');
                Route::post('/store', [ProductTypePriceController::class, 'store'])->name('store');
                Route::post('/update/{id}', [ProductTypePriceController::class, 'update'])->name('update');
                Route::delete('/destroy/{id}', [ProductTypePriceController::class, 'destroy'])->name('destroy');
                Route::post('/toggle-status', [ProductTypePriceController::class, 'toggleStatus'])->name('toggle-status');
            });
        });
        
        /********** Master : Accounting ***********/
        Route::group(['prefix' => 'accounting', 'as' => 'accounting.'], function() {
            Route::group(['prefix' => 'chart-of-account', 'as' => 'chart-of-account.'], function() {
                Route::get('/', [ChartOfAccountController::class, 'index'])->name('index');
                Route::get('/level2', [ChartOfAccountController::class, 'getLevel2'])->name('level2');
                Route::get('/accounts', [ChartOfAccountController::class, 'getAccounts'])->name('accounts');
                Route::get('/search', [ChartOfAccountController::class, 'search'])->name('search');
                Route::post('/store', [ChartOfAccountController::class, 'store'])->name('store');
                Route::get('/edit/{type}/{id}', [ChartOfAccountController::class, 'edit'])->name('edit');
                Route::post('/update/{id}', [ChartOfAccountController::class, 'update'])->name('update');
            }); 

            Route::group(['prefix' => 'analytical', 'as' => 'analytical.'], function() {
                Route::get('/', [AnalyticalController::class, 'index'])->name('index');
                Route::get('/create', [AnalyticalController::class, 'create'])->name('create');
                Route::post('/store', [AnalyticalController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [AnalyticalController::class, 'edit'])->name('edit');
                Route::put('/update/{id}', [AnalyticalController::class, 'update'])->name('update');
                Route::get('/view/{id}', [AnalyticalController::class, 'show'])->name('view');
                Route::delete('/destroy/{id}', [AnalyticalController::class, 'destroy'])->name('destroy');
            });

            Route::group(['prefix' => 'payment-purpose', 'as' => 'payment-purpose.'], function() {
                Route::get('/', [PaymentPurposeController::class, 'index'])->name('index');
                Route::get('/create', [PaymentPurposeController::class, 'create'])->name('create');
                Route::post('/store', [PaymentPurposeController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [PaymentPurposeController::class, 'edit'])->name('edit');
                Route::put('/update/{id}', [PaymentPurposeController::class, 'update'])->name('update');
                Route::get('/view/{id}', [PaymentPurposeController::class, 'show'])->name('view');
                Route::delete('/destroy/{id}', [PaymentPurposeController::class, 'destroy'])->name('destroy');
            });
        });

        /********** Master : HR ***********/
        Route::group(['prefix' => 'hr', 'as' => 'hr.'], function() {
            Route::group(['prefix' => 'employee', 'as' => 'employee.'], function() {
                Route::get('/', [EmployeeController::class, 'index'])->name('index');
                Route::get('/create', [EmployeeController::class, 'create'])->name('create');
                Route::post('/store', [EmployeeController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [EmployeeController::class, 'edit'])->name('edit');
                Route::put('/update/{id}', [EmployeeController::class, 'update'])->name('update');
                Route::get('/view/{id}', [EmployeeController::class, 'show'])->name('view');
                Route::delete('/destroy/{id}', [EmployeeController::class, 'destroy'])->name('destroy');
                Route::post('/toggle-status', [EmployeeController::class, 'toggleStatus'])->name('toggle-status');
            });

            Route::group(['prefix' => 'user', 'as' => 'user.'], function() {
                Route::get('/', [UserController::class, 'index'])->name('index');
                Route::get('/create', [UserController::class, 'create'])->name('create');
                Route::post('/store', [UserController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
                Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
                Route::get('/view/{id}', [UserController::class, 'show'])->name('view');
                Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('destroy');
                Route::post('/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
            });
        });
    });

    /*********** Purchase Module ***********/
    Route::group(['prefix' => 'purchase', 'as' => 'purchase.'], function() {
        Route::group(['prefix' => 'grn', 'as' => 'grn.'], function() {
            Route::get('/', [GRNController::class, 'index'])->name('index');
            Route::get('/view/{id}', [GRNController::class, 'show'])->name('view');
            Route::get('/{grn}/assign/{id}', [GRNController::class, 'assign'])->name('assign');
            Route::get('/get-storage-rooms', [GRNController::class, 'getStorageRooms'])->name('get-storage-rooms');
            Route::post('/get-racks', [GRNController::class, 'getRacks'])->name('get-racks');
            Route::post('/assign-to-inventory', [GRNController::class, 'assignProductToStorage'])->name('assign-to-inventory');
            Route::post('/sync', [GRNController::class, 'syncFromPJJERP'])->name('sync');
        });
    });

    /*********** Inventory Module ***********/
    Route::group(['prefix' => 'inventory', 'as' => 'inventory.'], function() {

        //Pre Alert
        Route::group(['prefix' => 'pre-alert', 'as' => 'pre-alert.'], function() {
            Route::get('/', [PreAlertController::class, 'index'])->name('index');
            Route::get('/create', [PreAlertController::class, 'create'])->name('create');
            Route::get('/{id}/edit', [PreAlertController::class, 'edit'])->name('edit');
            Route::post('/{id}/update', [PreAlertController::class, 'update'])->name('update');
            Route::get('/view/{id}', [PreAlertController::class, 'show'])->name('view');
            Route::get('/{id}/print', [PreAlertController::class, 'print'])->name('print');
        });

        //gatepass
        Route::group(['prefix' => 'gatepass-in', 'as' => 'gatepass-in.'], function() {
            Route::get('/', [GatePassInController::class, 'index'])->name('index');
            Route::get('/create', [GatePassInController::class, 'create'])->name('create');
            Route::post('/store/{id?}', [GatePassInController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [GatePassInController::class, 'edit'])->name('edit');
            Route::post('/{id}/update', [GatePassInController::class, 'update'])->name('update');
            Route::get('/view/{id}', [GatePassInController::class, 'show'])->name('view');
            Route::get('/{id}/print', [GatePassInController::class, 'print'])->name('print');
            Route::post('/change-status', [GatePassInController::class, 'changeStatus'])->name('change-status');
        });

        //packing list
        Route::group(['prefix' => 'packing-list', 'as' => 'packing-list.'], function() {
            Route::get('/', [PackingListController::class, 'index'])->name('index');
            Route::get('/create', [PackingListController::class, 'create'])->name('create');
            Route::get('/store', [PackingListController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [PackingListController::class, 'edit'])->name('edit');
            Route::post('/{id}/update', [PackingListController::class, 'update'])->name('update');
            Route::get('/view/{id}', [PackingListController::class, 'show'])->name('view');
            Route::get('/{id}/print', [PackingListController::class, 'print'])->name('print');
            Route::post('/get-packing-list-details', [PackingListController::class, 'getPackingListDetails'])->name('get_packinglist_details');
        });

         //Temperature Check
        Route::group(['prefix' => 'temperature-check', 'as' => 'temperature-check.'], function() {
            Route::get('/', [TemperatureCheckController::class, 'index'])->name('index');
            Route::get('/create', [TemperatureCheckController::class, 'create'])->name('create');
            Route::get('/{id}/edit', [TemperatureCheckController::class, 'edit'])->name('edit');
            Route::post('/{id}/update', [TemperatureCheckController::class, 'update'])->name('update');
            Route::get('/view/{id}', [TemperatureCheckController::class, 'show'])->name('view');
            Route::get('/{id}/print', [TemperatureCheckController::class, 'print'])->name('print');
        });

         //palletization
        Route::group(['prefix' => 'palletization', 'as' => 'palletization.'], function() {
            Route::get('/', [PalletizationController::class, 'index'])->name('index');
            Route::get('/create', [PalletizationController::class, 'create'])->name('create');
            Route::get('/store', [PalletizationController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [PalletizationController::class, 'edit'])->name('edit');
            Route::post('/{id}/update', [PalletizationController::class, 'update'])->name('update');
            Route::get('/view/{id}', [PalletizationController::class, 'show'])->name('view');
            Route::get('/{id}/print', [PalletizationController::class, 'print'])->name('print');
        });

         //put away
        Route::group(['prefix' => 'put-away', 'as' => 'put-away.'], function() {
            Route::get('/', [PutAwayController::class, 'index'])->name('index');
        });

        //Inward
        Route::group(['prefix' => 'inward', 'as' => 'inward.'], function() {
            Route::get('/', [InwardController::class, 'index'])->name('index');
            Route::get('/create/{id?}', [InwardController::class, 'create'])->name('create');
            Route::post('/store/{id?}', [InwardController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [InwardController::class, 'edit'])->name('edit');
            Route::put('/{id}/update', [InwardController::class, 'update'])->name('update');
            Route::get('/view/{id}', [InwardController::class, 'show'])->name('view');
            Route::post('/{packinglist}/assign/{id}', [InwardController::class, 'assign'])->name('assign');
            Route::post('/assign/back', [InwardController::class, 'saveAssignedSlots'])->name('assign.back');
            Route::post('/{inward}/reassign/{id}', [InwardController::class, 'reassign'])->name('reassign');
            Route::post('/reassign/back', [InwardController::class, 'saveReAssignedSlots'])->name('reassign.back');
            Route::get('/{id}/print', [InwardController::class, 'print'])->name('print');
            Route::post('/change-status', [InwardController::class, 'changeStatus'])->name('change-status');
        });

        //picklist
        Route::group(['prefix' => 'pick-list', 'as' => 'pick-list.'], function() {
            Route::get('/', [PickListController::class, 'index'])->name('index');
            Route::get('/create', [PickListController::class, 'create'])->name('create');
            Route::post('/store', [PickListController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [PickListController::class, 'edit'])->name('edit');
            Route::put('/{id}/update', [PickListController::class, 'update'])->name('update');
            Route::get('/view/{id}', [PickListController::class, 'show'])->name('view');
            Route::get('/{id}/print', [PickListController::class, 'print'])->name('print');
            Route::post('/change-status', [PickListController::class, 'changeStatus'])->name('change-status');
        });

        //outward
        Route::group(['prefix' => 'outward', 'as' => 'outward.'], function() {
            Route::get('/', [OutwardController::class, 'index'])->name('index');
            Route::get('/create/{id?}', [OutwardController::class, 'create'])->name('create');
            Route::post('/store/{id?}', [OutwardController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [OutwardController::class, 'edit'])->name('edit');
            Route::post('/{id}/update', [OutwardController::class, 'update'])->name('update');
            Route::get('/view/{id}', [OutwardController::class, 'show'])->name('view');
            Route::get('/{id}/print', [OutwardController::class, 'print'])->name('print');
            Route::post('/change-status', [OutwardController::class, 'changeStatus'])->name('change-status');
        });

        //stock adjustment
        Route::group(['prefix' => 'stock-adjustment', 'as' => 'stock-adjustment.'], function() {
            Route::get('/', [StockAdjustmentController::class, 'index'])->name('index');
            Route::get('/create/{id?}', [StockAdjustmentController::class, 'create'])->name('create');
            Route::post('/store/{id?}', [StockAdjustmentController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [StockAdjustmentController::class, 'edit'])->name('edit');
            Route::post('/{id}/update', [StockAdjustmentController::class, 'update'])->name('update');
            Route::get('/view/{id}', [StockAdjustmentController::class, 'show'])->name('view');
            Route::post('/{packinglist}/assign/{id}', [StockAdjustmentController::class, 'assign'])->name('assign');
            Route::post('/assign/back', [StockAdjustmentController::class, 'saveAssignedSlots'])->name('assign.back');
            Route::post('/{packinglist}/reassign/{id}', [StockAdjustmentController::class, 'reassign'])->name('reassign');
            Route::post('/reassign/back', [StockAdjustmentController::class, 'saveReAssignedSlots'])->name('reassign.back');
            Route::get('/{id}/print', [StockAdjustmentController::class, 'print'])->name('print');
            Route::post('/remove-adjustment-product', [StockAdjustmentController::class, 'removeAdjustmentProduct'])->name('remove-adjustment-product');
        });

        Route::group(['prefix' => 'storage-room', 'as' => 'storage-room.'], function() {
            Route::get('/', [StorageRoomController::class, 'index'])->name('index');
            Route::get('/room/{roomId}', [StorageRoomController::class, 'getRacks'])->name('get-racks');
            Route::get('/room/{roomId}/rack/{rackId}', [StorageRoomController::class, 'getRackDetail'])->name('get-rack-detail');
            Route::get('/pallet/{palletId}', [StorageRoomController::class, 'getPalletDetail'])->name('get-pallet-detail');
        });

        //gatepass
        Route::group(['prefix' => 'gatepass', 'as' => 'gatepass.'], function() {
            Route::get('/', [GatePassController::class, 'index'])->name('index');
            Route::get('/create/{id?}', [GatePassController::class, 'create'])->name('create');
            Route::post('/store/{id?}', [GatePassController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [GatePassController::class, 'edit'])->name('edit');
            Route::post('/{id}/update', [GatePassController::class, 'update'])->name('update');
            Route::get('/view/{id}', [GatePassController::class, 'show'])->name('view');
            Route::get('/{id}/print', [GatePassController::class, 'print'])->name('print');
            Route::post('/change-status', [GatePassController::class, 'changeStatus'])->name('change-status');
        });
    });

    //*********** Accounting Module ***********/
    Route::group(['prefix' => 'accounting', 'as' => 'accounting.'], function() {

        //payment
        Route::group(['prefix' => 'payment', 'as' => 'payment.'], function() {
            Route::get('/', [PaymentController::class, 'index'])->name('index');
            Route::get('/create', [PaymentController::class, 'create'])->name('create');
            Route::post('/store', [PaymentController::class, 'store'])->name('store');
            Route::get('/view/{id}', [PaymentController::class, 'show'])->name('view');
            Route::post('/get-ledger-account-by-account-label', [PaymentController::class, 'getLedgerAccount'])->name('get-ledger-account');
            Route::post('/get-ledger-account-balance', [PaymentController::class, 'getLedgerAccountBalance'])->name('get-ledger-account-balance');
            Route::post('/get-payment-purpose', [PaymentController::class, 'getPaymentPurpose'])->name('get-payment-purpose');
            Route::post('/change-status', [PaymentController::class, 'changeStatus'])->name('change-status');
            Route::post('/{id}/settle', [PaymentController::class, 'settle'])->name('settle');
            Route::get('/{id}/print', [PaymentController::class, 'print'])->name('print');
        });

        //journal
        Route::group(['prefix' => 'journal', 'as' => 'journal.'], function() {
            Route::get('/', [JournalController::class, 'index'])->name('index');
            Route::get('/create', [JournalController::class, 'create'])->name('create');
            Route::post('/store', [JournalController::class, 'store'])->name('store');
            Route::get('/view/{id}', [JournalController::class, 'show'])->name('view');
            Route::post('/change-status', [JournalController::class, 'changeStatus'])->name('change-status');
            Route::get('/{id}/print', [JournalController::class, 'print'])->name('print');
        });
       
    });

    //*********** Sales Module ***********/
    Route::group(['prefix' => 'sales', 'as' => 'sales.'], function() {

        //customer enquiry
        Route::group(['prefix' => 'customer-enquiry', 'as' => 'customer-enquiry.'], function() {
            Route::get('/', [CustomerEnquiryController::class, 'index'])->name('index');
            Route::get('/create', [CustomerEnquiryController::class, 'create'])->name('create');
            Route::post('/store', [CustomerEnquiryController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [CustomerEnquiryController::class, 'edit'])->name('edit');
            Route::put('/{id}/update', [CustomerEnquiryController::class, 'update'])->name('update');
            Route::get('/view/{id}', [CustomerEnquiryController::class, 'show'])->name('view');
            Route::post('/change-status', [CustomerEnquiryController::class, 'changeStatus'])->name('change-status');
            Route::get('/{id}/print', [CustomerEnquiryController::class, 'print'])->name('print');
        });

        //sales quotation
        Route::group(['prefix' => 'sales-quotation', 'as' => 'sales-quotation.'], function() {
            Route::get('/', [SalesQuotationController::class, 'index'])->name('index');
            Route::get('/create', [SalesQuotationController::class, 'create'])->name('create');
            Route::post('/store', [SalesQuotationController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [SalesQuotationController::class, 'edit'])->name('edit');
            Route::put('/{id}/update', [SalesQuotationController::class, 'update'])->name('update');
            Route::get('/view/{id}', [SalesQuotationController::class, 'show'])->name('view');
            Route::post('/change-status', [SalesQuotationController::class, 'changeStatus'])->name('change-status');
            Route::get('/{id}/print', [SalesQuotationController::class, 'print'])->name('print');
        });
       
    });

    /*********** Dashboard ***********/
    Route::group(['prefix' => 'product-flow', 'as' => 'product-flow.'], function() {
        Route::get('/', [ProductFlowController::class, 'index'])->name('index');
    });

    /*********** Bulk-Import ***********/
    Route::group(['prefix' => 'bulk-import', 'as' => 'bulk-import.'], function() {
        Route::get('/new', [BulkImportController::class, 'importNew'])->name('new');
        Route::get('/existing', [BulkImportController::class, 'importExisting'])->name('exist');
        Route::post('/import/download', [BulkImportController::class, 'downloadTemplate'])->name('downloadTemplate');
        Route::post('/import/preview', [BulkImportController::class, 'previewUpload'])->name('previewUpload');
        Route::post('/import/process', [BulkImportController::class, 'processImport'])->name('processImport');
    });

    /*********** Attachments ***********/
    Route::group(['prefix' => 'attachments', 'as' => 'attachments.'], function() {
        Route::post('/upload', [AttachmentController::class, 'store'])->name('upload');
        Route::get('/list', [AttachmentController::class, 'index'])->name('list');
        Route::delete('/{id}', [AttachmentController::class, 'destroy'])->name('destroy');
    });

    /*********** Report ***********/
    Route::group(['prefix' => 'report', 'as' => 'report.'], function() {
        Route::group(['prefix' => 'stock-summary', 'as' => 'stock-summary.'], function() {
            Route::get('/', [StockSummaryController::class, 'index'])->name('index');
            Route::get('/print', [StockSummaryController::class, 'printView'])->name('print');
        });

        Route::group(['prefix' => 'stock-detail', 'as' => 'stock-detail.'], function() {
            Route::get('/', [StockDetailController::class, 'index'])->name('index');
            Route::get('/print', [StockDetailController::class, 'printView'])->name('print');
        });
    });
});
